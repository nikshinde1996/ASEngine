<?php
  	$servername = "localhost";
	$username = "root";
	$password = "holyshit";
	$dbname = "ASengine";
	
	//using PDO instead of MySQLi OOP/procedural
	try{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		
		$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
		$sql1 = "CREATE TABLE page(
		  page_id int(10) unsigned NOT NULL auto_increment,
		  page_url varchar(200) NOT NULL default '',
		  PRIMARY KEY (page_id)
		)";
		
		$sql2 = "CREATE TABLE word(
		  word_id int(10) unsigned NOT NULL auto_increment,
		  word_word varchar(50) NOT NULL default '',
		  PRIMARY KEY (word_id)
		)";
		
		$sql3 = "CREATE TABLE occurence(
		  occurrence_id int(10) unsigned NOT NULL auto_increment,
		  word_id int(10) unsigned NOT NULL default '0',
		  page_id int(10) unsigned NOT NULL default '0',
		  PRIMARY KEY (occurrence_id)
		)";
		
		$conn->exec($sql1);
		$conn->exec($sql2);
		$conn->exec($sql3);
		
		echo "All tables created successfully";
		
	}catch(PDOException $e){
		echo $sql."<br>".$e->getMessage();
	}

?>