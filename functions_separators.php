<?php

// Recursively match a letter in the subject and pattern
function recursiveLetter($splitject, $splittern, $index, $subindex = 0) {
	// If the current letter matches
	if ($splittern[$subindex] === $splitject[$index + $subindex]) {
		// If the next letter is in the pattern
			if ($subindex + 1 < count($splittern)) {
			// Check if it matches
			return recursiveLetter($splitject, $splittern, $index, $subindex + 1);
		} else {
			return true;
		}
	} else {
		return false;
	}
}

// Replace pattern with different pattern
function patternReplacer($subject, $pattern1, $pattern2) {
	// Turn strings into arrays
	$splitject = str_split($subject);
	$splittern = str_split($pattern1);

	// Array lengths
	$span = count($splitject);
	$size = count($splittern);

	$result = '';

	// If the subject length is at least the pattern length
	if ($size <= $span) {
		// Recounting found patterns
		$count = 0;
		// Subject index
		$index = 0;

		// As long as the index plus pattern length is at most pattern length
		while ($index < $span) {
			// Check at index if the pattern can be found
			$found = recursiveLetter($splitject, $splittern, $index);
			
			if ($found) {
				// Skip pattern1 and record pattern2
				$index += $size - 1;
				$result .= $pattern2;
			} else {
				// Record the letter
				$result .= $splitject[$index];
			}

			++$index;
		}		
	} else {
		// Subject to0 small to contain pattern1
		$result = $subject;
	}

	return $result;
}

// Count the amount of times the pattern is found in the subject
function patternAmount($subject, $pattern) {
	// Turn strings into arrays
	$splitject = str_split($subject);
	$splittern = str_split($pattern);

	// Array lengths
	$span = count($splitject);
	$size = count($splittern);

	// Amount of found patterns
	$amount = 0;
	
	// If the subject length is at least the pattern length
	if ($size <= $span) {
		$index = 0;	

		// Is the pattern found?
		$found = false;

		// As long as the index plus pattern length is at most pattern length
		while ($index + $size <= $span) {
			// When the pattern is found..			
			if (recursiveLetter($splitject, $splittern, $index)) {
				++$amount;
			}

			++$index;
		}		
	}

	return $amount;
}

// Split string into arrays of usable data separated by a distinct pattern
function arraySplitterForward($subject, $pattern) {
	// Turn strings into arrays
	$splitject = str_split($subject);
	$splittern = str_split($pattern);

	// Array lengths
	$span = count($splitject);
	$size = count($splittern);

	$result = [];

	// If the subject length is at least the pattern length
	if ($size <= $span) {
		// How many patterns are there?
		$amount = patternAmount($subject, $pattern);

		$entry = '';
	
		// Subject index
		$index = 0;

		// Current amount of patterns found
		$count = 0;

		// As long as the index plus pattern length is at most pattern length
		while ($index + $size <= $span) {
			// The record function is on
			$record = true;

			// Once the max amount of patterns are found
			if ($count >= $amount) {
				// Record function off
				$record = false;
			}

			// Check at index if the pattern can be found
			$found = recursiveLetter($splitject, $splittern, $index);

	
			if ($found) {
				++$count;				
			}			

			// If record function is on while pattern is found
			if ($record &&
					$found) {
				// Record function off
				$record = false;

				// If the entry is a number
				if (is_numeric($entry)) {
					// Convert it explicitly into a float
					// Makes for appropriate comparisons
					$entry = floatval($entry);
				}

				// Push the entry to the array
				$result[] = $entry;
				// Reset the entry
				$entry = '';

				// Skip the pattern
				$index += $size - 1;
			}

			if ($record) {
				// Record the letter into the entry
				$entry .= $splitject[$index];
			}			

			// Next letter
			++$index;
		}		
	} else {
		// Something went wrong, abort
		$result = abort();
	}

	return $result;
}
