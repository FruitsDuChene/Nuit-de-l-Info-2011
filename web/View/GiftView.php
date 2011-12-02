<?php

class GiftView
{
	public static function showGiftButton($mode) {

	global $ROOT_PATH;

	$url_gift = CNavigation::generateUrlToApp('Gift','form', array('mode'=>$mode));

	echo <<<END
		<div class="well">
        <a href="$url_gift" class="btn large primary">Ajouter un cadeau</a>
      </div>
END;
	}

	public static function showForm($mode) {

		$url_submit = CNavigation::generateUrlToApp('Gift', 'form');
		$hmode = htmlspecialchars($mode);

		echo <<<END
<form action="$url_submit" name="gift_form" method="post" id="gift_form">
	<input type="hidden" name="mode" value="$hmode" />
<fieldset>
	<div class="clearfix">
	</div>
	<div class="clearfix">
		<label for="input_nom">Nom</label>
		<div class="input">
			<input name="nom" id="input_nom" type="text" autofocus required />
		</div>
	</div>
	<div class="clearfix">
		<label for="input_description">Description</label>
		<div class="input">
			<textarea name="description" id="input_description" type="text">
			</textarea>
		</div>
	</div>
	<div class="clearfix">
		<label for="input_eve">Évènement</label>
		<div class="input">
			<input name="eve" id="input_eve" type="text" />
		</div>
	</div>
	<div class="actions">
		<input type="submit" class="btn large primary" value="Ajouter le cadeau" />
	</div>
</fieldset>
</form>
END;
	}

	public static function showList($mod) {

		global $ROOT_PATH;
		CHead::addJS('jquery.tablesorter.min');
		
		echo <<<END
<table class="zebra-striped gift_list" id="gift_list">
	<thead>
		<tr>
			<th class="header green">Nom</th>
			<th class="header orange">Description</th>
			<th class="header blue">Évènement</th>
		</tr>
	</thead>
	<tbody>
END;

		foreach ($mod as $gift) {
		
			$hnom = htmlspecialchars($gift->nom);
			$hdescription = htmlspecialchars($gift->description);
			$heve = htmlspecialchars($gift->eve);

			echo <<<END
		<tr>
			<td>$hnom</td>
			<td>$hdescription</td>
			<td>$heve</td>
		</tr>
END;
		
		}
		echo <<<END
	</tbody>
</table>

<script type="text/javascript">
$('.gift_list').tablesorter();
</script>
END;
	}

}

?>
