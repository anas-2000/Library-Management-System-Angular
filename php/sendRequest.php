<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

session_start();


$servername = "localhost";
$username = "root";
$password = "";
$database = "library";

$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_error){
    die("connection failed: " . $sconn->connect_error);
}

$info= [];
$data = [];
$info = file_get_contents("php://input");
$data = json_decode($info, true);
$requests=[];

$request_id = $_SESSION['request_id'] + 1;
$status = 'pending';
$u_id = $_SESSION['id'];
$b_id = mysqli_real_escape_string($conn, trim($data['b_id']));


$query ="Insert into library.request (request_id, status, u_id, b_id) values ({$request_id},'{$status}',{$u_id},{$b_id})";


if($conn->query($query) === TRUE){
    //http_response_code(201);
    $requests['request_id'] = $request_id;
    $requests['status'] = $status;
    $requests['u_id'] = $u_id;
    $requests['b_id'] = $b_id;
    echo json_encode($requests);
}
else{
    echo "Error: " . $query . "<br>" . $conn->error;
}

?>