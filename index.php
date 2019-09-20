<?php
header("Content-Type:application/json");
function getUrlContent($url)
{
    $curl = curl_init($url);
    curl_setopt_array($curl, array( CURLOPT_RETURNTRANSFER => true,
  	                                CURLOPT_ENCODING => "",
  	                                CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "GET",
                                    CURLOPT_HTTPHEADER => array("x-rapidapi-host:api-football-v1.p.rapidapi.com",
	                                                              "x-rapidapi-key:e237d77783msh1277417c4197892p118192jsnf7d06f8c7652"),
                                    ));
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

  return $response;
}
function response($status, $status_message, $data)
{
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$json_response = json_encode($response);

	echo $json_response;
}
function getAllInfoByMatch($games)
{
  $aGames = array('fixture_id' => [],
					        'league_id' =>[],
					        'event_date' => [],
                  'event_timestamp' => [],
                  'firstHalfStart' => [],
                  'secondHalfStart' => [],
                  'round' => [],
                  'status' => [],
                  'elapsed' => [],
                  'venue' => [],
                  'referee' => [],
                  'homeTeam' => array('team_id' => [],
                                      'team_name' => [],
                                      'logo' => [],
                                      ),
                  'awayTeam' => array('team_id' => [],
                                      'team_name' => [],
                                      'logo' => [],
                                      ),
                  'goalsHomeTeam' => [],
                  'goalsAwayTeam' => [],
                  'score' => array('halftime' => [],
                                   'fulltime' => [],
                                   'extratime' => [],
                                   'penalty' => [],
                                  )
                 );

  for ($i = 0;
       $i < count($games['api']['fixtures']);
       $i++)
  {
      // Fixture id
      $aGames[$i]['fixture_id'] = $games['api']['fixtures'][$i]['fixture_id'];

      // Id della lega
      $aGames[$i]['league_id'] = $games['api']['fixtures'][$i]['league_id'];

      // Data dell'evento
      $aGames[$i]['event_date'] = $games['api']['fixtures'][$i]['event_date'];

      // Timestamp evento
      $aGames[$i]['event_timestamp'] = $games['api']['fixtures'][$i]['event_timestamp'];

      // Inizio primo tempo (Timestamp)
      $aGames[$i]['firstHalfStart'] = $games['api']['fixtures'][$i]['firstHalfStart'];

      // Inizio secondo tempo (Timestamp)
      $aGames[$i]['secondHalfStart'] = $games['api']['fixtures'][$i]['secondHalfStart'];

      // Dati sulla partita disputata
      $aGames[$i]['round'] = $games['api']['fixtures'][$i]['round'];


      // Dati sullo stato della partita
      $aGames[$i]['status'] = $games['api']['fixtures'][$i]['status'];

      // Dati sul tempo giocato
      $aGames[$i]['elapsed'] = $games['api']['fixtures'][$i]['elapsed'];

      // Dati sullo stadio
      $aGames[$i]['venue'] = $games['api']['fixtures'][$i]['venue'];

      // Dati sull'arbitro
      if(!empty($games['api']['fixtures'][$i]['referee']))
        $aGames[$i]['referee'] = $games['api']['fixtures'][$i]['referee'];
      else
        $aGames[$i]['referee'] = "null";

      // Dati Squadra di casa
      $aGames[$i]['homeTeam']['team_id'] = $games['api']['fixtures'][$i]['homeTeam']['team_id'];
      $aGames[$i]['homeTeam']['team_name'] = $games['api']['fixtures'][$i]['homeTeam']['team_name'];

      if(!empty($games['api']['fixtures'][$i]['homeTeam']['logo']))
        $aGames[$i]['homeTeam']['logo'] = $games['api']['fixtures'][$i]['homeTeam']['logo'];
      else
        $aGames[$i]['homeTeam']['logo'] = "https://montagnolirino.it/wp-content/uploads/2015/12/immagine-non-disponibile.png";

      // Dati squadra ospite
      $aGames[$i]['awayTeam']['team_id'] = $games['api']['fixtures'][$i]['awayTeam']['team_id'];
      $aGames[$i]['awayTeam']['team_name'] = $games['api']['fixtures'][$i]['awayTeam']['team_name'];

      if(!empty($games['api']['fixtures'][$i]['awayTeam']['logo']))
        $aGames[$i]['awayTeam']['logo'] = $games['api']['fixtures'][$i]['awayTeam']['logo'];
      else
        $aGames[$i]['awayTeam']['logo'] = "https://montagnolirino.it/wp-content/uploads/2015/12/immagine-non-disponibile.png";

      // Goal squadra di casa
      $aGames[$i]['goalsHomeTeam'] = $games['api']['fixtures'][$i]['goalsHomeTeam'];

      // Goal squadra ospite
      $aGames[$i]['goalsAwayTeam'] = $games['api']['fixtures'][$i]['goalsAwayTeam'];

      // Risultato
      $aGames[$i]['score']['halftime'] = $games['api']['fixtures'][$i]['score']['halftime'];
      $aGames[$i]['score']['fulltime'] = $games['api']['fixtures'][$i]['score']['fulltime'];

      // Controlli sui campi 'extratime' e 'penalty' perchè potrebbero essere nulli
      if(!empty($games['api']['fixtures'][$i]['extratime']))
        $aGames[$i]['score']['extratime'] = $games['api']['fixtures'][$i]['score']['penalty'];
      else
        $aGames[$i]['score']['extratime'] = "null";

      if(!empty($games['api']['fixtures'][$i]['penalty']))
        $aGames[$i]['score']['penalty'] = $games['api']['fixtures'][$i]['score']['penalty'];
      else
        $aGames[$i]['score']['penalty'] = "null";

  }

  return($aGames);
}
function getAllSquadByLeague($games)
{
  $aGames = array('team_id' => [],
					        'name' =>[],
                 );

  for ($i = 0;
       $i < count($games['api']['teams']);
       $i++)
  {
      //Id Squadra
      $aGames[$i]['team_id'] = $games['api']['teams'][$i]['team_id'];

      //Nome squadra
      $aGames[$i]['name'] = $games['api']['teams'][$i]['name'];

  }

  return($aGames);
}
/*
function getAllPlayerBySquad($games)
{
  $aGames = array('player_id' => [],
					        'player_name' =>[],
					        'firstname' => [],
                  'lastname' => [],
                  'number' => [],
                  'position' => [],
                  'age' => [],
                  'birth_date' => [],
                  'nationality' => [],
                  'height' => [],
                  'weight' => [],
                  'injured' => [],
                  'rating' => [],
                  'team_id' => [],
                  'team_name' => [],
                  'season' => [],
                  'goals' => array('total' => [],
                                  'conceded' => [],
                                  'assists' => [],
                                      ),
                  'games' => array('appearences' => [],
                                   'minutes_played' => [],
                                   'lineups' => [],
                                  )
                 );

  for ($i = 0;
       $i < count($games['api']['players']);
       $i++)
  {
      // Fixture id
      $aGames[$i]['player_id'] = $games['api']['players'][$i]['player_id'];

      // Id della lega
      $aGames[$i]['player_name'] = $games['api']['players'][$i]['player_name'];

      // Dati nome
      if(!empty($games['api']['players']))
        $aGames[$i]['firstname'] = $games['api']['players'][$i]['firstname'];
      else
        $aGames[$i]['firstname'] = "null";

      // Dati cognome
      if(!empty($games['api']['players']))
        $aGames[$i]['lastname'] = $games['api']['players'][$i]['lastname'];
      else
        $aGames[$i]['lastname'] = "null";

      // Dati numero
      if(!empty($games['api']['players']))
        $aGames[$i]['number'] = $games['api']['players'][$i]['number'];
      else
        $aGames[$i]['number'] = "null";

      // Dati posizione
      if(!empty($games['api']['players']))
        $aGames[$i]['position'] = $games['api']['players'][$i]['position'];
      else
        $aGames[$i]['position'] = "null";

      // Dati età
      if(!empty($games['api']['players']))
        $aGames[$i]['age'] = $games['api']['players'][$i]['age'];
      else
        $aGames[$i]['age'] = "null";

      // Dati data di nascita
      if(!empty($games['api']['players']))
        $aGames[$i]['birth_date'] = $games['api']['players'][$i]['birth_date'];
      else
        $aGames[$i]['birth_date'] = "null";

      // Dati nazionalità
      if(!empty($games['api']['players']))
        $aGames[$i]['nationality'] = $games['api']['players'][$i]['nationality'];
      else
        $aGames[$i]['nationality'] = "null";

      // Dati altezza
      if(!empty($games['api']['players']))
        $aGames[$i]['height'] = $games['api']['players'][$i]['height'];
      else
        $aGames[$i]['height'] = "null";

      // Dati peso
      if(!empty($games['api']['players']))
        $aGames[$i]['weight'] = $games['api']['players'][$i]['weight'];
      else
        $aGames[$i]['weight'] = "null";

      // Dati infortunio
      if(!empty($games['api']['players']))
        $aGames[$i]['injured'] = $games['api']['players'][$i]['injured'];
      else
        $aGames[$i]['injured'] = "null";

      // Dati della valutazione giocatore
      if(!empty($games['api']['players']))
        $aGames[$i]['rating'] = $games['api']['players'][$i]['rating'];
      else
        $aGames[$i]['rating'] = "null";

      // Dati del team_id
      $aGames[$i]['team_id'] = $games['api']['players'][$i]['team_id'];

      // Dati del nome del team
      $aGames[$i]['team_name'] = $games['api']['players'][$i]['team_name'];

      // Dati della stagione
      $aGames[$i]['season'] = $games['api']['players'][$i]['season'];

      // Dati sulle statistiche - goal
      $aGames[$i]['goals']['total'] = $games['api']['players'][$i]['goals']['total'];
      $aGames[$i]['goals']['conceded'] = $games['api']['players'][$i]['goals']['conceded'];
      $aGames[$i]['goals']['assists'] = $games['api']['players'][$i]['goals']['assists'];

      // Dati sulle statistiche - partite
      $aGames[$i]['games']['appearences'] = $games['api']['players'][$i]['games']['appearences'];
      $aGames[$i]['games']['minutes_played'] = $games['api']['players'][$i]['games']['minutes_played'];
      $aGames[$i]['games']['lineups'] = $games['api']['players'][$i]['games']['lineups'];

  }

  return($aGames);
}
*/


