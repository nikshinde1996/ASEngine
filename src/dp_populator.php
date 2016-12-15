<?php  

    $servername = "localhost";
	$username = "root";
	$password = "nikhil20#";
	$dbname = "ASengine";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}else{
		echo "Connection established !<br>";
	} 

	$url = addslashes($_GET['url']);
	echo "$url","<br>";
    
    if( !$url ) {
         die("You need to define a URL to process." );
    }
    else if( substr($url,0,7) != "http://" ){
      $url = "http://$url";
    }
    echo "$url"."<br>";
  
    $sql1 = "SELECT page_id FROM page WHERE page_url = \"$url\"";
    $result = $conn->query($sql1);

    if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
            $page_id = $row["page_id"]; 
            echo "Present page_id = $page_id";
       }
    }else{
    	$conn->query("INSERT INTO page (page_url) VALUES (\"$url\")");
    	$page_id = $conn->insert_id;
    }

    $myfile = fopen("/var/www/html/pop.php","r") or die("Unable to loop url page!");
   // echo fgets($myfile);


    while($buf=fgets($fd,1024)){
       $buf = trim($buf);
       $buf = strip_tags($buf);
       $buf = ereg_replace('/&\w;/','',$buf);
       preg_match_all("/(\b[\w+]+\b)/",$buf,$words);
 
       for($i=0;$words[$i];$i++){
          for($j=0;$words[$i][$j];$j++){
               $cur_word = addslashes(strtolower($words[$i][$j]) );
               echo "$cur_word"."<br>";
          }
       }   


    }
 

?>