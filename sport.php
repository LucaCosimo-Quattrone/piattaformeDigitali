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
       $i < count($games);
       $i++)
  {
      $aGames[$i]['title'] = $games[$i]['title'];
      $aGames[$i]['embed'] = $games[$i]['embed'];
      $aGames[$i]['url'] = $games[$i]['url'];
      $aGames[$i]['thumbnail'] = $games[$i]['thumbnail'];
      $aGames[$i]['date'] = $games[$i]['date'];
      $aGames[$i]['side1'][$i]['name'] = $games[$i]['side1'][$i]['name'];
      $aGames[$i]['side1'][$i]['url'] = $games[$i]['side1'][$i]['url'];
      $aGames[$i]['side2'][$i]['name'] = $games[$i]['side2'][$i]['name'];
      $aGames[$i]['side2'][$i]['url'] = $games[$i]['side2'][$i]['url'];
      $aGames[$i]['competition'][$i]['name'] = $games[$i]['competition'][$i]['name'];
      $aGames[$i]['competition'][$i]['url'] = $games[$i]['competition'][$i]['url'];
      $aGames[$i]['videos'][$i]['title'] = $games[$i]['videos'][$i]['title'];
      $aGames[$i]['videos'][$i]['embed'] = $games[$i]['videos'][$i]['embed'];
  }

  return($aGames);
}

$url = "https://www.scorebat.com/video-api/v1/";
$data = getUrlContent($url);
$data = json_decode($data,true);
print_r($data);

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
