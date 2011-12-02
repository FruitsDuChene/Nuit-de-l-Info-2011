<?php

class Dashboard
{

	public function refresh() {
		$c = new Gift();
		$c->form();
		//echo "bordel de merde";
		//groaw(R::find('user_gift'));

	}

	public function index() {
			$this->refresh();
			return;
			$friends = CTools::fb($_SESSION['facebook']->id."/friends");
			groaw($friends);
			FriendsView::friendsAsList($friends->data);
		groaw($_SESSION);
		/*$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : null;
		CaptureView::showForm($url);*/

		/*$book = R::dispense( 'book' );
		$book->coucou = "Salut";
		R::store($book);*/
		echo "coucou tu veux voir ma bite ?<h2>Vous avez perdu !</h2>";

	}

	public function submit() {
		groaw($_POST);

		if (!CNavigation::isValidSubmit(array('url'), $_REQUEST)) {
			new CMessage('An url is required');
			CNavigation::redirectToApp('Dashboard');
		}
	
		$capture = new Capture(time(), $_REQUEST['url']);
		$capture->download();
		$capture->save();
		groaw($capture);
	}
}

?>
