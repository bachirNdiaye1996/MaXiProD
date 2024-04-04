<?php
    include "../connexion/conexiondb.php";

    // Pour la supression d'une reception avec un get de idsupreception
        if(isset($_GET['idmatiereDemandeRectifier'])){
            $id = $_GET['idmatiereDemandeRectifier'];
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `matiere` set `actifapprouvreception`=1 where idmatiere=$id";
            $db->query($sql1);

            //Pour enlever la couleur rouge
            $sql1 = "UPDATE `matiere` set `acceptereceptionmodif`=1 where idmatiere=$id";
            $db->query($sql1);
            

            header("location: detailsReception.php?idreception=$_GET[idreceptionDemandeRectifier]");
            exit;
        }
    // Fin pour la supression d'une reception avec un get de idsupreception

    // L'admin permet de donner la main au responsable du pont bascule
        if(isset($_GET['idmatiereDemandeAccepter'])){
            $id = $_GET['idmatiereDemandeAccepter'];
            //$sql = "UPDATE `reception` set `actifapprouvreception`=0, `status` = 'Approuvée'  where idreception=$id";
            //$db->query($sql);

            $sql1 = "UPDATE `matiere` set `acceptereceptionmodif`=0 where idmatiere=$id";
            $db->query($sql1);

            //foreach ($Reception as $key => $value) {
                $epaisseur = $_GET['epaisseur'];
                $nbbobine = $_GET['nbbobine'];
                $lieutransfert = $_GET['lieutransfert'];
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
            //}

            header("location: detailsReception.php?idreception=$_GET[idreceptionDemandeAccepter]");
            exit;
        }
    // Fin admin permet de donner la main au responsable du pont bascule

?>