<?php
   include "../../init.php";
   include "../../".$header;
   $error_message = "";
   $success_message = "";
   if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["num_doc"])){
        $get_num_doc = $_GET["num_doc"];
        $pages = $conn->prepare("select * from pages where num_doc='$get_num_doc'");
        $pages->execute();
        $pages = $pages->fetchAll();
        foreach($pages as $page){
            $num_img = $page["num_img"];
            $stmt = $conn->prepare("DELETE from pages where num_img='$num_img'");
            $stmt->execute();
        }
        $stmt = $conn->prepare("delete from documents where num_doc='$get_num_doc'");
        $stmt->execute();
        header("location:../../index.php");
        exit;
   }
 
  
   
?>