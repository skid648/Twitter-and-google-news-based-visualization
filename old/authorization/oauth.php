<?php
// fill in your consumer key and consumer secret below
define('CONSUMER_KEY', 'raCr6vpkMGirsUzXALRnZQ');
define('CONSUMER_SECRET', 'JPEf3tBkZ3onm3M3yoEBAgKM6qLLAyccTBaND3e5rY');
/**
*        Get the Bearer Token, this is an implementation of steps 1&2
*        from https://dev.twitter.com/docs/auth/application-only-auth
*/
        // Step 1
        // step 1.1 - url encode the consumer_key and consumer_secret in accordance with RFC 1738
        $encoded_consumer_key = urlencode(CONSUMER_KEY);
        $encoded_consumer_secret = urlencode(CONSUMER_SECRET);
        // step 1.2 - concatinate encoded consumer, a colon character and the encoded consumer secret
        $bearer_token = $encoded_consumer_key.':'.$encoded_consumer_secret;
        // step 1.3 - base64-encode bearer token
        $base64_encoded_bearer_token = base64_encode($bearer_token);
        // step 2
        $url = "https://api.twitter.com/oauth2/token"; // url to send data to for authentication
        $headers = array( 
                "POST /oauth2/token HTTP/1.1", 
                "Host: api.twitter.com", 
                "User-Agent: jonhurlock Twitter Application-only OAuth App v.1",
                "Authorization: Basic ".$base64_encoded_bearer_token."",
                "Content-Type: application/x-www-form-urlencoded;charset=UTF-8", 
                "Content-Length: 29"
        ); 

        $ch = curl_init();  // setup a curl
        curl_setopt($ch, CURLOPT_URL,$url);  // set url to send to
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // set custom headers
        curl_setopt($ch, CURLOPT_POST, 1); // send as post
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return output
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");		// post body/fields to be sent
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $header = curl_setopt($ch, CURLOPT_HEADER, 1); // send custom headers
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $retrievedhtml = curl_exec ($ch); // execute the curl
        
			if(curl_exec($ch) === false)
				{
					echo 'Curl error: ' . curl_error($ch);
				}
				else
				{
					echo 'Operation completed without any errors';
				}
		curl_close($ch); // close the curl
        $output = explode("\n", $retrievedhtml);
        $bearer_token = '';
        foreach($output as $line)
        {
                if($line === false)
                {
                        echo " there was no bearer token";
                }else{
						echo "egine h fash";
                        $bearer_token = $line;
                }
        }
        $bearer_token = json_decode($bearer_token);
        $toxw =  $bearer_token->{'access_token'};
		echo "oxi?";
		var_dump($toxw);
		var_dump($httpcode);
		
?>
