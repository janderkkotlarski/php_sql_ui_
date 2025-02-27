<?php

require_once DIR . "/Database.php";

$groc = [];

// If the input method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Some hack examples for testing
  // <h1 style="font-size: 100px">Haxxed!</h1><script>alert('ALL YOUR BASE BELONG TO US!')</script>
	// curl -X POST http://localhost:8000 -d "name=Hello&price=5.5&number=7"

	// Turn $_POST string into an array
	$expand = explode(SEPARATOR, $_POST[0]);
	// How many entries does it have
	$length = count($expand);	

	// Turn $_POST string into a workable array
	$contents = arraySplitterForward($_POST[0], SEPARATOR);

	$terms = TAGS;

	// If the question is found at the end
	if ($expand[$length - 1] === QUESTION) {
		// Delete line
		lineDelete($db, $data_name, $terms, $contents);
	} else {
		// Select line explicitly
		$groc = lineSelect($db, $data_name, $terms, $contents);
	}
}

// Select all the lines
$groceries = allSelect($db, $data_name);

require_once DIR . "/views/delete.view.php";