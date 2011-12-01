<?php
class UrlView extends AbstractView {

	public function showList() {
	
		echo "<ul>\n";
		foreach ($this->model as $url) {
			$hurl = htmlspecialchars($url->url);
			$link = CNavigation::generateUrlToApp('Archive', 'versions', array('url' => $url->url));
			echo "\t<li><a href=\"$link\">$hurl</a></li>\n";
		}
		echo "</ul>\n";
	}
}
?>
