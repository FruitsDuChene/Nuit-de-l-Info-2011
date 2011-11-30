<?php

// The output is in a buffer
ob_start();

require_once('config.php');

require_once('Tools/autoload.php');
require_once('Tools/debug.php');

$ROOT_PATH = dirname($_SERVER['SCRIPT_NAME']);

if (URL_REWRITING) {
	CNavigation::urlRewriting();
}

date_default_timezone_set(TIME_ZONE);

session_start();

$CTRL_NAME = isset($_REQUEST['CTRL']) ? $_REQUEST['CTRL'] : 'Session';
$ACTION_NAME = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'index';

// It's better to remove path special characters
$ctrl_filename = 'Ctrl/'.strtr($CTRL_NAME, '/\\.', '   ').'.php';
if (file_exists($ctrl_filename)) {
	require_once($ctrl_filename);
} else {
	$CTRL_NAME = 'Dashboard';
}

$CTRL = new $CTRL_NAME();
if (!method_exists($CTRL, $ACTION_NAME)) {
	$ACTION_NAME = 'index';
}

$CTRL->{$ACTION_NAME}();

// If just the body is requested, the page is printed
if (isset($_REQUEST['AJAX_MODE'])) {
	ob_end_flush();
}
else {
	// Call of the function
	CHead::addCSS('bootstrap.min');
	CHead::addCSS('application');
	CHead::addCSS($CTRL_NAME);
	CHead::addJS('application');
	CHead::addJS($CTRL_NAME);

	CMessage::showMessages();

	$PAGE_CONTENT = ob_get_contents();
	ob_end_clean();

	if (isset($_REQUEST['PRELOAD_MODE'])) {
		header('Content-Type: image/gif');
		echo file_get_contents('Img/Transparent.gif');
	}
	else {
		header ('Content-Type: text/html; charset=utf-8');
		require('View/template.php');
	}
}
?>
