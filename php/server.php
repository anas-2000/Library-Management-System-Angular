<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

session_start();



$servername = "localhost";
$username = "root";
$password = "";
$database = "library";

$user = [];
$p = $_REQUEST['username'];
$q = $_REQUEST['password'];
$query = "Select id, username, password, type from library.user where username = '".$p ."' and password = '".$q."'";


//making connection
$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_error){
    die("connection failed: " . $sconn->connect_error);
}

if($result = $conn->query($query)){
    
    while($row = mysqli_fetch_assoc($result)){
        $user['id'] = $row['id'];
        $user['username'] = $row['username'];
        $user['password'] = $row['password'];
        $user['type'] = $row['type'];
        
    }
    echo json_encode($user);
}
else
{
  http_response_code(404);
}

$_SESSION['id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['password'] = $user['password'];
$_SESSION['type'] = $user['type'];




$conn->close();
?>