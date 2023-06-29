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
                    <h3 class="m-2">Sinone</h3>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                <?php
include "../../init.php";
function isWindowsScannerInstalled() {
   $command = 'powershell.exe -Command "(New-Object -ComObject WIA.DeviceManager).Devices.Count"';
  //  $output = shell_exec($command);
   $output=1;
   return is_numeric($output) && $output > 0;
}

?>



<div class="container mt-3">
   <?php
   // make the id of the new page
   $last_pages = $conn->prepare("select * from pages order by num_img desc limit 1");
   $last_pages->execute();
   $last_pages = $last_pages->fetch();
   if (empty($last_pages)) {
      $num_img = 1;
   } else {
      $num_img = $last_pages["num_img"] + 1;
   }
   // les pages
   $stmt = $conn->prepare("select * from pages");
   $stmt->execute();
   $rows = $stmt->fetchAll();
   // les documents
   $stmt2 = $conn->prepare("select * from documents");
   $stmt2->execute();
   $documents = $stmt2->fetchAll();
   $nom_img = "";
   $doc_img = "";
   $error_message = "";
   $success_message = "";
   $scannerInstalled = isWindowsScannerInstalled(); // Vérifier si un scanner est installé et reconnu sur Windows

   if (isset($_POST["submit"])) {
      $nom_img = $_POST["nom_img"];
      if(!$scannerInstalled){
         $doc_img = $_FILES["doc_img"]["name"];
      }
      else{
         $doc_img = $_POST["doc_img"].".pdf";
         $type = "pdf";
      }
      
      $num_doc = $_POST["num_doc"];

      if (empty($num_img) || empty($nom_img)) {
         $error_message = "Tous les champs sont obligatoires";
      } else {
         // vérifier le type de file inséré par l'utilisateur(pdf,image,video)
         $checkTheExtention = true;
         if(!$scannerInstalled){
                  $type = "";
                  
                  $fileType = $_FILES['doc_img']['type'];
                  
            
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
         }

                  if($checkTheExtention){
                     $stmt = $conn->prepare("insert into pages(num_img,doc_img,nom_img,num_doc,type)
                     values('$num_img','$doc_img','$nom_img','$num_doc','$type')");
                     $stmt->execute();
                     if(!$scannerInstalled){
                        $tmp = $_FILES['doc_img']['tmp_name'];
                        move_uploaded_file($tmp, 'imgs/'.$_FILES["doc_img"]["name"]);
                     }
                  
                     $document = $conn->prepare("UPDATE document set num_doc++ where num_doc='$num_doc'");
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
      <h2>Ajouter une page</h2>
      <a class="btn btn-primary mb-3" href="index.php">la page de liste</a>
   </div>

   <?php
      if(isset($checkTheExtention) && !$checkTheExtention){
         echo "<div class='alert alert-danger'>nous acceptons justement les pdf,images(jpg,jpeg,png,gif),et vidéos</div>";
     }
   if (!empty($error_message)) {
      echo "<div class='alert alert-danger'>" . $error_message . "</div>";
   } elseif (!empty($success_message)) {
      echo "<div class='alert alert-success'>" . $success_message . "</div>";
   }

   if ($scannerInstalled) {
      echo "<div class='alert alert-info'>Un scanner est installé et reconnu sur cette machine.</div>";

   }
   
   ?>
    <?php if ($scannerInstalled) { ?>
      <!-- <form method="GET"> -->
        <button  onclick="AcquireImage();" class="btn btn-primary" >Scanner</button>
        <!-- Add a button -->
<input type="button" value="Upload" onclick="UploadAsPDF();" />
<div id="dwtcontrolContainer"></div>

      <!-- </form> -->
    <?php } ?>
    
   <form id="form" enctype="multipart/form-data" method="post">
      <div class="d-flex gap-2">
         <div class="w-100">
            <label class="label">numéro :</label>
            <input disabled value="<?php echo $num_img; ?>" name="num_img" class="form-control">
         </div>
         <div class="w-100">
            <label class="label">nom :</label>
            <input value="<?php echo $nom_img; ?>" name="nom_img" class="form-control">
         </div>
         <?php if (!$scannerInstalled) {
              ?>
                      <div class="w-100">
                           <label class="label">image :</label>
                           <input type="file" id="doc_img" name="doc_img" class="form-control">
                          <?php echo $scannerInstalled ? 'display: none;' : ''; ?>"> 
                        </div>
              <?php
         } ?>
       
      </div>
      <div class="w-100">
         <label class="label">document :</label>
         <select name="num_doc" class="form-control">
            <?php
            foreach ($documents as $document) {
               ?>
               <option value="<?php echo $document["num_doc"] ?>"><?php echo $document["nom_doc"] ?></option>
            <?php
            }
            ?>
         </select>
      </div>
      <div class="mt-2">
         <button name="submit" type="submit" class="btn btn-success">Ajouter</button>
      </div>
   </form>

 

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
          
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->

    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>$
    <!--twain-->
    <script src="Resources/dynamsoft.webtwain.initiate.js"></script>
    <script src="Resources/dynamsoft.webtwain.config.js"></script>
   
    <script type="text/javascript">
        var DWObject;

        function Dynamsoft_OnReady() {
            DWObject = Dynamsoft.DWT.GetWebTwain("dwtcontrolContainer");
        }

        function AcquireImage() {
   if (DWObject) {
     DWObject.SelectSourceAsync()
      .then(function() {
        return DWObject.AcquireImageAsync({
          IfDisableSourceAfterAcquire: true,
        });
      })
      .then(function(result) {
        if (result && result.length > 0 && result[0].metaDataURL) {
          // Récupérer l'URL de l'image scannée
          // var imageUrl = result[0].metaDataURL;
       
          // Utiliser l'URL pour télécharger l'image
    
      //    uploadScannedImage();
        } else {
          console.error("L'image scannée n'est pas disponible ou n'a pas d'URL.");
          
        }
        UploadAsPDF()
      })
      .catch(function(exp) {
        console.error(exp.message);
      })
      .finally(function() {
        DWObject.CloseSourceAsync().catch(function(e) {
          console.error(e);
        });
      });
  }
}



// Encrypt and display the current date
function encryptDate() {
  const currentDate = new Date();
  const day = currentDate.getDate().toString().padStart(2, '0');
  const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
  const year = currentDate.getFullYear().toString();
  const randomString = generateRandomString(10); // Generate a random string of 10 characters

  return day + month + year + randomString;
}

function generateRandomString(length) {
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  let randomString = '';

  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    randomString += characters[randomIndex];
  }

  return randomString;
}


      
function UploadAsPDF() {
            var url = Dynamsoft.Lib.detect.ssl ? "https://" : "http://";
            url += location.hostname;
            var path = location.pathname.substring(0, location.pathname.lastIndexOf("/") + 1);
            url += location.port === "" ? path : ":" + location.port + path;
            url += "saveUploadedPDF.php";
            var indices = [];
            if (DWObject) {
                if (DWObject.HowManyImagesInBuffer === 0) {
                    console.log("There is no image to upload!");
                    return;
                }
                // DWObject.SelectAllImages();
                var nameFile = encryptDate();
                var inputFile = document.createElement('input');
               inputFile.type = 'text';
               inputFile.name = "doc_img";
               inputFile.value = nameFile;
               inputFile.style.display="none";
               document.getElementById("form").appendChild(inputFile)
                indices = DWObject.SelectedImagesIndices;
                DWObject.HTTPUpload(
                    url,
                    indices,
                    Dynamsoft.DWT.EnumDWT_ImageType.IT_PDF,
                    Dynamsoft.DWT.EnumDWT_UploadDataFormat.Binary,
                    nameFile,
                    function() {
                        //The server response is empty!
                        console.log("Successfully uploaded!")
                    },
                    function(errCode, errString, response) {
                        console.log(errString);
                    }
                );
            }
        }
    </script>

</body>

</html>