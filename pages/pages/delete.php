<?php
   include "../../init.php";
   include "../../".$header;
   $error_message = "";
   $success_message = "";
   if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["num_img"])){
        $get_num_img = $_GET["num_img"];
        // remove the img
             $page = $conn->prepare("select * from pages where num_img='$get_num_img'");
             $page->execute();
             $page = $page->fetch();
             unlink("imgs/".$page["doc_img"]);
        // remove the page
        $stmt = $conn->prepare("delete from pages where num_img='$get_num_img'");
        $stmt->execute();
        header("location:index.php");
        exit;
     
   }
 
  
   
?>