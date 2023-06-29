<?php
   $dsn = "mysql:host=localhost;dbname=sinone";
   $username = "root";
   $password = "";
   $options = array(
       PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
   );
   try {
    $conn = new PDO($dsn,$username,$password,$options);
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
   }
   catch(PDOException $e){
         echo "failed to connect".$e->getMessage();
   }