<?php

class UserView
{
	
	public static function showProfil() {

	global $ROOT_PATH;
	
	$now = time();
	
	$friends = CTools::fb($_SESSION['facebook']->id."/friends");
	$friends = $friends->data;
	
	foreach($friends as $f) {
		echo '<a href="#">' . $f->name . '</a>' . '<br />';
	}
	
	$birthdays = '';
	$LAST = 5;
	for($i=0; $i<$LAST; $i++) {
		$friend_info = CTools::fb($friends[$i]->id);
		if(isset($friend_info->birthday)) {
			$birthdays .= '<a href="#">' . $friend_info->birthday . '</a>';
			if($i != $LAST-1) $birthdays .= ',';
		}
	}
	
	$events = CTools::fb("/me/events");
	$events = $events->data;
	
	$fetes_today_array = array();
	$fetes_7_array = array();
	$fetes_30_array = array();
	$fetes_7_days = array();
	$fetes_30_days = array();
	$LAST = count($events);
	for($i=0; $i<$LAST; $i++) {
		$tmps = strtotime($events[$i]->start_time);
		$tmpe = strtotime($events[$i]->end_time);
		
		$sec_by_day = 3600 * 24;
		
		$days_until = intval(($tmps - $now) / $sec_by_day);
		
		// 7 jours
		if($tmps > $now && $tmps < ($now + 7 * $sec_by_day)) {
			$fetes_7_array[] = $events[$i]->name;
			$fetes_7_days[] = $days_until;
		}
		
		// 30 jours
		if($tmps > $now && $tmps < ($now + 30 * $sec_by_day)) {
			$fetes_30_array[] = $events[$i]->name;
			$fetes_30_days[] = $days_until;
		}
		
		// Today
		echo date("m.d.y") . ' // ' . date("m.d.y", $tmps) . '<br />';
		if(($now > $tmps && $now < $tmpe) || (date("m.d.y") == date("m.d.y", $tmps))) {
			$fetes_today_array[] = '<a href="#">' . $events[$i]->name . '</a>';
		}
	}
	
	$fetes_today_string = '';
	$fetes_7_string = '';
	$fetes_30_string = '';
	
	for($i=0; $i<count($fetes_today_array); $i++) {
		$fetes_today_string .= $fetes_today_array[$i];
		if($i != count($fetes_today_array)-1) $fetes_today_string .= ', ';
	}
	
	for($i=0; $i<count($fetes_7_array); $i++) {
		$fetes_7_string .= '<div class="eventTimeline"> <span class="imgEvent"><img src="' . $ROOT_PATH . '/Img/wedding.png" alt="wedding logo" width="17px" height="17px"/></span><span class="countDown">dans ' . $fetes_7_days[$i] . ' jours</span><span class="userEventName">C\'est  <a href="#">' . $fetes_7_array[$i] . '</a></span></div>';
	}
	
	for($i=0; $i<count($fetes_30_array); $i++) {
		$fetes_30_string .= '<div class="eventTimeline"> <span class="imgEvent"><img src="' . $ROOT_PATH . '/Img/wedding.png" alt="wedding logo" width="17px" height="17px"/></span><span class="countDown">dans ' . $fetes_30_days[$i] . ' jours</span><span class="userEventName">C\'est  <a href="#">' . $fetes_30_array[$i] . '</a></span></div>';
	}

	echo <<<END
<!-- 1 ROW 3 Collumns -->
		<div class="row">
			<div class="span2" id="left">
				<div id="mesfiltres">
					<h2>Filtres :</h2>
						<ul>
							<li><a href="#"> anniversaire</a></li>
							<li><a href="#"> fetes</a></li>
							<li><a href="#"> mariages</a></li>
						</ul>
				</div>
				<div id="lesmeilleurs">
					<h2>Les meilleurs :</h2>
						<ul>
							<li><a href="#"> Toto</a> : 45</li>
							<li><a href="#"> Tata</a> : 1095</li>
							<li><a href="#"> Titi</a> : 121014</li>
						</ul>
				</div>
			</div>
			
			<!-- 2 ROWS Main DIV-->
			<div class="span11" id="center">
				<!-- Live Notification -->
				<div id="divTodayNotification">
					<div class="alert-message block-message warning">
						<h2>Ce qui se passe aujourd'hui :</h2>
						<p>Les fetes : $fetes_today_string.</p>
						
						<p>Les anniversaires : $birthdays.</p>
					</div>
				</div>	
				<div id="timeLine">
					<h2>Evenements dans les 7 jours a venir :</h2>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/bday.png" alt="birthday logo" width="17px" height="17px"/></span><span class="countDown">dans 3 jours</span><span class="userEventName">Anniversaire de : <a href="#">Toto</a> !</span></div>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/christmas.png" alt="christmas logo" width="17px" height="17px"/></span><span class="countDown">dans 3 jours</span><span class="userEventName">C'est <a href="#">Noel</a> !</span></div>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/valentine.png" alt="valentine logo" width="17px" height="17px"/></span><span class="countDown">dans 3 jours</span><span class="userEventName">C'est <a href="#">la Saint Valentin</a> !</span></div>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/wedding.png" alt="wedding logo" width="17px" height="17px"/></span><span class="countDown">dans 3 jours</span><span class="userEventName">C'est le mariage de <a href="#">Toto</a> et <a href="#">Tata</a>!</span></div>
					$fetes_7_string
					
					<h2>Evenements dans les 30 jours a venir :</h2>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/bday.png" alt="birthday logo" width="17px" height="17px"/></span><span class="countDown">dans 15 jours</span><span class="userEventName">Anniversaire de : <a href="#">Toto</a> !</span></div>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/christmas.png" alt="christmas logo" width="17px" height="17px"/></span><span class="countDown">dans 18 jours</span><span class="userEventName">C'est <a href="#">Noel</a> !</span></div>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/valentine.png" alt="valentine logo" width="17px" height="17px"/></span><span class="countDown">dans 19 jours</span><span class="userEventName">C'est <a href="#">la Saint Valentin</a> !</span></div>
					<div class="eventTimeline"> <span class="imgEvent"><img src="$ROOT_PATH/Img/wedding.png" alt="wedding logo" width="17px" height="17px"/></span><span class="countDown">dans 20 jours</span><span class="userEventName">C'est le mariage de <a href="#">Toto</a> et <a href="#">Tata</a>!</span></div>
					$fetes_30_string
					
					<h2><a href="#">Voire tout les evenements</a></h2>
				</div>
				<div id="footer">
					<p>toto</p>
				</div>
			</div>
		
			
			<div class="span3" id="right">
				<h2>Les suggestions recentes</h2>
				<ul>
					<li>Suggestion : <a href="#">Chevalier de la mort qui tue</a></li>
					<li>Suggestion : <a href="#">Chevalier de la mort qui tue</a></li>
					<li>Suggestion : <a href="#">Chevalier de la mort qui tue</a></li>
				</ul>
			</div>
		</div>
END;
	}
}

?>
