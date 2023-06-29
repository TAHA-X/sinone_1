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
   $error_message = "";
   $success_message = "";
   // get the pages related to this document
   $get_num_doc = $_GET["num_doc"];
   $pages = $conn->prepare("SELECT * from pages where num_doc='$get_num_doc'");
   $pages->execute();
   $pages = $pages->fetchAll();
   if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["num_doc"])){
        $get_num_doc = $_GET["num_doc"];
        $stmt = $conn->prepare("select * from documents where num_doc='$get_num_doc'");
        $stmt->execute();
        $row = $stmt->fetch();
        $num_doc = $row["num_doc"];
        $nom_doc = $row["nom_doc"];
        $mot_cle = $row['mot_cle'];
        $langue = $row["langue"];
        $domaine = $row["domaine"];
        $resume = $row['resume'];
     //    $nombre_page = $row['nombre_page'];
   }
   else{
        $num_doc = $_POST["num_doc"];
        $nom_doc = $_POST["nom_doc"];
        $mot_cle = $_POST["mot_cle"];
        $resume = $_POST["resume"];
        $langue = $_POST["langue"];
        $domaine = $_POST["domaine"];
     //    $nombre_page = $_POST["nombre_page"];
        if(empty($num_doc) || empty($nom_doc) || empty($mot_cle) || empty($resume) || empty($domaine) || empty($langue)){
            $error_message = "tous les champs sont obligatoires";
        }
        else{
            $stmt = $conn->prepare("UPDATE documents SET num_doc=?, nom_doc=?, mot_cle=?, resume=? ,domaine=?,langue=? WHERE num_doc=?");
            $stmt->execute([
                $num_doc,
                $nom_doc,
                $mot_cle,
                $resume,
                $domaine,
                $langue,
                $num_doc 
            ]);
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
        <h2>Modifier un document</h2>
         <a class="btn btn-primary mb-3" href="../../index.php">la page de liste</a>
   </div>

   <?php
 
      if(!empty($error_message)){
          echo "<div class='alert alert-danger'>".$error_message."</div>";
      }
      elseif(!empty($success_message)){
        echo "<div class='alert alert-success'>".$success_message."</div>";
        ?>
           <script>
                setTimeout(()=>{
                    window.location.href="../../index.php"
                },2000)
           </script>
        <?php
      }
   ?>

   <form method="post">
      <div class="d-flex gap-2">
      <input type="hidden" value="<?php echo $num_doc; ?>" name="num_doc" class="form-control">
           <div class="w-100">
                <label class="label">numéro :</label>
                <input disabled value="<?php echo $num_doc; ?>"  class="form-control">
           </div>
           <div class="w-100">
                <label class="label">nom :</label>
                <input value="<?php echo $nom_doc; ?>" name="nom_doc" class="form-control">
           </div>
           <!-- <div class="w-100">
                <label class="label">nombre de page :</label>
                <input value="<?php echo $nombre_page; ?>" name="nombre_page" class="form-control">
           </div> -->
      </div> 
      <div class="d-flex gap-2">
           <div class="w-100">
                <label class="label">langue :</label>
                <input type="text" name="langue"  value="<?php echo $langue; ?>" class="form-control">
           </div>
           <div class="w-100">
                <label class="label">domaine :</label>
                <input value="<?php echo $domaine; ?>" name="domaine" class="form-control">
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
              <button name="submit" type="submit" class="btn btn-success">modifier</button>
        </div>
   </form>

   <h3 class="mt-3 mb-3">Les pages de ce document</h3>
   <table id="table"  class="shadow rounded-lg">        <thead>
            <tr>
                <td>image</td>
                <td>num</td>
                <td>nom</td>
                <td>date</td>
                <td>actions</td>
            </tr>
        </thead>
        <tbody>
            <?php
                    foreach($pages AS $row){
                        // src='"imgs/.$row['num_img']."
                        echo "<tr>";
                            $img = $row["doc_img"];
                            $img = "../pages/imgs/".$row["doc_img"];
                            if($row["type"]=="video"){
                               $img = "../pages/imgs/videoLogo.png";
                            }
                            else if($row["type"]=="pdf"){
                               $img = "../pages/imgs/pdfLogo.png";
                            }

                           echo "<td><img style='width:120px; height:90px;' src='$img'/></td>";
                            // echo "<td><img style='width:100px; height:90px;' src='../pages/imgs/$img'/></td>";
                            echo "<td>".$row['num_img']."</td>";
                            echo "<td>".$row['nom_img']."</td>";
                            echo "<td>".$row['date_arch']."</td>";
                            echo "<td>";
                            ?>
                                <a href='../pages/edit.php?num_img=<?php echo $row['num_img'] ?>'><button class='btn btn-success m-2'><i class='bi bi-eye'></i> view</button></a>
                                <a onclick="retrun confirm('voulez vous vraiment supprimer cette page')" href='../pages/delete.php?num_img=<?php echo $row['num_img'] ?>' class='btn btn-danger m-2 confirmdeleat'><i class='bi bi-trash'></i>  delete</a>
                            <?php
                            echo  "</td>";
                        echo "</tr>";
                    }
            ?>
        </tbody> 
   </table>

 
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
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#table").DataTable();
            $("#trier").click(()=>{
                $("#trier-detaills").fadeIn();
                $("#trier").css("display","none");
            })
       
        
        })

   </script>

</body>

</html>