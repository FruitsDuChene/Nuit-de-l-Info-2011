<?php

class Error
{
	public function index() {
		$this->page_not_found();
	}

	public function page_not_found() {
		header("Status: 404 Not Found");
		CNavigation::setTitle('Error 404');
		ErrorView::showError(404, "La page est introuvable. C'est une situation regrettable.", "800px-Peugeot_404_Berlin.JPG");
	}
}

?>
