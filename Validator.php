<?php

// Check subject length
function lengthChecker($subject, $min = 1, $max = INF) {
	// If the subject has not enough characters
	if (strlen($subject) < $min) {
		return " heeft een lengte kleiner dan $min!";
	}
	
	// If the subject has too many characters
	if (strlen($subject) > $max) {
		return " heeft een lengte groter dan $max!";
	}

	return false;
}

class Validator {
	// Check string validity
	public static function string($subject, $min = 1, $max = INF) {
		$subject = trim($subject);

		// Cehck for numericity
		if (is_numeric($subject)) {
			return " is een getal!";
		}

		// Check length
		return lengthChecker($subject, $min, $max);
	}

	// Check integer validity
	public static function integer($subject, $min = 1, $max = 1000) {
		$subject = trim($subject);

		// Check length
		if (lengthChecker($subject, MIN_SIZE, MAX_SIZE)) {
			return lengthChecker($subject, MIN_SIZE, MAX_SIZE);
		}

		// Check numericity
		if (!is_numeric($subject)) {
		  return " is geen getal! ";
		// Check integerity
		} elseif ($subject - round($subject) != 0) {
			return " is geen geheel getal!";
		}

		// Integer has a minimum amount
		if ($subject < $min) {
			return " moet minstens $min kwa aantal zijn!";
		}

		// Integer has a maximum amount
		if ($subject > $max) {
			return " mag hoogstens $max kwa aantal zijn!";
		}

		return false;
	}

	// Check flaot validity
	public static function decimal($subject, $min = 0, $max = INF) {
		$subject = trim($subject);

		// Check length
		if (lengthChecker($subject, MIN_SIZE, MAX_SIZE)) {
			return lengthChecker($subject, MIN_SIZE, MAX_SIZE);
		}

		// Check numericity
		if (!is_numeric($subject)) {
		  return " is geen getal!";
		}

		$digit_length = 0;

		// RegEx to find decimal points and numbers
		$pattern = "/\.\d/";

		// If point and number are found
		if (preg_match($pattern, $subject)) {
			// Get the length of the 2nd array entry
			$digit_length = strlen(explode('.', $subject)[1]);
		}		

		// Decimal number length must be at least
		if ($digit_length < $min) {
			return " moet minstens $min decimalen hebben!";
		}

		// Decimal number length may be at most
		if ($digit_length > $max) {
			return " mag hoogstens $max decimalen hebben!";
		}

		return false;
	}

	// Check for invalidity
	public static function tagInvalid($subject, $tag) {
		$invalid = false;
	
		// Per tag an appropriate check
		if ($tag === 'name') {
			$invalid = Validator::string($subject, MIN_SIZE, MAX_SIZE);
		} elseif ($tag === 'number') {
			$invalid = Validator::integer($subject);
		} elseif ($tag === 'price') {
			$invalid = Validator::decimal($subject, 0, MAX_DEC);
		}
	
		// If invalidity is found 
		if ($invalid) {
			// return error in a presentable way
			return EN2NL[$tag] . " " . htmlspecialchars($subject) . $invalid;
		}	

		return false;
	}
}

