<?php
class FriendsView extends AbstractView {
	public static function friendsAsList($friends) {
		
		print '<ul>';
		foreach($friends as $f) {
			//print '<li>' . $f->id . '</li>';
			print '<li>' . $f->name . '</li>';
			
			//groaw($f);
		}
		print '</ul>';
		
		
	}
}
?>
