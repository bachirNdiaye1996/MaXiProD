<?php
    
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";


    //Variables
    // Il faut savoir que metal3 est remplacer par niambour
    $valideFiche="";
    $ProblemeQuart="";
    $ProblemeCompteur="";
    $ProblemeArret="";
    $ProblemeFicheExist="";
    $ProblemeFilMachine="";


    //Insertion une fiche
    if(isset($_POST['CreerFicheProduction'])){

        $compteurdebut=htmlspecialchars( $_POST['compteurdebut']);
        $compteurfin=htmlspecialchars( $_POST['compteurfin']);
        $controleur1=htmlspecialchars( $_POST['controleur1']);
        $controleur2=htmlspecialchars($_POST['controleur2']);
        $machine=htmlspecialchars( $_POST['machine']);
        $datecreationfiche=htmlspecialchars( $_POST['datecreationfiche']);
        $observationdebut=htmlspecialchars($_POST['observationdebut']);
        $heuredepartquart=htmlspecialchars($_POST['heuredepartquart']);
        $heurefinquart=htmlspecialchars( $_POST['heurefinquart']);
        $user=htmlspecialchars( $_POST['user']);
        $quart=htmlspecialchars($_POST['quart']);
        $vitesse=htmlspecialchars( $_POST['vitesse']);
        $observationfin=htmlspecialchars($_POST['observationfin']);
        $poidsestimetravaillenonnote=htmlspecialchars($_POST['poidsestimetravaillenonnote']);

    for ($i = 0; $i < count($_POST['diametre']); $i++){
    }

    //** Nombre des bobines total
        $sql = "SELECT SUM(`3`) + SUM(`3.5`) + SUM(`4`) + SUM(`4.5`) + SUM(`5`) + SUM(`5.5`) + SUM(`6`) + SUM(`6.5`) + SUM(`7`) + SUM(`7.5`)
        + SUM(`8`) + SUM(`8.5`) + SUM(`9`) + SUM(`9.5`) + SUM(`10`) + SUM(`10.5`) + SUM(`11`) + SUM(`11.5`) + SUM(`12`) + SUM(`12.5`) + SUM(`13`) + SUM(`13.5`) + 
        SUM(`14`) + SUM(`14.5`) + SUM(`15`) + SUM(`15.5`) + SUM(`16`) + SUM(`16.5`) + SUM(`17`) AS nb_reception_total FROM `epaisseur` where `lieu`='Cranteuse';";
        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère le nombre d'articles
        $result = $query->fetch();

        $nbReception = (int) $result['nb_reception_total'];
    //** Fin nombre des bobines total

    //** Debut select de stockage pour Metal1
        $sqlepaisseur = "SELECT * FROM `matiere` where `nbbobineactuel`>0 and `lieutransfert`='Cranteuse'  ORDER BY `idmatiere` DESC;";

        // On prépare la requête
        $queryepaisseur = $db->prepare($sqlepaisseur);

        // On exécute
        $queryepaisseur->execute();

        // On récupère les valeurs dans un tableau associatif
        $stockCranteuse = $queryepaisseur->fetchAll();
    //** Fin select de stockage pour Metal1

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="../../image/iconOnglet.png" />
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
            $('#dynamicaddConsommations').on('click', '.removeConsommations', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddProductions').on('click', '.removeProductions', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddEchantillons').on('click', '.removeEchantillons', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });

            // Removing Row on click to Remove button
            $('#dynamicaddErreurs').on('click', '.removeErreurs', function () {
                //console.log("TestRemove");
                $(this).parent('td.text-center').parent('tr.rowClass').remove(); 
            });
        })
    </script>

    <script>
        // Pour le loading
            //const loader = document.querySelector('.loader');

            document.addEventListener('DOMContentLoaded', () => {
                //console.log(loader);
                //document.getElementById('loader').className = "fondu-out";
                document.getElementById("loader").remove();
                //loader.classList.add('fondu-out');

            })
        //Pour le loading
    </script>

    <script type="text/javascript"> 
        var foo1 = "<script>";
        var foo2 = "</scr"+"ipt>";

        $(document).ready(function(){  
            var i = 0; 
            $('#addErreurs').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddErreurs').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault04" type="time" name="debutarret[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="time" name="finarret[]" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control" id="validationDefault01" type="text" name="raisonerreur[]" value="" placeholder="Mettez la raison d'erreur" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeErreurs"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});

            $('#addConsommations').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddConsommations').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="diametre[]" id="diametre`+i+`" value="" required>
                        </div> 
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="numerofin[]" id="numerofin`+i+`" required>
                                <option></option> 
                                <?php
                                    foreach($stockCranteuse as $stock){
                                ?>                                                                                        
                                    <option value="<?php echo $stock['numbobine'].'/'.$stock['epaisseur'].'/'.$stock['poidsdeclare']; ?>"> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                <?php
                                    }  
                                ?> 
                            </select>                                                
                        </div>
                    </div>     
                </td>
                `+foo1+`
                    $(document).ready(function(){
                        $('#numerofin`+i+`').change(function(){
                            //Selected value
                            var inputValue = $(this).val();
                            var myArray = inputValue.split('/');
                            document.getElementById("diametre`+i+`").value = myArray[1];
                            document.getElementById("poids`+i+`").value = myArray[2];
                        });
                    });
                `+foo2+`
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="time" name="heuremontagebobine[]" id="example" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="poids[]" id="poids`+i+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="dechet[]" id="example" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="finirfm`+i+`[]">
                            </label>
                        </div>
                    </div>  
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeConsommations"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});  
            
            
            $('#addProductions').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddProductions').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre`+i+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="Prodnomenclature[]" id="Prodnomenclature" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="">
                        <div class="mb-1 text-start">
                            <select class="form-control" name="Prodnumerofin[]" id="numerofinProd`+i+`" required>
                                <option></option> 
                                <?php
                                    foreach($stockCranteuse as $stock){
                                ?>      
                                    <option value="<?php echo $stock['numbobine'].'/'.$stock['epaisseur'].'/'.$stock['poidsdeclare']; ?>"> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                <?php
                                    }
                                ?>
                            </select>                                                
                        </div>
                    </div>
                </td>
                `+foo1+`
                    $(document).ready(function(){
                        $('#numerofinProd`+i+`').change(function(){
                            //Selected value
                            var inputValue = $(this).val();
                            var myArray = inputValue.split('/');
                            document.getElementById("Proddiametre`+i+`").value = myArray[1];
                            document.getElementById("Prodpoids`+i+`").value = myArray[2];
                        });
                    });
                `+foo2+`
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Prodpoids[]" id="Prodpoids`+i+`" value="" required>
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Echanlongueur[]" id="example" value="" placeholder="EXP : 30">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Echanpoids[]" id="example" value="" placeholder="EXP : 30">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="Echandf[]" id="example" value="" placeholder="EXP : 30">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeProductions"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );});

            $('#addEchantillons').click(function(){           
            //alert('ok');           
            i++;           
            $('#dynamicaddEchantillons').append(`
            <tr id="row'+i+'" class="rowClass">
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Echandiametre[]" id="" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="number" step="0.01" name="Echanlongueur[]" id="" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;">
                    <div class="col-md-10">
                        <div class="mb-1 text-start">
                            <input class="form-control designa" type="text" name="Echandf[]" id="" value="">
                        </div>
                    </div>
                </td>
                <td style="background-color:#CFFEDA ;" class="text-center"> 
                    <button class="btn btn-danger removeEchantillons"
                        type="button">Enlever
                    </button> 
                </td>
            </tr>`
            );})
            ;}); 
    </script> 

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" style="background: #C2C3C3;">

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
                        <div class="col-lg-12">
                            <div class="modal-dialog-centered">
                                <div class="modal-content col-lg-12">
                                    <div class="modal-header col-lg-12 bg-primary" >
                                        <h5 class="modal-title" id="myExtraLargeModalLabel" style="color:white; text-align: center;">Ajout fiche de production cranteuse</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                                            <div class="row">
                                                <?php if($valideFiche != "erreurFiche" && $ProblemeArret != "erreurProblemeArret" && $ProblemeFilMachine != "erreurProblemeFilMachine" && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && ($ProblemeFicheExist != "erreurProblemeFicheExist")){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 ml-5 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur début</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurdebut" value="" placeholder="Mettez le compteur du début" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur fin</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurfin" value="" placeholder="Mettez le Compteur de la fin" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du machiniste 1</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur1" value="" placeholder="Mettez le nom complet du machiniste 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du machiniste 2</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur2" value="" placeholder="Mettez le nom complet du machiniste 2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Machine</label>
                                                            <select class="form-control" name="machine">
                                                                <option>Cranteuse 1</option>
                                                                <option>Cranteuse 2</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Date de production</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="datecreationfiche" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle départ du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heuredepartquart" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle fin du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heurefinquart" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Quart</label>
                                                            <select class="form-control" name="quart">
                                                                <option>1</option>
                                                                <option>2</option>
                                                                <option>3</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-5">
                                                        <div class="mb-5 float-right mr-5">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (début) </label>
                                                            <textarea class="form-control" name="observationdebut" rows="4" cols="120"  placeholder="Mettez ici les observations ( pas obligatoire... )"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                        <table class="table table-bordered" id="" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Diametre</th>
                                                                    <th>Nomenclature</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Poids</th>
                                                                    <th>Longueur échantillon (cm)</th>
                                                                    <th>Poids échantillon</th>
                                                                    <th>N° DF échantillon</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddProductions">
                                                                <?php
                                                                    //$i=0;
                                                                    //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="Prodnomenclature[]" id="Prodnomenclature" value="">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="Prodnumerofin[]" id="numerofinProd" required>
                                                                                        <option></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>                                                                                        
                                                                                           <option value="<?php echo $stock['numbobine'].'/'.$stock['epaisseur'].'/'.$stock['poidsdeclare']; ?>"> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofinProd').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("Proddiametre").value = myArray[1];
                                                                                    document.getElementById("Prodpoids").value = myArray[2];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodpoids[]" id="Prodpoids" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Echanlongueur[]" id="example" value="" placeholder="EXP : 30">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Echanpoids[]" id="example" value="" placeholder="EXP : 30">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="Echandf[]" id="example" value="" placeholder="EXP : 30">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeProductions"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                // }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addProductions" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7 mt-2">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Diametre</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Heure montage</th>
                                                                    <th>Poids</th>
                                                                    <th>Déchets</th>
                                                                    <th>Finir FM</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddConsommations">
                                                                <?php
                                                                    $i=0;
                                                                    //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="diametre[]" id="diametre" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" id="numerofin" name="numerofin[]" required>
                                                                                        <option></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>   
                                                                                           <option value="<?php echo $stock['numbobine'].'/'.$stock['epaisseur'].'/'.$stock['poidsdeclare']; ?>"> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofin').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("diametre").value = myArray[1];
                                                                                    document.getElementById("poids").value = myArray[2];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="heuremontagebobine[]" id="example" value="">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poids[]" id="poids" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="dechet[]" id="example" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="finirfm<?php echo $i;?>[]">
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeConsommations"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                // }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addConsommations" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5 mt-2">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Gestion des temps d'arret</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Début arrets</th>
                                                                    <th>Fin arrets</th>
                                                                    <th>Raisons</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddErreurs">
                                                                <?php
                                                                    //$i=0;
                                                                    //for ($i = 0; $i <= $NombreLigne; $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="time" name="debutarret[]" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="finarret[]" value="" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <!--<td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="raisonerreur[]">
                                                                                        <option>Raison 1</option>
                                                                                        <option>Raison 2</option>
                                                                                        <option>Raison 3</option> 
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>!-->
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault01" type="text" name="raisonerreur[]" value="" placeholder="Mettez la raison d'erreur" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;" class="text-center"> 
                                                                            <button class="btn btn-danger removeErreurs"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                // }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-7  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addErreurs" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 ml-5 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur début</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurdebut" value="<?php echo $_POST['compteurdebut']; ?>" placeholder="Mettez le compteur du début" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Compteur fin</label>
                                                            <input class="form-control" id="validationDefault02" type="number" step="0.01" name="compteurfin" value="<?php echo $_POST['compteurfin']; ?>" placeholder="Mettez le Compteur de la fin" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du machiniste 1</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur1" value="<?php echo $_POST['controleur1']; ?>" placeholder="Mettez le nom complet du machiniste 1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Nom complet du machiniste 2</label>
                                                            <input class="form-control" id="validationDefault01" type="text" name="controleur2" value="<?php echo $_POST['controleur2']; ?>" placeholder="Mettez le nom complet du machiniste 2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Machine</label>
                                                            <select class="form-control" name="machine">
                                                                <option <?php if ( $_POST['machine']=="Cranteuse 1") {echo "selected='selected'";} ?>>Cranteuse 1</option>
                                                                <option <?php if ( $_POST['machine']=="Cranteuse 2") {echo "selected='selected'";} ?>>Cranteuse 2</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Date de production</label>
                                                            <input class="form-control" id="validationDefault03" type="date" name="datecreationfiche" value="<?php echo $_POST['datecreationfiche']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle départ du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heuredepartquart" value="<?php echo $_POST['heuredepartquart']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-4">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Heure réelle fin du quart</label>
                                                            <input class="form-control" id="validationDefault03" type="time" name="heurefinquart" value="<?php echo $_POST['heurefinquart']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-4 mt-3 mb-5 ml-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Quart</label>
                                                            <select class="form-control" name="quart">
                                                                <option <?php if ( $_POST['quart']=="1") {echo "selected='selected'";} ?>>1</option>
                                                                <option <?php if ( $_POST['quart']=="1") {echo "selected='selected'";} ?>>2</option>
                                                                <option <?php if ( $_POST['quart']=="1") {echo "selected='selected'";} ?>>3</option>
                                                            </select>                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-5">
                                                        <div class="mb-5 float-right mr-5">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (début) </label>
                                                            <textarea class="form-control" name="observationdebut" rows="4" cols="120"  placeholder="Mettez ici les observations ( pas obligatoire... )"><?php echo $_POST['observationdebut']; ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Productions</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Diametre</th>
                                                                    <th>Nomenclature</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Poids</th>
                                                                    <th>Longueur échantillon (cm)</th>
                                                                    <th>Poids échantillon</th>
                                                                    <th>N° DF échantillon</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddProductions">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['Proddiametre']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Proddiametre[]" id="Proddiametre" value="<?php echo $_POST['Proddiametre'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="Prodnomenclature[]" id="Prodnomenclature" value="<?php echo $_POST['Prodnomenclature'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="Prodnumerofin[]" id="numerofinProd" required>
                                                                                        <option value="<?php echo $_POST['Prodnumerofin'][$i].'/'; ?>"><?php $numerofinString = explode("/", $_POST['Prodnumerofin'][$i]); echo $numerofinString[0]; ?></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>                                                                                        
                                                                                           <option value="<?php echo $stock['numbobine'].'/'.$stock['epaisseur'].'/'.$stock['poidsdeclare']; ?>"> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Prodpoids[]" id="Prodpoids" value="<?php echo $_POST['Prodpoids'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Echanlongueur[]" id="example" value="<?php echo $_POST['Echanlongueur'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="Echanpoids[]" id="example" value="<?php echo $_POST['Echanpoids'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="text" name="Echandf[]" id="example" value="<?php echo $_POST['Echandf'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofinProd').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("Proddiametre").value = myArray[1];
                                                                                    document.getElementById("Prodpoids").value = myArray[2];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeProductions"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addProductions" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-7">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Consommations</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Diametre</th>
                                                                    <th>N° fil machine</th>
                                                                    <th>Heure montage</th>
                                                                    <th>Poids</th>
                                                                    <th>Déchets</th>
                                                                    <th>Finir FM</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddConsommations">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['diametre']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="diametre[]" id="diametre" value="<?php echo $_POST['diametre'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" id="numerofin" name="numerofin[]" required>
                                                                                        <option value="<?php echo $_POST['numerofin'][$i].'/' ?>"><?php $numerofinString = explode("/", $_POST['numerofin'][$i]); echo $numerofinString[0]; ?></option> 
                                                                                        <?php
                                                                                            foreach($stockCranteuse as $stock){
                                                                                        ?>                                                                                        
                                                                                           <option value="<?php echo $stock['numbobine'].'/'.$stock['epaisseur'].'/'.$stock['poidsdeclare']; ?>"> <?php echo $stock['numbobine']; ?></option>                                                                                     
                                                                                        <?php
                                                                                            }
                                                                                        ?>
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <script>
                                                                            $(document).ready(function(){
                                                                                $('#numerofin').change(function(){
                                                                                    //Selected value
                                                                                    var inputValue = $(this).val();
                                                                                    var myArray = inputValue.split('/');
                                                                                    document.getElementById("diametre").value = myArray[1];
                                                                                    document.getElementById("poids").value = myArray[2];
                                                                                });
                                                                            });
                                                                        </script>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="heuremontagebobine[]" id="example" value="<?php echo $_POST['heuremontagebobine'][$i]; ?>">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="poids[]" id="poids" value="<?php echo $_POST['poids'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="number" step="0.01" name="dechet[]" id="example" value="<?php echo $_POST['dechet'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;">
                                                                            <div class="col-md-10">
                                                                                <div class="form-check-inline">
                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" style="width: 25px; height: 25px;" class="form-check-input" name="finirfm<?php echo $i;?>[]" <?php if(isset($_POST['finirfm'.$i])){ echo "checked"; } ?> >
                                                                                    </label>
                                                                                </div>
                                                                            </div>  
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA ;" class="text-center"> 
                                                                            <button class="btn btn-danger removeConsommations"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addConsommations" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-5 ">
                                                        <h5 class="modal-title mb-3 text-center font-weight-bold text-primary" id="myExtraLargeModalLabel">Gestion des erreurs</h5>
                                                        <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>       
                                                                    <th>Début arrets</th>
                                                                    <th>Fin arrets</th>
                                                                    <th>Raisons</th>
                                                                    <th>Supprimer ligne</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="dynamicaddErreurs">
                                                                <?php
                                                                    //$i=0;
                                                                    for ($i = 0; $i < count($_POST['debutarret']); $i++){
                                                                        //$i++;
                                                                        //if($article['status'] == 'termine'){
                                                                ?>
                                                                    <tr class="rowClass">
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault04" type="time" value="<?php echo $_POST['debutarret'][$i]; ?>" name="debutarret[]" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control designa" type="time" name="finarret[]" value="<?php echo $_POST['finarret'][$i]; ?>" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <!--<td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <select class="form-control" name="raisonerreur[]">
                                                                                        <option <?php if ( $_POST['raisonerreur'][$i]=="Raison 1") {echo "selected='selected'";} ?>>Raison 1</option>
                                                                                        <option <?php if ( $_POST['raisonerreur'][$i]=="Raison 2") {echo "selected='selected'";} ?>>Raison 2</option>
                                                                                        <option <?php if ( $_POST['raisonerreur'][$i]=="Raison 3") {echo "selected='selected'";} ?>>Raison 3</option> 
                                                                                    </select>                                                
                                                                                </div>
                                                                            </div>
                                                                        </td>!-->
                                                                        <td style="background-color:#CFFEDA;">
                                                                            <div class="col-md-10">
                                                                                <div class="mb-1 text-start">
                                                                                    <input class="form-control" id="validationDefault01" type="text" name="raisonerreur[]" value="<?php echo $_POST['raisonerreur'][$i]; ?>" placeholder="Mettez la raison d'erreur" required>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td style="background-color:#CFFEDA;" class="text-center"> 
                                                                            <button class="btn btn-danger removeErreurs"
                                                                                type="button">Enlever
                                                                            </button> 
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </tbody>
                                                        </table>

                                                        <div class="col-md-4  d-flex gap-2">
                                                            <div class="mb-5 text-start d-flex gap-2 pt-4">
                                                                <input class="btn btn-success  w-lg bouton mr-3" name="ChangerNombreLigne" id="addErreurs" type="button" value="Ajouter une ligne">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-md-6 invisible">
                                                    <div class="mb-1 text-start">
                                                        <label class="form-label fw-bold" for="user" ></label>
                                                        <input class="form-control " type="text" value="<?php
                                                            echo $_SESSION['nomcomplet']; 
                                                        ?>" name="user" id="example-date-input2">
                                                    </div>
                                                </div>
                                                <?php if($valideFiche != "erreurFiche" && $ProblemeArret != "erreurProblemeArret" && $ProblemeFilMachine != "erreurProblemeFilMachine"  && $ProblemeCompteur != "erreurProblemeCompteur" && $ProblemeQuart != "erreurProblemeQuart" && ($ProblemeFicheExist != "erreurProblemeFicheExist")){ // Lorsqu'il y a pas de erreur ?> 
                                                    <div class="col-md-2 mr-5 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Vitésse</label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="vitesse" value="" placeholder="Mettez la vitesse" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mt-3 mr-5 mb-5 ">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Poids estimatif travaillé et non noté </label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="poidsestimetravaillenonnote" value="" placeholder="Mettez le poids">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ml-5">
                                                        <div class="mb-1">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (fin) </label>
                                                            <textarea class="form-control" name="observationfin" rows="4" cols="90"  placeholder="Mettez ici les observations ( pas obligatoire... )"></textarea>
                                                        </div>
                                                    </div> 
                                                <?php }else{  // Lorsqu'il y a une erreur ?>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Vitésse</label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="vitesse" value="<?php echo $_POST['vitesse']; ?>" placeholder="Mettez la vitesse" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 mr-2 mt-3 mb-5">
                                                        <div class="mb-1 text-start">
                                                            <label class="form-label font-weight-bold text-primary" for="nom">Poids estimatif travaillé et non noté </label>
                                                            <input class="form-control" id="validationDefault01" type="number" step="0.01" name="poidsestimetravaillenonnote" value="<?php echo $_POST['poidsestimetravaillenonnote']; ?>" placeholder="Mettez le poids">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ml-5">
                                                        <div class="mb-1">
                                                            <label class="form-label font-weight-bold text-primary" for="commentaire" >Observations (fin) </label>
                                                            <textarea class="form-control" name="observationfin" rows="4" cols="90"  placeholder="Mettez ici les observations ( pas obligatoire... )"><?php echo $_POST['observationfin']; ?></textarea>
                                                        </div>
                                                    </div> 
                                                <?php } ?>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <div class="col-md-8 align-items-center col-md-12 text-end"> 
                                                        <?php if($ProblemeCompteur == "erreurProblemeCompteur"){ ?> 
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Le compteur de fin doit etre soupérieur au compteur de départ svp!',
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeQuart == "erreurProblemeQuart"){ ?>
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Veiller revoir les heures de depart et de fin du quart svp!',
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeFicheExist == "erreurProblemeFicheExist"){ ?>
                                                            <script>    
                                                                Swal.fire({
                                                                    text: 'Desolé mais cette fiche existe déja, veillez revoir les champs (Machine, Quart ou la Date) svp!',
                                                                    icon: 'error',
                                                                    timer: 4500,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeArret == "erreurProblemeArret"){ ?>
                                                            <script>    
                                                                Swal.fire({
                                                                    text: "Veiller revoir les heures de depart et de fin des arrets svp!",
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($ProblemeFilMachine == "erreurProblemeFilMachine"){ ?>
                                                            <script>    
                                                                Swal.fire({
                                                                    text: "Veiller remplir le champs numéro fil machine svp!",
                                                                    icon: 'error',
                                                                    timer: 4000,
                                                                    showConfirmButton: false,
                                                                },
                                                                function(){ 
                                                                    location.reload();
                                                                });
                                                            </script> 
                                                        <?php } ?>
                                                        <?php if($valideFiche == "ValideInsertion"){?> 
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
                                                            <a href="ficheCranteuse.php"><input class="btn btn-danger  w-lg bouton mr-3" name=""  value="Annuler"></a>
                                                            <input class="btn btn-success  w-lg bouton mr-3" name="CreerFicheProduction" type="submit" value="ENREGISTRER">
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

                    <div class="col-lg-12 mt-5">
                        <div class="card position-relative">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Nombre de bobine stocké à la machine Cranteuse : <?php echo $nbReception; ?></h6>
                            </div>
                            <div class="row m-2">
                                <div class="table-responsive">
                                    <!-- Page Loader -->
                                        <div id="loader">
                                            <span class="lettre">M</span>
                                            <span class="lettre">E</span>
                                            <span class="lettre">T</span>
                                            <span class="lettre">A</span>
                                            <span class="lettre">L</span>
                                            <span class="lettre">*</span>
                                            <span class="lettre">*</span>
                                            <span class="lettre">*</span>
                                            <span class="lettre">A</span>
                                            <span class="lettre">F</span>
                                            <span class="lettre">R</span>
                                            <span class="lettre">I</span>
                                            <span class="lettre">Q</span>
                                            <span class="lettre">U</span>
                                            <span class="lettre">E</span>
                                        </div>
                                    <!-- Page Loader -->
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>       
                                                <th>Numéro fil machine</th>                                                                                
                                                <th>Epaisseur</th>
                                                <th>Nombre rouleaux</th>
                                                <th>Poids déclaré</th>
                                                <th>Poids pesé</th>
                                                <th>Etat bobine</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i=0;
                                                foreach($stockCranteuse as $stock){
                                                    $i++;
                                                    //if($article['status'] == 'termine'){
                                            ?>
                                                <tr>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['numbobine'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"> <?= $stock['epaisseur'] ?> </td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['nbbobineactuel'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidsdeclare'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['poidspese'] ?></td>
                                                    <td style="background-color:#4e73df ; color:white;"><?= $stock['etatbobine'] ?></td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
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