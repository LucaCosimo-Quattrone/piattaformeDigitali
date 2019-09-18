<?php
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
function getGames($games)
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
      $aGames[$i]['homeTeam']['logo'] = $games['api']['fixtures'][$i]['homeTeam']['logo'];

      // Dati squadra ospite
      $aGames[$i]['awayTeam']['team_id'] = $games['api']['fixtures'][$i]['awayTeam']['team_id'];
      $aGames[$i]['awayTeam']['team_name'] = $games['api']['fixtures'][$i]['awayTeam']['team_name'];
      $aGames[$i]['awayTeam']['logo'] = $games['api']['fixtures'][$i]['awayTeam']['logo'];

      // Goal squadra di casa
      $aGames[$i]['goalsHomeTeam'] = $games['api']['fixtures'][$i]['goalsHomeTeam'];

      // Goal squadra ospite
      $aGames[$i]['goalsAwayTeam'] = $games['api']['fixtures'][$i]['goalsAwayTeam'];

      // Risultato
      $aGames[$i]['score']['halftime'] = $games['api']['fixtures'][$i]['score']['halftime'];
      $aGames[$i]['score']['fulltime'] = $games['api']['fixtures'][$i]['score']['fulltime'];

      // Controlli sui campi 'extratime' e 'penalty' perchè potrebbero essere nulli
      if(!empty($games['api']['fixtures'][$i]['']))
        $aGames[$i]['score']['extratime'] = $games['api']['fixtures'][$i]['score']['penalty'];
      else
        $aGames[$i]['score']['extratime'] = "null";

      if(!empty($games['api']['fixtures'][$i]['']))
        $aGames[$i]['score']['penalty'] = $games['api']['fixtures'][$i]['score']['penalty'];
      else
        $aGames[$i]['score']['penalty'] = "null";

  }

  return($aGames);
}

$league_id = $_GET['league-id'];
$url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/".$league_id;
$data = getUrlContent($url);
$data = json_decode($data,true);

if (count($data) == 0)
{
  response(204,"Assente",NULL);
}
elseif (count($data) > 0)
{
  $games = getGames($data);
  response(200,"Presente",$games);
}
else
{
  response(400,"Rischiesta non valida",NULL);
}


?>
