<!DOCTYPE html>
<html>
<head>
	<title><?php echo htmlspecialchars(CNavigation::getTitle()); ?> - Tortue</title>
<?php foreach (CHead::$css as $css)
{
	echo "\t<link href=\"$ROOT_PATH/Css/$css.css\" media=\"screen\" rel=\"Stylesheet\" type=\"text/css\" />\n";
}
foreach (CHead::$js as $js)
{
	echo "\t<script type=\"text/javascript\" src=\"$ROOT_PATH/Js/$js.js\"></script>\n";
}
?>
</head>
<body>
<?php

if (!defined('NO_HEADER_BAR')) {

	/*$url_redaction = CNavigation::generateUrlToApp('Redaction',null,null);
	$url_logout = CNavigation::generateUrlToApp('Session','logout',null);*/

	$title = htmlspecialchars(CNavigation::getBodyTitle());

	$description = CNavigation::getDescription();

	if ($description) {
		$title = "$title&nbsp;&nbsp;<small>".htmlspecialchars($description)."</small>";
	}

	$url_root = CNavigation::generateUrlToApp(null);
	$url_urls = CNavigation::generateUrlToApp('Archive', 'urls');
	$url_show = CNavigation::generateUrlToApp('Dashboard', 'show');
	$url_user = CNavigation::generateUrlToApp('User');
	$url_logout = CNavigation::generateUrlToApp('Session', 'logout');

	$user_name = htmlspecialchars($_SESSION['facebook']->name);

	echo <<<END
<div class="topbar">
	<div class="topbar-inner">
		<nav class="container">
			<h3><a href="$url_root">Tortue</a></h3>
				<ul class="nav left">
					<li class="active points">Mes points : 4562</li>
					<li class="notification"><a href="#">45</a></li>
				</ul>
					<ul class="nav right">
					<li class="active"><a href="#">Mon profil</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle">$user_name</a>
						<ul class="dropdown-menu">
							<li><a href="$url_user">Préférences</a></li>
							<li><a href="$url_user">Aide</a></li>
							<li class="divider"></li>
							<li><a href="$url_logout">Déconnexion</a></li>
						</ul>
					</li>
					<li><a href="#about">Mes suggestions</a></li>
					<li><a href="#contact">element</a></li>
				</ul>
			<!--<form action="#">
				<input type="text" placeholder="Search">
			</form>-->
		</nav>
	</div>
</div>
<div class="container" id="mainContent">
<div class="content">
<div class="page-header">
	<h1>$title</h1>
</div>
END;
} else
{
echo '<div class="container" id="mainContent">';
}

if (DEBUG) {
	showGroaw();
}
?>

<?php
echo $PAGE_CONTENT;
?>

</div>
</div>
</body>
</html>
