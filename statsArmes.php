<?php
session_start();
?>
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/Ban.css" />
<link rel="icon" type="image/x-icon" href="imgPack/csgoIcon.bmp" />
<title>STATS ARMES</title>
</script>
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
                
                if(!array_key_exists($joueur, $statistiques)) $statistiques[$joueur] = array('score' => 0,'kills' => 0, 'headshots' => 0, 'assists' => 0,'otages' => 0, 'morts' => 0, 'threws' => 0, 'knifeKills' => 0, 'friendKills' => 0, 'bombe' => 0, 'defuse' => 0, 'authJoueur' => 0, 'authBot' => 0);
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
				$patternTeamsKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternTeamsBombe = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsOtage = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsHeadshots = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternTeamsAssists = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "([\s\S]*?)\.+([\s\S]*?)"#';
                $patternTeamsConnexion = '#L ([0-9/]{10}) - ([0-9:]{8}): "([\s\S]*?)\.+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(?:<>)?" (.+)#';
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
								$arme = $stat[7];
								if($arme == "hkp2000"){
								$arme = "p2000";}
								if($arme == "m4a1"){
								$arme = "m4a4";}
								if($arme == "knife_t" || $arme == "knife_default_ct"){
								$arme = "knife";}
								if($arme == "knife")
								{update(player($stat[3]), 'knifeKills', 1);}
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
							if($stat[4] == $stat[7]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -5);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[3]), 'headshots', -1);}}
							
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
								if($arme == "hkp2000"){
								$arme = "p2000";}
								if($arme == "m4a1"){
								$arme = "m4a4";}
								if($arme == "knife_t" || $arme == "knife_default_ct"){
								$arme = "knife";}
								if($arme == "knife")
								{update(player($stat[3]), 'knifeKills', 1);}
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
								if (isset($mostWeapon[$arme][$user = player($stat[3])])){
									++$mostWeapon[$arme][$user];}
								else{
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}
						preg_match($patternFK, $statInfo,$stat);
						if(count($stat) > 0) {
							if($stat[4] == $stat[7]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -2);
							update(player($stat[3]), 'kills', -1);}}}
							
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
						
				elseif(preg_match("#headshot#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
                                
                        preg_match($patternHeadshot,$statInfo,$stat);
                        if(count($stat) > 0) {
						if($statistiques[player($stat[3])]['authJoueur'] == 1 && $statistiques[player($stat[5])]['authJoueur'] == 1){
								update(player($stat[3]), 'score', 5);
								update(player($stat[3]), 'kills', 1);
                                update(player($stat[3]), 'headshots', 1);
                                update(player($stat[5]), 'morts', 1);
								$arme = $stat[7];
								if($arme == "hkp2000"){
								$arme = "p2000";}
								if($arme == "m4a1"){
								$arme = "m4a4";}
								if($arme == "knife_t" || $arme == "knife_default_ct"){
								$arme = "knife";}
								if($arme == "knife")
								{update(player($stat[3]), 'knifeKills', 1);}
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
							if($stat[4] == $stat[7]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -5);
							update(player($stat[3]), 'kills', -1);
							update(player($stat[3]), 'headshots', -1);}}}
							
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

                
                } elseif(preg_match("#killed#",$statInfo,$stat) && preg_match("#STEAM#",$statInfo,$stat)) {
                        
                        preg_match($patternKills,$statInfo,$stat);
						// print_r($stat);
                        if(count($stat) > 0) {
						if($statistiques[player($stat[3])]['authJoueur'] == 1 && $statistiques[player($stat[5])]['authJoueur'] == 1){
								update(player($stat[3]), 'score', 2);
                                update(player($stat[3]), 'kills', 1);
                                update(player($stat[5]), 'morts', 1);
								$weapons[] = $stat[7];
								$arme = $stat[7];
								if($arme == "hkp2000"){
								$arme = "p2000";}
								if($arme == "m4a1"){
								$arme = "m4a4";}
								if($arme == "knife_t" || $arme == "knife_default_ct"){
								$arme = "knife";}
								if($arme == "knife")
								{update(player($stat[3]), 'knifeKills', 1);}
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
								if (isset($mostWeapon[$arme][$user = player($stat[3])])){
									++$mostWeapon[$arme][$user];}
								else{
									$mostWeapon[$arme][$user = player($stat[3])] = 1;}
                        }
						preg_match($patternFK, $statInfo,$stat);
						if(count($stat) > 0) {
							if($stat[4] == $stat[7]){
							update(player($stat[3]), 'friendKills', 1);
							update(player($stat[3]), 'score', -2);
							update(player($stat[3]), 'kills', -1);}}}
							
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
		foreach($mostWeapon as $k => $v){
		$best[$k] = array(array_search(max($v), $v) => max($v));
		}
		foreach($mostWeaponHeadshots as $k => $v){
		$bestHeadshots[$k] = array(array_search(max($v), $v) => max($v));
		}
		echo '<br />';
		?><div id='classement'>STATISTIQUES DES <bolder id="tBold">ARMES</bolder></div><br /><?php
		$i = 0;
				if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 0){
				echo'<center><table><tr>
						<th id="place">PLACE</th>
						<th id="precision">ARME</th>
						<th id="KMH">KILLS</th>
						<th id="H">HEADSHOTS</th>
						<th id="precision">PRECISION</th>
						<th id="BEST">MEILLEUR SHOOTER</th>
						<th id="BEST">MEILLEUR HEADSHOOTER</th>
					</tr>
				<table></center>';
		foreach(array_sort($weaponStats, 'kills', SORT_DESC) as $k => $v)
		{
		$i++;
		echo '<center><table><tr>';
		if($i == 1)
		{echo'<td id="place"><h21>'.$i.'</h21></td>';}
		else{echo'<td id="place"><h23>'.$i.'</h23></td>';}
		echo'<td id="precision"><h26 style="font-size: 20; color: black; font-weight: normal;">'.$k.'</h26></td>
		<td id="KMH"><h11>'.$v['kills'].'</h11></td>
		<td id="H"><h11>'.$v['headshots'].'</h11></td>';
		if($v['kills'] > 0 && $v['headshots'] > 0 && ((($v['headshots']) / ($v['kills'])) * 100) < 100){
		echo '<td id="precision"><h11>'.number_format(((($v['headshots']) / ($v['kills'])) * 100), 2, ',', '').'%</h11></td>';}
		elseif($v['kills'] > 0 && $v['headshots'] > 0 && ((($v['headshots']) / ($v['kills'])) * 100) == 100){
		echo '<td id="precision"><h11>100%</h11></td>';}
		if(!isset($v['kills']) || !isset($v['headshots']) || $v['headshots'] == 0 || $v['kills'] == 0){
		echo '<td id="precision"><h11>0%</h11></td>';}
		echo'<td id="BEST">';
		foreach($best as $kk => $vv){
		if($kk == $k){
			$pName = key($vv);
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", key($vv), $playerName)){
			$pName = $playerName[2];
		}
		echo '<taille style="font-size: 20;">'.$pName.' [<h260>'.max($vv).'</h260>]</taille></td>';}}
		echo '<td id="BEST">';
		foreach($bestHeadshots as $kk => $vv){
		if($kk == $k){
			$pName = key($vv);
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", key($vv), $playerName)){
			$pName = $playerName[2];
		}
		echo '<taille style="font-size: 20;">'.$pName.' [<h260>'.max($vv).'</h260>]</taille></td>';}}
		echo '</tr></table></center>';
		}	
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