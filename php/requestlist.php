<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "library";


$requests = [];

$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_error){
    die("connection failed: " . $sconn->connect_error);
}
$query = "select * from library.request where status = 'pending' ";

if($result = $conn->query($query)){
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $requests[$i]['request_id'] = $row['request_id'];
        $requests[$i]['status'] = $row['status'];
        $requests[$i]['u_id'] = $row['u_id'];
        $requests[$i]['b_id'] = $row['b_id'];
        $i++;
    }
    
    echo json_encode($requests);
    $_SESSION['request_id'] = $requests[--$i]['request_id'];
}
else{
    http_response_code(404);
}

  
$conn->close();
  
?>