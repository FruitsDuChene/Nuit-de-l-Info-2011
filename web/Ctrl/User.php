<?php

class User
{
	public function index() {
		//groaw(R::find('user'));

		CNavigation::setTitle('Profil');
		CNavigation::setDescription('Dominez le monde, et achetez des canards');

		UserView::showProfil();
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
