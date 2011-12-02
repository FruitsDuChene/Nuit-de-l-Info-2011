<?php

class GiftView
{
	public static function showGiftList() {

	global $ROOT_PATH;

	$url_gift = CNavigation::generateUrlToApp('Gift','form');

	echo <<<END
		<div class="well">
        <a href="$url_gift" class="btn large primary">Ajouter un cadeau</a>
      </div>
END;
	}

	public static function showForm() {

		$url_submit = CNavigation::generateUrlToApp('Gift', 'form');

		echo <<<END
<form action="$url_submit" name="gift_form" method="post" id="gift_form">
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
}

?>
