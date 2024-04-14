<?php   

    session_start();   

    include "conexiondb.php";
    $mess1="";

    if(isset($_POST['valide'])){
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            $user=htmlspecialchars($_POST['username']);
            $password=sha1($_POST['password']);
            //$password=$_POST['password'];
            $recupeUser=$db->prepare('select * from utilisateur where username=? and password=?');
            $recupeUser->execute(array($user,$password));
            
            //print_r($recupeUser);
            if($recupeUser->rowCount() > 0){
                $Utilisateur = $recupeUser->fetch();
                $_SESSION['matricule'] = $Utilisateur['matricule'];
                $_SESSION['id'] = $Utilisateur['id'];
                $_SESSION['nomcomplet'] = $Utilisateur['nomcomplet'];
                $_SESSION['username'] = $Utilisateur['username'];
                $_SESSION['niveau'] = $Utilisateur['niveau'];
                $_SESSION['email'] = $Utilisateur['email'];
                $_SESSION['section'] = $Utilisateur['section'];

                //$_SESSION['user'] = $Utilisateur['user'];
                if($Utilisateur['niveau'] == 'admin'){
                    header('Location: ./indexPage/accueil.php');
                    exit;
                }elseif($Utilisateur['niveau'] == 'pontbascule'){
                    header('Location: ./indexPage/accueil.php');
                    exit;
                }/*else{
                    header('Location: acueil.php');
                    exit;
                }
                #header('Location: acueil.php');
                #exit;
            }else{
                $mess1="error";
            }*/
        }else{
            $mess1="error";
        }
    }
}

    /*
    $User1 = $db->prepare("select*from utilisateur");
    $User1->execute();
    $Utilisateur = $User1->fetchAll();
    echo $Utilisateur['username'];*/
?>


