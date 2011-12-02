<?php

class Offer
{

	public function index() {
		$this->friend_list();
	}

	public function friend_list() {
		echo "coucou tu veux voir ma bite";
		CNavigation::setTitle("Mes amis");
		CNavigation::setDescription("Sélectionnez l'amis à qui vous voulez offrir un cadeau");

	}
	
}

?>
