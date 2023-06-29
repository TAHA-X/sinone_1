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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

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
                <a class="nav-link" href="index.php">
                <i style="font-size:16px;" class="bi bi-book"></i>
                    <span>Documents</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pages/pages/index.php">
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
                  include "init.php";
   // get all the documents
   $stmt = $conn->prepare("SELECT * from documents");
   $stmt->execute();
   $rows = $stmt->fetchAll();


  
   // get all the pages
   $pages = $conn->prepare("select * from pages");
   $pages->execute();
   $pages = $pages->fetchAll();
   // trier les donnes par(mot_clé_domain,langue)
   if(isset($_POST["search_mot_cle"])){
        $input = "%".$_POST["mot_cle_input"]."%";
        $stmt = $conn->prepare("SELECT * from documents where mot_cle like ?");
        $stmt->execute([$input]);
        $rows = $stmt->fetchAll();
   }
    if(isset($_POST["search_domaine"])){
        $input = "%".$_POST["domaine_input"]."%";
        $stmt = $conn->prepare("SELECT * from documents where domaine like ?");
        $stmt->execute([$input]);
        $rows = $stmt->fetchAll();
    }
    if(isset($_POST["search_langue"])){
        $input = "%".$_POST["langue_input"]."%";
        $stmt = $conn->prepare("SELECT * from documents where langue like ?");
        $stmt->execute([$input]);
        $rows = $stmt->fetchAll();
    }
   // filtrer par nombre de pages

   if(isset($_POST["fill"])){
        for($i=1;$i<101;$i++){
            $num_doc = $i;
            $names = ["Certificat de maladie","Attestation de travail","Contrat de travail"];
            $number = rand(0,2);
            $nom_doc= $names[$number];
            $names = ["Certificat","Attestation","Contrat"];

            $mot_cle = $names[$number];
          
            $resume = ["Le certificat de maladie est un document délivré par un professionnel de la santé (médecin, médecin généraliste, spécialiste, etc.) qui atteste de l état de santé dune personne. Il s agit d un certificat médical qui est généralement requis dans diverses situations administratives, professionnelles ou légales.", 
                "L attestation de travail est un document émis par lemployeur pour attester de lemploi dune personne au sein de l entreprise. Ce document est généralement demandé dans diverses situations administratives, juridiques ou professionnelles.",
                "Un contrat est un accord légal entre deux parties ou plus qui établit des droits et des obligations mutuelles. Il s agit dun document écrit qui formalise les termes et les conditions auxquels les parties se sont engagées."
            ];
            $resume=$resume[$number];
            $langue = ["anglais","francais","arabe"];
            $langue=$langue[$number];
            $domaine=["certificat","service","contrat"];
            $domaine=$domaine[$number];
            $stmt = $conn->prepare("INSERT into documents(num_doc,nom_doc,mot_cle,resume,langue,domaine) values('$num_doc','$nom_doc','$mot_cle','$resume','$langue','$domaine')");
            $stmt->execute();
        }
   }
   if(isset($_POST["fillPages"])){
        $stmt = $conn->prepare("SELECT * from documents");
        $stmt->execute();
        $documents= $stmt->fetchAll();      
        foreach($documents as $document){
            if($document["domaine"]=="certificat"){
                for($i=1;$i<=3;$i++){
                    $stmt = $conn->prepare("SELECT * from pages");
                    $stmt->execute();
                    $pages= $stmt->fetchAll();
                    if(count($pages) == 0){
                        $num_img =1;
                        echo "empty";
                    }
                    else{
                        $num_img = $pages[count($pages)-1]["num_img"]+1;
                        echo $num_img;
                    }
                    
                    $doc_img="certificatMaladie.jpg";
                    $names=["amine","yassine","taha","ahmed","monir","mouad","othman"];
                    $nom_img="certificat de maladie mr ".$names[rand(0,6)];
                    $num_doc=$document["num_doc"];
                    $type="img";
                    $stmt = $conn->prepare("insert into pages(num_img,doc_img,nom_img,num_doc,type)
                    values('$num_img','$doc_img','$nom_img','$num_doc','$type')");
                    $stmt->execute();
                }
            }
            elseif($document["domaine"]=="contrat"){
                for($i=1;$i<=3;$i++){
                    $stmt = $conn->prepare("SELECT * from pages");
                    $stmt->execute();
                    $pages= $stmt->fetchAll();
                    if(count($pages) == 0){
                        $num_img = 1;
                        echo "empty";
                    }
                    else{
                        $num_img = $pages[count($pages)-1]["num_img"]+1;
                        echo $num_img;
                    }
                    $doc_img="contrat.pdf";
                    $names=["amine","yassine","taha","ahmed","monir","mouad","othman"];
                    $nom_img="contrat de mr ".$names[rand(0,6)];
                    $num_doc=$document["num_doc"];
                    $type="pdf";
                    $stmt = $conn->prepare("insert into pages(num_img,doc_img,nom_img,num_doc,type)
                    values('$num_img','$doc_img','$nom_img','$num_doc','$type')");
                    $stmt->execute();
                }
            }  
        }
    }
  
?>
 

    <div class="container mt-3">
    <?php
   
        if(isset($input)){
            ?>
             <a href="index.php" class="btn btn-outline-dark">annuler le filter</a>
            <?php
        }
        else{
            ?>
            <!-- <form method="post">
                <button name="fill" type="submit">fill documents</button>
            </form>
            <form method="post">
                <button name="fillPages" type="submit">fill pages</button>
            </form> -->
                <div class="mb-3 d-flex gap-2">
                        <a class="btn btn-primary" href="pages/documents/add.php">ajouter document</a>
                        <button id="trier" class="btn btn-outline-dark">trier</button>
                        <div id="trier-detaills" style="display:none;">
                            <a href="index.php" class="btn btn-outline-dark">annuler</a>
                            <!-- <form style="display:inline-block;" method="GET">
                            <button type="submit" name="filtrer_par_date" class="btn btn-secondary btn-sm" href="#">par date</button>
                            </form> -->
                            <a class="btn btn-secondary btn-sm" href="pages/documents/trier_date.php">par date</a>
                            <a class="btn btn-secondary btn-sm" href="pages/documents/trier_totale.php">par totale de page</a>
                        </div>
                </div>
            <?php
        }
    ?>
   
   <!-- <div class="d-flex m-2 gap-2">
       
   </div> -->
   <!-- <h2>affichage des documents</h2> -->
   <div class="d-flex gap-2">
        <form method="POST" class="m-2 w-100 mb-4 gap-2 d-flex">
                <input name="mot_cle_input" placeholder="chercher par les mot clé" class="form-control" />
                <button name="search_mot_cle" class="btn btn-dark" type="submit">search</button>
        </form>
        <form method="POST" class="m-2 w-100 mb-4 gap-2 d-flex">
                <input name="domaine_input" placeholder="chercher par le domaine" class="form-control" />
                <button name="search_domaine" class="btn btn-dark" type="submit">search</button>
        </form>
        <form method="POST" class="m-2 w-100 mb-4 gap-2 d-flex">
                <input name="langue_input" placeholder="chercher par la langue" class="form-control" />
                <button name="search_langue" class="btn btn-dark" type="submit">search</button>
        </form>
   </div>
  

   <table id="table"  class="rounded-lg">
        <thead>
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
                                <a href='pages/documents/edit.php?num_doc=<?php echo $row['num_doc'] ?>'><button class='btn btn-success m-2'><i class='bi bi-eye'></i> view</button></a>
                                <a onclick="return confirm('You want to delete this?');" href='pages/documents/delete.php?num_doc=<?php echo $row['num_doc'] ?>' class='btn btn-danger m-2 confirmdeleat'><i class='bi bi-trash'></i>  delete</a>
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

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