<?php 
header("Access-Control-Allow-Origin: *");//other cross browser catch the db
header("Content-Type: application/json");

require '../db_connect.php';//db connection

$request_method = $_SERVER['REQUEST_METHOD'];

switch ($request_method) {
	case 'GET':
		index();
		break;

		case 'POST':
		store();
		break;

		case 'DELETE':
		delete();
		break;
	
		default:
		
		break;
}
  
 function store()
{
	global $pdo;//from db_connect.php
	$name = $_POST['name'];//name col: in table,query key name

if(!empty($name)){

	$sql = "SELECT * FROM categories where name=:name";//check if name is in db or not,all id and name are get from this
	$stmt = $pdo->prepare($sql);//get query
	$stmt->bindParam(":name", $name);//bind parameter
	$stmt->execute();
	//execute

	//var_dump($stmt->rowCount());//==print

	if($stmt-> rowCount()){
		$response = array(
			'status'=> 0,
			'status_message'=> "That name is already added to database"
		);
	}
	else{//no data is same in db and insert into db
		$sql = "INSERT INTO api_sample.categories (name) VALUES (:name)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name',$name);
		$stmt->execute();

		if($stmt->rowCount()){
			//$array=[]
			$response = array(
				'status' => 1,
				'status_message' => "Category is Added successfully" );//array>> that return json
			}
		}
	}	

	else
	{
	$response = array(
		'status' => 0,
		'status_message' => "Category cannot be null");
	}

	echo json_encode($response);//array format to json
}

function index(){
	global $pdo;
	$sql = "SELECT * FROM categories";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	$rows = $stmt->fetchAll();

	//var_dump($rows);//output >>> is there any data?

	$categories_arr = array();

	if ($stmt->rowCount() <= 0) {//no data
		$categories_arr['status']=0 ;//[key] value return 
		$categories_arr['status_message']="Something went wrong";
	}

	else{//data
		$categories_arr['status']=1 ;//[key] value return 
		$categories_arr['status_message']="200 OK";
		$categories_arr['data']= array();//array result[array[array]]
		foreach ($rows as $row) {
			$category = array("id" => $row['id'],"name" => $row['name']);
				array_push($categories_arr['data'] , $category);
			}
		echo json_encode($categories_arr);
		}
}

?>