<?php
function load()
{
	if (!isset($_GET[PARAMETER_TERM]) || !isset($_GET[PARAMETER_PAGE]))
	{
		throw new ServerException("Requête invalide");
	}
	
	$data = request($_GET[PARAMETER_TERM]);
	$filters = array();
	
	if (isset($_GET[PARAMETER_NOT_OUT]))
	{
		$filters[] = new FilterOut();
	}
	
	if (isset($_GET[PARAMETER_NOT_IN]))
	{
		$filters[] = new FilterIn();
	}
	
	$filters[] = new FilterLimit($_GET[PARAMETER_PAGE], LIMIT_NB_WORD);
	
	Word::filterRelations($data, $filters);
	
	return $data;
}

include("./functions/loader.php");
