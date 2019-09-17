<?php
function getUrlContent($url)
{
    $curl = curl_init();
    curl_setopt_array($curl, array( CURLOPT_URL => $url,
  	                                CURLOPT_RETURNTRANSFER => true,
  	                                CURLOPT_ENCODING => "",
  	                                CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 30,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => "GET",
                                    CURLOPT_HTTPHEADER => array("x-rapidapi-host: football-livescore.p.rapidapi.com",
  		                                                          "x-rapidapi-key: e237d77783msh1277417c4197892p118192jsnf7d06f8c7652"
  	                                                            ),
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
  $aGames = array('title' => [],
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
					);

  for ($i = 0;
       $i < count($games['title']);
       $i++)
  {
      $aGames['title'][$i] = $games['title'][$i];
      $aGames['embed'][$i] = $games['embed'][$i];
      $aGames['url'][$i] = $games['url'][$i];
      $aGames['thumbnail'][$i] = $games['thumbnail'][$i];
      $aGames['date'][$i] = $games['date'][$i];
      $aGames['side1'][$i]['name'][$i] = $games['side1'][$i]['name'][$i];
      $aGames['side1'][$i]['url'][$i] = $games['side1'][$i]['url'][$i];
      $aGames['side2'][$i]['name'][$i] = $games['side2'][$i]['name'][$i];
      $aGames['side2'][$i]['url'][$i] = $games['side2'][$i]['url'][$i];
      $aGames['competition'][$i]['name'][$i] = $games['competition'][$i]['name'][$i];
      $aGames['competition'][$i]['url'][$i] = $games['competition'][$i]['url'][$i];
      $aGames['videos'][$i]['title'][$i] = $games['videos'][$i]['title'][$i];
      $aGames['videos'][$i]['embed'][$i] = $games['videos'][$i]['embed'][$i];
  }

  return($aGames);
}

$url = "https://www.scorebat.com/video-api/v1/"
$response = getUrlContent($url);
$data = json_decode($response,true);

if (count($data['title']) == 0)
{
  deliver_response(204,"Assente",NULL);
}
elseif (count($data['title']) > 0)
{
  $games = getGames($data);
  response(200,"Presente",$games);
}
else
{
  deliver_response(400,"Rischiesta non valida",NULL);
}


?>
