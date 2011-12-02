<?php

define('NO_LOGIN_REQUIRED', true);
define('NO_HEADER_BAR', true);

// http://157.169.101.145

class Session
{
	public function __construct() {
		$host = 'http://' . $_SERVER['SERVER_NAME'];
		$this->redirect_uri = $host . CNavigation::generateUrlToApp('Session', 'submit');
	}
	
	public function index() {
		$this->login();
	}

	public function login() {
		LoginView::showLoginButton();

			CHead::addJs('sha1');
			CHead::delCSS('bootstrap.min');
			new SessionView();
	}

	public function submit() {
		$code = (isset($_REQUEST['code'])) ? $_REQUEST['code'] : null;
		$this->serverSideFlow($code);
	}

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

			$_SESSION['access_token'] = $params['access_token'];
			$user = CTools::fb("me");
			$_SESSION['facebook'] = $user;
			$_SESSION['id'] = $user->id;
			$_SESSION['logged'] = true;
			
			$u = R::findOne('user', 'facebook_id = ?', array($_SESSION['id']));

			if ($u) {
				$_SESSION['bd_id'] = $u->id;
			}
			else
			{
				$u = R::dispense('user');
				$u->facebook_id = $user->id;
				$_SESSION['bd_id'] = R::store($u);
			}
		
			CNavigation::redirectToApp();
		}
		else {
			echo("The state does not match. You may be a victim of CSRF.");
			$_SESSION['logged'] = false;
		}
	}
}

?>
