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
	$json_response = json_encode($response)

	echo $json_response;
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
  response(200,"Presente",$data);
}
else
{
  response(400,"Rischiesta non valida",NULL);
}


?>

