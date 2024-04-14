<?php
    //INSERT INTO `utilisateur` (`id`, `username`, `password`, `email`, `nomcomplet`, `niveau`, `matricule`, `datecreation`, `actif`) 
    //VALUES (NULL, 'pbascule', 'test', 'pbascule@metalafrique.com', 'Pont Bascule', 'pontbascule', '3050', current_timestamp(), '1');

    session_start(); 

    if(!$_SESSION['niveau']){
        header('Location: ../../../../404.php');
    }

    include "../../connexion/conexiondb.php";

    //Variables
    $ProblemeSurInput="";

if($_SERVER["REQUEST_METHOD"]=='GET'){
    if(!isset($_GET['idUser'])){
        header("location: ../accueil.php");
        exit;
    }
    $id = $_GET['idUser'];
    $sql = "select * from utilisateur where id=$id";
    $result = $db->query($sql);
    $row = $result->fetch();
    while(!$row){
        header("location: ../accueil.php");
    exit;
    }
}else{ }

    //Insertion des utilisateur
    if(isset($_POST['modifierUtilisateur'])){
        $id = $_GET['idUser'];

        $password=sha1($_POST['password']);
        $email=htmlspecialchars( $_POST['email']);
        $nomcomplet=htmlspecialchars( $_POST['nomcomplet']);
        $matricule=htmlspecialchars($_POST['matricule']);
        $numTelephone=htmlspecialchars( $_POST['numTelephone']);

        if(!empty($_POST['email']) && !empty($_POST['nomcomplet']) && !empty($_POST['matricule']) && !empty($_POST['password'])){

            // |--> Pour update user
                $sql = "UPDATE `utilisateur` SET `email` = '$email',`nomcomplet` = '$nomcomplet'
                , `matricule` = '$matricule', `numTelephone` = '$numTelephone', `password` = '$password' WHERE `id` = ?;";
                //$result = $db->query($sql); 
                $sth = $db->prepare($sql);    
                $sth->execute(array($id));
            // |--> Fin update user

            header("location: ../accueil.php");
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

    <link rel="stylesheet"
          href=
    "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
        <link rel="stylesheet"
            href=
    "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
            integrity=
    "sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
            crossorigin="anonymous">
    <style>
        form i {
            margin-left: -30px;
            cursor: pointer;
        }
    </style>


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
                                <h1 class="h4 text-gray-900 mb-4">Paramétrages de votre compte !</h1>
                                <h6>Bienvenu <?php echo $_SESSION['nomcomplet'];?>, vous pouvez modifier vos parametres de connexion.</h6>
                            </div>
                            <form class="user mt-5" action="#" method="POST" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" name="nomcomplet" value="<?php echo $row['nomcomplet'];?>" id="example-date-input1" required
                                            placeholder="Nom complet">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" name="numTelephone" value="<?php echo $row['numTelephone'];?>"
                                            placeholder="Numéro Téléphone MAF Exemple: 70 xxx xx xx">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" name="email" value="<?php echo $row['email'];?>" id="example-date-input3" required
                                        placeholder="Adresse email">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" value="<?php echo $row['matricule'];?>" name="matricule" id="example-date-input4" required
                                            placeholder="Matricule">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user d-inline" name="password" id="example-date-input5" required value=""
                                            placeholder="Mettez ici votre nouveau mot de passe">
                                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    </div>
                                    <script>
                                        const togglePassword = document
                                            .querySelector('#togglePassword');
                                        const password = document.querySelector('#example-date-input5');
                                        togglePassword.addEventListener('click', () => {
                                            // Toggle the type attribute using
                                            // getAttribure() method
                                            const type = password
                                                .getAttribute('type') === 'password' ?
                                                'text' : 'password';
                                            password.setAttribute('type', type);
                                            // Toggle the eye and bi-eye icon
                                            this.classList.toggle('bi-eye');
                                        });
                                    </script>
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
                                    <input class="btn btn-success  w-lg bouton mr-3 mt-5" name="modifierUtilisateur" type="submit" value="ENREGISTRER">
                                    <a href="../accueil.php" class="btn btn-danger w-lg bouton ml-3 mt-5"><i class="fa fa-angle-double-left mr-2 "></i>Annuler</a>
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