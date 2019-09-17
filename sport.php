<?php

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
       $i < count($games) ;
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


$data = getUrlContent($url);
$content = json_decode($data,true);
echo $data;

if (count($data) == 0)
{
  deliver_response(204,"Assente",NULL);
}
elseif (count($data) > 0)
{
  $games = getGames($data);
  response(200,"Presente",$games);
}
else
{
  deliver_response(400,"Rischiesta non valida",NULL);
}


?>
