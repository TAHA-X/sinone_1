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
   // get all the documents
   $stmt = $conn->prepare("SELECT * from documents order by num_doc");
   $stmt->execute();
   $rows = $stmt->fetchAll();

  
   // get all the pages
   $pages = $conn->prepare("select * from pages");
   $pages->execute();
   $pages = $pages->fetchAll();
   // filtrer par date
   if(isset($_GET["filtrer_par_date"])){
        $stmt = $conn->prepare("SELECT * from documents ORDER BY num_doc ");
        $stmt->execute();
        $rows_date = $stmt->fetchAll();
   }
   // filtrer par nombre de pages
?>
 

    <div class="container mt-3">
    <div class="mb-3 d-flex gap-2">
        <a class="btn btn-primary" href="add.php">ajouter document</a>
        <div id="trier-detaills">
            <a href="../../index.php" class="btn btn-outline-dark">annuler</a>
            <a class="btn btn-secondary btn-sm" href="trier_totale.php">par totale de page</a>        </div>
    </div>
   <!-- <div class="d-flex m-2 gap-2">
       
   </div> -->
   
   <div class="d-flex justify-content-between">
            <h2>Trie par date</h2>
            <a class="btn btn-primary mb-3" href="../../index.php">la page de liste</a>
   </div>
   <table id="table"  class="rounded-lg">        <thead>
            <tr>
                <td>num</td>
                <td>nom</td>
                <td>pages</td>
                <td>date</td>
                <td>actions</td>
            </tr>
        </thead>
        <tbody>
        
            <?php
          
                    foreach($rows as $row){
                       
                        echo "<tr>";
                            echo "<td>".$row['num_doc']."</td>";
                            echo "<td>".$row['nom_doc']."</td>";
                            echo "<td>";
                                $i = 0;
                                foreach($pages as $page){
                                     if($page["num_doc"]==$row["num_doc"]){
                                          $i++;
                                     }
                                }
                                if($i==0){
                                  
                               
                                    echo  '<div class="badge bg-danger">0</div>';
                              
                                }
                                else{
                                    echo  '<div class="badge bg-success">'.$i.'</div>';
                            
                                }
                            echo "</td>";
                            echo "<td>".$row['date_arch']."</td>";
                            echo "<td>";
                            ?>
                                <a href='edit.php?num_doc=<?php echo $row['num_doc'] ?>'><button class='btn btn-success m-2'><i class='bi bi-eye'></i> view</button></a>
                                <a onclick="retrun confirm('voulez vous vraiment supprimer ce docment')" href='delete.php?num_doc=<?php echo $row['num_doc'] ?>' class='btn btn-danger m-2 confirmdeleat'><i class='bi bi-trash'></i>  delete</a>
                            <?php
                            echo  "</td>";
                        echo "</tr>";
                    }
            ?>
        </tbody> 
   </table>

 



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