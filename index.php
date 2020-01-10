<?php
header("Content-Type:application/json");
$pwd = "Test";

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
                  'round' => [],
                  'status' => [],
                  'homeTeam' => array('team_id' => [],
                                      'team_name' => [],
                                      'logo' => [],
                                      ),
                  'awayTeam' => array('team_id' => [],
                                      'team_name' => [],
                                      'logo' => [],
                                      ),
                  'score' => array('halftime' => [],
                                   'fulltime' => [],
                                   'extratime' => [],
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

      // Dati sulla partita disputata
      $aGames[$i]['round'] = $games['api']['fixtures'][$i]['round'];

      // Dati sullo stato della partita
      $aGames[$i]['status'] = $games['api']['fixtures'][$i]['status'];

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

      // Risultato
      if(!empty($games['api']['fixtures'][$i]['score']['halftime']))
        $aGames[$i]['score']['halftime'] = $games['api']['fixtures'][$i]['score']['halftime'];
      else
        $aGames[$i]['score']['halftime'] = "null";

      if(!empty($games['api']['fixtures'][$i]['score']['fulltime']))
        $aGames[$i]['score']['fulltime'] = $games['api']['fixtures'][$i]['score']['fulltime'];
      else
        $aGames[$i]['score']['fulltime'] = "null";

      // Controlli sui campi 'extratime' e 'penalty' perchè potrebbero essere nulli
      if(!empty($games['api']['fixtures'][$i]['extratime']))
        $aGames[$i]['score']['extratime'] = $games['api']['fixtures'][$i]['score']['penalty'];
      else
        $aGames[$i]['score']['extratime'] = "null";

  }

  return($aGames);
}
function getAllInfoByMatchWithRound($games)
{
  $aGames = array('fixture_id' => [],
					        'league_id' =>[],
					        'event_date' => [],
                  'round' => [],
                  'status' => [],
                  'homeTeam' => array('team_id' => [],
                                      'team_name' => [],
                                      'logo' => [],
                                      ),
                  'awayTeam' => array('team_id' => [],
                                      'team_name' => [],
                                      'logo' => [],
                                      ),
                  'score' => array('halftime' => [],
                                   'fulltime' => [],
                                   'extratime' => [],
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

      // Dati sulla partita disputata
      $aGames[$i]['round'] = $games['api']['fixtures'][$i]['round'];


      // Dati sullo stato della partita
      $aGames[$i]['status'] = $games['api']['fixtures'][$i]['status'];

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

      // Risultato
      $aGames[$i]['score']['halftime'] = $games['api']['fixtures'][$i]['score']['halftime'];
      $aGames[$i]['score']['fulltime'] = $games['api']['fixtures'][$i]['score']['fulltime'];

      // Controlli sui campi 'extratime' e 'penalty' perchè potrebbero essere nulli
      if(!empty($games['api']['fixtures'][$i]['extratime']))
        $aGames[$i]['score']['extratime'] = $games['api']['fixtures'][$i]['score']['penalty'];
      else
        $aGames[$i]['score']['extratime'] = "null";

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
function getAllPlayerBySquad($games)
{
  $aGames = array('player_id' => [],
					        'player_name' =>[],
					        'firstname' => [],
                  'lastname' => [],
                  'number' => [],
                  'position' => [],
                  'age' => [],
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
function getLineupsByFixtures($games, $homeTeam, $awayTeam)
{
  $aGames = array('homeTeam' =>array('formation' =>[],
                                     'startXI' =>array('player' => [],
                                                       'number' => [],
                                                       'pos' => []
                                                      )
                                    ),
                  'awayTeam' =>array('formation' =>[],
                                     'startXI' =>array('player' => [],
                                                       'number' => [],
                                                       'pos' => []
                                                       )
                                     )
                  );


      // Nome squadra
      $aGames['homeTeam'] = $games['api']['lineUps'][$homeTeam];

      // Fixture id
      $aGames['homeTeam']['formation'] = $games['api']['lineUps'][$homeTeam]['formation'];


      for ($i = 0;
           $i < count($games['api']['lineUps'][$homeTeam]['startXI']);
           $i++)
      {
        $aGames['homeTeam']['startXI'][$i]['player'] = $games['api']['lineUps'][$homeTeam]['startXI'][$i]['player'];
        $aGames['homeTeam']['startXI'][$i]['number'] = $games['api']['lineUps'][$homeTeam]['startXI'][$i]['number'];
        $aGames['homeTeam']['startXI'][$i]['pos'] = $games['api']['lineUps'][$homeTeam]['startXI'][$i]['pos'];
      }

      // Nome squadra
      $aGames['awayTeam'] = $games['api']['lineUps'][$awayTeam];

      // Fixture id
      $aGames['awayTeam']['formation'] = $games['api']['lineUps'][$awayTeam]['formation'];

      for ($i = 0;
           $i < count($games['api']['lineUps'][$awayTeam]['startXI']);
           $i++)
      {
        $aGames['awayTeam']['startXI'][$i]['player'] = $games['api']['lineUps'][$awayTeam]['startXI'][$i]['player'];
        $aGames['awayTeam']['startXI'][$i]['number'] = $games['api']['lineUps'][$awayTeam]['startXI'][$i]['number'];
        $aGames['awayTeam']['startXI'][$i]['pos'] = $games['api']['lineUps'][$awayTeam]['startXI'][$i]['pos'];
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
  $username = urldecode($_GET['user']);
  $password = urldecode($_GET['pwd']);
  if(($username == "LuQuattr") && (password_verify($pwd, $password)))
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
    response(300,"PermessiNegati");
  }
}
else if($_GET['request'] == "lineup")
{
  $fixtures_id = $_GET['fix_id'];
  $homeTeam = urldecode($_GET['home-team']);
  $awayTeam = urldecode($_GET['away-team']);
  $url = "https://api-football-v1.p.rapidapi.com/v2/lineups/".$fixtures_id;
  $data = getUrlContent($url);
  $data = json_decode($data,true);

  if (count($data) == 0)
  {
    response(204,"Assente",NULL);
  }
  else
  {
    $data = getLineupsByFixtures($data, $homeTeam, $awayTeam);
    response(200,"Presente",$data);
  }
}
else if($_GET['request'] == "roundfix")
{
  $league_id = $_GET['league-id'];
  $round = $_GET['round'];
  $url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/". $league_id ."/Regular_Season_-_". $round;
  $data = getUrlContent($url);
  $data = json_decode($data,true);

  if (count($data) == 0)
  {
    response(204,"Assente",NULL);
  }
  else
  {
    $data = getAllInfoByMatchWithRound($data);
    response(200,"Presente",$data);
  }
}
else
{
  response(400,"Rischiesta non valida",NULL);
}


?>

