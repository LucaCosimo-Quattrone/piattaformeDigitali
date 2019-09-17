<?php
header("Content-Type:application/json");
//Pagina principale del web server

function getUrlContent($url)
{
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array("cache-control: no-cache")));
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
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


if (isset($_GET["request"]))
{
  if (($_GET["request"]) == "film")
  {
    $url = "";
    require("film.php");
  }
  elseif (($_GET["request"]) == "sport")
  {
    $url = "https://www.scorebat.com/video-api/v1/";
    require("sport.php");
  }
  else
  {

  }
}

?>
