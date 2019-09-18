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
                                    CURLOPT_HTTPHEADER => array("cache-control: no-cache"),
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
  $aGames = array(array('title' => [],
					              'embed' =>[],
					              'url' => [],
                        'thumbnail' => [],
                        'date' => [],
                        'side1' => array( 'name' => [],
                                          'url' => []),
                        'side2' => array( 'name' => [],
                                          'url' => []),
                        'competition' => array( 'name' => [],
                                                'url' => []),
                        'videos' => array( 'title' => [],
                                           'embed' => []),
					             )
                 );

  for ($i = 0;
       $i < count($games);
       $i++)
  {
      if(!empty($games[$i]['title']))
        $aGames[$i]['title'] = $games[$i]['title'];
      else
        $aGames[$i]['title'] = "null";

      if(!empty($games[$i]['embed']))
        $aGames[$i]['embed'] = $games[$i]['embed'];
      else
        $aGames[$i]['embed'] = "null";

      if(!empty($games[$i]['url']))
        $aGames[$i]['url'] = $games[$i]['url'];
      else
        $aGames[$i]['url'] = "null";

      if(!empty($games[$i]['thumbnail']))
        $aGames[$i]['thumbnail'] = $games[$i]['thumbnail'];
      else
        $aGames[$i]['thumbnail'] = "null";

      if(!empty($games[$i]['date']))
        $aGames[$i]['date'] = $games[$i]['date'];
      else
        $aGames[$i]['date'] = "null";

      //$aGames[$i]['side1'][$i]['name'][$i] = $games[$i]['side1'][$i]['name'][$i];
      //$aGames[$i]['side1'][$i]['url'][$i] = $games[$i]['side1'][$i]['url'][$i];
      //$aGames[$i]['side2'][$i]['name'][$i] = $games[$i]['side2'][$i]['name'][$i];
      //$aGames[$i]['side2'][$i]['url'][$i] = $games[$i]['side2'][$i]['url'][$i];
      //$aGames[$i]['competition'][$i]['name'][$i] = $games[$i]['competition'][$i]['name'][$i];
      //$aGames[$i]['competition'][$i]['url'][$i] = $games[$i]['competition'][$i]['url'][$i];
      //$aGames[$i]['videos'][$i]['title'][$i] = $games[$i]['videos'][$i]['title'][$i];
      //$aGames[$i]['videos'][$i]['embed'][$i] = $games[$i]['videos'][$i]['embed'][$i];
  }

  return($aGames);
}

$url = "https://api-football-v1.p.rapidapi.com/v2/fixtures/league/4";
$data = getUrlContent($url);
$data = json_decode($data,true);

if (count($data) == 0)
{
  response(204,"Assente",NULL);
}
elseif (count($data) > 0)
{
  //$games = getGames($data);
  response(200,"Presente",$data);
}
else
{
  response(400,"Rischiesta non valida",NULL);
}


?>
