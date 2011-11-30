<?php
class CaptureView extends AbstractView {
	public static function showForm($url_value) {

		$url_submit = CNavigation::generateUrlToApp('Dashboard', 'submit');
		$label_url = _('URL');
		$label_tags = _('Tags');
		$legend_text = _('Create a new diskette of an URL');
		$submit_text = _('Create');

		$url_value = htmlspecialchars($url_value);

		echo <<<END
<form action="$url_submit" name="capture_form" method="post" id="capture_form">
<fieldset>
	<legend>$legend_text</legend>
	<div class="clearfix">
		<label for="input_url">$label_url</label>
		<div class="input">
			<input name="url" id="input_url" type="text" autofocus required value="$url_value" />
		</div>
	</div>
	<div class="clearfix">
		<label for="input_tags">$label_tags</label>
		<div class="input">
			<input name="tags" id="input_tags" type="text" />
		</div>
	</div>
	<div class="actions">
		<input type="submit" class="btn large primary" value="$submit_text" />
	</div>
</fieldset>
</form>	
END;
	}

	public function showList($url) {

		global $ROOT_PATH;

		include_once 'Tools/phpqrcode/qrlib.php';
	
		CHead::addJS('jquery-1.6.2.min');
		CHead::addJS('jquery.tablesorter.min');

		echo <<<END
<table class="zebra-striped capture_list" id="canard">
	<thead>
		<tr>
			<th class="header">Label</th>
			<th class="header yellow headerSortDown">Date</th>
			<th class="header green">Status code</th>
			<th class="header orange">Type</th>
			<th class="header blue">Size</th>
			<th class="header purple">Version</th>
		</tr>
	</thead>
	<tbody>
END;

		foreach ($this->model as $capture) {
			$link = CNavigation::generateUrlToApp('Archive', 'versions', array('url' => $url));
		
			$icon = $this->getMimeIcone($capture->type);
			$date = htmlspecialchars($this->formateDate($capture->date));
			$statusCode = htmlspecialchars($capture->statusCode);
			$type = htmlspecialchars($capture->type);
			$size = CTools::nbBytesToKibis($capture->size);
			$size = number_format($size[0], (fmod($size[0], 1) == 0.0) ? 0 : 2).' '.$size[1];

			$qrcode_text = $url.strftime(' - %d/%m/%y %H:%M:%S', $capture->date);
			$qrcode_path = CTools::getDataPath(sha1($qrcode_text), true);

			QRCode::png($qrcode_text, $qrcode_path, QR_ECLEVEL_L, 2, 0);

			echo <<<END
		<tr>
			<td class="diskette"><a href="#"><img src="$ROOT_PATH/$qrcode_path" alt="" /></a></td>
			<td><a href="#"><span style="display:none">$capture->date</span>$date</a></td>
			<td><a href="#">$statusCode</a></td>
			<td class="mimetype"><a href="#"><img src="$ROOT_PATH/Img/mimes/$icon.png" alt=""/>$type</a></td>
			<td><a href="#"><span style="display:none">$capture->size</span>$size</a></td>
			<td class="version"><a href="#">$capture->version</a></td>
		</tr>
END;
		/*echo "<li><a href=\"$link\">\n\t<img src=\"$ROOT_PATH/Img/mimes/$icon.png\" alt=\"",
			htmlspecialchars($capture->type), "\" class=\"icon\"/>\n\t",
			"\n\t<strong>",
			htmlspecialchars($date), "</strong>\n\t - <em class=\"size\">",
			, "</em> - Status: <strong>",$capture->statusCode,"</strong>\n</a></li>\n";
		}
		echo "</ul>\n";*/

		}
		echo <<<END
	</tbody>
</table>
END;
	}
}
?>
