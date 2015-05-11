<html>
<head>
  <title>flutrack test</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head/>
<body>
<body/>
<html/>

<?php
$queries = array( "?&q=Τσίπρας%20OR%20Παπαδημούλης&result_type=recent&include_entities=1&count=100+exclude:retweets",
					"?&q=Βορίδης%20OR%20Σαμαράς&result_type=recent&include_entities=1&count=100+exclude:retweets",
					"?&q=Μιχαλολιάκος%20OR%20Κασιδιάρης&result_type=recent&include_entities=1&count=100+exclude:retweets"
					);
					$csvf = fopen("mazemenatweets.csv" , 'a');//OPENING CSV FILE FOR APPENDING STRIPPED TWEETS

/*****************************************************************************************

						SETTING API QUERY,PARAMETRES AND TOKENS
						     TOKENS TAKEN FROM OAUTH


********************************************************************************************/
$api_URL = 'https://api.twitter.com/1.1/search/tweets.json';
$API_parameters = '&include_entities=true&result_type=recent';

$bearertok = "AAAAAAAAAAAAAAAAAAAAAC4CUAAAAAAAe4fo6tVR2jCYdwJ7yQ%2BKjlPIOmg%3DoeTz7MkA2F3fVOsTL9oEVhcLT2awxP03dwedxohbKCA";
/*****************************************************************************************

					      SETTING CURL FOR REQUESTING TWEETS
						    http://curl.haxx.se/docs/


********************************************************************************************/
if(filesize("mazemenatweets.csv") == 0 ){	
	$line = array(
				"name" => "name",
				"id" => "id",
				"stweet" => "stripped_tweet",
				"time" => "time",
				);
		fputcsv($csvf, $line);
	}
	
for($index=0;$index<3;$index++){
$API_query = "$queries[$index]";
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
  
/*****************************************************************************************

					      INITTIALIZE FIRST LINE OF SCV FILE
							NAME,ID,STRIPPED_TWEETS,TIME


********************************************************************************************/

/*****************************************************************************************

								FOREACH LOOP 
						TRANFERING TWEETS FROM JSON TO CSV


********************************************************************************************/
	
	
	
	foreach ($json['statuses'] as $tweet) {
      
      $tweet_id = $tweet["id_str"];	  
      $text_tweet = $tweet["text"];
	  $user_id = $tweet["user"]["name"];
		
		$datetime = $tweet["created_at"];
		$tweet_text = $tweet["text"];
        $tweet_ID = $tweet["id_str"];
        $twitter_account_name = $tweet["user"]["screen_name"];
        $twitter_account_ID =$tweet["user"]["id_str"]; //id_string because of large numbers
        $stripped_tweet = preg_replace('/(#|@)\S+|(RT:)|(RT)/', '', $tweet_text); // remove hashtags
        $stripped_tweet = preg_replace('#\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))#', '', $stripped_tweet);
		$stripped_tweet = trim(preg_replace('/\s+/', ' ', $stripped_tweet ));
		$unix_time = strtotime($datetime);
		
		$line = array(
				"name" => "$twitter_account_name",
				"id" => "$twitter_account_ID",
				"stweet" => "$stripped_tweet",
				"time" => "$unix_time",
				);
		
		if(!(ISinCSV("mazemenatweets.csv",$line[stweet]))){	
		
		fputcsv($csvf, $line);
		}
		
		//echo "</br>o xrhsths</br>";
		//print_r ($user_id);
		
		//echo "</br>eipe stripped:</br>";
		//print_r ($stripped_tweet);
		//echo "</br>**********************************************************************************************</br>";
		}
		$Fuc = fopen ('refresh_url.txt',w);
		$cache = $json['search_metadata']['refresh_url'];
		fwrite($Fuc,$cache);
		
		
		
		
		
  }
  	//print_r(csvFILE);
    fclose($csvf);
  
		
	function ISinCSV( $filename,$line ){

$csvFILE = array();
$same = false;

	$lines = file($filename, FILE_IGNORE_NEW_LINES);

	foreach ($lines as $key => $value)
	{
		$csvFILE[$key] = str_getcsv($value);
	}

	foreach ( $csvFILE as $key){
	
	      similar_text($key[2],$line, $per);
			echo "</br>sugkrinw: ";
			echo $key[2];
			echo " </br> me: <br/> ";
			echo $line;
			echo " </br> me apotelesma: ";
			echo $per;
	      if($per >= 80){
	
	      $same = 1;
	      echo "</br> mesa sto if to same einai:";
	      echo $same;
	      echo "</br>";
	      break;
	   
	      }else{
	      $same = 0;
	       }
	
	}
	echo "trexei auto.";
	if( $same == 1){
	return true;
    }
    else{
    return false;
    }
  

  }
  
?>
