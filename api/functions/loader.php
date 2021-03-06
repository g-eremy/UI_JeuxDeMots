<?php
// chaque page de l'API doivent require ce fichier et implémenter la fonction load
// load doit retourner le résultat qui doit être envoyé au client
// ce fichier se charge de gérer les erreurs et envoyer les données au client

declare(strict_types=1);

// toute les erreurs doivent être retourné par l'interpréteur PHP
// https://www.php.net/manual/fr/function.error-reporting.php
@error_reporting(-1);

// les erreurs ne seront pas affiché dans le tampon de sortie
// cependant, en DEV_MODE, les erreurs seront attrapé et retourné dans le JSON
@ini_set("display_errors", "0");
@ini_set("display_startup_errors", "0");

//@set_time_limit(15);

// tout ce qui sera affiché dans le tampon de sortie sera retourné dans le JSON en DEV_MODE dans debug
ob_start();

function is_dev_mode()
{
	return !(defined("PROD_MODE") && PROD_MODE);
}

try
{
	$obj = new stdClass();
	$obj->error = false;

	// get classes
	spl_autoload_register(function ($class_name) {
		require(APP_PATH . "/classes/" . $class_name . '.php');
	});

	// get functions
	require(APP_PATH . "/functions/constante.php");
	require(APP_PATH . "/functions/cache_manager.php");
	require(APP_PATH . "/functions/data_parser.php");
	require(APP_PATH . "/functions/function.php");
	require(APP_PATH . "/functions/request.php");
	
	$bench_total = Benchmark::total();

	// appel de la fonction load
	$r = load();
	$obj->result = $r;

	$bench_total->end();

	if (is_dev_mode())
	{
		$bench = Benchmark::getBench();
		$obj->bench = $bench;
	}
}
catch(ServerException $e)
{
	$obj->error = true;
	$obj->message = $e->getMessage();
}
catch(Throwable $e)
{
	if (is_dev_mode())
	{
		$message = "Erreur dans \"" . $e->getFile() . "\" à la ligne " . $e->getLine() . " : " . $e->getMessage();		
		$obj->trace = $e->getTrace();
	}
	else
	{
		$message = "Une erreur s'est produite";
	}
	
	$obj->error = true;
	$obj->message = $message;
}

$buffer_debug = ob_get_contents();
ob_end_clean();

if (is_dev_mode())
{
	$obj->debug = $buffer_debug;
}

header("content-type: application/json; charset=" . APP_ENCODING);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");

// envoie des données au client au format JSON
$json = json_encode($obj);
echo $json;
