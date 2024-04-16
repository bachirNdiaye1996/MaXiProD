<?php
    //INSERT INTO `utilisateur` (`id`, `username`, `password`, `email`, `nomcomplet`, `niveau`, `matricule`, `datecreation`, `actif`) 
    //VALUES (NULL, 'pbascule', 'test', 'pbascule@metalafrique.com', 'Pont Bascule', 'pontbascule', '3050', current_timestamp(), '1');

    session_start(); 


    if((strcmp("$_SESSION[niveau]","admin") !== 0)){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";

    //Variables
    $ProblemeSurInput="";

    //Insertion des utilisateur
    if(isset($_POST['CreerUtilisateur'])){

        $username=htmlspecialchars($_POST['username']);
        $password=sha1("Passer@123");
        $email=htmlspecialchars( $_POST['email']);
        $nomcomplet=htmlspecialchars( $_POST['nomcomplet']);
        $niveau=htmlspecialchars($_POST['niveau']);
        $matricule=htmlspecialchars($_POST['matricule']);
        $numTelephone=htmlspecialchars( $_POST['numTelephone']);
        $section=htmlspecialchars( $_POST['section']);

        if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['nomcomplet']) && !empty($_POST['niveau']) && !empty($_POST['matricule']) && !empty($_POST['section'])){
            $insertUser=$db->prepare("INSERT INTO `utilisateur` (`id`, `username`, `password`, `email`, `nomcomplet`, `niveau`, `matricule`, `datecreation`, `actif`, `numTelephone`, `section`)
            VALUES (NULL, ?, ?, ?, ?, ?, ?, current_timestamp(), '1', ?, ?);");
            $insertUser->execute(array($username,$password,$email,$nomcomplet,$niveau,$matricule,$numTelephone,$section));

            header("location: utilisateur.php");
            exit;
        }else{
            $ProblemeSurInput="erreurProblemeSurInput";
        }
    }
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

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Création d'un compte utilisateur !</h1>
                            </div>
                            <form class="user" action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="nomcomplet" id="example-date-input1" required
                                            placeholder="Nom complet">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="username" id="example-date-input2" required
                                            placeholder="Username Exemple: hdiop">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" id="example-date-input3" required
                                        placeholder="Adresse email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="matricule" id="example-date-input4" required
                                            placeholder="Matricule">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="numTelephone"
                                            placeholder="Numéro Téléphone MAF Exemple: 70 xxx xx xx">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="section" id="example-date-input5" required
                                            placeholder="Séction">
                                    </div>
                                </div>
                                <p class="mt-5">Choisissez le niveau de l'utilisateur :</p>
                                <div class="form-check form-check-inline checkbox-xl">
                                    <input class="form-check-input mr-2" type="radio" name="niveau" id="inlineRadio1" value="admin" required>
                                    <label class="form-check-label mr-5" for="inlineRadio1">Admin</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mr-2" type="radio" name="niveau" id="inlineRadio2" value="pontbascule" required>
                                    <label class="form-check-label mr-5" for="inlineRadio2">Pont bascule</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mr-2" type="radio" name="niveau" id="inlineRadio3" value="chefquart" required>
                                    <label class="form-check-label mr-5" for="inlineRadio3">Chef de quart</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mr-2" type="radio" name="niveau" id="inlineRadio2" value="respoproduction" required>
                                    <label class="form-check-label mr-5" for="inlineRadio2">Responsable production</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input mr-2" type="radio" name="niveau" id="inlineRadio2" value="maintenance" required>
                                    <label class="form-check-label mr-5" for="inlineRadio2">Maintenance</label>
                                </div>
                                <div>
                                    <?php if($ProblemeSurInput == "erreurProblemeSurInput"){ ?> 
                                        <script>    
                                            Swal.fire({
                                                text: 'Véillez remplir tous les champs svp!',
                                                icon: 'error',
                                                timer: 2500,
                                                showConfirmButton: false,
                                            },
                                            function(){ 
                                                location.reload();
                                            });
                                        </script> 
                                    <?php } ?>
                                    <input class="btn btn-success  w-lg bouton mr-3 mt-5" name="CreerUtilisateur" type="submit" value="ENREGISTRER">
                                    <a href="./utilisateur.php" class="btn btn-google mt-5">
                                        <i class=""></i> Annuler
                                    </a>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

                <!-- Footer -->
                <footer class="sticky-footer bg-white" style="position: absolute; width: 100%; bottom: 0;">
                <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.1);">
                    METAL AFRIQUE © <script>document.write(new Date().getFullYear())</script> Copyright:
                    <a class="text-dark" href="https://metalafrique.com//">METALAFRIQUE.COM BY @BACHIR</a>
                </div>
            </footer>
            <!-- End of Footer -->

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>