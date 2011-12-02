<?php
class LoginView extends AbstractView {
	public static function showForm($redirect_uri) {
        

          // Permissions : https://developers.facebook.com/docs/authentication/permissions
          //$scope = 'scope=email,read_stream';
          //$url_oauth = 'https://www.facebook.com/dialog/oauth?' . $client_id . '&' . $redirect_uri . '&' . $scope;

          //LoginView::register($redirect_uri);
          LoginView::login($redirect_uri);
        }
          private static function login() {
?>

      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '<?php echo APP_ID; ?>',
            status     : true, 
            cookie     : true,
            xfbml      : true
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
      <div class="fb-login-button">Login with Facebook</div>

<?php
        }

        private static function register($redirect_uri) {
?>

      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '<?php echo APP_ID; ?>',
            status     : true, 
            cookie     : true,
            xfbml      : true
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
      <div 
        class="fb-registration" 
        data-fields="[{'name':'name'}, {'name':'email'}]" 
        data-redirect-uri="<?php echo $redirect_uri; ?>"
      </div>
<?php
        }

	public static function showLoginButton() {
		$login_url = CNavigation::generateUrlToApp('Session', 'submit');
		global $ROOT_PATH;

		echo <<<END
<h1 class="title">Le Lapin Malin</h1>

<p class="facebook_login"><a href="$login_url">Se connecter avec facebook <em>(obligatoire)</em></a></p>
END;
	}
        
}
?>