function getAllPlayerBySquad($games)
{
  $aGames = array('player_id' => [],
					        'player_name' =>[],
					        'firstname' => [],
                  'lastname' => [],
                  'number' => [],
                  'position' => [],
                  'age' => [],
                  'birth_date' => [],
                  'nationality' => [],
                  'height' => [],
                  'weight' => [],
                 );

  for ($i = 0;
       $i < count($games['api']['players']);
       $i++)
  {
      // Fixture id
      $aGames[$i]['player_id'] = $games['api']['players'][$i]['player_id'];

      // Id della lega
      $aGames[$i]['player_name'] = $games['api']['players'][$i]['player_name'];

      // Dati nome
      if(!empty($games['api']['players']))
        $aGames[$i]['firstname'] = $games['api']['players'][$i]['firstname'];
      else
        $aGames[$i]['firstname'] = "null";

      // Dati cognome
      if(!empty($games['api']['players']))
        $aGames[$i]['lastname'] = $games['api']['players'][$i]['lastname'];
      else
        $aGames[$i]['lastname'] = "null";

      // Dati numero
      if(!empty($games['api']['players']))
        $aGames[$i]['number'] = $games['api']['players'][$i]['number'];
      else
        $aGames[$i]['number'] = "null";

      // Dati posizione
      if(!empty($games['api']['players']))
        $aGames[$i]['position'] = $games['api']['players'][$i]['position'];
      else
        $aGames[$i]['position'] = "null";

      // Dati età
      if(!empty($games['api']['players']))
        $aGames[$i]['age'] = $games['api']['players'][$i]['age'];
      else
        $aGames[$i]['age'] = "null";

      // Dati data di nascita
      if(!empty($games['api']['players']))
        $aGames[$i]['birth_date'] = $games['api']['players'][$i]['birth_date'];
      else
        $aGames[$i]['birth_date'] = "null";

      // Dati nazionalità
      if(!empty($games['api']['players']))
        $aGames[$i]['nationality'] = $games['api']['players'][$i]['nationality'];
      else
        $aGames[$i]['nationality'] = "null";

      // Dati altezza
      if(!empty($games['api']['players']))
        $aGames[$i]['height'] = $games['api']['players'][$i]['height'];
      else
        $aGames[$i]['height'] = "null";

      // Dati peso
      if(!empty($games['api']['players']))
        $aGames[$i]['weight'] = $games['api']['players'][$i]['weight'];
      else
        $aGames[$i]['weight'] = "null";
  }

  return($aGames);
}


