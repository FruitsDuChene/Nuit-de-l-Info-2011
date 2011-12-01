<?php

define('NO_LOGIN_REQUIRED', true);
define('NO_HEADER_BAR', true);

class Session
{
	public function index() {
		$this->login();
	}

	public function login() {
		CHead::addJs('sha1');
		CHead::delCSS('bootstrap.min');
		new SessionView();
	}

	public function logout() {
		session_destroy();

		new CMessage(_('Successful logout'));

		CNavigation::redirectToApp();
	}
}

?>
