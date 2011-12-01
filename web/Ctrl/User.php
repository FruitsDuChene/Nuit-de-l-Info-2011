<?php

class User
{
	public function index() {
		groaw(R::find('user'));
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
