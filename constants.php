<?php

// Where is the root directory?
define("DIR", getcwd());

// Tab for source html
define("TABY", "\t");

// New line for source html
define("NEWL", "\n");

define("ROUTES", [
	'/' => 'controllers/index.php',
	'/create' => 'controllers/create.php',
	'/delete' => 'controllers/delete.php',
	'/change' => 'controllers/change.php'
]);

define("NAVLINKS", [
	"\\" => 'View Data',
	"\\create" => 'Add Data',
	"\\delete" => 'Delete Data',
	"\\change" => 'Change Data'
]);

// Separator for deletion button display
define("SEPARATOR", "[|]");

// Replacement for inputted separator
define("DIVIDER", "_");

// Question to display and ensure that the right deletion is done
define("QUESTION", "Weghalen?");

// Data tags
define("TAGS", ['name',
							'number',
							'price']);

// English to Dutch translation
define("EN2NL", [
	'name' => 'Naam',
	'number' => 'Aantal',
	'price' => 'Prijs'
]);

// Minimum subject length
define("MIN_SIZE", 1);

// Maximum subject length
define("MAX_SIZE", 30);

// Maximum decimals after point
define("MAX_DEC", 2);

// Maximum database float deviation
define("MAX_DEV", 0.5 * pow(10, -MAX_DEC));