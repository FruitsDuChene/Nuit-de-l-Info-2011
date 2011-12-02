<?php

class User
{
	public function index() {
		//groaw(R::find('user'));

		CNavigation::setTitle('Mon profil');
		CNavigation::setDescription('Voici les informations importantes');

		UserView::showProfil();

		//groaw(CTools::fb('me/events'));
		//groaw($_SESSION['facebook']);
	}

	public function add_example() {
		$g = R::dispense('user');

		$g->nom = "Dion";
		$g->prenom = "Céline";

		$id = R::store($g);

		groaw($id);
	}

}

?>
