<?php
session_start();
?>
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/Ban.css" />
<link rel="icon" type="image/x-icon" href="imgPack/csgoIcon.bmp" />
<title>SPECIALITES</title>
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
                
                if(!array_key_exists($joueur, $statistiques)) $statistiques[$joueur] = array('score' => 0,'kills' => 0, 'headshots' => 0, 'assists' => 0,'otages' => 0, 'morts' => 0, 'threws' => 0, 'knifeKills' => 0, 'friendKills' => 0, 'bombe' => 0, 'defuse' => 0, 'authJoueur' => 0, 'authBot' => 0, 'teamEnnemy' => 0);
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
        $log = file('stat.log');
		if($log > 0){
        $statistiques = array();
		$teamStats = array();
        foreach($log as $statInfo) {
				$patternFKHeadshot = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternFK = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
                $patternHeadshot = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*)" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
                $patternAssists = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "([\s\S]*)"#';
                $patternAchat = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
                $patternConnexion = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(<STEAM[\s\S\d]>)*(?:<>)?" (.+)#';
				$patternOtage = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternBombe = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeam = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*)" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternMostGrenade = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w+) (\w+) (?:\[\-*\d* \-*\d* \-*\d*\])#';
				$patternTeamsKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternTeamsBombe = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsOtage = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsHeadshots = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternTeamsAssists = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "([\s\S]*?)\.+([\s\S]*?)"#';
                $patternTeamsConnexion = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(?:<>)?" (.+)#';
                $patternTalk = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "([\s\S]*)"#';
                //L 07/05/2015 - 09:28:19: "[OutBursT]Anil<21><STEAM_1:0:87826628><TERRORIST>" say "GL all"
                //L 07/05/2015 - 09:32:49: "[OutBursT]sn2GhosTKilleR 猩红针<18><STEAM_1:1:84443486><TERRORIST>" say_team "nn mais dis pas ca"

				preg_match("#.*#",$statInfo,$stat);
				if(isset($_SESSION['bots']) && $_SESSION['bots'] == 1){
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
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}
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
                        if(count($stat) > 0) {
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
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}
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
							update(player($stat[8]), 'teamEnnemy', 1);}}}
							
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
				//Bots = 0
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
						if(!isset($talkCounter[player($stat[3])]) && $statistiques[player($stat[3])]['authJoueur'] == 1){
							$talkCounter[player($stat[3])] = 0;}
						if(!isset($trashCounter[player($stat[3])]) && $statistiques[player($stat[3])]['authJoueur'] == 1){
							$trashCounter[player($stat[3])] = 0;}
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

				//-----------------TALK.COUNTER--------------

				if	(preg_match("#say#",$statInfo,$stat)) {
					preg_match($patternTalk,$statInfo,$stat);
					if(count($stat) > 0){
						//print_r($stat);
							if(isset($talkCounter[player($stat[3])]) && $statistiques[player($stat[3])]['authJoueur'] == 1){
							++$talkCounter[player($stat[3])];
						}
						if(strripos($stat[5], "fuck") !== false ||
							strripos($stat[5], "putain") !== false ||
							strripos($stat[5], "merde") !== false ||
							strripos($stat[5], "wtf") !== false ||
							strripos($stat[5], "connard") !== false ||
							strripos($stat[5], "noobs") !== false ||
							strripos($stat[5], "noob") !== false ||
							strripos($stat[5],  "foutre") !== false ||
							strripos($stat[5], "chier") !== false ||
							strripos($stat[5], "connerie") !== false 
							){
								if(isset($trashCounter[player($stat[3])]) && $statistiques[player($stat[3])]['authJoueur'] == 1){
								++$trashCounter[player($stat[3])];
							}
						}
					}
				}
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
						
				elseif(preg_match("#headshot#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
                                
                        preg_match($patternHeadshot,$statInfo,$stat);
                        if(count($stat) > 0) {
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
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}}}
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

                elseif(preg_match("#killed#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
                        
                        preg_match($patternKills,$statInfo,$stat);
						// print_r($stat);
                        if(count($stat) > 0) {
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
						if($statistiques[player($stat[3])]['authJoueur'] == 1 && $statistiques[player($stat[5])]['authJoueur'] == 1){
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
				if(isset($_SESSION['bots']) && $_SESSION['bots'] == 1){
				foreach(array_sort($statistiques, 'morts', SORT_ASC) as $k => $v){
		if($v['score'] != 0){
		$mostSurvival[] = array($k => $v['morts']);}}
		$mostSurvival = max($mostSurvival);
				foreach(array_sort($statistiques, 'headshots', SORT_DESC) as $k => $v)
		{
		$mostHeadshots[] = array($k => $v['headshots']);}
		$mostHeadshots = max($mostHeadshots);
				foreach($statistiques as $k => $v)
		{
		if($v['headshots'] > 0 && $v['kills'] > 0){
		$mostPrecision[] = array($k => number_format(($v['headshots'] / ($v['kills'])) * 100, 2, ',', ''));}
		else{
		$mostPrecision[] = array($k => 0);
		}
		}
		$mostPrecision = max($mostPrecision);
				foreach(array_sort($statistiques, 'threws', SORT_DESC) as $k => $v){
		$mostThrews[] = array($k => $v['threws']);
		}
		$mostThrews = max($mostThrews);
		foreach(array_sort($statistiques, 'otages', SORT_DESC) as $k => $v){
		$mostHostages[] = array($k => $v['otages']);}
	    $mostHostages = max($mostHostages);
		foreach(array_sort($statistiques, 'defuse', SORT_ASC) as $k => $v){
		$mostDefuse[$k] = $v['defuse'];}
		$mostDefuse = array(array_search(max($mostDefuse), $mostDefuse) => max($mostDefuse));
		foreach(array_sort($statistiques, 'knifeKills', SORT_DESC) as $k => $v){
		$mostKnifes[] = array($k => $v['knifeKills']);}
		$mostKnifes = max($mostKnifes);
		foreach(array_sort($statistiques, 'friendKills', SORT_DESC) as $k => $v){
		$mostfriendKills[] = array($k => $v['friendKills']);}
		$mostfriendKills = max($mostfriendKills);
		foreach(array_sort($statistiques, 'bombe', SORT_DESC) as $k => $v){
		$mostBomb[] = array($k => $v['bombe']);}
		$mostBomb = max($mostBomb);
		foreach(array_sort($statistiques, 'teamEnnemy', SORT_DESC) as $k => $v){
		$mostTeamEnnemy[] = array($k => $v['teamEnnemy']);}
		$mostTeamEnnemy = max($mostTeamEnnemy);
		foreach($nemesis as $k => $v){
		$playerNemesis[$k] = array(array_search(max($v), $v) => max($v));}
		foreach($punchBall as $k => $v){
		$punchingBall[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($mostWeapon as $k => $v){
		$best[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($mostWeaponHeadshots as $k => $v){
		$bestHeadshots[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($playerNemesis as $k => $v){
		$mostNemesis[] = array_search(max($v), $v);}
		$mostNemesis = array_count_values($mostNemesis);
		$mostNemesis = array(array_search(max($mostNemesis), $mostNemesis) => max($mostNemesis));
		foreach($punchingBall as $k => $v){
		$mostPunch[] = array_search(max($v), $v);}
		$mostPunch = array_count_values($mostPunch);
		$mostPunch = array(array_search(max($mostPunch), $mostPunch) => max($mostPunch));}

		//Bots = 0

		else{
				foreach(array_sort($statistiques, 'morts', SORT_ASC) as $k => $v){
		if($v['authJoueur'] == 1){
		if($v['score'] != 0){
		$mostSurvival[] = array($k => $v['morts']);}}}
		$mostSurvival = max($mostSurvival);
				foreach(array_sort($statistiques, 'headshots', SORT_DESC) as $k => $v)
		{
		if($v['authJoueur'] == 1){
		$mostHeadshots[] = array($k => $v['headshots']);}}
		$mostHeadshots = max($mostHeadshots);
				foreach($statistiques as $k => $v)
		{
		if($v['headshots'] > 0 && $v['kills'] > 0){
		$mostPrecision[$k] = number_format(($v['headshots'] / ($v['kills'])) * 100, 2, ',', '');}
		else{
		$mostPrecision[$k] =  0;
		}
		}
		foreach($mostPrecision as $k => $v){
		$mostPrecision = array_sort($mostPrecision, $v, SORT_DESC);
		$mostPrecision = array(array_search(max($mostPrecision), $mostPrecision) => max($mostPrecision));}
				foreach(array_sort($statistiques, 'threws', SORT_DESC) as $k => $v){
				if($v['authJoueur'] == 1){
		$mostThrews[] = array($k => $v['threws']);
		}}
		$mostThrews = max($mostThrews);
		foreach(array_sort($statistiques, 'otages', SORT_DESC) as $k => $v){
		if($v['authJoueur'] == 1){
		$mostHostages[] = array($k => $v['otages']);}}
	    $mostHostages = max($mostHostages);
		foreach(array_sort($statistiques, 'defuse', SORT_ASC) as $k => $v){
		if($v['authJoueur'] == 1){
		$mostDefuse[$k] = $v['defuse'];}}
		$mostDefuse = array(array_search(max($mostDefuse), $mostDefuse) => max($mostDefuse));
		foreach(array_sort($statistiques, 'knifeKills', SORT_DESC) as $k => $v){
		if($v['authJoueur'] == 1){
		$mostKnifes[] = array($k => $v['knifeKills']);}}
		$mostKnifes = max($mostKnifes);
		foreach(array_sort($statistiques, 'friendKills', SORT_DESC) as $k => $v){
		if($v['authJoueur'] == 1){
		$mostfriendKills[] = array($k => $v['friendKills']);}}
		$mostfriendKills = max($mostfriendKills);
		foreach(array_sort($statistiques, 'bombe', SORT_DESC) as $k => $v){
		if($v['authJoueur'] == 1){
		$mostBomb[] = array($k => $v['bombe']);}}
		$mostBomb = max($mostBomb);
		foreach(array_sort($statistiques, 'teamEnnemy', SORT_DESC) as $k => $v){
		$mostTeamEnnemy[] = array($k => $v['teamEnnemy']);}
		$mostTeamEnnemy = max($mostTeamEnnemy);
		foreach($nemesis as $k => $v){
		$playerNemesis[$k] = array(array_search(max($v), $v) => max($v));}
		foreach($punchBall as $k => $v){
		$punchingBall[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($mostWeapon as $k => $v){
		$best[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($mostWeaponHeadshots as $k => $v){
		$bestHeadshots[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($playerNemesis as $k => $v){
		$mostNemesis[] = array_search(max($v), $v);}
		$mostNemesis = array_count_values($mostNemesis);
		$mostNemesis = array(array_search(max($mostNemesis), $mostNemesis) => max($mostNemesis));
		foreach($punchingBall as $k => $v){
		$mostPunch[] = array_search(max($v), $v);}
		$mostPunch = array_count_values($mostPunch);
		$mostPunch = array(array_search(max($mostPunch), $mostPunch) => max($mostPunch));
		
		foreach($talkCounter as $k => $v){
			$Talker = array(array_search(max($talkCounter), $talkCounter) => max($talkCounter));}

		foreach($trashCounter as $k => $v){
			$trashTalker = array(array_search(max($trashCounter), $trashCounter) => max($trashCounter));}

		foreach(array_sort($statistiques, 'assists', SORT_ASC) as $k => $v){
		if($v['authJoueur'] == 1){
		if($v['score'] != 0){
		$mostAssists[] = array($k => $v['morts']);}}}
		$mostAssists = max($mostAssists);

				foreach(array_sort($statistiques, 'morts', SORT_ASC) as $k => $v){
		if($v['authJoueur'] == 1){
		if($v['score'] != 0){
		$mostDeath[] = array($k => $v['morts']);}}}
		$mostDeath = min($mostDeath);

		foreach($talkCounter as $k => $v){
			if($v == 0){
				if(!isset($unsociable[$k]))
					$unsociable[$k] = 0;
			}
		}

		}

		echo '<br />';
		?><div id='classement'><bolder id="tBold">SPECIALITES</bolder></div><br /><?php
		if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 1){
		foreach($mostHeadshots as $k => $v){
		if($v > 0){
		echo '<center><h4><h8>LE <h10>HEADSHOOTER</h10> : </h8><h17>'.$k.'</h17><h8> [<h10> '.$v.'</h10> '.mot($v, 'HEADSHOTS').' ]</h8></h4>';}}
		foreach($mostAssists as $k => $v){
		if($v > 0){
		echo '<center><h4><h8>L\'<h10>ASSISTANT</h10> : </h8><h17>'.$k.'</h17><h8> [<h10> '.$v.'</h10> '.mot($v, 'ASSISTANCES').' ]</h8></h4>';}}
		foreach($mostThrews as $k => $v){
		if($v > 0){
		echo '<h4><h8>LE FAN DES <h10>GRENADES</h10> : </h8><h17>'.$k.'</h17><h8> [<h10> '.$v.'</h10> '.mot($v, 'GRENADES').' '.mot($v, 'LANCEES').' ]</h8></h4>';}}
		foreach($mostfriendKills as $k => $v){
		if($v > 0){
		echo '<h4><h8>LE <h10>TRAITRE</h10> : </h8><h17>'.$k.'</h17><h8> [<h10> '.$v.'</h10> '.mot($v, 'COEQUIPIERS').' '.mot($v, 'TUES').' ]</h8></h4>';}}
		foreach($mostHostages as $k => $v){
		if($v > 0){
		echo "<h4><h8>L'<h10>EXFILTRATEUR</h10> : </h8><h17>".$k."</h17><h8> [<h10> ".$v."</h10> ".mot($v, 'OTAGES')." ".mot($v, 'SAUVES')." ]</h8></h4>";}}
		foreach($mostBomb as $k => $v){
		if($v > 0){
		echo "<h4><h8><h10>C4</h10>-MAN : </h8><h17>".$k."</h17><h8> [<h10> ".$v."</h10> ".mot($v, 'BOMBES')." ".mot($v, 'POSEES')." ]</h8></h4>";}}
		foreach($mostSurvival as $k => $v){
		if($v >= 0){
		echo "<h4><h8>LE <h10>SURVIVANT</h10> : </h8><h17>".$k."</h17><h8> [<h10> ".$v."</h10> ".mot($v, 'MORTS')." ]</h8></h4>";}}
		foreach($mostKnifes as $k => $v){
		if($v > 0){
		echo "<h4><h8>LE <h10>SAMOURAI</h10> : </h8><h17>".$k."</h17><h8> [<h10> ".$v."</h10> ".mot($v, "ENNEMIS")." ".mot($v, "TRANCHES")." ]</h8></h4>";}}
		foreach($mostNemesis as $k => $v){
		if($v > 0){
		echo "<h4><h8>L'<h10>ENNEMI</h10> PUBLIC <h10>N'1</h10> : </h8><h17>".$k."</h17><h8> [ BETE NOIRE DE <h10>".$v."</h10> ".mot($v, "JOUEURS")." ]</h8></h4>";}}
		foreach($mostDefuse as $k => $v){
		if($v > 0){
		echo "<h4><h8>LA <h10>BETE NOIRE</h10> DES <h10>BOMBES</h10> : </h8><h17>".$k."</h17><h8> [ <h10>".$v."</h10> ".mot($v, "BOMBES")." ".mot($v, "DESAMORCEES")." ]</h8></h4>";}}
		foreach($mostTeamEnnemy as $k => $v){
		if($v > 0){
		echo '<tr><td  id="BNPBA"><h112>LE MAL<h260>CHANCEUX</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112>TUE <h260>'.$v.'</h260> FOIS PAR SES COEQUIPIERS</h112></td></tr>';}}
		foreach($mostPrecision as $k => $v){
		if($v > 0){
		echo "<h4><h8>L'<h10>OEIL</h10> DE <h10>LYNX</h10> : </h8><h17>".$k."</h17><h8> [ <h10>".$v."</h10> % DE PRECISION ]</h8></h4></center>";}}
		}

		//Bots = 0 / Interface = 0

		if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 0){
				echo'<center><table><tr>
						<th id="BNPBA">DESIGNATION</th>
						<th id="BNPBA">JOUEUR</th>
						<th id="BNPBA">POINTS</th>
					</tr>
				</table></center>';
		echo '<center><table>';
		foreach($mostHeadshots as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td id="BNPBA"><h112>LE <h260>HEADSHOOTER</h260></h112></td><td id="Joueurs"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'HEADSHOTS').'</h112></td></tr>';}}
		foreach($mostAssists as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}	
		echo '<tr><td id="BNPBA"><h112>L\'<h260>ASSISTANT</h260></h112></td><td id="Joueurs"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'ASSISTANCES').'</h112></td></tr>';}}		
		foreach($mostThrews as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td id="BNPBA"><h112>LE <h260>FAN</h260> DES </h112><h260>GRENADES</h260></td><td id="Joueurs"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'GRENADES').' '.mot($v, 'LANCEES').'</h112></td></tr>';}}
		foreach($mostfriendKills as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td id="BNPBA"><h112>LE <h260>TRAITRE</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'COEQUIPIERS').' '.mot($v, 'TUES').'</h112></td></tr>';}}
		foreach($mostHostages as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>L\'<h260>EXFILTRATEUR</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'OTAGES').' '.mot($v, 'SAUVES').'</h112></td></tr>';}}
		foreach($mostBomb as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112><h260>C4</h260>-MAN</h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'BOMBES').' '.mot($v, 'POSEES').'</h112></td></tr>';}}
		foreach($mostSurvival as $k => $v){
		if($v >= 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LE <h260>SURVIVANT</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'MORTS').'</h112></td></tr>';}}
		foreach($mostKnifes as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LE <h260>SAMOURAI</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'ENNEMIS').' '.mot($v, 'TUES').' AU COUTEAU</h112></td></tr>';}}
		foreach($mostNemesis as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>L\'<h260>ENNEMI</h260> PUBLIC <h260>N\'1</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112> BETE NOIRE DE <h260>'.$v.'</h260> '.mot($v, 'JOUEURS').'</h112></td></tr>';}}
		foreach($mostDefuse as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LA <h260>BETE NOIRE</h260> DES <h260>BOMBES</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'BOMBES').' '.mot($v, 'DESAMORCEES').'</h112></td></tr>';}}
		foreach($mostTeamEnnemy as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LE <h260>MAL</h260>CHANCEUX</h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112>TUE <h260>'.$v.'</h260> FOIS PAR SES COEQUIPIERS</h112></td></tr>';}}
		foreach($mostPrecision as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>L\'<h260>OEIL</h260> DE <h260>LYNX</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'%</h260> DE PRECISION</h112></td></tr>';}}

		foreach($Talker as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LA <h260>PIPELETTE</h260></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'MESSAGES').'</h112></td></tr>';}}

		foreach($trashTalker as $k => $v){
		if($v > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LE <h260>TRASH</h260>TALKER</td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'MESSAGES').' '.mot($v, 'VULGAIRES').'</h112></td></tr>';}}

		foreach($mostDeath as $k => $v){
		if($v >= 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		echo '<tr><td  id="BNPBA"><h112>LA <h260>VICTIME</h260></h112></td><td id="BNPBA"><h112>'.$k.'</h112></td><td id="BNPBA"><h112><h260>'.$v.'</h260> '.mot($v, 'MORTS').'</h112></td></tr>';}}

		$unsociableValues = array_count_values($unsociable);

		if($unsociableValues[0] == 1){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}
		echo '<tr><td  id="BNPBA"><h112>L\'<h260>INSOCIABLE</h260></td><td id="BNPBA"><h112>'.key(array_search($unsociable[0])).'</h112></td><td id="BNPBA"><h112><h260>'.$unsociable[key(array_search($unsociable[0]))].'</h260> '.mot($unsociable[key(array_search($unsociable[0]))], 'MESSSAGES').'</h112></td></tr>';
		}
		else if($unsociableValues[0] > 1){
		echo '<tr><td  id="BNPBA"><h112>LES<h260> INSOCIABLES</h260></td><td id="BNPBA"><h112>';
		foreach($unsociable as $k => $v){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$k = $playerName[2];
		}			
		print_r($k);
		echo '<br />';
		}
		echo'</h112></td><td id="BNPBA"><h112><h260>0</h260> MESSSAGE</h112></td></tr>';
		}
		echo '</table></center>';
		}
		}
		else{
		echo'<br /><h12>Veuillez placer un fichier de statistiques CS:GO au format "*.log" dans le répértoire de CsGoStats.php et nommez le "stat"</h12>';}
		?>
<br />
<br />
<br />
<?php include 'footer.php'; ?>
</body>
</html>