/*
Selezione url
*/
if($_GET['request'] == "general")
{
  $league_id = $_GET['league-id'];
  $url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/".$league_id;
  $data = getUrlContent($url);
  $data = json_decode($data,true);

  if (count($data) == 0)
  {
    response(204,"Assente",NULL);
  }
  else
  {
    $data = getAllInfoByMatch($data);
    response(200,"Presente",$data);
  }

}
else if($_GET['request'] == "squad")
{
  $league_id = $_GET['league-id'];
  $url = "https://api-football-v1.p.rapidapi.com/v2/teams/league/".$league_id;
  $data = getUrlContent($url);
  $data = json_decode($data,true);

  if (count($data) == 0)
  {
    response(204,"Assente",NULL);
  }
  else
  {
    $data = getAllSquadByLeague($data);
    response(200,"Presente",$data);
  }
}
else if($_GET['request'] == "player")
{
  $team_id = $_GET['team_id'];
  $url = "https://api-football-v1.p.rapidapi.com/v2/players/squad/".$team_id."/2019-2020";
  $data = getUrlContent($url);
  $data = json_decode($data,true);

  if (count($data) == 0)
  {
    response(204,"Assente",NULL);
  }
  else
  {
    $data = getAllPlayerBySquad($data);
    response(200,"Presente",$data);
  }
}
else
{
  response(400,"Rischiesta non valida",NULL);
}


?>
