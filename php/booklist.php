<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "library";

$books = [];

//making connection
$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_error){
    die("connection failed: " . $sconn->connect_error);
}

$query = "select * from library.book";

if($result = $conn->query($query)){
    $i=0;
    while($row = mysqli_fetch_assoc($result)){
        $books[$i]['name'] = $row['name'];
        $books[$i]['id'] = $row['id'];
        $books[$i]['s_id'] = $row['s_id'];
        $books[$i]['quantity'] = $row['quantity'];
        $books[$i]['url'] = $row['url'];
        $books[$i]['i_url'] = $row['i_url'];
        $i++;
    }
    echo json_encode($books);
    
    
}
else{
  http_response_code(404);
}


$conn->close();



?>