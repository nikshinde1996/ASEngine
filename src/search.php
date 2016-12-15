<!DOCTYPE html>
<html>
<head>
	<title>
		ASEngine
	</title>
</head>
<body>
    <?php

        function gettime(){
        	list($usec,$sec) = explode("",microtime());
        	return ((float)$usec + (float)$sec);
        }

        if($_POST['keyword']){
        	
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

            $starttime = gettime(); 
        	
        	$keyword = addslashes($_POST['$keyword']);
            $result = addslashes($_POST['$result']);
        	
        	$result = $conn->query(" SELECT p.page_url AS url,
                           COUNT(*) AS occurences 
                           FROM page p, word w, occurence o
                           WHERE p.page_id = o.page_id AND
                           w.word_id = o.word_id AND
                           w.word_word = \"$keyword\"
                           GROUP BY p.page_id
                           ORDER BY occurences DESC
                           LIMIT $results" );

            $endtime = gettime();

            print "<h2>Search results for '".$_POST['keyword']."':</h2>\n";
   			for( $i = 1; $row = mysql_fetch_array($result); $i++ ){
      			print "$i. <a href='".$row['url']."'>".$row['url']."</a>\n";
      			print "(occurrences: ".$row['occurrences'].")<br><br>\n";
   			}

   			/* Present how long it took the execute the query: */
   			print "query executed in ".(substr($end_time-$start_time,0,5))." seconds.";
            
        }else{
            print "<form method='post'> Keyword: 
                <input type='text' size='20' name='keyword'>\n";
            print "Results: <select name='results'><option value='5'>5</option>\n";
            print "<option value='10'>10</option><option value='15'>15</option>\n";
            print "<option value='20'>20</option></select>\n";
            print "<input type='submit' value='Search'></form>\n";
        }

        
    ?>
</body>
</html>