<?php

define('NO_LOGIN_REQUIRED', true);
define('NO_HEADER_BAR', true);

class Session
{
	public function __construct() {
		$host = 'http://' . $_SERVER['SERVER_NAME'];
		$this->redirect_uri = $host . CNavigation::generateUrlToApp('Session', 'index');
	}

	public function index() {
		$code = (isset($_REQUEST['code'])) ? $_REQUEST['code'] : null;
		$this->serverSideFlow($code);
	}

	/*public function login() {

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
	}*/

	public function logout() {
		session_destroy();

		new CMessage(_('Successful logout'));

		CNavigation::redirectToApp('Session','login');
	}
  
	private function serverSideFlow($code) {

		if(empty($code)) {
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
			$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
			. APP_ID . "&redirect_uri=" . urlencode($this->redirect_uri) . "&state="
			. $_SESSION['state'];

			CNavigation::redirectToURL($dialog_url);
		}

		if($_REQUEST['state'] == $_SESSION['state']) {
			$token_url = "https://graph.facebook.com/oauth/access_token?"
			. "client_id=" . APP_ID . "&redirect_uri=" . urlencode($this->redirect_uri)
			. "&client_secret=" . APP_SECRET . "&code=" . $code;

			$response = @file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);

			$graph_url = "https://graph.facebook.com/me?access_token=" 
			. $params['access_token'];

			$user = json_decode(file_get_contents($graph_url));

			groaw($user);
			$_SESSION['logged'] = true;
			echo("Hello " . $user->name);
		}
		else {
			echo("The state does not match. You may be a victim of CSRF.");
		}
	}
}

?>
