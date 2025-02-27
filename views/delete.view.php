
<!-- Tab depth matters -->
		<br>
		<?php
		echo "<br>";
		newLine();

		// Turn tags of a database line into a anme string for a button
		function tag2button($taggers, $amount = 0, $break = '', $ask = '') {
			$label = '';

			// Go through all tags within the selected line
			foreach ($taggers as &$tag) {	
				// What is the type of the tag		
				$type = gettype($tag);

				// Clean the strings for script protection
				if ($type === "string") {
					$tag = htmlspecialchars($tag);
				}

				// Add tag and separator
				$label .= $tag . SEPARATOR;
			}

			// Add ask
			$label .= $ask;

			if ($break) {
				tabStacks($amount);
				echo $break;
				newLine();	
			}
			
			// Create the button
			makeFormButton('/delete', $label, $amount, 'POST', $ask === QUESTION);
		}

		// For each grocery entry line a button
		foreach($groceries as $grocery) {			
			tag2button($grocery, 2);
		}
		
		// Button for selected grocery line
		if (!empty($groc)) {
			tag2button($groc, 2, "<br>", QUESTION);
		}	
		?>
