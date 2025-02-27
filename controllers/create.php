<?php

// If the input method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // <h1 style="font-size: 100px">Haxxed!</h1><script>alert('ALL YOUR BASE BELONG TO US!')</script>
  // curl -X POST http://localhost:8000/ -d name=`n -d number=1 -d price=3

	require_once DIR . "/Database.php";
	require_once DIR . "/Validator.php";

  $errors = [];
  $line = [];
  
  lineDumps($_POST);

  // For each tag
  foreach (TAGS as $tag) {
    // Replace separator sequence with divider sequence
    // Makes delete button representation easier
    $subject = patternReplacer($_POST[$tag], SEPARATOR, DIVIDER);

    // If the Validator algorithms find a problem
    if (Validator::tagInvalid($subject, $tag)) {
      // Clean the output and push it into the error array
      $errors[$tag] = htmlspecialchars(Validator::tagInvalid($subject, $tag));
    }
    
    // For the name tag
    if ($tag === 'name') {
      // If that name already exists, delete it
      lineTagDeleter($db, $data_name, $subject, $tag);
    }

    // Clean the subject for database insertion
    $cleanject = htmlspecialchars($subject);

    // Push it into the line array
    $line[$tag] = $cleanject;
  }

  // If there are no errors
  if (empty($errors)) {
    /*
    // $empties = [];

    // For each tag push null entry
    // For null entry injection testing
    foreach (TAGS as $tag) {
      $empties[$tag] = NULL;
    }

    $line = $empties
    */
    
    // Insert the line
    lineCreate($db, $data_name, TAGS, $line);

    // Go to index to display the change
		header("Location: /");    
    die();
  }
} 

require_once DIR . "/views/create.view.php";