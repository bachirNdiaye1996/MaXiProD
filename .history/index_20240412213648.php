<?php
    include './connexion/connectionIndex.php';
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        form i {
            margin-left: -30px;
            cursor: pointer;
        }
    </style>

    <link href="./style.css" id="app-style" rel="stylesheet" type="text/css"/>

    <!-- App favicon -->
    <link rel="shortcut icon" href="./image/iconOnglet.png" />
    <title>METAL AFRIQUE</title>
</head>
    <body>
        <div class="container">
            <form action="#" method="POST" enctype="multipart/form-data" class="row g-3">
                <?php if($mess1 === "error"){?> <p id="clignoter1" style="color:red;">Mot de passe ou nom d'utilisateur incorrect</p> <?php } ?>
                <?php if($mess1 != "error"){?> <p id="monTitre">GESTION DE PRODUCTION DE METAL AFRIQUE</p> <?php } ?>
                <input type="text" name="username" placeholder="Nom d'utilisateur" id="validationDefault01" required value="<?php if($_POST){echo $_POST['username'] ;}?>"><br>
                <input type="password" name="password" placeholder="Mot de passe" value="<?php if($_POST){ echo $_POST['password']; }?>" id="validationDefault02" required><br>
                <!-- An element to toggle between password visibility -->
                <div>
                    <input type="checkbox" style="width:unset; margin-right:10px;" onclick="myFunction()"><span style="font-size: 13px; color: #ddd;">Voir Mot de passe</span>
                </div>
                <script>
                    function myFunction() {
                        var x = document.getElementById("validationDefault02");
                        if (x.type === "password") {
                            x.type = "text";
                        } else {
                            x.type = "password";
                        }
                    }
                </script>
                <input type="submit" value="Connexion" name="valide"><br>
                <a href="#">Mot de passe oublié</a>
            </form>

            <div class="drop drop-1"></div>
            <div class="drop drop-2"></div>
            <div class="drop drop-3"></div>
            <div class="drop drop-4"></div>
            <div class="drop drop-5"></div>
        </div>
    </body>
</html>