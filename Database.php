<?php

// dsn configuration parameters
$config = require_once DIR . "/config.php";

class Database {
	public $connection;
	public $statement;

	// Create a Database with PDO connection
	public function __construct($config, $username = 'root', $password = 'root') {
		// Build the dsn query with the appropriate parameters
		$dsn = 'mysql:' . http_build_query($config, '', ';');

		// Create a new PDO connection based on the dsn query
		$this->connection = new PDO($dsn, $username, $password, [
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		]);
	}

	// Prepare and execute a query for data-manipulation in the database
	public function query($query, $params = []) {
		// Prepare the query
		$this->statement = $this->connection->prepare($query);

		// Execute with parameters
		$this->statement->execute($params);

		// Important to note: When providing parameters, the amount of those must match the amount of query terms

		return $this;
	}

	// Get first line of  specified data
	public function retrieve() {
		return $this->statement->fetch();
	}

	// Try getting specified data or go to error handling
	public function retrieveTry() {
		$data = $this->retrieve();
		
		// Stop when failed
		if (!$data) {
			abort();
		}

		return $data;
	}

	// Get all specified data
	public function retrieveAll() {
		return $this->statement->fetchAll();
	}
}

// Display all specified data
function getDisplayContents($base, $name) {
	foreach ($_GET as $term => $content) {
		// Show how this element of the associated array
		echo $term . "=>" . $content . "<br>";
	
		$query = "SELECT * FROM $name WHERE $term = ?";	
		$data = $base->query($query, [$content])->retrieveAll();
	
		// Show the retrieved line data
		lineDumps($data);
	}
}

// Get all applicable data
function allSelect($data_base, $data_name) {
	// Select everything form the database
	$query = "SELECT * FROM $data_name";

	// Return all lines of data
	return $data_base->query($query)->retrieveAll();
}

// Turn associative array terms into usable search terms for the data
function lineBindings($data_base, $data_name, $terms, $contents, $action) {
	$terms_query = [];
	$line_assocs = [];

	$index = 0;

	$nullifier = false;

	foreach ($terms as $term) {	
		// If this content is a string
		if ($contents[$index] === NULL) {
			$terms_query[] = "$term IS NULL";
			$nullifier = true;
		} elseif (is_string($contents[$index])) {
			// String comparison
			$terms_query[] = "$term = :$term";
		} else {
			// How much float deviation is allowed?
			$max_dev = 0.5 * pow(10, -MAX_DEC);

			// Float comparison
			$terms_query[] = "ABS($term - :$term) < $max_dev";
		}

		// Create term to content association and push array it
		$line_assocs[$term] = $contents[$index];

		++$index;
	}

	// Turn terms into a workable string
	$select_query = implode(" AND ", $terms_query);

	if ($nullifier) {
		$line_assocs = [];
	}
	
	// Return the specific selection query with data criteria
	return ["$action FROM $data_name WHERE " . $select_query,
					$line_assocs];
}

// Turn associative array terms into usable insertion terms for the data
function lineInsertions($data_base, $data_name, $terms) {
	$terms2 = [];

	foreach ($terms as $term) {
		// Needed new term
		$terms2[] = ":" . $term;
	}
	
	// Return the specific insertion query with data criteria
	return "INSERT INTO $data_name(" . implode(", ", $terms) . ") VALUES(" . implode(", ", $terms2) . ")";
}

// Get the correct line of data
function lineSelect($data_base, $data_name, $terms, $contents) {
	// Data for line selection
	$line_bindings = lineBindings($data_base, $data_name, $terms, $contents, "SELECT *");

	// Get first corresponding line
	return $data_base->query($line_bindings[0], $line_bindings[1])->retrieveTry();
}

// Delete all lines of data that fit the criteria
function lineDelete($data_base, $data_name, $terms, $contents) {
	// Data for line deletion
	$line_bindings = lineBindings($data_base, $data_name, $terms, $contents, "DELETE");

	// Delete all corresponding lines
	$data_base->query($line_bindings[0], $line_bindings[1]);
}

function lineCreate($data_base, $data_name, $terms, $contents) {
	// Data to insert as a line
	$line_binding = lineInsertions($data_base, $data_name, $terms);

	// Create the line
	$data_base->query($line_binding, $contents);
}

// See whether any of the $_GET parameters can be found in the data
function lineGetSelect($data_base, $data_name, $tag) {
	// If there is GET data
	if (count($_GET)) {
		// Check for each associated term
		foreach ($_GET as $term => $content) {
			if ($term == $tag) {
				// Whether it can be retrieved
				return lineSelect($data_base, $data_name, $term, $content);
			}
		}		
	}
}

// Is the subject already in the database table?
function lineTagFinder($data_base, $data_name, $subject, $tag) {
	// get the whole table
	$table = allSelect($data_base, $data_name);
	
	// For each line entry
	foreach ($table as $line) {
		// If subject is found...
		if ($line[$tag] === $subject) {
			return true;
		}
	}

	return false;
}

// Delete lines based upon a single tag subject
function lineTagDeleter($data_base, $data_name, $subject, $tag) {
	$select_query = "$tag = :$tag";

	// If the subject for the tag is found...
	if (lineTagFinder($data_base, $data_name, $subject, $tag)) {
		lineDelete($data_base, $data_name, [$tag], [$subject]);
	}	
}

// Delete all line with null entries
function NullEraser($data_base, $data_name) {
	foreach (TAGS as $tag) {
		if (lineTagFinder($data_base, $data_name, NULL, $tag)) {
			lineDelete($data_base, $data_name, [$tag], [NULL]);
		}
	}
}

// This project's database name
$base_name = 'database';
// This project's database table
$data_name = 'groceries';

// Set up new access point to the server database
$db = new Database($config[$base_name]);