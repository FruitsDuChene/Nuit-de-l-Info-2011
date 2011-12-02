<?php

class Login
{
  public function __construct() {
    $host = 'http://' . $_SERVER['SERVER_NAME'];
    //$this->redirect_uri = $host . CNavigation::generateUrlToApp('Login', 'index');
    $this->redirect_uri = $host . CNavigation::generateUrlToApp('Dashboard', 'index');
  }

  public function index() {
    /*
    $code = (isset($_REQUEST['code'])) ? $_REQUEST['code'] : null;
    $this->serverSideFlow($code);
    */
    $this->jsLogin();
    LoginView::showForm($this->redirect_uri);
  }

  private function jsLogin() {

  }

  private function serverSideFlow($code) {

    if(empty($code)) {
      $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
      $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
        . APP_ID . "&redirect_uri=" . urlencode($this->redirect_uri) . "&state="
        . $_SESSION['state'];

      header('Location: ' . $dialog_url);
      //echo("<script> top.location.href='" . $dialog_url . "'</script>");
    }

    if($_REQUEST['state'] == $_SESSION['state']) {
      //groaw($_REQUEST);
      //groaw($_SESSION);
      $token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . APP_ID . "&redirect_uri=" . urlencode($this->redirect_uri)
        . "&client_secret=" . APP_SECRET . "&code=" . $code;

      $response = @file_get_contents($token_url);
      $params = null;
      parse_str($response, $params);

      $graph_url = "https://graph.facebook.com/me?access_token=" 
        . $params['access_token'];

      $user = json_decode(file_get_contents($graph_url));

	  $_SESSION['logged'] = true;
      echo("Hello " . $user->name);
    }
    else {
      echo("The state does not match. You may be a victim of CSRF.");
    }
  }
}

?>
