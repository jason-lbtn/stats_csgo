<head>
	<link rel="stylesheet" href="styles/Ban.css" />
</head>
<a href="Options.php" id="rightBan">> OPTIONS</a><br />
<?php

if(isset($_SESSION['Interface'])) {

	if($_SESSION['Interface'] == 0)
		echo "<info id='info'>. INTERFACE <white style='color: white;'>CLASSIQUE</white></info>";

	else if($_SESSION['Interface'] == 1)
		echo "<info id='info'>. INTERFACE <white style='color: white;'>DYNAMIQUE</white></info>";
}

if(isset($_SESSION['Interface']) && isset($_SESSION['bots']))
	echo '<br />';

if(isset($_SESSION['bots'])) {

	if($_SESSION['bots'] == 0)
		echo "<info id='info'>. BOTS <white style='color: white;'>DESACTIVES</white></info>";

	else if($_SESSION['bots'] == 1)
		echo "<info id='info'>. BOTS <white style='color: white;'>ACTIVES</white></info>";
}

if(isset($_SESSION['Interface']) || isset($_SESSION['bots']))
	echo '<br />';

if(isset($_SESSION['classOrder'])) {
	echo "<info id='info'>. CLASSEMENT PAR <white style='color: white;'>".mb_strtoupper($_SESSION['classOrder'])."</white></info>";
}
?>