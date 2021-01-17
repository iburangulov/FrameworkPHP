<?php

return [
	'request_url' => htmlspecialchars(trim($_SERVER['REQUEST_URI'], '/')),
	'request_method' => strtolower($_SERVER['REQUEST_METHOD']),
	'get_method_data' => $_GET,
	'post_method_data' => $_POST
];