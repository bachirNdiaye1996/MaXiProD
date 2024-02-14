<?php
    // Pour la supression d'une reception avec un get de idsupreception
    include "../connexion/conexiondb.php";

    if(isset($_GET['idappreception'])){
        $id = $_GET['idappreception'];
        $sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
        $db->query($sql);

        $sql1 = "UPDATE `matiere` set `actifapprouvreception`=1 where idreception=$id";
        $db->query($sql1);
        
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
            }elseif(($lieutransfert == "Metal3")){
                //Debut inserer le nombre de bobine par epaisseur
                $req ="UPDATE epaisseur SET `$epaisseur` = `$epaisseur` + ? where `id`=3;";  // Metal 3 dit Niambour
                //$db->query($req); 
                $reqtitre = $db->prepare($req);
                $reqtitre->execute(array($nbbobine));
                //Fin inserer le nombre de bobine par epaisseur
            }
        }

        header('location: reception.php');
        exit;
    }

?>