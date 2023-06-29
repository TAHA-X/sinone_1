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
    <link href="https://unpkg.com/tabulator-tables@5.5.0/dist/css/tabulator.min.css" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/tabulator-tables@5.5.0/dist/js/tabulator.min.js"></script>

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
                <a class="nav-link" href="../pages/index.php">
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
  // make the id of the new document
  $last_documents = $conn->prepare("select * from documents order by num_doc desc limit 1");
  $last_documents->execute();
  $last_documents = $last_documents->fetch();
  if(empty($last_documents)){
    $num_doc = 1;
  }
  else{
    $num_doc = $last_documents["num_doc"]+1;
  }
  
  $nom_doc = "";
  $mot_cle = "";
  $resume = "";
  $domaine = "";
  $langue = "";
//    $nombre_page = "";
  $error_message = "";
  $success_message = "";
  if(isset($_POST["submit"])){
       $nom_doc = $_POST["nom_doc"];
       $mot_cle = $_POST["mot_cle"];
       $resume = $_POST["resume"];
       $langue = $_POST["langue"];
       $domaine = $_POST["domaine"];
    
       if(empty($num_doc) || empty($nom_doc) || empty($mot_cle) || empty($resume) || empty($domaine) || empty($langue)){
           $error_message = "tous les champs sont obligatoires";
       }
       else{
           $stmt = $conn->prepare("INSERT into documents(num_doc,nom_doc,mot_cle,resume,langue,domaine) values('$num_doc','$nom_doc','$mot_cle','$resume','$langue','$domaine')");
           $stmt->execute();
           ?>
            <script>
                 window.location.href="../../index.php";
            </script>
        <?php       
        }
  }
 
  
?>


   <div class="container mt-3">

  <div class="d-flex justify-content-between">
     <h2>Ajouter un document</h2>
     <a class="btn btn-primary mb-3" href="../../index.php">la page de liste</a>
  </div>
  <?php
     if(!empty($error_message)){
         echo "<div class='alert alert-danger'>".$error_message."</div>";
     }
     elseif(!empty($success_message)){
       echo "<div class='alert alert-success'>".$success_message."</div>";
     }
  ?>
  <form method="post">
     <div class="d-flex gap-2">
          <div class="w-100">
               <label class="label">numéro :</label>
               <input type="number" disabled value="<?php echo $num_doc; ?>" class="form-control">
          </div>
          <div class="w-100">
               <label class="label">nom :</label>
               <input value="<?php echo $nom_doc; ?>" name="nom_doc" class="form-control">
          </div>
     </div> 
     <div class="d-flex gap-2">
          <div class="w-100">
               <label class="label">langue :</label>
               <input type="text" name="langue" value="<?php echo $langue; ?>" class="form-control">
          </div>
          <div class="w-100">
               <label class="label">domaine :</label>
               <input type="text" value="<?php echo $domaine; ?>" name="domaine" class="form-control">
          </div>
     </div> 
     <div class="w-100">
               <label class="label">mot clé :</label>
               <input value="<?php echo $mot_cle; ?>" name="mot_cle" class="form-control">
     </div>   
     <div class="w-100">
               <label class="label">résumé :</label>
               <textarea name="resume" class="form-control"><?php echo $resume; ?></textarea>
     </div>   
     <div class="mt-2">
             <button name="submit" type="submit" class="btn btn-success">add</button>
       </div>
  </form>

                      

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> -->
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
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>

</body>

</html>