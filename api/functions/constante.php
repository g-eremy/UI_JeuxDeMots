<?php
// PROD_MODE = false pour afficher en détail les erreurs
// PROD_MODE = true pour cacher les informations sur les erreurs
//define("PROD_MODE", true);
// si DEV_MODE = true et CACHE_IN_DEV_MODE = false alors il n'y aura pas de cache en DEV_MODE
define("CACHE_IN_DEV_MODE", false);

// encodage
define("APP_ENCODING", "UTF-8");

// url pour les requetes
define("REQUEST_URL", "http://www.jeuxdemots.org/rezo-dump.php");
// Paramètre submit
define("REQUEST_SUBMIT_PARAMETER", "gotermsubmit");
// Valeur du paramètre submit
define("REQUEST_SUBMIT_VALUE", "Chercher");
// Paramètre pour le terme
define("REQUEST_TERM_PARAMETER", "gotermrel");
// paramètre pour les relations
define("REQUEST_REL_PARAMETER", "rel");

// balises encapsulant les données
define("DATA_DELIMITER_BEGIN", "<CODE>");
define("DATA_DELIMITER_END", "</CODE>");

// données indiquant un problème de type warning
define("DATA_WARNING", "/<WARNING>(.+)<WARNING>/");

// les commentaires dans les données permettent de pouvoir séparer les différentes parties
// la constante ci-dessous est une expression régulière permettant de détecter les commenataires
define("DATA_PARTS_DELIMITER", "/\n\/\/\s(.+)\n/");

// les différentes lignes sont séparé par un saut de lignes (exception pour les définitions où on a besoin d'une expression régulière)
define("DATA_DEF_LINE_DELIMITER", "/^[0-9]+\.\s/m");
define("DATA_LINE_DELIMITER", "\n");
// les différentes colonnes sont séparé par un ";"
define("DATA_COLUMN_DELIMITER", ";");
// les définitions sont numéroté
// la numérotation seront supprimé en séparant la numérotation de la définition avec le . au début
define("DATA_DEF_DIAL", ". ");

// position des différentes parties dans les données
define("DATA_COUNT_PARTS", 6); // nombre de parties
define("DATA_DEF_POS", 1); // définition
define("DATA_NODETYPE_POS", 2); // type des noeuds
define("DATA_NODE_POS", 3); // noeuds
define("DATA_RELTYPE_POS", 4); // type des relations
define("DATA_RELOUT_POS", 5); // relations sortantes
define("DATA_RELIN_POS", 6); // relations entrantes

// position du noeud du mot recherché dans l'ensemble des noeuds
define("DATA_WORD_POS", 0);

// position indiquant le type de l'instance dans les données (e, r, etc...)
define("DATA_TYPE_POS", 0);
// relation > relation sortante (on renomme le type "r" désignant une relation par "ro" désignant une relation sortante)
define("DATA_RELOUT", "ro");
// relation > relation entrante (on renomme le type "r" désignant une relation par "ro" désignant une relation entrante)
define("DATA_RELIN", "ri");

// position de l'id d'un type noeud
define("DATA_NODETYPE_ID_POS", 1);
// position de ntname dans un type denoeud
define("DATA_NODETYPE_NAME_POS", 2);

// position de l'id d'un type de relation
define("DATA_RELTYPE_ID_POS", 1);
// position de trname d'un type de relation
define("DATA_RELTYPE_NAME_POS", 2);
// position de trgpname d'un type de relation
define("DATA_RELTYPE_GPNAME_POS", 3);
// position de rthelp d'un type de relation
define("DATA_RELTYPE_HELP_POS", 4);

// position de l'id du noeud
define("DATA_NODE_ID_POS", 1);
// position du mot dans un noeud
define("DATA_NODE_WORD_POS", 2);
// position du type de noeud dans un noeud
define("DATA_NODE_TYPE_POS", 3);
// position du poids d'un noeud dans un noeud
define("DATA_NODE_WEIGHT_POS", 4);
// position de formated name dans un noeud
define("DATA_NODE_FNAME_POS", 5);

// position de l'id de la relation
define("DATA_REL_ID_POS", 1);
// position de l'id du noeud entrant dans une relation
define("DATA_RELIN_ID_POS", 2);
// position de l'id du noeud sortant dans une relation
define("DATA_RELOUT_ID_POS", 3);
// position du type de relation dans une relation
define("DATA_REL_TYPE_POS", 4);
// position du poids d'une relation dans une relation
define("DATA_REL_WEIGHT_POS", 5);

// dossier de cache
define("CACHE_DIRECTORY", APP_PATH . "/cache");
//nombre maximal de fichier cache
define("LIMIT_NB_CACHE_FILE", 50);

// nombre de mots renvoyer
define("LIMIT_NB_WORD", 10);

define("AUTOCOMPLETE_DATA", APP_PATH . "/data/12172019-word.json");
define("AUTCOMPLETE_COUNT", 5);

// search paramètre : terme
define("PARAMETER_TERM", "term");
//search paramètre : node
define("PARAMETER_NODE", "node");
// search paramètre : masquer les relations sortantes
define("PARAMETER_NOT_OUT", "not_out");
// search paramètre : masquer les relations entrantes
define("PARAMETER_NOT_IN", "not_in");
// search paramètre : limiter le nombre d'occurence
define("PARAMETER_NB_TERMS", "nb_terms");
// search paramètre : page
define("PARAMETER_PAGE", "p");
// search paramètre : type de relation paginé
define("PARAMETER_PAGE_NAME", "pname");
// search paramètre : relation sortante ou entrante paginé
define("PARAMETER_PAGE_INOUT", "pinout");
// search valeur de paramètre : pagination sur relation entrante
define("PARAMETER_PAGE_IN", "in");
// search valeur de paramètre : pagination sur relation sortante
define("PARAMETER_PAGE_OUT", "out");
// automplete paramètre
define("PARAMETER_AUTOCOMPLETE", "autocomplete");