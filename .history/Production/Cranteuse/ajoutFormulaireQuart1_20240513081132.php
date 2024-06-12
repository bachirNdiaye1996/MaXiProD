<?php
    
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";


    //Variables
    // Il faut savoir que metal3 est remplacer par niambour
    $valideExportation="";
    $ProblemeNbBobineDepart="";
    $Iddepart=null;                       // Variable qui nous permet d'optenir l'Id de la matiere de départ
    $idcranteuseq1 = $_GET['idcranteuseq1'];  // On recupére l'ID exportation par get
    $quart = $_GET['quart'];


    //Insertion des réceptions
    if(isset($_POST['CreerExportation'])){

        $idexportation=htmlspecialchars($_POST['idexportation']);
        $saisisseur=htmlspecialchars( $_POST['saisisseur']);
        $dateexportation=htmlspecialchars( $_POST['dateexportation']);
        $transporteur=htmlspecialchars( $_POST['transporteur']);
        $commentaire=htmlspecialchars($_POST['commentaire']);

        if(!empty($_POST['saisisseur'])){
        
            $sql = "UPDATE `exportation` SET `dateexportation` = '$dateexportation', `transporteur` = '$transporteur', `commentaire` = '$commentaire', `saisisseur` = '$saisisseur' WHERE `idexportation` = ?;";
            //$result = $db->query($sql);
            $sth = $db->prepare($sql);    
            $sth->execute(array($idexportation));


            for ($i = 0; $i < count($_POST['epaisseur']); $i++){
                if(!empty($_POST['epaisseur'][$i])){
                    //var_dump($_POST);
                    $epaisseur=htmlspecialchars( $_POST['epaisseur'][$i]);
                    //$largeur=htmlspecialchars($_POST['largeur']);
                    $etatbobine=htmlspecialchars($_POST['etatbobine'][$i]);
                    //$user=htmlspecialchars($_POST['user'][$i]);
                    $poidsdeclare=htmlspecialchars($_POST['poidsdeclare'][$i]);
                    $poidspese=htmlspecialchars($_POST['poidspese'][$i]);
                    $pointdepart=htmlspecialchars($_POST['pointdepart'][$i]);
                    $pointarrive=htmlspecialchars($_POST['pointarrive'][$i]);
                    $nbbobine=htmlspecialchars($_POST['nbbobine'][$i]);

                    //** On vérifie si le nombre est exact
                        $idepais = 0;
                        /*
                            1 -> Metal1
                            3 -> Niambour
                            4 -> Cranteuse
                            5 -> Tréfilage
                            6 -> Metal Mbao
                        */

                        //Rechercher le nombre de piéces sur le lieu de depart
                            $sqlEpaisseur = "SELECT * FROM `matiere` where `lieutransfert`='$pointdepart' and `epaisseur`='$epaisseur' and `nbbobineactuel` != 0 and `nbbobineactuel`>=$nbbobine LIMIT 1;";
                            // On prépare la requête
                            $queryEpaisseur = $db->prepare($sqlEpaisseur);

                            // On exécute
                            $queryEpaisseur->execute();

                            // On récupère le nombre d'articles
                            $resultEpaisseur = $queryEpaisseur->fetch();

                            if($resultEpaisseur){
                                $Iddepart = $resultEpaisseur['idmatiere'];
                            }
                        //Fin Rechercher le nombre de piéces 

                        if($resultEpaisseur){
                            // Enlever le nombre de bobine dans le lieu de depart
                                $req ="UPDATE matiere SET `nbbobineactuel` = `nbbobineactuel` - ? where `idmatiere`='$resultEpaisseur[idmatiere]';";
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine));
                            // Fin enlever le nombre de bobine dans le lieu de depart
                            
                            // Récuperer le dernier id de la matiére
                                $sqlEpaisseur = "SELECT MAX( idmatiere )  AS idMax FROM `matiere`";
                                // On prépare la requête
                                $queryEpaisseur = $db->prepare($sqlEpaisseur);
                                $queryEpaisseur->execute();
                                $resultEpaisseur = $queryEpaisseur->fetch();
                                $idMax = (int) $resultEpaisseur['idMax'];
                            // Fin

                            //Depart epaisseur
                                $sqlEpaisseur = "SELECT `$epaisseur` AS epaisseurVeriDepart FROM `epaisseur` where `lieu`='$pointdepart';";
                                // On prépare la requête
                                $queryEpaisseur = $db->prepare($sqlEpaisseur);

                                // On exécute
                                $queryEpaisseur->execute();

                                // On récupère le nombre d'articles
                                $resultEpaisseur = $queryEpaisseur->fetch();

                                $nbEpaisseurDepart = (int) $resultEpaisseur['epaisseurVeriDepart'];
                            //Fin Depart epaisseur

                            //if(($nbEpaisseurDepart < $nbbobine) || ($nbbobine == 0)){
                            //    $valideTransfert="erreurEpaisseur";
                                /*echo"<script language=\"javascript\">";
                                    echo"alert('bonjour')";
                                    echo"return false";
                                echo"</script>";*/
                            //}else{
                                //if(($pointdepart == "Cranteuse vers Metal1")){ // Vérifie le type de transfert
                                    //Debut inserer le nombre de bobine par epaisseur
                                $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` - ? where `lieu`='$pointdepart';";
                                //$db->query($req); 
                                $reqtitre = $db->prepare($req);
                                $reqtitre->execute(array($nbbobine));

                                $insertUser=$db->prepare("INSERT INTO `exportationdetails` (`idexportationdetail`, `poidspese`, `dateajout`, `user`, `nbbobine`, `actif`, `pointdepart`, `idexportation`, `epaisseur`, `etatbobine`, `poidsdeclare`, `commentaire`, `pointarrive`,`idmatieredepart`,`idmatierearrive`)
                                VALUES (NULL, ?, current_timestamp(), NULL, ?, '1', ?, ?, ?, ?, ?, ?, ?, ?, ?);");
                                $insertUser->execute(array($poidspese,$nbbobine,$pointdepart,$idexportation,$epaisseur,$etatbobine,$poidsdeclare,$commentaire,$pointarrive,$Iddepart,$idMax));
                            //}
                        }else{
                            $ProblemeNbBobineDepart="erreurProblemeNbDepart";
                        }

                        //** Fin verification


                    /*if($nbbobine == 0){
                        $valideTransfert="erreurEpaisseur";
                    }else{
                        $insertUser=$db->prepare("INSERT INTO `transfertdetails` (`idtransfertdetail`, `poidspese`, `dateajout`, `user`, `nbbobine`, `actif`, `pointdepart`, `idtransfert`, `epaisseur`, `etatbobine`, `poidsdeclare`, `commentaire`, `pointarrive`)
                        VALUES (NULL, ?, current_timestamp(), NULL, ?, '1', ?, ?, ?, ?, ?, ?, ?);");
                        $insertUser->execute(array($poidspese,$nbbobine,$pointdepart,$idtransfert,$epaisseur,$etatbobine,$poidsdeclare,$commentaire,$pointarrive));

                        //Inserer dans la reception pour que pont bascule puisse modifier
                        $insertUser=$db->prepare("INSERT INTO `matiere` (`idmatiere`, `epaisseur`, `poidsdeclare`, `dateajout`, `nbbobine`, `idreception`) 
                        VALUES (NULL, ?, ?, current_timestamp(), ?, ?);");
                        $insertUser->execute(array($epaisseur,$poidsdeclare,$nbbobine,$idreception));
                    }*/

                    // Pour éliminer les post une fois ajouté

                }else{
                    //$valideTransfert="erreurInsertion";
                }
            }

            // Ajouter le nombre d'epaisseur 
                /*if(isset($_GET['idreception'])){
                    $id = $_GET['idreception'];
                    
                    //** Debut select des receptions
                        $sql = "SELECT * FROM `matiere` where `actif`=1 and idreception=$id;";
            
                        // On prépare la requête
                        $query = $db->prepare($sql);
            
                        // On exécute
                        $query->execute();
            
                        // On récupère les valeurs dans un tableau associatif
                        $Reception = $query->fetchAll();
                    //** Fin select des receptions
            
                        
                    foreach ($Reception as $key => $value) {
                        $epaisseur = $value['epaisseur'];
                        $nbbobine = $value['nbbobine'];
                        $lieutransfert = $value['lieutransfert'];
                        if(($lieutransfert == "Metal1")){ // Vérifie le type de transfert
                            //Debut inserer le nombre de bobine par epaisseur
                            $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=1;";  //Metal 1
                            //$db->query($req); 
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($nbbobine));
                            //Fin inserer le nombre de bobine par epaisseur
                        }elseif(($lieutransfert == "Niambour")){
                            //Debut inserer le nombre de bobine par epaisseur
                            $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=3;";  // Metal 3 dit Niambour
                            //$db->query($req); 
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($nbbobine));
                            //Fin inserer le nombre de bobine par epaisseur
                        }
                        elseif(($lieutransfert == "Metal Mbao")){
                            //Debut inserer le nombre de bobine par epaisseur
                            $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=6;";  // Metal Mbao dit Niambour
                            //$db->query($req); 
                            $reqtitre = $db->prepare($req);
                            $reqtitre->execute(array($nbbobine));
                            //Fin inserer le nombre de bobine par epaisseur
                        }
                    }
            
                    header('location: reception.php');
                    exit;
                }
            // Fin ajouter le nombre d'epaisseur */

            if($ProblemeNbBobineDepart != "erreurProblemeNbDepart"){
                header("location: detailExportation.php?idexportation=$idexportation");
                exit;
            }
        }else{
            //$valideTransfert="erreurInsertion";
        }

    }

    // Pour insertion details reception
        /*if(isset($_POST['CreerReception'])){
            if(!empty($_POST['referenceusine']) && !empty($_POST['epaisseur'])  && !empty($_POST['lieutransfert'])  && !empty($_POST['poidsdeclare'])){
                $referenceusine=htmlspecialchars($_POST['referenceusine']);
                $epaisseur=htmlspecialchars($_POST['epaisseur']);
                //$largeur=htmlspecialchars($_POST['largeur']);
                $lieutransfert=htmlspecialchars($_POST['lieutransfert']);
                $commentaire=htmlspecialchars($_POST['commentaire']);
                $user=htmlspecialchars($_POST['user']);
                $poidsdeclare=htmlspecialchars($_POST['poidsdeclare']);
                //$poidspese=htmlspecialchars($_POST['poidspese']);
                //$idLot=htmlspecialchars($_POST['idLot']);
                $idbobine=htmlspecialchars($_POST['idbobine']);
                //$idreception=htmlspecialchars($_POST['idreception']);
                $nbbobine=htmlspecialchars($_POST['nbbobine']);

                if($nbbobine == 0){
                    $valideTransfert="erreurEpaisseur";
                }else{
                    $insertUser=$db->prepare("INSERT INTO `matiere` (`idmatiere`, `referenceusine`, `epaisseur`, `largeur`, `poidsdeclare`, `laminage`, `poidspese`, `produitfini`,
                    `travaille`, `idlot`, `annee`, `numprod`, `dateajout`, `idbobine`,`user`,`nbbobine`,`commentaire`,`lieutransfert`, `idreception`) VALUES (NULL, ?, ?, '', ?, '', '', '', '', '', '', '', current_timestamp(), '1',?,?,?,?,?);");
                $insertUser->execute(array($referenceusine,$epaisseur,$poidsdeclare,$user,$nbbobine,$commentaire,$lieutransfert,$idreception));

                header("location: detailsReception.php?idreception=$idreception");
                exit;
                }
                
            }else{
                $valideTransfert="erreurInsertion";
            }
        }*/
    //Fin insertion details reception

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="../image/iconOnglet.png" />
    <title>METAL AFRIQUE</title>

    <!-- Custom fonts for this template -->
    <link href="../../indexPage/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="../../libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
    <script src="../../libs/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../libs/sweetalert2/jquery-1.12.4.js"></script>

    <!-- Custom styles for this template -->
    <link href="../../indexPage/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../indexPage/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script>
        $(document).ready(() => { 
            // Removing Row on click to Remove button
            $('#dynamicadd').on('click', '.remove', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });
        })
    </script>

    <script type="text/javascript"> 
        $(document).ready(function(){  
            var i = 1;         
            $('#add').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicadd').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine" value="">
                                <option>3</option>
                                <option>3.5</option>
                                <option>4</option>
                                <option>4.5</option>
                                <option>5</option>
                                <option>5.5</option>
                                <option>6</option>
                                <option>6.5</option>
                                <option>7</option>
                                <option>7.5</option>
                                <option>8</option>
                                <option>8.5</option>
                                <option>9</option>
                                <option>9.5</option>
                                <option>10</option>
                                <option>10.5</option>
                                <option>11</option>
                                <option>11.5</option>
                                <option>12</option>
                                <option>12.5</option>
                                <option>13</option>
                                <option>13.5</option>
                                <option>14</option>
                                <option>14.5</option>
                                <option>15</option>
                                <option>15.5</option>
                                <option>16</option>
                                <option>16.5</option>
                                <option>17</option>
                            </select> 
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" type="number" name="nbbobine[]" value="" id="validationDefault0<?$i+9?>" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poidspese[]">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poidsdeclare[]" id="validationDefault0<?$i+11?>" id="exam" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="pointdepart[]">
                                <option>Metal1</option>
                                <option>Niambour</option>
                                <option>Tréfilage</option>
                                <option>Cranteuse</option>
                                <option>Metal Mbao</option>
                            </select>                                                
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="pointarrive[]">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="etatbobine[]" value="">
                                <option>Normale</option>
                                <option>Disloquée</option>
                                <option>Autres</option>
                            </select>                                                  
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger remove"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});
            $(document).on('click','.remove_row',function(){ 
            var row_id = $(this).attr("id");          
            $('#row'+row_id+'').remove();});});      
    </script> 

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">


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



                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid" style="margin-bottom: 200px;">
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Modale pour ajouter reception -->
                        <div class="col-lg-12 ">
                            <div class="modal-dialog-centered">
                                <div class="modal-content col-lg-12">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myExtraLargeModalLabel">Ajouter une fiche de production cranteuse</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <div class="row">
                                                <?php if($valideExportation != "erreurEpaisseur" && $ProblemeNbBobineDepart != "erreurProblemeNbDepart"){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Nom complet du saisisseur</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="saisisseur" value="<?= $row['saisisseur'] ?>" placeholder="Mettez le nom complet du saisisseur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 ml-5 mt-3">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Transporteur</label>
                                                            <input class="form-control" id="validationDefault02" type="text" name="transporteur" value="<?= $row['transporteur'] ?>" placeholder="Mettez le nom complet du transporteur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Date d'exportation</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="dateexportation" value="<?= $row['dateexportation'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 ">
                                                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Epaisseur</th>
                                                                <th>Nombre de bobine</th>
                                                                <th>Poids pesé</th>
                                                                <th>Poids déclaré</th>
                                                                <th>Point de départ</th>
                                                                <th>Point d'arrivée</th>
                                                                <th>Etat bobine</th>
                                                                <th>Supprimer ligne</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamicadd">
                                                            <?php
                                                                //$i=0;
                                                                //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                    //$i++;
                                                                    //if($article['status'] == 'termine'){
                                                            ?>
                                                                <tr class="rowClass">
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine">
                                                                                    <option>3</option>
                                                                                    <option>3.5</option>
                                                                                    <option>4</option>
                                                                                    <option>4.5</option>
                                                                                    <option>5</option>
                                                                                    <option>5.5</option>
                                                                                    <option>6</option>
                                                                                    <option>6.5</option>
                                                                                    <option>7</option>
                                                                                    <option>7.5</option>
                                                                                    <option>8</option>
                                                                                    <option>8.5</option>
                                                                                    <option>9</option>
                                                                                    <option>9.5</option>
                                                                                    <option>10</option>
                                                                                    <option>10.5</option>
                                                                                    <option>11</option>
                                                                                    <option>11.5</option>
                                                                                    <option>12</option>
                                                                                    <option>12.5</option>
                                                                                    <option>13</option>
                                                                                    <option>13.5</option>
                                                                                    <option>14</option>
                                                                                    <option>14.5</option>
                                                                                    <option>15</option>
                                                                                    <option>15.5</option>
                                                                                    <option>16</option>
                                                                                    <option>16.5</option>
                                                                                    <option>17</option>
                                                                                </select> 
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control" id="validationDefault04" type="number" name="nbbobine[]" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="number" step="0.01" name="poidspese[]" value="">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" id="validationDefault06" type="number" step="0.01" name="poidsdeclare[]" value="" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="pointdepart[]">
                                                                                    <option>Metal1</option>
                                                                                    <option>Niambour</option>
                                                                                    <option>Tréfilage</option>
                                                                                    <option>Cranteuse</option>
                                                                                    <option>Metal Mbao</option>
                                                                                </select>                                                
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="text" name="pointarrive[]" value="">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="etatbobine[]" value="">
                                                                                    <option>Normale</option>
                                                                                    <option>Disloquée</option>
                                                                                    <option>Autres</option>
                                                                                </select>                                                  
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                        <button class="btn btn-danger remove"
                                                                            type="button">Enlever
                                                                        </button> 
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            // }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    </div>

                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Nom complet du saisisseur</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="saisisseur" value="<?= $_POST['saisisseur'] ?>" placeholder="Mettez le nom complet du saisisseur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 ml-5 mt-3">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Transporteur</label>
                                                            <input class="form-control" id="validationDefault02" type="text" name="transporteur" value="<?= $_POST['transporteur'] ?>" placeholder="Mettez le nom complet du transporteur" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="nom">Date d'exportation</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="dateexportation" value="<?= $_POST['dateexportation'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Epaisseur</th>
                                                                <th>Nombre de bobine</th>
                                                                <th>Poids pesé</th>
                                                                <th>Poids déclaré</th>
                                                                <th>Point de départ</th>
                                                                <th>Point d'arrivée</th>
                                                                <th>Etat bobine</th>
                                                                <th>Supprimer ligne</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamicadd">
                                                            <?php
                                                                //print_r($_POST);
                                                                for ($i = 0; $i < count($_POST['epaisseur']); $i++){
                                                            ?>
                                                                <tr class="rowClass">
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="epaisseur[]" placeholder="Taper l'épaisseur de la bobine">
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='3') {echo "selected='selected'";} ?> >3</option>
                                                                                    <option  <?php if ( $_POST['epaisseur'][$i]=='3.5') {echo "selected='selected'";} ?> >3.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='4') {echo "selected='selected'";} ?> >4</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='4.5') {echo "selected='selected'";} ?> >4.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='5') {echo "selected='selected'";} ?> >5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='5.5') {echo "selected='selected'";} ?> >5.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='6') {echo "selected='selected'";} ?> >6</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='6.5') {echo "selected='selected'";} ?> >6.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='7') {echo "selected='selected'";} ?> >7</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='7.5') {echo "selected='selected'";} ?> >7.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='8') {echo "selected='selected'";} ?> >8</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='8.5') {echo "selected='selected'";} ?> >8.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='9') {echo "selected='selected'";} ?> >9</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='9.5') {echo "selected='selected'";} ?> >9.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='10') {echo "selected='selected'";} ?> >10</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='10.5') {echo "selected='selected'";} ?> >10.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='11') {echo "selected='selected'";} ?> >11</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='11.5') {echo "selected='selected'";} ?> >11.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='12') {echo "selected='selected'";} ?> >12</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='12.5') {echo "selected='selected'";} ?> >12.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='13') {echo "selected='selected'";} ?> >13</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='13.5') {echo "selected='selected'";} ?> >13.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='14') {echo "selected='selected'";} ?> >14</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='14.5') {echo "selected='selected'";} ?> >14.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='15') {echo "selected='selected'";} ?> >15</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='15.5') {echo "selected='selected'";} ?> >15.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='16') {echo "selected='selected'";} ?> >16</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='16.5') {echo "selected='selected'";} ?>>16.5</option>
                                                                                    <option <?php if ( $_POST['epaisseur'][$i]=='17') {echo "selected='selected'";} ?> >17</option>
                                                                                </select> 
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control" value="<?php echo $_POST['nbbobine'][$i] ?>" id="validationDefault04" type="number" name="nbbobine[]" id="example-date-input4" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="number" step="0.01" name="poidspese[]" id="example" value="<?php echo $_POST['poidspese'][$i] ?>">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" id="validationDefault06" type="number" step="0.01" name="poidsdeclare[]" id="exam" value="<?php echo $_POST['poidsdeclare'][$i] ?>" required>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="pointdepart[]">
                                                                                    <option <?php if ( $_POST['pointdepart'][$i]=='Metal1') {echo "selected='selected'";} ?> >Metal1</option>
                                                                                    <option <?php if ( $_POST['pointdepart'][$i]=='Niambour') {echo "selected='selected'";} ?> >Niambour</option>
                                                                                    <option <?php if ( $_POST['pointdepart'][$i]=='Metal Mbao') {echo "selected='selected'";} ?> >Metal Mbao</option>
                                                                                    <option <?php  if ( $_POST['pointdepart'][$i]=='Tréfilage') {echo "selected='selected'";} ?> >Tréfilage</option>
                                                                                    <option <?php  if ( $_POST['pointdepart'][$i]=='Cranteuse') {echo "selected='selected'";} ?> >Cranteuse</option>
                                                                                </select>                                                
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <input class="form-control designa" type="text" name="pointarrive[]" value="<?php echo $_POST['pointarrive'][$i] ?>">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;">
                                                                        <div class="col-md-10">
                                                                            <div class="mb-1 text-start">
                                                                                <select class="form-control" name="etatbobine[]" value="">
                                                                                    <option <?php if ( $_POST['etatbobine'][$i]=='Normale') {echo "selected='selected'";} ?> >Normale</option>
                                                                                    <option <?php if ( $_POST['etatbobine'][$i]=='Disloquée') {echo "selected='selected'";} ?> >Disloquée</option>
                                                                                    <option <?php if ( $_POST['etatbobine'][$i]=='Autres') {echo "selected='selected'";} ?> >Autres</option>
                                                                                </select>                                                  
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                        <button class="btn btn-danger remove"
                                                                            type="button">Enlever
                                                                        </button> 
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>

                                                <div class="col-md-4  d-flex gap-2">
                                                    <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                        <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="add" type="button" value="Ajouter une ligne">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 invisible">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="user" ></label>
                                                        <input class="form-control " type="text" value="<?php
                                                            echo $_SESSION['nomcomplet']; 
                                                        ?>" name="user" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 invisible">
                                                    <div class="mb-1 text-start">
                                                        <input class="form-control " type="text" value="<?php
                                                            echo $_GET['idexportation']; 
                                                        ?>" name="idexportation" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <?php if($valideExportation != "erreurEpaisseur" && $ProblemeNbBobineDepart != "erreurProblemeNbDepart"){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-8">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="commentaire" >Commentaire</label>
                                                            <textarea class="form-control" name="commentaire" rows="4" cols="50"  placeholder="Commentaire en quelques mots ( pas obligatoire... )"><?= $row['commentaire'] ?></textarea>
                                                        </div>
                                                    </div> 
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-8">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label fw-bold" for="commentaire" >Commentaire</label>
                                                            <textarea class="form-control" name="commentaire" rows="4" cols="50"  placeholder="Commentaire en quelques mots ( pas obligatoire... )"><?= $_POST['commentaire'] ?></textarea>
                                                        </div>
                                                    </div> 
                                                <?php } ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end"> 
                                                        <?php if($valideExportation == "erreurInsertion"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller remplir tous les champs svp!',
                                                                    icon: 'error',
                                                                    timer: 2500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeNbBobineDepart == "erreurProblemeNbDepart"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller revoir votre stockage (nombre de bobine, epaisseur ou poids déclaré) svp!',
                                                                    icon: 'error',
                                                                    timer: 5500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($valideExportation == "ValideInsertion"){?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Exportation enregistrée avec succès merci!',
                                                                    icon: 'success',
                                                                    timer: 3000,
                                                                    showConfirmButton: false,
                                                                    });
                                                            </script> 
                                                        <?php } ?>
                                                        <div class="d-flex gap-2 pt-4">                           
                                                            <a href="detailExportation.php?idexportation=<?= $_GET['idexportation'] ?>"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="CreerExportation" type="submit" value="ENREGISTRER">
                                                        </div>
                                                        <hr/>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>  
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white" style="position: absolute; width: 100%; bottom: 0;">
                <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.1);">
                    METAL AFRIQUE © <script>document.write(new Date().getFullYear())</script> Copyright:
                    <a class="text-dark" href="https://metalafrique.com//">METALAFRIQUE.COM BY @BACHIR</a>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="../../indexPage/vendor/jquery/jquery.min.js"></script>
    <script src="../../indexPage/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../indexPage/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../indexPage/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../indexPage/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../indexPage/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../indexPage/js/demo/datatables-demo.js"></script>

</body>

</html>