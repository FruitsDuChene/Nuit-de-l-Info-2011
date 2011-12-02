<?php

class Offer
{

	public function index() {
		$this->friend_list();
	}

	public function friend_list() {
		CNavigation::setTitle("Mes amis");
		CNavigation::setDescription("Sélectionnez l'ami à qui vous voulez offrir un cadeau");

	$friends = CTools::fb($_SESSION['facebook']->id."/friends");
	$friends = $friends->data;
	
	foreach($friends as &$f) {
		$f->nb_cadeaux = R::getrow('select count(*) as nb from w_gift w, user u where w.user_id = u.id and u.facebook_id = ?', array(intval($f->id)));

		$f->nb_cadeaux = $f->nb_cadeaux['nb'];
		$f->nom = $f->name;

		//echo '<a href="#">' . $f->name . '</a>' . '<br />';
	}
	usort($friends, array("Offer", "cmp_friend"));
	UserView::showFriendList($friends);
	
	}

	public function liste() {
		$super_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		$f_u = CTools::fb('/'.$super_id);
		
		CNavigation::setTitle("La liste de ".$f_u->name);
		
		GiftView::showList(R::getAll('select * from w_gift w, user u where w.user_id = u.id and u.facebook_id = ?', array($super_id)));
	}

	static function cmp_friend($a, $b)
    {
        $al = $a->nb_cadeaux;
        $bl = $b->nb_cadeaux;
        if ($al == $bl) {
			$aal = strtolower($a->name);
			$bbl = strtolower($b->name);
        	return ($aal > $bbl) ? +1 : -1;
        }
        return ($al < $bl) ? +1 : -1;
    }
}

?>
