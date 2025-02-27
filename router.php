<?php

// Get the current page url
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// Page error handling
function abort() {
	require_once "views/404.php";

	// Stop everything
	die();
}

// Get the correctly linked pages
function routeToController($uri) {
	// If the current page is a valid key url
	if (array_key_exists($uri, ROUTES)) {
		// Load the right page
		require_once ROUTES[$uri];
	} else {
		abort();
	}
}

routeToController($uri);