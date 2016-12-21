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
			  $password = "holyshit";
			  $dbname = "ASengine";

			  // Create connection
			  $conn = new mysqli($servername, $username, $password, $dbname);
			  // Check connection
			  if ($conn->connect_error) {
    		  	die("Connection failed: " . $conn->connect_error);
			  } 

          $starttime = gettime(); 
        	
        	$keyword = addslashes($_POST['keyword']);
          $result = addslashes($_POST['result']);
        	

          $sql = "select p.page_url as url,
                  count(*) as occ 
                  from page p, word w,occurence o where p.page_id = o.page_id and w.word_id = o.word_id and w.word_word='".$keyword."'
                  group by p.page_id
                  order by occ desc ";

          
          $result = $conn->query($sql);
          $endtime = gettime();

          print "<h2>Search results for '".$_POST['keyword']."':</h2>\n";
        
        	if ($result->num_rows > 0) {
               // output data of each row
               while($row = $result->fetch_assoc()) {
                  print "$i. <a href='".$row['url']."'>".$row['url']."</a>\n";
                  print "(occurences: ".$row['occ'].")<br><br>\n";
               }
               echo "</table>";
          }else{
               echo "0 results";
          } 

          print "<br>query executed in ".(substr($end_time-$start_time,0,5))." seconds.";

          $conn->close();            
        }else{
            print "<img src='../res/im1.gif' width='300px' height='300px' style='padding:3%;padding-left:40%;'>";
            print "<form method='post' action=\"?\" style='padding-left:25%;'> Keyword: 
                <input type='text' size='50' name='keyword' style='padding-left:4%;'>\n";
            print "Results: <select name='results'><option value='5'>5</option>\n";
            print "<option value='10'>10</option><option value='15'>15</option>\n";
            print "<option value='20'>20</option></select>\n";
            print "<input type='submit' value='Search'></form>\n</div>";
        }

        
    ?>
</body>
</html>