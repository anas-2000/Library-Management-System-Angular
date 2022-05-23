<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "library";

$user =[];
$id;

//making connection
$conn = new mysqli($servername, $username, $password, $database);
if($conn->connect_error){
    die("connection failed: " . $sconn->connect_error);
}

$postdata = file_get_contents("php://input");



$data = json_decode($postdata,true);


$name = mysqli_real_escape_string($conn, $data['name']);
$uname = mysqli_real_escape_string($conn, $data['username']);
$upassword= mysqli_real_escape_string($conn, trim($data['password']));
$type= mysqli_real_escape_string($conn, trim($data['usertype']));


$query = "select * from library.user where username = '".$uname."'";




if($result = $conn->query($query)){
    if($result-> num_rows > 0){//User already exists
        while($row = mysqli_fetch_assoc($result)){
        if($row != null){
            $user['id'] = "0";
            $user['username'] = $uname;
            $user['password'] = $upassword;
            $user['type'] = $type;
        }

        }

        echo json_encode($user);
    }
    else{//User does not exist
        $query = "Select id from library.user order by id desc limit 1"; // fetching the last id;
        if($result = $conn->query($query)){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
            }
           
        }
        $id++;
        
        
        $query = "Insert into library.user (id, username, password, type) values ({$id}, '{$uname}', '{$upassword}', '{$type}')";
        //$query = "Insert into library.user (id, username, password, type) values ( ".$id .", '" .$uname ."', '" .$upassword ."', '" .$type ."')";

        if($conn->query($query) === TRUE){
            
           /* $user['id'] = $id;
            $user['username'] = $uname;
            $user['password'] = $upassword;
            $user['type'] = $type;*/
            http_response_code(201);
            //echo json_encode($user);
        }
        else{
          //http_response_code(422);
          echo "Error: " . $query . "<br>" . $conn->error;
        }
        if(strcmp($type, 'student') == 0){
            $department= mysqli_real_escape_string($conn, trim($data['department']));
            $query = "Insert into library.student (name, student_id, department) values ('{$name}',{$id}, '{$department}')";
            $user['name'] = $name;
            $user['department'] = $department;
            $user['id'] = $id;
            $user['username'] = $uname;
            $user['password'] = $upassword;
            $user['type'] = $type;
            $user['address'] = "";
        }
        elseif(strcmp($type,"faculty") == 0){
            $department= mysqli_real_escape_string($conn, trim($data['department']));
            $query = "Insert into library.faculty (name, f_id, department) values ('{$name}',{$id}, '{$department}')";
            $user['name'] = $name;
            $user['department'] = $department;
            $user['id'] = $id;
            $user['username'] = $uname;
            $user['password'] = $upassword;
            $user['type'] = $type;
            $user['address'] = "";
        }
        elseif(strcmp($type, "supplier") == 0){
            $address= mysqli_real_escape_string($conn, trim($data['address']));
            $query = "Insert into library.supplier (name, s_id, address) values ('{$name}',{$id}, '{$address}')";
            $user['name'] = $name;
            $user['department'] = "";
            $user['id'] = $id;
            $user['username'] = $uname;
            $user['password'] = $upassword;
            $user['type'] = $type;
            $user['address'] = $address;
        }

        if($conn->query($query) === TRUE){

            
            echo json_encode($user);
        }
        else{
            //http_response_code(422);
            echo "Error: " . $query . "<br>" . $conn->error;
          }
    }
}


$conn->close();


?>