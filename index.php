<?php
header("Content-Type:application/json");
//Pagina principale del web server


if (isset($_GET["request"]))
{
  if (($_GET["request"]) == "sport")
  {
    $url = "https://www.scorebat.com/video-api/v1/";
    require("sport.php");
  }
  else
  {

  }
}

?>
