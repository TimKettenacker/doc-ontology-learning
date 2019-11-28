<?php

$conn = mysqli_connect("localhost", "root", "", "news event extraction");
require('connection.php');
error_reporting(0);
echo("i am here");
//$form=$_POST['myForm'];
$relphrase=$_POST['relphrase'];
$eventid=$_POST['eventid'];
$anno=$_POST['annotatorid'];
// $text=$_POST['text'];
//$text=$_POST['text'];

//$text=$_POST['text'];
echo $relphrase,$eventid,$anno;
// $query="INSERT INTO `events_rel_phrases`(`event_id`, `Relation Phrase`,`annotator_ID`) VALUES ($eventid,$relphrase,$anno)";
$query="INSERT INTO `events_rel_phrases`(`event_id`, `Relation Phrase`,`annotator_ID`) VALUES ('$eventid','$relphrase',1)";

mysqli_query($conn, $query);
    


  

?>