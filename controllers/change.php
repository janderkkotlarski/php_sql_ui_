<?php
require_once DIR . "/Database.php";

// Get rid of possible null entries
NullEraser($db, $data_name);

// Get all groceries
$table = allSelect($db, $data_name);

require_once DIR . "/views/change.view.php";