<?php

$conn = mysqli_connect("localhost", "root", "", "news event extraction");
require('connection.php');
error_reporting(0);
echo("i am here");
//$form=$_POST['myForm'];
$importance=$_POST['check'];
$id=$_POST['id'];
$text=$_POST['text'];
//$text=$_POST['text'];

//$text=$_POST['text'];
echo $importance;
//$text=$_POST['text'];
//echo $_POST['importance'];

//$query="UPDATE 'newstable' SET 'Important' ='$importance', 'Text' = '$text' WHERE id = 1 order by id desc limit 1";
$query="UPDATE events_annotation SET Goal_Test ='$importance' WHERE event_annotation_id = '$id'";

mysqli_query($conn, $query);
    


  

?>