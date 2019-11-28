<?php


$conn = mysqli_connect("localhost", "root", "", "news event extraction");
// require('connection.php');
$id=$_GET['id'];
// $Goal_Test=$_GET['Goal_Test'];
error_reporting(0);
// echo("i am here");
$query="SELECT Important,Goal_Test,argtext,event_id From events_annotation Where event_id=$id AND Goal_Test='important'";
$userData=mysqli_query($conn, $query);
// $userData = mysqli_query($conn,$sql);
// // echo $userData;
$response = array();
// $Goal=array();
// // echo $response;
while($row = mysqli_fetch_assoc($userData)){

   $response[]=$row;
   // echo $response[];
   
}

echo json_encode($response); 
$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
// // echo "\n Data is here";
// // echo $response[];
// echo var_dump(json_decode($response, true));

  

?>