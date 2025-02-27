<?php
require_once DIR . "/Database.php";

// Get rid of possible null entries
NullEraser($db, $data_name);

// Get all groceries
$groceries = allSelect($db, $data_name);

// Get the sum total of all groceries
function subtotalSummation($sum, $grocery) {
  // Per entry calculate the total price of the grocery
  return $sum += (float)$grocery["number"] * (float)$grocery["price"]; 
}

// Calculate the total price
$total_price = array_reduce($groceries, "subtotalSummation");

require_once DIR . "/views/index.view.php";

