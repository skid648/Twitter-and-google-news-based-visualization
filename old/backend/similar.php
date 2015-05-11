<html>
<head>
  <title>flutrack test</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head/>
<body>
<body/>
<html/>

<?php

$flag;
echo "douleuw</br>";
$flag = ISinCSV("mazemenatweets.csv","Εξεπλάγη ο Κασιδιάρης βλέποντας τους δημοσιογράφους να αφήνουν τα μικρόφωνα στα πόδια του.Μέχρι τώρα είχε τους δημοσιογράφ…");
var_dump($flag);

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
