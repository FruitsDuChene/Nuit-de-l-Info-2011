<?php

class Accessibilite
{

	public function index() {
		CHead::addCSS('demo');
		CHead::addJS('jquery-1.6.2.min');
		CHead::addJS('script');
		AccessibiliteView::show();
	}

}

?>
