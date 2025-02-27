<!-- Tab depth matters -->
	<body>
		<nav>
			<?php
			$amount = 0;

			// Make the navigation buttons
			foreach (NAVLINKS as $link => $message) {
				makeFormButton($link, $message, $amount);
				$amount = 3;
			}
			?> 
		</nav>