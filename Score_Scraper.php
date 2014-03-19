<?php
/* Class ScoreScraper
 * Version 1.0.0
 * Copyright 2006 dyodyo
 *
 * Description
 *
 * The class scrapes score data for the major US sports leagues:
 *   NFL, MLB, NHL and NBA
 *   and the two major US College leagues: NCAA Men's Basketball and NCAA Men's Football
 *   from the ESPN mobile website.
 *
 * @param Values
 *	 the Class is used via the main function 'fetchScore' (eg ScoreScraper->fetchScore)
 *	 The function takes the following parameters:
 *		'league' (string) !required : this sets the league where the scores will be from
 *  		valid values for the 'league' parameter are:
 *			 'nba', 'nfl', 'mlb', 'nhl' : self explanatory
 *			 'ncb' = NCAA Men's basketball
 *			 'ncf' = NCAA Men's football
 *  		Specifying a league outside of this values would return an error
 *
 *		'date' (string) optional: this is the date of when the scores would be taken 		
 *				This would default to the current date if none is specified
 *				this parameter is parsed using the 'strtotime' PHP function
 *
 *	function return values:
 *		  true : sports scores fetched; false otherwise
 *		  if this function returns false the 'ScoreScraper->error' variable contains the error message
 *
 * NOTE:
 *		In case there are no games on the date specified (whether today or a specified future date),
 *		the function would still return TRUE but there the scores array would be null or zero-length
 *		However, an error message would still be returned in the 'error' string variable
 *
 * The class returns the scraped scores as a PHP array (ScoreScraper->scores) that follows this structure
 *   Array (0.. number of games) {
 *		 gameDate (date): the Game Date
 *       isStarted (boolean): if the game has already started or not
 *
 *		 homeTeam (string) : the name of the host team
 *		 homeTeamScore (integer) : the score of the host team (always zero if 'isStarted' == false)
 *
 *		 awayTeam (string) : the name of the visiting team
 *		 awayTeamScore (integer) : the score of the visiting team (always zero if 'isStarted' == false)
 *
 *		 if 'isStarted' is True:
 *				period (byte) : the period number (either the number of
 *									the current Quarter, Period or Inning 
 *									based on the league type specified
 *				periodTime (string): time remaining in the current period 
 *								can be (min:sec) or either "top/bottom/middle" for baseball
 *
 *		 if 'isStarted' is False:
 *				gameTime (string) : the game time (eg '9:00 PM ET')
 *
 *
 *
 *	Please see the 'test_score.php' file for an example of how to use the class
 *
 *
 *
 *
 * LICENSE
 *
 * This script is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This script is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *	
 * You should have received a copy of the GNU General Public License along
 * with this script; if not, write to the Free Software Foundation, Inc.,
 * 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

require_once "class_HTTPRetriever.php";

DEFINE ("BASE_URL", "http://scores.espn.go.com/{LEAGUE}/scoreboard");


class ScoreScraper {
	var $http;
	var $valid_leagues;
	var $error;
	var $scores;
	var $fetchedDate;
	
	function ScoreScraper (){
		$this->http = &new HTTPRetriever();		
		$this->valid_leagues = array("nba","nfl","mlb","nhl","ncf","ncb");
		$this->error = "";
		$this->scores = array();
	}
	
	function fetchScore($league,$date=""){
		$league = strtolower($league);
		
		
		if (!in_array($league,$this->valid_leagues)) {
			$this->error = "Invalid League Specified!";
			return  false;
		}
		if ($date!="") {
			if (!$date=strtotime($date)) {
				$this->error = "Invalid Date Specified!";
				return false;
			}
			$this->fetchedDate = $date;
			$date = "?date=".date("Ymd",$date);
		} 
		
		$url = str_replace("{LEAGUE}",$league,BASE_URL).$date;
		if (!$this->http->get($url)) {
      		$this->error= "HTTP request error: #{$this->http->result_code}: {$this->http->result_text}";
      		return false;
  		}
  		$html = $this->http->response;
  		
  		if ($date=="") {
  			//no date specified in function call == "current scores"
  			//retrieve the date from within the fetched html page
  			preg_match("/<hr><b>(.*?)<\\/b>/",$html,$d);
  			if ((is_array($d)) && (sizeof($d)>0) ){
  				$this->fetchedDate=strtotime($d[1]);
  			} else {
  				//no date specified within page
  				//tag error but still continue;
  				$this->error = "No date found within fetched html.";
  			}
  		}
  		if (in_array($league, array("nfl","ncf") )) {
  			return $this->processFootballScore($html);
  		}
  		return $this->processScore($html);
	}

	function getScores($html,$gd=""){
		preg_match_all("/<br><font size=\"?1\"?>(.*?)<\\/a>/", $html, $items, PREG_SET_ORDER);

		if (!is_array($this->scores)) {$this->scores=array();}

		if ($gd=="") $gd=$this->fetchedDate;
		
		while (sizeof($items)>0){
			$item=array_shift($items);
            $item=$item[1];
            if (strpos($item,"scoreboard")===false) {
            	preg_match("/^(.*?)<\\/font>/", $item, $s);
            	preg_match("/<a[^>]*>(.*?)$/", $item, $t);
            	preg_match("/<a\ href=\"(.*?)\">/", $item, $l);

            	if(sizeof($s)){ $s = trim(strip_tags($s[1])); };    
            	if(sizeof($t)){ $t = trim(strip_tags($t[1])); };    
            	if(sizeof($l)){ $l = trim(strip_tags($l[1])); };    
            
            	if (strpos($s," ET")===false){
            		//game started
            		$sa = explode(" ",$s); $t1 = $sa[0];$t2 = $sa[1];$t3="";
            		$ta = explode(" ",$t);
            		if (count($ta)>4) {
            			$ht='';$at='';
            			$idx=array();foreach ($ta as $k=>$tt){if (is_numeric($tt)) {$idx[]=$k;}}
            			for ($n=0;$n<$idx[0];$n++) {$ht .=$ta[$n];}
            			for ($n=$idx[0]+1;$n<$idx[1];$n++) {$at .=$ta[$n];}
            			$hs=$ta[$idx[0]];$as=$ta[$idx[1]];
            		} else { $ht = $ta[0];$hs = $ta[1];$at = $ta[2];$as = $ta[3]; }
            		$isStarted = true;
            	} else {
            		$t1="";$t2="";$t3 = $s;
            		$ta = explode(" at ",$t);$ht = $ta[0];$at = $ta[1];$hs = 0;$as = 0;
            		$isStarted = false;
            	}
            	$this->scores[] = array( "isStarted"   => $isStarted,
            						 "gameDate"=> $gd,
            						 "gameTime" => $t3,            	
            						 "period" => $t2,
            						 "periodRemain" => $t1,
            						 
            						 "awayTeam" => $at,
            						 "awayTeamScore" => $as,
            						 "homeTeam" => $ht,
            						 "homeTeamScore" => $hs,
            					);
			}
		}
		return true;
		
	}
	
	function processScore ($html){
		if ($html=="") {
			$this->error="Invalid page returned!";
			return false;
		}
		
		if ((strpos($html,'No games scheduled')!==false) || (strpos($html,'href="scoreboard?')===false) ) {
			$this->error = "No Games Scheduled Today!";
			$this->scores = null;
			return true;
		}
		
		return $this->getScores($html);
	}

	function processFootballScore ($html){
		if ($html=="") {
			$this->error="Invalid page returned!";
			return false;
		}
		
		if ((strpos($html,'No games scheduled')!==false) || (strpos($html,'href="scoreboard?')===false) ) {
			$this->error = "No Games Scheduled Today!";
			$this->scores = null;
			return true;
		}
		
		preg_match("/<hr>(.*?)&nbsp;/",$html,$sc);
		
		if (sizeof($sc)<0) {
			$this->error = "Invalid page returned by site.";
			return false;
		}
		
		$sc=$sc[1];
		$go=true;
		while ($go) {
			$p1=strpos($sc,"<b>")+3;
			$p2=strpos($sc,"<b>",$p1);
			if (!$p2) {
				$go=false;
				$p2 = strlen($sc);
			}
			$test = substr($sc,$p1,strpos($sc,"</b>")-$p1).date(" Y",$this->fetchedDate);
			$thisdate = strtotime($test);
			if (!$this->getScores(substr($sc,$p1,$p2-$p1),$thisdate)) {
				return false;
			}
			$sc = substr($sc,$p2,strlen($sc));
		}
		return true;
	}
}
?>