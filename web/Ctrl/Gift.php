<?php

class Gift
{

	public function index() {
		$this->my_gifts();
	}

	public function form() {
	
		if (CNavigation::isValidSubmit(array('nom', 'description', 'eve', 'mode'), $_REQUEST))
		{
			$u = R::load('user', $_SESSION['bd_id']);

			$g = null;
			$redirect = 'my_gifts';

			switch (strtolower($_REQUEST['mode'])) {
				case "my":
					$g = R::dispense('m_gift');
					break;
				case "want":
					$g = R::dispense('w_gift');
					$redirect = 'gift_list';
					break;
				default:
					die("connard");
			}
			
			$g->user = $u;
			$g->nom = $_REQUEST['nom'];
			$g->description = $_REQUEST['description'];
			$g->eve = $_REQUEST['eve'];

			R::store($g);

			new CMessage('Cadeau correctement ajouté');

			CNavigation::redirectToApp('Gift', $redirect);
		}
		else
		{
			if ($_REQUEST['mode'] === 'want') {
				CNavigation::setTitle("Nouveau cadeau");
				CNavigation::setDescription("Ajoutez un cadeau dont vous avez envi");
			}
			else
			{
				CNavigation::setTitle("Nouveau cadeau");
				CNavigation::setDescription("Ajoutez un cadeau que l'on vous a offert");
			}

			GiftView::showForm($_REQUEST['mode']);
		}
	}

	public function my_gifts() {
		CNavigation::setTitle("Mes cadeaux");
		CNavigation::setDescription("Cadeaux que j'ai déjà reçu");

		$u = R::load('user', $_SESSION['bd_id']);

		GiftView::showList($u->ownM_gift);
		GiftView::showGiftButton('my');
	}
	public function gift_list() {
		CNavigation::setTitle("Mes envies");
		CNavigation::setDescription("Les cadeaux que j'aimerais avoir");

		$u = R::load('user', $_SESSION['bd_id']);

		GiftView::showList($u->ownW_gift);
		GiftView::showGiftButton('want');
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
		groaw(R::find('gift_history', 'user_to_id = ?', array(1)));
		groaw($u->ownUser_gift);*/
		//groaw($u->ownGift_history);
		
		groaw(R::find('gift_history', 'user_to_id = ?', array(1)));
	}
}

?>
