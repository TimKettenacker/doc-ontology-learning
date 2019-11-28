<?php 
session_start(); 
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
     echo  '<strong>Incorrect verification code.</strong>'; 
} else { 
     // add form data processing code here 
     echo  '<strong>Verification successful.</strong>'; 
}; 
?>
<!-- #https://www.phpjabbers.com/captcha-image-verification-php19.html -->