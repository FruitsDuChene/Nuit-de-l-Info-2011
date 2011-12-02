<?php

class User
{
	public function index() {
		//groaw(R::find('user'));

		CNavigation::setTitle('Mon profil');
		CNavigation::setDescription('Informations importantes');

		UserView::showProfil();

		//groaw(CTools::fb('me/events'));
		//groaw($_SESSION['facebook']);
	}

	public function settings() {
		CNavigation::setTitle('Préférences du compte');
		CNavigation::setDescription('Modifiez les préférences de votre compte');

		UserView::showPrefs();
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
