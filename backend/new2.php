<html>
<head>
  <title>flutrack test</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head/>
<body>
<body/>
<html/>

<?php


$api_URL = 'https://api.twitter.com/1.1/search/tweets.json';
$API_parameters = '&include_entities=true&result_type=recent';

$bearertok = "AAAAAAAAAAAAAAAAAAAAAC4CUAAAAAAAe4fo6tVR2jCYdwJ7yQ%2BKjlPIOmg%3DoeTz7MkA2F3fVOsTL9oEVhcLT2awxP03dwedxohbKCA";


$name = "alekshs%20tsipras";
$API_query = "?&q=".$name;
$ch = curl_init();
$headers = array( 
    "Authorization: Bearer $bearertok"
  ); 
  
  curl_setopt($ch, CURLOPT_URL, "$api_URL"."$API_query");
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, " birdvisualization.comze.com Application / mailto:p11gkli@ionio.com ");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $data = curl_exec($ch);
  if(curl_exec($ch) === false)
				{
					echo 'Curl error: ' . curl_error($ch);//ERROR CHECKING
				}
				else
				{
					echo 'Operation completed without any errors';
				}
		
  $info = curl_getinfo($ch); 
  $http_code = $info['http_code'];//print_r($http_code); FOR DEBUG TO HTTP HEADERS
  curl_close($ch);//CLOSING CURL
  $json = json_decode($data, true);//decoding json from twitter 
  var_dump($json);
  
/*****************************************************************************************

					      INITTIALIZE FIRST LINE OF SCV FILE
							NAME,ID,STRIPPED_TWEETS,TIME


********************************************************************************************/

/*****************************************************************************************

								FOREACH LOOP 
						TRANFERING TWEETS FROM JSON TO CSV


********************************************************************************************/
	


  
  
?>
