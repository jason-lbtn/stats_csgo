<?php
session_start();
?>
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/Ban.css" />
<link rel="icon" type="image/x-icon" href="imgPack/csgoIcon.bmp" />
<title>OPTILANSTATS CS:GO</title>
<script type="text/javascript" src='jquery.js'></script>
</head>
<body>
<aside id="banLeft">
BANNIERE LATERALE
</aside>
<aside id="banRight">
<?php include 'banRight.php'; ?>
</aside>
<section id="corps">
<?php include 'header.php'; ?>
<body>
<?php
if(isset($_POST['botsOn']) && $_POST['botsOn'] == 'on'){
$_SESSION['bots'] = 1;
}
elseif(isset($_POST['botsOff']) && $_POST['botsOff'] == 'on'){
$_SESSION['bots'] = 0;}
elseif(isset($_SESSION['bots']) && $_SESSION['bots'] == 1 && !isset($_POST['botsOn']) && !isset($_POST['botsOff'])){
$_SESSION['bots'] = 1;}
else{
$_SESSION['bots'] = 0;}
if(isset($_POST['Interface1']) && $_POST['Interface1'] == 'on'){
$_SESSION['Interface'] = 1;
}
elseif(isset($_POST['Interface0']) && $_POST['Interface0'] == 'on'){
$_SESSION['Interface'] = 0;}
elseif(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 1 && !isset($_POST['Interface1']) && !isset($_POST['Interface0'])){
$_SESSION['Interface'] = 1;}
else{
$_SESSION['Interface'] = 0;}

if(isset($_POST['bddSync']) && $_POST['bddSync'] == 'on'){
$_SESSION['bddSync'] = 1;
}
else{
$_SESSION['bddSync'] = 0;}

if(isset($_POST['classOrderSelect'])) {
$_SESSION['classOrder'] = $_POST['classOrderSelect'];
}
else if(!isset($_POST['classOrderSelect']) && !isset($_SESSION['classOrder']))
	$_SESSION['classOrder'] = 'score';
?>
<br />
<br />
<br />
<?php include 'footer.php'; ?>
</body>
</html>