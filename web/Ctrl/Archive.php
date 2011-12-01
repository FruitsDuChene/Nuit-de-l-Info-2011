<?php

class Archive
{
	public function index() {
		$this->urls();
	}

	public function urls() {
		$view = new UrlView(URL::getAll());
		$view->showList();
	}

	public function show() {
		groaw(Capture::getAll());
	}

	public function versions() {
		if (!isset($_REQUEST['url'])) {
			CNavigation::redirectToApp();
		}

		$url = new URL($_REQUEST['url']);

		$view = new CaptureView($url->getCaptures());
		$view->showList($url->url);
	}
}
