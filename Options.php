<?php
session_start();
?>
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/Ban.css" />
<link rel="stylesheet" href="styles/Options.css" />
<link rel="icon" type="image/x-icon" href="imgPack/csgoIcon.bmp" />
<title>STATS EQUIPES</title>
<script type="text/javascript" src='jquery.js'></script>
</head>
<body>
<aside id="banLeft">
BANNIERE LATERALE
</aside>
<aside id="banRight">
<a href="Classement.php" id="rightBan">RETOUR</a>
</aside>
<section id="corps">
<?php include 'header.php'; ?><br />
<div id='classement'><red style='color: rgb(255, 170, 50)'>OPTIONS</red></div><br />
<?php
echo "<div id='opt'><red style='color: silver; text-align: left;'>BOTS</red></div><br />";
if(!isset($_SESSION['bots']) || $_SESSION['bots'] == 0){
echo'
<form method="post" action="index.php">
   <p>
	<input type="checkbox" name="botsOn" id="botsOn" /> 
	<label for="botsOn"><h39 id="optionsLabels">ACTIVER LES BOTS</h39></label><br />
	<input type="submit" value="Appliquer" />
	</p>
</form>';}
elseif(isset($_SESSION['bots']) && $_SESSION['bots'] == 1){
echo'
<form method="post" action="index.php">
   <p>
		<input type="checkbox" name="botsOff" id="botsOff" />
	<label for="botsOff"><h39 id="optionsLabels">DESACTIVER LES BOTS</h39></label><br /> 
	<input type="submit" value="Appliquer" />
	</p>
</form>';}






echo "<div id='opt'><red style='color: silver; text-align: left;'>ORDRE DE CLASSEMENT</red></div><br />";
if (isset($_SESSION['classOrder'])) {
echo'
<form method="post" action="index.php">
   <p>
	<input type="radio" name="classOrderSelect" value="score" />
		<label for="classOrderSelect"><h39 id="optionsLabels">CLASSER LES JOUEURS SELONS LE SCORE</h39></label><br />
	<input type="radio" name="classOrderSelect" value="kills" />
		<label for="classOrderSelect"><h39 id="optionsLabels">CLASSER LES JOUEURS SELONS LE NOMBRE DE KILLS</h39></label><br />
	<input type="radio" name="classOrderSelect" value="headshots" />
		<label for="classOrderSelect"><h39 id="optionsLabels">CLASSER LES JOUEURS SELONS LE NOMBRE DE HEADSHOTS</h39></label><br />
	<input type="submit" value="Appliquer" />
	</p>
</form>';
}

/*
echo "<div id='opt'><red style='color: silver; text-align: left;'>SYNCHRONISATION AVEC BDD</red></div><br />";
echo'
<form method="post" action="syncBDD.php">
   <p>
	<input type="checkbox" name="bddSync" id="bddSync" /> 
	<label for="bddSync"><h39 id="optionsLabels">Synchroniser</h39></label><br />
	<input type="submit" value="Appliquer" />
	</p>
</form>';
*/
?>
<?php include 'footer.php'; ?>
</body>
</html>