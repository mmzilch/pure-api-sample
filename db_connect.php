<?php 
	$serverName = "localhost";
	$dbName ="api_sample";
	$user = "root";
	$password = "";

	$pdo = new PDO("mysql:host=$serverName;dbname=$dbName" , $user, $password); //obj//prepare to connect

	try {//if not connect
	$conn = $pdo;
	$conn -> setAttribute(PDO:: ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);//to show err msg

	echo "Connected Successfully";//==println, if connected
	}catch(Excepteion $e){
		echo "Connection failed: ". $e -> getMessage();//err msg
	}

 ?>