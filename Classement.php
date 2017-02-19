<?php
session_start();
?>
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/Ban.css" />
<link rel="icon" type="image/x-icon" href="imgPack/csgoIcon.bmp" />
<title>CLASSEMENT</title>
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
<?php
// On met a jour les champs

function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }
		return $new_array;
}

        function update($joueur, $champ, $nb) {

                global $statistiques;

                if(!array_key_exists($joueur, $statistiques)) $statistiques[$joueur] = array('score' => 0,'kills' => 0, 'headshots' => 0, 'assists' => 0,'otages' => 0, 'morts' => 0, 'threws' => 0, 'knifeKills' => 0, 'friendKills' => 0, 'bombe' => 0, 'defuse' => 0, 'authJoueur' => 0, 'authBot' => 0, 'equipe' => 0);
                $statistiques[$joueur][$champ] += $nb;}


		function mot($chiffre = 0, $mot = 0){
		if($chiffre < 2){
		if(preg_match('#.+[^S|s$]#', $mot, $motVerifie)){
		$motVerifie = $motVerifie[0];}
		return $motVerifie;}
		elseif($chiffre > 1)
		{return $mot;}
		}
        // On simplifie le nom du joueur
        function player($joueur) {

                return strip_tags($joueur);


        }
		if(isset($_SESSION['bddSync']) AND $_SESSION['bddSync'] == 1)
		{
try
{
$bdd = new PDO('mysql:host=localhost;dbname=statcsgo', 'root', '');
}
catch(Exception $e)
{
die('Erreur : '.$e->getMessage());
}
}

        $log = file('stat.log');
		if($log > 0){
        $statistiques = array();
		$teamStats = array();
		$dateOK = 0;
        foreach($log as $statInfo) {
				$patternLogStart = '#L ([0-9/]{10}) - ([0-9:]{8}): Log file started (.+)#';
				$patternFKHeadshot = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<|TERRORIST>)*" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<|TERRORIST>)*" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternFK = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<|TERRORIST>)*" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<|TERRORIST>)*" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
                $patternHeadshot = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*)" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
                $patternAssists = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "([\s\S]*)"#';
                $patternAchat = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
                $patternConnexion = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(<STEAM[\s\S\d]>)*(?:<>)?" (.+)#';
				$patternOtage = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternBombe = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeam = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*)" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternMostGrenade = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w+) (\w+) (?:\[\-*\d* \-*\d* \-*\d*\])#';
				$patternTeamsKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternTeamsCampsKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternTeamsCampsHeadshots = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\([\w]+\))#';
				$patternTeamsBombe = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsOtage = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsHeadshots = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternTeamsAssists = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "\[+([\s\S]*?)\]+([\s\S]*?)"#';
                $patternTeamsConnexion = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(?:<>)?" (.+)#';
				preg_match("#.*#",$statInfo,$stat);
				if(preg_match("#file#",$statInfo,$stat)){
						preg_match($patternLogStart,$statInfo,$stat);
						if(count($stat) > 0){
						if(isset($dateOK) AND $dateOK == 0)
						{
						$startDate = $stat[1];
						if(isset($_SESSION['bddSync']) AND $_SESSION['bddSync'] == 1)
						{
						$testtest = 'test';
						$patternToReplace = '#/#';
						$Replace = '';
						$startDate = preg_replace($patternToReplace, $Replace, $startDate);
						echo $startDate;
						$BDDcreateTable = $bdd->query("CREATE TABLE coucou()");
						echo '<br /><br />BDD CREEE AVEC SUCCES !';
						}
						$dateOK = 1;
						}
						}}
				if(isset($_SESSION['bots']) && $_SESSION['bots'] == 1){
				if(preg_match("#entered the game#",$statInfo,$stat)){
						preg_match($patternConnexion,$statInfo,$stat);
						if(count($stat) > 0){
						$player = player($stat[3]);
						update(player($stat[3]), 'authBot', 1);
						if($statistiques[player($stat[3])]['authBot'] > 1){
						$statistiques[player($stat[3])]['authBot'] = 1;}
						}}
                if(preg_match("#entered the game#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)){
						preg_match($patternConnexion,$statInfo,$stat);
						if(count($stat) > 0){
						if($statistiques[player($stat[3])]['authBot'] > 0){
						$statistiques[player($stat[3])]['authBot'] == 0;}
						update(player($stat[3]), 'authJoueur', 1);
						if($statistiques[player($stat[3])]['authJoueur'] > 1){
						$statistiques[player($stat[3])]['authJoueur'] = 1;}
						}

                        preg_match($patternTeamsConnexion,$statInfo,$stat);
						if(count($stat) > 0 ){
						if(!isset($teamStats[$team = $stat[3]]['kills']) && !isset($teamStats[$team = $stat[3]]['headshots']) && !isset($teamStats[$team = $stat[3]]['assists']) && !isset($teamStats[$team = $stat[3]]['morts']) && !isset($teamStats[$team = $stat[3]]['otage']) && !isset($teamStats[$team = $stat[3]]['bombe'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;
							$teamStats[$team = $stat[3]]['headshots'] = 0;
							$teamStats[$team = $stat[3]]['morts'] = 0;
							$teamStats[$team = $stat[3]]['assists'] = 0;
							$teamStats[$team = $stat[3]]['otages'] = 0;
							$teamStats[$team = $stat[3]]['bombe'] = 0;
							$teamStats[$team = $stat[3]]['score'] = 0;
							$teamStats[$team = $stat[3]]['defuse'] = 0;}
							}}
			   if	(preg_match("#Planted#",$statInfo,$stat)) {
						preg_match($patternBombe,$statInfo,$stat);
						if(count($stat) > 0 ){
						update(player($stat[3]), 'bombe', 1);}
						preg_match($patternTeamsBombe, $statInfo,$stat);
						if(count($stat) > 0 ){
                        if (isset($teamStats[$team = $stat[3]]['bombe'])){
							++$teamStats[$team]['bombe'];}
						else{
							$teamStats[$team = $stat[3]]['bombe'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['bombe'])){
							$teamStats[$team = $stat[3]]['bombe'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}
							}
				elseif(preg_match("#Defused#",$statInfo,$stat)) {
				preg_match($patternBombe,$statInfo,$stat);
				if(count($stat) > 0){
				update(player($stat[3]), 'defuse', 1);}}
				preg_match($patternTeamsBombe,$statInfo,$stat);
						if(count($stat) > 0 ){
                        if (isset($teamStats[$team = $stat[3]]['defuse'])){
							++$teamStats[$team]['defuse'];}
						else{
							$teamStats[$team = $stat[3]]['defuse'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['defuse'])){
							$teamStats[$team = $stat[3]]['defuse'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}

				elseif(preg_match("#headshot#",$statInfo,$stat)) {

                        preg_match($patternHeadshot,$statInfo,$stat);
                        if(count($stat) > 0) {
								update(player($stat[3]), 'score', 5);
								update(player($stat[3]), 'kills', 1);
                                update(player($stat[3]), 'headshots', 1);
                                update(player($stat[5]), 'morts', 1);
								if($stat[7] == "knife_t")
								{update(player($stat[3]), 'knifeKills', 1);}
								elseif($stat[7] == "knife_default_ct")
								{update(player($stat[3]), 'knifeKills', 1);}
								$arme = $stat[7];
								$killed = player($stat[5]);
								$killer = player($stat[3]);
								$joueur = player($stat[3]);
								if(isset($punchBall[$killer][$killed])){
								++$punchBall[$killer][$killed];}
								else{
								$punchBall[$killer][$killed] = 1;}
								if(isset($nemesis[$killed][$killer])){
								++$nemesis[$killed][$killer];}
								else{
								$nemesis[$killed][$killer] = 1;}
								if (isset($weaponStats[$arme]['headshots'])){
									++$weaponStats[$arme]['headshots'];}
								else{
									$weaponStats[$arme]['headshots'] = 1;}
								if (isset($weaponStats[$arme]['kills'])){
									++$weaponStats[$arme]['kills'];}
								else{
									$weaponStats[$arme]['kills'] = 1;}
								if (isset($mostWeaponHeadshots[$arme][$user = player($stat[3])])){
									++$mostWeaponHeadshots[$arme][$user];}
								else{
									$mostWeaponHeadshots[$arme][$user = player($stat[3])] = 1;}
								if (isset($mostWeapon[$arme][$user = player($stat[3])])){
									++$mostWeapon[$arme][$user];}
								else{
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}}
						preg_match($patternFKHeadshot, $statInfo,$stat);
						if(count($stat) > 0) {
							if($stat[5] == 'CT' && $stat[10] == 'CT' && $stat[5] == $stat[10]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -5);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[3]), 'headshots', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}
							elseif($stat[6] == 'TERRORIST' && $stat[11] == 'TERRORIST' && $stat[6] == $stat[11]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -5);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[3]), 'headshots', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}}

						preg_match($patternTeamsHeadshots, $statInfo,$stat);
						if(count($stat) > 0) {
                        if (isset($teamStats[$team = $stat[3]]['kills'])){
							++$teamStats[$team]['kills'];}
						else{
							$teamStats[$team = $stat[3]]['kills'] = 1;}
                        if (isset($teamStats[$team]['headshots'])){
							++$teamStats[$team]['headshots'];}
						else{
							$teamStats[$team = $stat[3]]['headshots'] = 1;}
                        if (isset($teamStats[$team]['score'])){
							++$teamStats[$team]['score'];
							++$teamStats[$team]['score'];
							++$teamStats[$team]['score'];}
						else{
							$teamStats[$team = $stat[3]]['score'] = 4;}
                        if (isset($teamStats[$team = $stat[6]]['morts'])){
							++$teamStats[$team]['morts'];}
						else{
							$teamStats[$team = $stat[6]]['morts'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
                        }}

                 elseif(preg_match("#killed#",$statInfo,$stat)) {

                        preg_match($patternKills,$statInfo,$stat);
                        if(count($stat) > 0) {
						if(isset($bddSave) AND $bddSave == 1)
						{
						}
								update(player($stat[3]), 'score', 2);
                                update(player($stat[3]), 'kills', 1);
                                update(player($stat[5]), 'morts', 1);
								$weapons[] = $stat[7];
								$arme = $stat[7];
								$joueur = player($stat[3]);
								$killed = player($stat[5]);
								$killer = player($stat[3]);
								if(isset($punchBall[$killer][$killed])){
								++$punchBall[$killer][$killed];}
								else{
								$punchBall[$killer][$killed] = 1;}
								if(isset($nemesis[$killed][$killer])){
								++$nemesis[$killed][$killer];}
								else{
								$nemesis[$killed][$killer] = 1;}
								if (isset($weaponStats[$arme]['kills'])){
									++$weaponStats[$arme]['kills'];}
								else{
									$weaponStats[$arme]['kills'] = 1;}
								if (!isset($weaponStats[$arme]['headshots'])){
									$weaponStats[$arme]['headshots'] = 0;}
								if($stat[7] == "knife_t")
								{update(player($stat[3]), 'knifeKills', 1);}
								elseif($stat[7] == "knife_default_ct")
								{update(player($stat[3]), 'knifeKills', 1);}
								if (isset($mostWeapon[$arme][$user = player($stat[3])])){
									++$mostWeapon[$arme][$user];}
								else{
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}}
						preg_match($patternFK, $statInfo,$stat);
						if(count($stat) > 0) {
							if($stat[5] == 'CT' && $stat[10] == 'CT' && $stat[5] == $stat[10]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -2);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}
							elseif($stat[6] == 'TERRORIST' && $stat[11] == 'TERRORIST' && $stat[6] == $stat[11]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -2);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}}

						preg_match($patternTeamsKills, $statInfo,$stat);
						if(count($stat) > 0) {
                        if (isset($teamStats[$team = $stat[3]]['kills'])){
							++$teamStats[$team]['kills'];}
						else{
							$teamStats[$team = $stat[3]]['kills'] = 1;}
                        if (isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team]['score'] += 2;}
						else{
							$teamStats[$team = $stat[3]]['score'] = 2;}
                        if (isset($teamStats[$team = $stat[6]]['morts'])){
							++$teamStats[$team]['morts'];}
						else{
							$teamStats[$team = $stat[6]]['morts'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}

						}

                } elseif(preg_match("#purchased#",$statInfo,$stat)) {

                        preg_match($patternAchat,$statInfo,$stat);
						}
                elseif(preg_match("#Rescued#",$statInfo,$stat)) {

                        preg_match($patternOtage,$statInfo,$stat);
						if(count($stat) > 0) {
								update(player($stat[3]),'otages', 1);}
						preg_match($patternTeamsOtage, $statInfo,$stat);
						if(count($stat) > 0) {
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['otages'])){
							$teamStats[$team = $stat[3]]['otages'] = 0;}
                        if (isset($teamStats[$team = $stat[3]]['otages'])){
							++$teamStats[$team]['otages'];}
						else{
							$teamStats[$team = $stat[3]]['otages'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}
				} elseif(preg_match("#assisted killing#",$statInfo,$stat)) {

                        preg_match($patternAssists,$statInfo,$stat);
                        if(count($stat) > 0) {
								update(player($stat[3]), 'score', 1);
                                update(player($stat[3]), 'assists', 1);}
						preg_match($patternTeamsAssists, $statInfo,$stat);
						if(count($stat) > 0) {
                        if (isset($teamStats[$team = $stat[3]]['assists'])){
							++$teamStats[$team]['assists'];}
						else{
							$teamStats[$team = $stat[3]]['assists'] = 1;}
                        if (isset($teamStats[$team = $stat[3]]['score'])){
							++$teamStats[$team]['score'];}
						else{
							$teamStats[$team = $stat[3]]['score'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}
                }
				  elseif(preg_match("#threw#", $statInfo,$stat)) {
						preg_match($patternMostGrenade,$statInfo, $stat);
						if(count($stat) > 0) {
						update(player($stat[3]), 'threws', 1);
						}
						}
						}
				else{
				if(preg_match("#entered the game#",$statInfo,$stat)){
						preg_match($patternConnexion,$statInfo,$stat);
						if(count($stat) > 0){
						update(player($stat[3]), 'authBot', 1);
						if($statistiques[player($stat[3])]['authBot'] > 1){
						$statistiques[player($stat[3])]['authBot'] = 1;}
						}}
                if(preg_match("#entered the game#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)){
						preg_match($patternConnexion,$statInfo,$stat);
						if(count($stat) > 0){
						if($statistiques[player($stat[3])]['authBot'] > 0){
						$statistiques[player($stat[3])]['authBot'] == 0;}
						update(player($stat[3]), 'authJoueur', 1);
						if($statistiques[player($stat[3])]['authJoueur'] > 1){
						$statistiques[player($stat[3])]['authJoueur'] = 1;}
						}

                        preg_match($patternTeamsConnexion,$statInfo,$stat);
						if(count($stat) > 0 ){
						if(!isset($teamStats[$team = $stat[3]]['kills']) && !isset($teamStats[$team = $stat[3]]['headshots']) && !isset($teamStats[$team = $stat[3]]['assists']) && !isset($teamStats[$team = $stat[3]]['morts']) && !isset($teamStats[$team = $stat[3]]['otage']) && !isset($teamStats[$team = $stat[3]]['bombe'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;
							$teamStats[$team = $stat[3]]['headshots'] = 0;
							$teamStats[$team = $stat[3]]['morts'] = 0;
							$teamStats[$team = $stat[3]]['assists'] = 0;
							$teamStats[$team = $stat[3]]['otages'] = 0;
							$teamStats[$team = $stat[3]]['bombe'] = 0;
							$teamStats[$team = $stat[3]]['score'] = 0;
							$teamStats[$team = $stat[3]]['defuse'] = 0;}
							}}
			   if	(preg_match("#Planted#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
						preg_match($patternBombe,$statInfo,$stat);
						if(count($stat) > 0 ){
						if($statistiques[player($stat[3])]['authJoueur'] == 1){
						update(player($stat[3]), 'bombe', 1);}}
						preg_match($patternTeamsBombe, $statInfo,$stat);
						if(count($stat) > 0 ){
                        if (isset($teamStats[$team = $stat[3]]['bombe'])){
							++$teamStats[$team]['bombe'];}
						else{
							$teamStats[$team = $stat[3]]['bombe'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['bombe'])){
							$teamStats[$team = $stat[3]]['bombe'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}
							}
				elseif(preg_match("#Defused#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
				preg_match($patternBombe,$statInfo,$stat);
				if(count($stat) > 0){
				if($statistiques[player($stat[3])]['authJoueur'] == 1){
				update(player($stat[3]), 'defuse', 1);}}
				preg_match($patternTeamsBombe,$statInfo,$stat);
						if(count($stat) > 0 ){
                        if (isset($teamStats[$team = $stat[3]]['defuse'])){
							++$teamStats[$team]['defuse'];}
						else{
							$teamStats[$team = $stat[3]]['defuse'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['defuse'])){
							$teamStats[$team = $stat[3]]['defuse'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}}

				elseif(preg_match("#headshot#",$statInfo,$stat)) {

                        preg_match($patternHeadshot,$statInfo,$stat);
                        if(count($stat) > 0) {
						$assistVerif = player($stat[3]);
						$hourKill = $stat[2];
						if($statistiques[player($stat[3])]['authJoueur'] == 1 && $statistiques[player($stat[5])]['authJoueur'] == 1){
								update(player($stat[3]), 'score', 5);
								update(player($stat[3]), 'kills', 1);
                                update(player($stat[3]), 'headshots', 1);
                                update(player($stat[5]), 'morts', 1);
								if($stat[7] == "knife_t")
								{update(player($stat[3]), 'knifeKills', 1);}
								elseif($stat[7] == "knife_default_ct")
								{update(player($stat[3]), 'knifeKills', 1);}
								$arme = $stat[7];
								$killed = player($stat[5]);
								$killer = player($stat[3]);
								$joueur = player($stat[3]);
								if(isset($punchBall[$killer][$killed])){
								++$punchBall[$killer][$killed];}
								else{
								$punchBall[$killer][$killed] = 1;}
								if(isset($nemesis[$killed][$killer])){
								++$nemesis[$killed][$killer];}
								else{
								$nemesis[$killed][$killer] = 1;}
								if (isset($weaponStats[$arme]['headshots'])){
									++$weaponStats[$arme]['headshots'];}
								else{
									$weaponStats[$arme]['headshots'] = 1;}
								if (isset($weaponStats[$arme]['kills'])){
									++$weaponStats[$arme]['kills'];}
								else{
									$weaponStats[$arme]['kills'] = 1;}
								if (isset($mostWeaponHeadshots[$arme][$user = player($stat[3])])){
									++$mostWeaponHeadshots[$arme][$user];}
								else{
									$mostWeaponHeadshots[$arme][$user = player($stat[3])] = 1;}
								if (isset($mostWeapon[$arme][$user = player($stat[3])])){
									++$mostWeapon[$arme][$user];}
								else{
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}}
						preg_match($patternFKHeadshot, $statInfo,$stat);
						if(count($stat) > 0) {
							if($stat[5] == 'CT' && $stat[10] == 'CT' && $stat[5] == $stat[10]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -5);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[3]), 'headshots', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}
							elseif($stat[6] == 'TERRORIST' && $stat[11] == 'TERRORIST' && $stat[6] == $stat[11]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -5);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[3]), 'headshots', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}}

						preg_match($patternTeamsHeadshots, $statInfo,$stat);
						if(count($stat) > 0) {
                        if (isset($teamStats[$team = $stat[3]]['kills'])){
							++$teamStats[$team]['kills'];}
						else{
							$teamStats[$team = $stat[3]]['kills'] = 1;}
                        if (isset($teamStats[$team]['headshots'])){
							++$teamStats[$team]['headshots'];}
						else{
							$teamStats[$team = $stat[3]]['headshots'] = 1;}
                        if (isset($teamStats[$team]['score'])){
							++$teamStats[$team]['score'];
							++$teamStats[$team]['score'];
							++$teamStats[$team]['score'];}
						else{
							$teamStats[$team = $stat[3]]['score'] = 4;}
                        if (isset($teamStats[$team = $stat[6]]['morts'])){
							++$teamStats[$team]['morts'];}
						else{
							$teamStats[$team = $stat[6]]['morts'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
                        }}


                } elseif(preg_match("#killed#",$statInfo,$stat)) {

                        preg_match($patternKills,$statInfo,$stat);
						// print_r($stat);
                        if(count($stat) > 0) {
						$assistVerif = player($stat[3]);
						$hourKill = $stat[2];
						if($statistiques[player($stat[3])]['authJoueur'] == 1 && $statistiques[player($stat[5])]['authJoueur'] == 1){
								update(player($stat[3]), 'score', 2);
                                update(player($stat[3]), 'kills', 1);
                                update(player($stat[5]), 'morts', 1);
								$weapons[] = $stat[7];
								$arme = $stat[7];
								$joueur = player($stat[3]);
								$killed = player($stat[5]);
								$killer = player($stat[3]);
								if(isset($punchBall[$killer][$killed])){
								++$punchBall[$killer][$killed];}
								else{
								$punchBall[$killer][$killed] = 1;}
								if(isset($nemesis[$killed][$killer])){
								++$nemesis[$killed][$killer];}
								else{
								$nemesis[$killed][$killer] = 1;}
								if (isset($weaponStats[$arme]['kills'])){
									++$weaponStats[$arme]['kills'];}
								else{
									$weaponStats[$arme]['kills'] = 1;}
								if (!isset($weaponStats[$arme]['headshots'])){
									$weaponStats[$arme]['headshots'] = 0;}
								if($stat[7] == "knife_t")
								{update(player($stat[3]), 'knifeKills', 1);}
								elseif($stat[7] == "knife_default_ct")
								{update(player($stat[3]), 'knifeKills', 1);}
								if (isset($mostWeapon[$arme][$user = player($stat[3])])){
									++$mostWeapon[$arme][$user];}
								else{
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}}
                        }
						preg_match($patternFK, $statInfo,$stat);
						if(count($stat) > 0) {
							if($stat[5] == 'CT' && $stat[10] == 'CT' && $stat[5] == $stat[10]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -2);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}
							elseif($stat[6] == 'TERRORIST' && $stat[11] == 'TERRORIST' && $stat[6] == $stat[11]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -2);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[8]), 'teamEnnemy', 1);}}

						preg_match($patternTeamsKills, $statInfo,$stat);
						if(count($stat) > 0) {
                        if (isset($teamStats[$team = $stat[3]]['kills'])){
							++$teamStats[$team]['kills'];}
						else{
							$teamStats[$team = $stat[3]]['kills'] = 1;}
                        if (isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team]['score'] += 2;}
						else{
							$teamStats[$team = $stat[3]]['score'] = 2;}
                        if (isset($teamStats[$team = $stat[6]]['morts'])){
							++$teamStats[$team]['morts'];}
						else{
							$teamStats[$team = $stat[6]]['morts'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}

						}

                } elseif(preg_match("#purchased#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {

                        preg_match($patternAchat,$statInfo,$stat);
						}
                elseif(preg_match("#Rescued#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {

                        preg_match($patternOtage,$statInfo,$stat);
						if(count($stat) > 0) {
								update(player($stat[3]),'otages', 1);}
						preg_match($patternTeamsOtage, $statInfo,$stat);
						if(count($stat) > 0) {
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['otages'])){
							$teamStats[$team = $stat[3]]['otages'] = 0;}
                        if (isset($teamStats[$team = $stat[3]]['otages'])){
							++$teamStats[$team]['otages'];}
						else{
							$teamStats[$team = $stat[3]]['otages'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}
				} elseif(preg_match("#assisted killing#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {

                        preg_match($patternAssists,$statInfo,$stat);
                        if(count($stat) > 0) {
						if($statistiques[player($stat[3])]['authJoueur'] == 1 && $statistiques[player($stat[5])]['authJoueur'] == 1 && $hourKill == $stat[2] && $statistiques[$assistVerif]['authJoueur'] == 1){
								update(player($stat[3]), 'score', 1);
                                update(player($stat[3]), 'assists', 1);}}
						preg_match($patternTeamsAssists, $statInfo,$stat);
						if(count($stat) > 0) {
                        if (isset($teamStats[$team = $stat[3]]['assists'])){
							++$teamStats[$team]['assists'];}
						else{
							$teamStats[$team = $stat[3]]['assists'] = 1;}
                        if (isset($teamStats[$team = $stat[3]]['score'])){
							++$teamStats[$team]['score'];}
						else{
							$teamStats[$team = $stat[3]]['score'] = 1;}
						if(!isset($teamStats[$team = $stat[3]]['kills'])){
							$teamStats[$team = $stat[3]]['kills'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['headshots'])){
							$teamStats[$team = $stat[3]]['headshots'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['morts'])){
							$teamStats[$team = $stat[3]]['morts'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['assists'])){
							$teamStats[$team = $stat[3]]['assists'] = 0;}
						if(!isset($teamStats[$team = $stat[3]]['score'])){
							$teamStats[$team = $stat[3]]['score'] = 0;}
							}
                }
				  elseif(preg_match("#threw#", $statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
						preg_match($patternMostGrenade,$statInfo, $stat);
						if(count($stat) > 0) {
						if($statistiques[player($stat[3])]['authJoueur'] == 1){
						update(player($stat[3]), 'threws', 1);
						}
						}
						}
						}
						}
				foreach($statistiques as $k => $v){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $equipeJoueur)){
		if(array_key_exists($equipeJoueur[1], $teamStats)){
		$statistiques[$k]['equipe'] = $equipeJoueur[1];}}
		if(!preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $equipeJoueur)){
		$statistiques[$k]['equipe'] = 'Aucune';
		}
		}
		echo '<br />';
		?><div id='classement'>CLASSEMENT DES <bolder id="tBold">JOUEURS</bolder></div><br /><?php
				if(isset($_SESSION['bots']) && $_SESSION['bots'] == 1){
			$i = 0;
				if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 0){
		echo '<center><table><tr>
						<th id="place">PLACE</th>
						<th id="BNPBA">JOUEUR</th>
						<th id="BNPBA">EQUIPE</th>
						<th>SCORE</th>
					</tr>
			  </table></center>';
        foreach(array_sort($statistiques, 'score', SORT_DESC) as $k => $v)
		{
		if($v['score'] > 0){
		$i++;
		echo'<center><table><tr<h23>';
		if($i == 1)
		{echo'<td id="place"><h21>'.$i.'</h21></td><td id="BNPBA"><h26>';
		print_r($k);
		echo'</h26></td>';}
		else
		{echo'<td id="place"><h23>'.$i.'</h23></td><td id="BNPBA"><h12>';
		print_r($k);
		echo'</h12></td>';}
		echo '<td id="BNPBA"><h11>'.$v['equipe'].'</h11></td>';
		echo '<td><h11>'.$v['score'].'</h11></td>';
		echo '</23></tr></table></center>';}
		}
		}
		}
		//bots=0 interface=0
		else{
			$i = 0;
				if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 0){
				$classOrder = 'score';
				if(isset($_SESSION['classOrder'])){
					$classOrder = $_SESSION['classOrder'];
					if($_SESSION['classOrder'] == 'ratio'){
						$classOrder = $statistiques['kills']/$statistiques['morts'];
					}
					if($_SESSION['classOrder'] == 'precision'){
						$classOrder = $statistiques['kills']/$statistiques['headshots'];
					}
				}
		echo '<center><table><tr>
						<th id="place">PLACE</th>
						<th id="BNPBA">JOUEUR</th>
						<th id="BNPBA">EQUIPE</th>
						<th>'.mb_strtoupper($classOrder).'</th>
					</tr>
			  </table></center>';
        foreach(array_sort($statistiques, $classOrder, SORT_DESC) as $k => $v)
		{
		if($v['score'] > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$pName = $playerName[2];
		}
		$i++;
		echo'<center><table><tr><h23>';
		if($i == 1){
		echo'<td id="place" style="background-color: rgb(165, 165, 165);"><h21>'.$i.'</h21></td><td id="BNPBA" style="background-color: rgb(165, 165, 165);"><h26>';
		print_r($pName);
		echo'</h26></td>';
		echo '<td id="BNPBA" style="background-color: rgb(165, 165, 165);"><h11>'.$v['equipe'].'</h11></td>';
		echo '<td style="background-color: rgb(165, 165, 165);"><h11>'.$v[$classOrder].'</h11></td>';}
		else
		{echo'<td id="place"><h23>'.$i.'</h23></td><td id="BNPBA"><h12>';
		print_r($pName);
		echo'</h12></td>';
		echo '<td id="BNPBA"><h11>'.$v['equipe'].'</h11></td>';
		echo '<td><h11>'.$v[$classOrder].'</h11></td>';}
		echo '</23></tr></table></center>';}
		}
		}
		}
		}
		else{
		echo'<br /><h12>Veuillez placer un fichier de statistiques CS:GO au format "*.log" dans le r�p�rtoire de CsGoStats.php et nommez le "stat"</h12>';}
		?>
<br />
<br />
<br />
<?php include 'footer.php'; ?>
</section>
</body>
</html>
