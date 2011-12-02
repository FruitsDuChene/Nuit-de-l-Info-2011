<?php
class FriendsView extends AbstractView {
	public static function friendsAsList($friends) {
		
		$friends = CTools::fb("me/friends");
		$friends = $friends->data;
		
		print '<ul>';
		foreach($friends as $f) {
			//print '<li>' . $f->id . '</li>';
			print '<li>' . $f->name . '</li>';
			
			$friend = CTools::fb($f->id);
		}
		print '</ul>';
		
		
	}
	
}
?>
