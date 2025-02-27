<?php

require_once "constants.php";
require_once "functions_separators.php";

// New line in html source
function newLine() {
	echo NEWL;
}

// Stacking tabs in html source
function tabStacks($amount) {
	for ($tab = 0; $tab < $amount; ++$tab) {
		// Generate the html source tab (can be 2 or 4 spaces, depends on something not yet understood)
		echo TABY;
	}
}

// Construct input form
function makeFormInput($tag, $entry, $amount) {
	tabStacks($amount);
	// $amount = 3;
	// Translated input field header
	echo "<label for=$tag>$tag</label>";
	newLine();
	// Generate source html tabs
	tabStacks($amount);
	echo "<br>";
	newLine();
	// Generate source html tabs
	tabStacks($amount);
	// Input field
	// echo "<input type='text' id=$tag name=$tag value=$entry>";
	echo "<input type='text' id=$tag name=$tag value=$entry>";
	newLine();
	// Generate source html tabs
	tabStacks($amount);
	echo "<br>";
	newLine();
}

// Construct button within a form
function makeFormButton($link, $label, $index = 0, $method = '', $deleter = false) {
	$classer = '';
	
	// Add a possible input method and class to go with it
	if (!empty($method)) {
		$method = 'method=' . $method;

		$classer = "class='poster'";
	}

	// If the button deletes
	if ($deleter) {
		$classer  = "class='deleter'";
	}

	// Generate source html tabs
	tabStacks($index);

	// Construct suitable button with the right linkage
	echo "<form $method action=$link>";
	echo "<input $classer type='submit' ";

	// Ensures that the first POST entry is created
	if (!empty($method)) {
		echo "name='0' ";
	}

	echo "value='$label'>";
	echo "</form>";
	newLine();
}

// Construct simple button linking to a new tab
function makeButton($link, $label, $index = 0) {
	// Open the link in a new tab
	$clicked = "onclick=\"window.open('$link', '_blank')\"";

	// Generate source html tabs
	tabStacks($index);

	// Construct the button
	echo "<button $clicked>$label</button>";
	newLine();
}

// Display array as lines, maybe end
function lineDumps($data, $ends = FALSE) {
	echo "<div>";
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
	echo "</div>";

	echo "<br>";

	if ($ends) {
		die();
	}
}

// Recursively display (nested) array(s) in line(s) in a different way
function arrayDumps($data) {
	echo "<br>";

	// If the entry is an array
	foreach ($data as $entry) {
		if (is_array($entry)) {
			// Display it as such
			arrayDumps($entry);
		} else {
			// Display it as a string
			echo $entry;
		}
	}

	echo "<br>";
}

// Display [(nested) array(s)] data in a more presentable way, maybe end page loading
function dataDumper($data, $ends = FALSE) {	
	echo "<br>";
	echo "<div class='writing'>";

	// If the data is an array
	if (is_array($data)) {
		// Display it a such
		arrayDumps($data);
	} else {
		// Display it as a string
		echo $data. "<br>";
	}
	
	echo "</div>";

	if ($ends) {
		die();
	}
}