<!DOCTYPE html>
<html lang="en">
<!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Documents</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div> -->
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GED</title>


    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.css" rel="stylesheet">

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <!-- <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div> -->
                <div class="sidebar-brand-text mx-3">GED</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

        
            <!-- Divider -->
            <hr class="sidebar-divider">
            <li class="nav-item">
            <a class="nav-link" href="../../index.php">
               <i style="font-size:16px;" class="bi bi-book"></i>
               <span>Documents</span></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="index.php">
            <i style="font-size:16px;" class="bi bi-file-earmark"></i>
               <span>Pages</span></a>
         </li>
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
          

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                 

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                <?php
                                 include "../../init.php";

   function isWindowsScannerInstalled() {
        $command = 'powershell.exe -Command "(New-Object -ComObject WIA.DeviceManager).Devices.Count"';
        $output = trim(shell_exec(1));
        return is_numeric($output) && $output > 0;
    }
   ?>


    <div class="container mt-3">
   <?php
     // les pages
     $stmt = $conn->prepare("select * from pages");
     $stmt->execute();
     $rows = $stmt->fetchAll();
     // les documents
     $stmt2 = $conn->prepare("select * from documents");
     $stmt2->execute();
     $documents = $stmt2->fetchAll();
     $scannerInstalled = isWindowsScannerInstalled(); // Vérifier si un scanner est installé et reconnu sur Windows

 
    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["num_img"])){
        $get_num_img = $_GET["num_img"];
        $stmt = $conn->prepare("select * from pages where num_img='$get_num_img'");
        $stmt->execute();
        $row = $stmt->fetch();
        $num_img = $row["num_img"];
        $nom_img = $row["nom_img"];
        $doc_img = $row['doc_img'];
        $num_doc = $row["num_doc"];
        $type = $row["type"];
   }
   else{
        $error_message = "";
        $success_message = "";

            $num_img = $_POST["num_img"];
            $nom_img = $_POST["nom_img"];
            // $doc_img = $_FILES['doc_img']['tmp_name'];
	        
            $num_doc = $_POST["num_doc"];
          
            if (empty($num_img) || empty($nom_img)) {
                $error_message = "tous les champs sont obligatoires";
            }
            else{
                if(!empty($_FILES["doc_img"]["name"])){  // l'utilisateur change l'image
                 
                    
                        $checkTheExtention = true;
                            $doc_img = $_FILES["doc_img"]["name"];
                            $type = "";
                            $fileType = $_FILES['doc_img']['type'];
                            if (strpos($fileType, 'image') !== false) {
                               $type = "img";
                            } else if (strpos($fileType, 'pdf') !== false) {
                               $type = "pdf";
                            } else if (strpos($fileType, 'video') !== false) {
                               $type = "video";
                            } else {
                                $checkTheExtention = false;
                       
                            }
                  

                         if($checkTheExtention){
                               // supprimer l'ancienne image
                            $ancienne_img = $conn->prepare("select doc_img from pages where num_img='$num_img'");
                            $ancienne_img->execute();
                            $ancienne_img = $ancienne_img->fetch();
                            unlink("imgs/".$ancienne_img["doc_img"]);
                        
                            $tmp = $_FILES['doc_img']['tmp_name'];
                            move_uploaded_file($tmp, 'imgs/'.$_FILES["doc_img"]["name"]);
                            $stmt = $conn->prepare("UPDATE pages SET num_img=?,nom_img=?,num_doc=?,doc_img=?,type=? WHERE num_img=?");
                            $stmt->execute([
                                $num_img,
                                $nom_img,
                                $num_doc,
                                $_FILES["doc_img"]["name"],
                                $type,
                                $num_img
                            ]);
                            
                            ?>
                            <script>
                                 window.location.href="index.php";
                            </script>
                        <?php 
                        }
                  
                        }  
                        
                 
                
                else{ // l'utilisateur ne change pas l'image
                    $stmt = $conn->prepare("UPDATE pages SET num_img=?,nom_img=?,num_doc=? WHERE num_img=?");
                    $stmt->execute([
                        $num_img,
                        $nom_img,
                        $num_doc,
                        $num_img 
                    ]);
                    ?>
            <script>
                 window.location.href="index.php";
            </script>
        <?php 
                }
  
                
                
            }
   }
  
  
   
?>
   
   <div class="d-flex justify-content-between">
            <h2>Modifier une page</h2>
            <a class="btn btn-primary mb-3" href="index.php">la page de liste</a>
   </div>

   <?php
       if(isset($checkTheExtention) && !$checkTheExtention){
        echo "<div class='alert alert-danger'>nous acceptons justement les pdf,images(jpg,jpeg,png,gif),et vidéos</div>";
    }
      if(!empty($error_message)){
          echo "<div class='alert alert-danger'>".$error_message."</div>";
      }
      elseif(!empty($success_message)){
        echo "<div class='alert alert-success'>".$success_message."</div>";
      }
      if ($scannerInstalled) {
        echo "<div class='alert alert-info'>Un scanner est installé et reconnu sur cette machine.</div>";
     }
   ?>
   <form enctype="multipart/form-data" method="post">
      <div class="d-flex gap-2">
           <div class="w-100">
                <label class="label">numéro :</label>
                <input type="hidden" value="<?php echo $num_img; ?>" name="num_img" class="form-control">
                <input disabled value="<?php echo $num_img; ?>"  class="form-control">
           </div>
           <div class="w-100">
                <label class="label">nom :</label>
                <input value="<?php echo $nom_img; ?>" name="nom_img" class="form-control">
           </div>
      </div>  
      <div class="w-100 m-2 d-flex gap-2">
         <?php
            if($type=="pdf"){
                $pathPDF = "imgs/".$doc_img;
                ?>  
                   <a download href='<?php echo $pathPDF ?>'><img style='width:250px; height:220px;' src='<?php echo "imgs/pdfLogo.png"; ?>'/></a> 
                <?php 
            }
            else if($type=="video"){
                $pathVideo = "imgs/".$doc_img;
      
                ?>
                       <video controls style='width:400px; height:220px;' src='<?php echo $pathVideo; ?>'></video>
                <?php
            }
            else{
                ?>
                  <img style='width:250px; height:220px;' src='<?php echo "imgs/".$doc_img; ?>'/>  
                <?php
            }
         ?>
                <div>
                    <label class="label">image :</label>
                    <?php if ($scannerInstalled) { ?>
                         <button type="button" class="btn btn-primary" onclick="scanImage()">Scanner</button>
                    <?php } ?>
                    <input type="file"  style="<?php echo $scannerInstalled ? 'display: none;' : ''; ?>" id="doc_img_input" name="doc_img" class="form-control">
                </div>
           </div>
      <div class="w-100">
                <label class="label">document :</label>
                <select name="num_doc" class="form-control">
                    <?php 
                        foreach($documents as $document){
                            ?>
                                 <option  <?php if($document["num_doc"]==$num_doc){echo "selected";} ?> value="<?php echo $document["num_doc"] ?>"><?php echo $document["nom_doc"] ?></option>
                            <?php
                        }
                    ?>
                </select>
      </div> 
      <div id="div_scann" style="display:none;" class="mt-2">
          <input id="scanner" name="scanner" type="checkbox" /> <label for="scanner">voulez vous scanner l'image ?</label>
      </div>    
      <div class="mt-2">
              <button name="submit" type="submit" class="btn btn-success">modifier</button>
        </div>
   </form>

                </div>


    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>


        <script>
      function scanImage() {
         document.getElementById("doc_img_input").click();
      }
   </script>

</body>

</html>