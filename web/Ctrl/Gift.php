<?php

class Gift
{

	public function index() {
		groaw(R::find('gift'));
	}

	public function add_example() {
		$g = R::dispense('gift');

		$g->nom = "Gode en or";
		$g->description = "Version grand luxe";
		$g->url = "http://sophie.com/";

		$id = R::store($g);

		groaw($id);
	}

	public function user_gift_example() {
		$u = R::load('user', 2);
		$g = R::load('gift', 2);

		$r = R::dispense('user_gift');

		$r->user = $u;
		$r->gift = $g;
		$r->note = -7;

		groaw(R::store($r));
	}
	
	public function user_gift_example_2() {
		$u = R::load('user', 2);
		$t = R::load('user', 1);
		$g = R::load('gift', 2);

		$r = R::dispense('gift_history');

		$r->user_to = $u;
		$r->user_from = $t;
		$r->gift = $g;
		$r->note = -7;

		groaw(R::store($r));
	}

	public function get_gift_example() {
		/*$u = R::load('user', 1);
		groaw($u->ownUser_gift);*/
		//groaw($u->ownGift_history);
		
		groaw(R::find('gift_history', 'user_to_id = ?', array(1)));
	}
}

?>
