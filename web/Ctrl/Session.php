<?php

define('NO_LOGIN_REQUIRED', true);
define('NO_HEADER_BAR', true);

class Session
{
	public function index() {
		$this->login();
	}

	public function login() {

		if (CNavigation::isValidSubmit(array('email_facebook', 'password_facebook') , $_REQUEST))
		{
			$_SESSION['logged'] = true;
			CNavigation::redirectToApp();
		}
		else
		{
			CHead::addJs('sha1');
			CHead::delCSS('bootstrap.min');
			new SessionView();
		}
	}

	public function logout() {
		session_destroy();

		new CMessage(_('Successful logout'));

		CNavigation::redirectToApp('Session','login');
	}
}

?>
