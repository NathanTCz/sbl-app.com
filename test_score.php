<html>
<head>
<Title>Test for Score Scraper Class by Dyodyo</Title>

</head>
<body>
	<div>
		<form method="POST" action="test_score.php">
			Get Scores For:
			<select name='league'>
				<option value='nba'>NBA</option>
				<option value='nfl'>NFL</option>
				<option value='nhl'>NHL</option>
				<option value='mlb'>MLB</option>
				<option value='ncf'>NCAA Football</option>
				<option value='ncb'>NCAA Basketball</option>
			</select><br>
			<input type="submit" value="submit">
		</form>
	</div>
	<div>
<?php
 require_once ("Score_Scraper.php");
 
// $_POST['league'] = 'nhl';
 
 if ( (isset($_POST['league']))){
 	$ss = new ScoreScraper();
 	$league = $_POST['league'];
 	if (!$ss->fetchScore($league)) {
 		echo $this->error."<br>";
 	}
	echo "Fetching Scores for <b>".strtoupper($league)."</b><br><br>";
 	//write the scores to the screen
 	if ((is_array($ss->scores)) && (count($ss->scores)>0)) {
 		foreach ($ss->scores as $score){
 			echo "Game date: ".date("m-d-y", $score['gameDate'])."<br>";
 			echo "Game started? ".($score['isStarted']?"Yes":"No")."<br>";
 			if ($score['isStarted']) {
 				echo "Period: ".$score['periodRemain'].' - '.$score['period']."<br>";
 				echo "Home: ".$score['homeTeam']." - ".$score['homeTeamScore']."<br>";
 				echo "Visitor: ".$score['awayTeam']." - ".$score['awayTeamScore']."<br>";
 			} else {
 				echo "Game Time: ".$score['gameTime']."<br>";
 				echo $score['awayTeam']." at ".$score['homeTeam']."<br>";
 			}
 			echo "<br>";
 		}
 	} else {
 		// scores variable is invalid, it would mean that there are no games today...
 		echo $ss->error."<br>";
 	}
 }
?>
	</div>
</body>
</html>

