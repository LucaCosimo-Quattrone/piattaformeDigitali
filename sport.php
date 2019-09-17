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
  ?><p><?php echo $games ?> </p>
  <?php  
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

$url = "https://www.scorebat.com/video-api/v1/";
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

