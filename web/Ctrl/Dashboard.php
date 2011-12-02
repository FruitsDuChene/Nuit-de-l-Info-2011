<?php

class Dashboard
{

	public function refresh() {
		$c = new User();
		$c->index();
		//echo "bordel de merde";
		//groaw(R::find('user_gift'));

	}

	public function index() {
			$friends = CTools::fb("me/friends");
			FriendsView::friendsAsList($friends->data);
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
