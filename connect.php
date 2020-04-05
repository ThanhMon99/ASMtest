<?php
       
//$dbhost = "localhost";
//$dbport = 3306;
//$dbuser = "root";
//$dbpassword = "";
//$dbname = "asmtest";
//Connect to the DB
//$conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname, $dbport);
//if ($conn->connect_error) {
//    die ($conn->connect_error);
//}

    $conn = new PDO("mysql:host=localhost;dbname=asmtest",'root','');
    
?>