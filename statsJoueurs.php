<?php
session_start();
?>
<html>
<head>
<title>STATS JOUEURS</title>
<link rel="stylesheet" href="styles/style.css" />
<link rel="stylesheet" href="styles/Ban.css" />
<link rel="icon" type="image/x-icon" href="imgPack/csgoIcon.bmp" />
    <meta charset="utf-8" />
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

                if(!array_key_exists($joueur, $statistiques)) $statistiques[$joueur] = array('score' => 0,'kills' => 0, 'headshots' => 0, 'assists' => 0,'otages' => 0, 'morts' => 0, 'threws' => 0, 'knifeKills' => 0, 'friendKills' => 0, 'bombe' => 0, 'defuse' => 0, 'authJoueur' => 0, 'authBot' => 0, 'teamEnnemy' => 0, 'precision' => 0, 'ratio' => 0);
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
				$patternTeamsKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternTeamsCampsKills = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)"#';
				$patternTeamsCampsHeadshots = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(<(CT)?|(TERRORIST)?>)+" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\([\w]+\))#';
				$patternTeamsBombe = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsOtage = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*) "(\w*\d*)"#';
				$patternTeamsHeadshots = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w*) "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (?:\[\-*\d* \-*\d* \-*\d*\]) (\w+) "(\d*\w*)" (\(\w*\))#';
				$patternTeamsAssists = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?" (\w*\s*\S*) "\[+([\s\S]*?)\]+([\s\S]*?)"#';
                $patternTeamsConnexion = '#L ([0-9/]{10}) - ([0-9:]{8}): "\[+([\s\S]*?)\]+([\s\S]*?)(?:<STEAM[\s\S\d]>*)?(?:<>)?" (.+)#';
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
		$v['precision'] = number_format(($v['headshots'] / ($v['kills'])) * 100, 2, ',', '');
		$mostPrecision[] = array($k => number_format(($v['headshots'] / ($v['kills'])) * 100, 2, ',', ''));}
		else{
		$v['precision'] = 0;
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
		//CALCULS - Bots Off
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
		// PRECISION CALCULS
		if($v['authJoueur'] == 1){
		if($v['score'] != 0){
		if($v['headshots'] > 0 && $v['kills'] > 0){
		$mostPrecision[] = array($k => number_format(($v['kills'] / ($v['headshots'])) * 100, 2, ',', ''));}
		else{
		$mostPrecision[] = array($k => 0);
		}
		}
		}
		}
		$mostPrecision = max($mostPrecision);
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
		echo '<br />';
				if(isset($_SESSION['bots']) && $_SESSION['bots'] == 1){
				?><div id='classement'>STATISTIQUES DES <bolder id="tBold">JOUEURS</bolder></div><br /><?php
				if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 0){
		$i = 0;
				echo'<center><table><tr>
						<th id="place">PLACE</th>
						<th id="Joueurs">JOUEUR</th>
						<th id="Otages">SCORE</th>
						<th id="KMH">KILLS</th>
						<th id="KMH">MORTS</th>
						<th id="H">HEADSHOTS</th>
						<th id="FriendsK">ASSISTS</th>
						<th id="Otages">OTAGES</th>
						<th id="FriendsK">TRAHISONS</th>
						<th>RATIO (KILLS/MORTS)</th>
						<th id="precision">PRECISION</th>
						<th id="BNPB">BETE NOIRE</th>
						<th id="BNPB">PUNCHING BALL</th>
					</tr>
				</table></center>';
        foreach(array_sort($statistiques, 'score', SORT_DESC) as $k => $v)
		{
		if($v['score'] > 0){
		$i++;
		echo'<center><table><h23>';
		if($i == 1)
		{echo'<td id="place"><h21>'.$i.'</h21></td>';}
		else{echo'<td id="place"><h23>'.$i.'</h23></td>';}
		echo'<td id="Joueurs"><h16>';
		print_r($k);
		echo '</h16></td>';
		echo '<td id="Otages"><h11>'.$v['score'].'</h11></td>
		<td id="KMH"><h11>'.$v['kills'].'</h11></td>
		<td id="KMH"><h11>'.$v['morts'].'</h11></td>
		<td id="H"><h11>'.$v['headshots'].'</h11></td>
		<td id="FriendsK"><h11>'.$v['assists'].'</h11></td>
		<td id="Otages"><h11>'.$v['otages'].'</h11></td>
		<td id="FriendsK"><h11>'.$v['friendKills'].'</h11></td>
		<td><h11>';
		if($v['kills'] > 0 && $v['morts'] > 0){
		echo number_format(($v['kills'] / ($v['morts'])), 2, ',', '').'</h11></td>';}
		else{
		echo '0</h11></td>';}
		if($v['kills'] > 0 && (($v['headshots'] / $v['kills']) * 100) <= 100){
		    echo '<td id="precision"><h11>'.number_format(((($v['headshots']) / ($v['kills'])) * 100), 2, ',', '').'%</h11></td>';}
		elseif($v['kills'] > 0 && (($v['headshots'] / $v['kills']) * 100) > 100){
		    echo '<td id="precision"><h11>100%</h11></td>';}
		else{
		    echo '<td id="precision"><h11>0%</h11></td>';}
    $founded = false;
		foreach($playerNemesis as $kk => $vv){
  		if($kk == $k && $vv > 0){
		    echo '<td id="BNPB">'.key($vv).' (<h26>'.max($vv).'</h26> KILLS)</td>';
        $founded = true;
      }
    }
    if(!$founded) {
        echo '<td id="BNPB">-</td>';
    }
    $founded = false;
		foreach($punchingBall as $kk => $vv){
  		if($kk == $k && $vv > 0){
  		echo '<td id="BNPB">'.key($vv).' (<h26>'.max($vv).'</h26> KILLS)</td>';
      $founded = true;
      }
    }
    if(!$founded) {
      echo '<td id="BNPB">-</td>';
    }
		}
		echo '</table></center>';
		}
		}
		elseif(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 1){
		$i = 0;
        foreach(array_sort($statistiques, 'score', SORT_DESC) as $k => $v)
		{
		if($v['score'] > 0){
		$i++;
		echo'<center><h23><h4>';
		if($i == 1)
		{echo'<h21>'.$i.'<h27>er</h27> </h21>';}
		else{echo'<h23>'.$i.'<h25>e </h25></h23>';}
		echo'<h16>';
		print_r($k);
		echo '</h16>';
		echo '<center><h8><br />[SCORE '.'<h10>'.$v['score'].'</h10>]
		</h8> <h20>> </h20> <h12><h11>'.$v['kills'].'</h11> '.mot($v['kills'], 'KILLS').' <h20>|</h20><h11> '.
		$v['headshots'].'</h11> '.mot($v['headshots'], 'HEADSHOTS').' <h20>|</h20> <h11>'.
		$v['assists'].'</h11> '.mot($v['assists'], 'ASSISTANCES').' <h20>|</h20> <h11>'.
		$v['otages'].'</h11> '.mot($v['otages'], 'SAUVETAGES').' <h20>|</h20> <h11>'.
		$v['morts'].'</h11> '.mot($v['morts'], 'MORTS').'<h20> |</h20> <h11>'.
		$v['friendKills'].'</h11> '.mot($v['friendKills'],'COEQUIPIERS').' '.mot($v['friendKills'],'TUES').'</h11><br />';
		if($v['kills'] > 0 && $v['morts'] > 0){
		echo '<h8>[RATIO <h10>'.number_format(($v['kills'] / ($v['morts'])), 2, ',', '').'</h10>]</h8>';}
		else{
		echo '<h8>[RATIO <h10>0</h10>]</h8>';}
		if($v['kills'] > 0 && $v['headshots'] > 0){
		echo '<h20> > </h20>PRECISION <h11>'.number_format(((($v['headshots']) / ($v['kills'])) * 100), 2, ',', '').'</h11><h20></h20>';}
		echo'<br />';
		foreach($playerNemesis as $kk => $vv){
		if($kk == $k && $vv > 0){
		echo '<h12><h26>BETE</h26> NOIRE </h12>';
		echo ' : '.key($vv).' <h8>[ <h10> '.max($vv).'</h10> KILLS ]</h8>';}
		foreach($punchingBall as $kkk => $vvv){
		if($kkk == $kk && $kkk == $k && $vvv > 0 && $vv > 0){
		echo' | ';}
		}
		}
		foreach($punchingBall as $kk => $vv){
		if($kk == $k && $vv > 0){
		echo '<h12>PUNCHING<h26>BALL</h26></h12>';
		echo ' : '.key($vv).' <h8>[ <h10> '.max($vv).'</h10> KILLS ]<h8>';}}
		echo '</h12></center></h4></h23></center>';
		}
		}
		}
		}
		//Bots=0 / Interface=0
		else{
				?><div id='classement'>STATISTIQUES DES <bolder id="tBold">JOUEURS</bolder></div><br /><?php
				if(isset($_SESSION['Interface']) && $_SESSION['Interface'] == 0){
		$i = 0;
				echo'<center><table><tr id="bandeau">
						<th id="place">PLACE</th>
						<th id="Joueurs">JOUEUR</th>
						<th id="score">SCORE</th>
						<th id="KMH">KILLS</th>
						<th id="KMH">MORTS</th>
						<th id="H">HS</th>
						<th id="assists">ASSISTS</th>
						<th id="Otages">DEFUSE</th>
						<th id="FriendsK">TK</th>
						<th id="precision">RATIO</th>
						<th id="precision">PRECISION</th>
						<th id="BNPB">BETE NOIRE</th>
						<th id="BNPB">PUNCHING BALL</th>
					</tr>
				<table></center>';
				$classOrder = 'score';
				if(isset($_SESSION['classOrder'])){
					$classOrder = $_SESSION['classOrder'];
				}

					foreach ($statistiques as $k => $v) {
						if($v['kills'] > 0 && $v['headshots'] > 0) {
							$v['precision'] = number_format(((($v['headshots']) / ($v['kills'])) * 100), 2, ',', '');
							if($v['precision'] >= 100)
							$v['precision'] = 100;
						}
						else if($v['kills'] == 0 && $v['headshots'] == 0)
							$v['precision'] = 0;
						if($v['kills'] > 0 && $v['morts'] > 0) {
							$v['ratio'] = number_format(($v['kills'] / ($v['morts'])), 2, ',', '');
					}
				}

        foreach(array_sort($statistiques, $classOrder, SORT_DESC) as $k => $v)
		{
		if($v['score'] > 0){
		if(preg_match("#\[+([\s\S]+)\]+([\s\S]+)#", $k, $playerName)){
			$pName = $playerName[2];
		}
		$i++;
		echo'<center><table><tr><h23>';
		if($i == 1)
		{echo'<td id="place"><h21>'.$i.'</h21></td>';}
		else{echo'<td id="place"><h23>'.$i.'</h23></td>';}
		echo'<td id="Joueurs"><h16>';
		print_r($pName);
		echo '</h16></td>';
		echo '<td id="score"><h11>'.$v['score'].'</h11></td>
		<td id="KMH"><h11>'.$v['kills'].'</h11></td>
		<td id="KMH"><h11>'.$v['morts'].'</h11></td>
		<td id="H"><h11>'.$v['headshots'].'</h11></td>
		<td id="assists"><h11>'.$v['assists'].'</h11></td>
		<td id="Otages"><h11>'.$v['defuse'].'</h11></td>
		<td id="FriendsK"><h11>'.$v['friendKills'].'</h11></td>
		<td id="precision"><h11>';
    if($v['kills'] > 0 && $v['morts'] > 0){
    echo number_format(($v['kills'] / ($v['morts'])), 2, ',', '').'</h11></td>';}
    else{
    echo '0</h11></td>';}
    if($v['kills'] > 0 && (($v['headshots'] / $v['kills']) * 100) <= 100){
        echo '<td id="precision"><h11>'.number_format(((($v['headshots']) / ($v['kills'])) * 100), 2, ',', '').'%</h11></td>';}
    elseif($v['kills'] > 0 && (($v['headshots'] / $v['kills']) * 100) > 100){
        echo '<td id="precision"><h11>100%</h11></td>';}
    else{
        echo '<td id="precision"><h11>0%</h11></td>';}
    $founded = false;
    foreach($playerNemesis as $kk => $vv){
      if($kk == $k && $vv > 0){
        echo '<td id="BNPB">'.key($vv).' (<h26>'.max($vv).'</h26> KILLS)</td>';
        $founded = true;
      }
    }
    if(!$founded) {
        echo '<td id="BNPB">-</td>';
    }
    $founded = false;
    foreach($punchingBall as $kk => $vv){
      if($kk == $k && $vv > 0){
      echo '<td id="BNPB">'.key($vv).' (<h26>'.max($vv).'</h26> KILLS)</td>';
      $founded = true;
      }
    }
    if(!$founded) {
      echo '<td id="BNPB">-</td>';
    }
		}
		echo '</tr></table></center>';
		}
		}
		}
		}
		else{
		echo'<center><br /><h12>Veuillez placer un fichier de statistiques CS:GO au format "*.log" dans le r�p�rtoire de CsGoStats.php et nommez le "stat"</h12></center>';}
		?>
<br />
<br />
<br />
<?php include 'footer.php'; ?>
</body>
</html>
