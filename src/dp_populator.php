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

    $lines = file("$url");

    // Loop through our array, show HTML source as HTML source; and line numbers too.
    foreach ($lines as $line_num => $line) {
        $line = trim($line);
        $line = strip_tags($line);
        $line = trim($line);
        $line = preg_replace('/&\w;/', '', $line);
        preg_match_all("/(\b[\w+]+\b)/",$line,$words);

        for( $i = 0; $words[$i]; $i++ ){
            for( $j = 0; $words[$i][$j]; $j++ ){
              //  Does the current word already have a record in the word-table? 
              $cur_word = addslashes( strtolower($words[$i][$j]) );
              // echo "$cur_word<br>";

              $sql2 = "SELECT word_id FROM word WHERE word_word = '$cur_word'";
              $res = $conn->query(sql2);

              if ($res->num_rows > 0) {
                  while($row = $res->fetch_assoc()) {
                      $page_id = $row["word_id"]; 
                    //  echo "Present page_id = $page_id";
                  }
              }else{
    	          $conn->query("INSERT INTO word (word_word) VALUES (\"$cur_word\")");
    	          $word_id = $conn->insert_id;
              }

              $sql3 = $conn->query("INSERT INTO occurence (word_id,page_id) VALUES ($word_id,$page_id)");
              echo "Indexing: $cur_word <br>";
            }
        } 
    }

    fclose($myfile);

?>