
<!-- Tab depth matters -->
		<br>
		<form action="/create" method="POST">
			<?php
				$amount = 0;
				// For each tag
				foreach (TAGS as $tag) {
					// Translate the tag
					$lang = EN2NL[$tag];
					// Generate source html tabs
					tabStacks($amount);
					$amount = 3;
					// Translated input field header
					echo "<label for=$tag>$lang</label>";
					newLine();
					// Generate source html tabs
					tabStacks($amount);
					echo "<br>";
					newLine();
					// Generate source html tabs
					tabStacks($amount);
					// Input field
					echo "<input type='text' id=$tag name=$tag value=''>";
					newLine();
					// Generate source html tabs
					tabStacks($amount);
					echo "<br>";
					newLine();
					// Show applicable input errors
					if (!empty($errors[$tag])) {
						// Generate source html tabs
						tabStacks($amount);
						echo "<div class='writing'>$errors[$tag]</div>";
						newLine();
					}
				}
			?>
			<br>
			<!-- Submit button -->
			<input type="submit" value="Toevoegen">
		</form>
		<form action="/create" method="POST">
			<?php


			makeFormInput(TAGS[0], 'Sentry', 3);

			?>

			<input type="submit" value="Add">
		</form>
