<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
//include "./mailTransfert.php";


//Variables
    $PoidsConsommeTotal = 0;
    $RebusTotal = 0;
    $PoidsProduitTotal = 0;
    $TempsArretTotal = 0;
    $TempsFonctionTotal = 0;

$datefichedresseuse = $_GET['dateCreation'];  // On recupére l'ID de la réception par get

/** Quart 1 */
    /** Dresseuse 1 Q1 */
        //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 1' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD1Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD1Q1) {

            $IdproductiondresD1Q1 = $productionDresD1Q1['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD1Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD1Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD1Q1 as $arretD1Q1){
                    if(((strtotime($arretD1Q1['finarret']) - strtotime($arretD1Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD1Q1['finarret']) - strtotime($arretD1Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD1Q1['debutarret']) + strtotime($arretD1Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD1Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD1Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse1 Q1 */

    /** Dresseuse 2 Q1 */
        //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 2' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD2Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD2Q1) {

            $IdproductiondresD2Q1 = $productionDresD2Q1['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD2Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD2Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD2Q1 as $arretD2Q1){
                    if(((strtotime($arretD2Q1['finarret']) - strtotime($arretD2Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD2Q1['finarret']) - strtotime($arretD2Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD2Q1['debutarret']) + strtotime($arretD2Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD2Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD2Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 2 Q1 */

    /** Dresseuse 4 Q1 */
        //** Debut select de la production (Pour dresseuse 4)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 4' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD4Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD4Q1) {

            $IdproductiondresD4Q1 = $productionDresD4Q1['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD4Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD4Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD4Q1 as $arretD4Q1){
                    if(((strtotime($arretD4Q1['finarret']) - strtotime($arretD4Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD4Q1['finarret']) - strtotime($arretD4Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD4Q1['debutarret']) + strtotime($arretD4Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD4Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD4Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 4 Q1 */

    /** Dresseuse 5 Q1 */
        //** Debut select de la production (Pour dresseuse 4)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 5' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD5Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD5Q1) {

            $IdproductiondresD5Q1 = $productionDresD5Q1['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD5Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD5Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD5Q1 as $arretD5Q1){
                    if(((strtotime($arretD5Q1['finarret']) - strtotime($arretD5Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD5Q1['finarret']) - strtotime($arretD5Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD5Q1['debutarret']) + strtotime($arretD5Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD5Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD5Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 5 Q1 */
    
    /** Dresseuse 6 Q1 */
        //** Debut select de la production (Pour dresseuse 6)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 6' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD6Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD6Q1) {

            $IdproductiondresD6Q1 = $productionDresD6Q1['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD6Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD6Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD6Q1 as $arretD6Q1){
                    if(((strtotime($arretD6Q1['finarret']) - strtotime($arretD6Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD6Q1['finarret']) - strtotime($arretD6Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD6Q1['debutarret']) + strtotime($arretD6Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD6Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD6Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 6 Q1 */

    /** Dresseuse 7 Q1 */
        //** Debut select de la production (Pour dresseuse 7)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 7' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD7Q1 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD7Q1) {

            $IdproductiondresD7Q1 = $productionDresD7Q1['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD7Q1 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD7Q1 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD7Q1 as $arretD7Q1){
                    if(((strtotime($arretD7Q1['finarret']) - strtotime($arretD7Q1['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD7Q1['finarret']) - strtotime($arretD7Q1['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD7Q1['debutarret']) + strtotime($arretD7Q1['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD7Q1 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD7Q1 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 7 Q1 */
   
/** Fin Quart 1 */

/** Quart 2 */
    /** Dresseuse 1 Q2 */
        //** Debut select de la production (Pour cranteuse 1)
        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 1' and `quart`='2';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productionDresD1Q2 = $query->fetch();
    //** Fin select de la production 

    if ($productionDresD1Q2) {

        $IdproductiondresD1Q2 = $productionDresD1Q2['idfichedresseuse'];    // Id de productioncrantC1Q1

        //** Debut select de la production (consommation)
            $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q2;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsD1Q2 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q2;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsD1Q2 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsD1Q2 as $arretD1Q2){
                if(((strtotime($arretD1Q2['finarret']) - strtotime($arretD1Q2['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretD1Q2['finarret']) - strtotime($arretD1Q2['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretD1Q2['debutarret']) + strtotime($arretD1Q2['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelD1Q2 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q2;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsD1Q2 = $query->fetchAll();
        //** Fin select de la production 
    }
    /** Fin Dresseuse1 Q2 */

    /** Dresseuse 2 Q2 */
        //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 2' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD2Q2 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD2Q2) {

            $IdproductiondresD2Q2 = $productionDresD2Q2['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD2Q2 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD2Q2 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD2Q2 as $arretD2Q2){
                    if(((strtotime($arretD2Q2['finarret']) - strtotime($arretD2Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD2Q2['finarret']) - strtotime($arretD2Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD2Q2['debutarret']) + strtotime($arretD2Q2['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD2Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD2Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 2 Q2 */

    /** Dresseuse 4 Q2 */
        //** Debut select de la production (Pour dresseuse 4)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 4' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD4Q2 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD4Q2) {

            $IdproductiondresD4Q2 = $productionDresD4Q2['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD4Q2 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD4Q2 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD4Q2 as $arretD4Q2){
                    if(((strtotime($arretD4Q2['finarret']) - strtotime($arretD4Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD4Q2['finarret']) - strtotime($arretD4Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD4Q2['debutarret']) + strtotime($arretD4Q2['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD4Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD4Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 4 Q2 */

    /** Dresseuse 5 Q2 */
        //** Debut select de la production (Pour dresseuse 4)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 5' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD5Q2 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD5Q2) {

            $IdproductiondresD5Q2 = $productionDresD5Q2['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD5Q2 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD5Q2 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD5Q2 as $arretD5Q2){
                    if(((strtotime($arretD5Q2['finarret']) - strtotime($arretD5Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD5Q2['finarret']) - strtotime($arretD5Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD5Q2['debutarret']) + strtotime($arretD5Q2['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD5Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD5Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 5 Q2 */

    /** Dresseuse 6 Q2 */
        //** Debut select de la production (Pour dresseuse 6)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 6' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD6Q2 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD6Q2) {

            $IdproductiondresD6Q2 = $productionDresD6Q2['idfichedresseuse'];    // Id de prodDress

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD6Q2 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD6Q2 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD6Q2 as $arretD6Q2){
                    if(((strtotime($arretD6Q2['finarret']) - strtotime($arretD6Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD6Q2['finarret']) - strtotime($arretD6Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD6Q2['debutarret']) + strtotime($arretD6Q2['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD6Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD6Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 6 Q2 */

    /** Dresseuse 7 Q2 */
        //** Debut select de la production (Pour dresseuse 7)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 7' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD7Q2 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD7Q2) {

            $IdproductiondresD7Q2 = $productionDresD7Q2['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD7Q2 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD7Q2 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD7Q2 as $arretD7Q2){
                    if(((strtotime($arretD7Q2['finarret']) - strtotime($arretD7Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD7Q2['finarret']) - strtotime($arretD7Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD7Q2['debutarret']) + strtotime($arretD7Q2['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD7Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q2;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD7Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 7 Q2 */

/** Fin Quart 2 */

/** Quart 3 */
    /** Dresseuse 1 Q1 */
        //** Debut select de la production (Pour cranteuse 1)
        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 1' and `quart`='3';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productionDresD1Q3 = $query->fetch();
    //** Fin select de la production 

    if ($productionDresD1Q3) {

        $IdproductiondresD1Q3 = $productionDresD1Q3['idfichedresseuse'];    // Id de productioncrantC1Q1

        //** Debut select de la production (consommation)
            $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsD1Q3 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsD1Q3 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsD1Q3 as $arretD1Q3){
                if(((strtotime($arretD1Q3['finarret']) - strtotime($arretD1Q3['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretD1Q3['finarret']) - strtotime($arretD1Q3['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretD1Q3['debutarret']) + strtotime($arretD1Q3['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelD1Q3 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsD1Q3 = $query->fetchAll();
        //** Fin select de la production 
    }
/** Fin Dresseuse1 Q3 */

/** Dresseuse 2 Q3 */
    //** Debut select de la production (Pour cranteuse 1)
        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 2' and `quart`='3';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productionDresD2Q3 = $query->fetch();
    //** Fin select de la production 

    if ($productionDresD2Q3) {

        $IdproductiondresD2Q3 = $productionDresD2Q3['idfichedresseuse'];    // Id de productioncrantC1Q1

        //** Debut select de la production (consommation)
            $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsD2Q3 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsD2Q3 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsD2Q3 as $arretD2Q3){
                if(((strtotime($arretD2Q3['finarret']) - strtotime($arretD2Q3['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretD2Q3['finarret']) - strtotime($arretD2Q3['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretD2Q3['debutarret']) + strtotime($arretD2Q3['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelD2Q3 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsD2Q3 = $query->fetchAll();
        //** Fin select de la production 
    }
/** Fin Dresseuse 2 Q3 */

/** Dresseuse 4 Q3 */
    //** Debut select de la production (Pour dresseuse 4)
        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 4' and `quart`='3';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productionDresD4Q3 = $query->fetch();
    //** Fin select de la production 

    if ($productionDresD4Q3) {

        $IdproductiondresD4Q3 = $productionDresD4Q3['idfichedresseuse'];    // Id de product

        //** Debut select de la production (consommation)
            $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsD4Q3 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsD4Q3 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsD4Q3 as $arretD4Q3){
                if(((strtotime($arretD4Q3['finarret']) - strtotime($arretD4Q3['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretD4Q3['finarret']) - strtotime($arretD4Q3['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretD4Q3['debutarret']) + strtotime($arretD4Q3['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelD4Q3 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsD4Q3 = $query->fetchAll();
        //** Fin select de la production 
    }
/** Fin Dresseuse 4 Q3 */

/** Dresseuse 5 Q3 */
    //** Debut select de la production (Pour dresseuse 4)
        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 5' and `quart`='3';";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productionDresD5Q3 = $query->fetch();
    //** Fin select de la production 

    if ($productionDresD5Q3) {

        $IdproductiondresD5Q3 = $productionDresD5Q3['idfichedresseuse'];    // Id de product

        //** Debut select de la production (consommation)
            $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $consommationsD5Q3 = $query->fetchAll();
        //** Fin select de la production 

        //** Debut select de la production (arret)
            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $arretsD5Q3 = $query->fetchAll();
        //** Fin select de la production

        $TotalArretH = null;
        // Calcul du temps d'arret
            foreach($arretsD5Q3 as $arretD5Q3){
                if(((strtotime($arretD5Q3['finarret']) - strtotime($arretD5Q3['debutarret'])) > 0)){
                    $TotalArretH +=  (strtotime($arretD5Q3['finarret']) - strtotime($arretD5Q3['debutarret']));
                }else{
                    $TotalArretH +=  (-strtotime($arretD5Q3['debutarret']) + strtotime($arretD5Q3['finarret']));
                }
            }

            $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
            $TotalArretHReelD5Q3 = explode(":",date("H:i",$TotalArretH) );
        // Fin calcul du temps d'arret


        //** Debut select de la production (prod)
            $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q3;";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionsD5Q3 = $query->fetchAll();
        //** Fin select de la production 
    }
    /** Fin Dresseuse 5 Q3 */

    /** Dresseuse 6 Q3 */
        //** Debut select de la production (Pour dresseuse 6)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 6' and `quart`='3';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD6Q3 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD6Q3) {

            $IdproductiondresD6Q3 = $productionDresD6Q3['idfichedresseuse'];    // Id de productioncrantC1Q1

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD6Q3 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD6Q3 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD6Q3 as $arretD6Q3){
                    if(((strtotime($arretD6Q3['finarret']) - strtotime($arretD6Q3['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD6Q3['finarret']) - strtotime($arretD6Q3['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD6Q3['debutarret']) + strtotime($arretD6Q3['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD6Q3 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD6Q3 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 6 Q3 */

    /** Dresseuse 7 Q3 */
        //** Debut select de la production (Pour dresseuse 7)
            $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse' and `machine`='Dresseuse 7' and `quart`='3';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionDresD7Q3 = $query->fetch();
        //** Fin select de la production 

        if ($productionDresD7Q3) {

            $IdproductiondresD7Q3 = $productionDresD7Q3['idfichedresseuse'];    // Id de product

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsD7Q3 = $query->fetchAll();
            //** Fin select de la production 

            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $arretsD7Q3 = $query->fetchAll();
            //** Fin select de la production

            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsD7Q3 as $arretD7Q3){
                    if(((strtotime($arretD7Q3['finarret']) - strtotime($arretD7Q3['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretD7Q3['finarret']) - strtotime($arretD7Q3['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretD7Q3['debutarret']) + strtotime($arretD7Q3['finarret']));
                    }
                }

                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelD7Q3 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret


            //** Debut select de la production (prod)
                $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q3;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsD7Q3 = $query->fetchAll();
            //** Fin select de la production 
        }
    /** Fin Dresseuse 7 Q3 */

/** Fin Quart 3 */



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

    <link href="../../StyleLoad.css" rel="stylesheet">

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

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php $activeEtatProduction = "active"; ?>

        <!-- Contient la nav bar gauche -->
            <?php include "./navGaucheDresseuse.php" ?>
        <!-- End  -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                 <!-- Topbar -->
                 <nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="mb-3">
                        <div class="col-xl-9 col-md-8 mb-1">
                        <img src="../../image/logoAppli.jpg" class="img-fluid mx-auto d-block text-center" alt="" style="border-radius: 50%; margin:20px; opacity: 1;" width="200">
                        </div>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../../indexPage/img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../../indexPage/img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="../../indexPage/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['nomcomplet']; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="../../indexPage/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#InformationProfile" title="Voir votre profile" class="dropdown-item">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <?php if($_SESSION['niveau']=='admin'){ ?>
                                    <a class="dropdown-item" href="../../indexPage/Utilisateur/ParametreUtilisateur.php?idUser=<?php echo $_SESSION['id']; ?>">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Changer paramétres
                                    </a>
                                <?php } ?>
                                <a class="dropdown-item" href="../../indexPage/Utilisateur/utilisateur.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Gestion des utilisateurs
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activités
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../../index.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </li>

                    </ul>
                    <!-- Pour le status !--> 
                    <div class="modal fade " id="InformationProfile" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                        <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                            <div class="modal-content">
                                <div class="card">
                                    <div class="card-header bg-primary">
                                    </div>
                                    <div class="card-body">
                                        <img src="../../image/avatar.jpg" class="img-fluid mx-auto d-block text-center" alt="" style="border-radius: 45%; margin-top:-3%; opacity: 0.9;" width="150">
                                        <h5 class="card-title mt-2 mb-5 text-center"><?php echo $_SESSION['nomcomplet']; ?></h5>
                                        <p class="card-text"><h6 class="d-inline mr-3">Email :</h6><?php echo $_SESSION['email']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Section :</h6> <?php echo $_SESSION['section']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Matricule :</h6> <?php echo $_SESSION['matricule']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Nom d'utilisateur :</h6> <?php echo $_SESSION['username']; ?></p>
                                        <p class="card-text"><h6 class="d-inline mr-3">Numéro téléphone :</h6> <?php echo $_SESSION['numTelephone']; ?></p>
                                        <div class="col text-center">
                                            <a href="" class="btn btn-primary text-center">Retour</a>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-primary text-muted text-center">
                                        <h5 style="color:white">METAL *** AFRIQUE</h5>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->

                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-1">
                            <img src="../../image/fer-a-beton.jpg" class="img-fluid" alt="" style="border-radius: 50%; margin:20px; opacity: 0.9;" width="200">
                        </div>
                    </div>

                    <!--
                        <div class="d-sm-flex align-items-end justify-content-end mb-4 mr-3">
                            <a href="pdfEtatDresseuse.php?dateCreation=<?php echo $_GET['dateCreation'];?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Génerer en PDF</a>
                        </div>
                    -->
                    <!-- Fade In Utility -->
                    <div class="col-lg-12">
                        <div class="card position-relative">
                            <div class="card-header py-3 bg-primary">
                                <p class="m-0 font-weight-bold text-center h2 text-uppercase mt-2 mb-3" style="color: white;">Etat DE PRODUCTION journalier - section dresseuse </p>
                                <p class="m-0 font-weight-bold text-center h2 text-uppercase mt-2 mb-5" style="color: white;"><span class="mr-4">journee du : </span> <?php echo date("l j F Y", strtotime($_GET['dateCreation'])); ?></p>
                                <div class="">                                </div>
                                    <!--<p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Début quart : </span> <?php echo $Cranteuseq1['heuredepartquart']; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Fin quart : </span> <?php echo $Cranteuseq1['heurefinquart']; ?></p>
                                    <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-4">Contrôleurs : </span> <?php echo $Cranteuseq1['controleur1']." / ".$Cranteuseq1['controleur2']." / ".$Cranteuseq1['controleur3']; ?></p>
                                </div>
                                <p class="m-0 mb-3 h5 mt-3 ml-3 d-inline" style="color: white; padding-right: 30%;"><span class="mr-4">Compteur Horaire Début : </span> <?php echo $Cranteuseq1['compteurdebut']; ; ?></p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-4">Observations (Début) : </span> <?php echo $Cranteuseq1['observationdebut']; ; ?></p>
                                <p class="m-0 mt-3  h5 ml-3" style="color: white;"><span class="mr-5">Compteur Horaire Fin : </span> <?php echo $Cranteuseq1['compteurfin']; ; ?></p>-->
                            </div>

                            <!-- Debut quart1 -->
                            <?php
                                if($productionDresD1Q1 || $productionDresD2Q1 || $productionDresD4Q1 || $productionDresD5Q1 || $productionDresD6Q1 || $productionDresD7Q1){
                            ?>
                                <div class="bg-secondary bg-gradient mt-3">
                                    <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 1</p>
                                </div>
                            <?php
                                }
                            ?>
                            <div class="row m-1 mb-3 col-lg-12">
                                <div class="table-responsive col-lg-12">
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
                                    <!-- Debut D1Q1 -->
                                        <?php
                                            if($productionDresD1Q1){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD1Q1['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 1</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD1Q1" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD1Q1 as $consommationD1Q1){
                                                                $PoidsConsommeTotal += $consommationD1Q1['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD1Q1['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD1Q1['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD1Q1 as $productionD1Q1){
                                                                $PoidsProduitTotal += $productionD1Q1['prodpoids'];
                                                                $RebusTotal += $productionD1Q1['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD1Q1['prodnbBarreColis']*$productionD1Q1['prodnbcolis'])+$productionD1Q1['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q1['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD1Q1['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD1Q1['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD1Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline mb-5"><?= ($TotalArretHReelD1Q1[0]-1)." H ".$TotalArretHReelD1Q1[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD1Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q1;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD1Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 1 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD1Q1['compteurdebut'] ?> /  fin : <?= $productionDresD1Q1['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q1['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q1['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q1['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    <!-- Fin D1Q1 -->

                                    <!-- Debut D2Q1 -->
                                    <?php
                                            if($productionDresD2Q1){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD2Q1['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 2</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD2Q1" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD2Q1 as $consommationD2Q1){
                                                                $PoidsConsommeTotal += $consommationD2Q1['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD2Q1['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD2Q1['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD2Q1 as $productionD2Q1){
                                                                $PoidsProduitTotal += $productionD2Q1['prodpoids'];
                                                                $RebusTotal += $productionD2Q1['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD2Q1['prodnbBarreColis']*$productionD2Q1['prodnbcolis'])+$productionD2Q1['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q1['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD2Q1['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD2Q1['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD2Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD2Q1[0]-1)." H ".$TotalArretHReelD2Q1[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD2Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 2 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q1;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD2Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 2 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD2Q1['compteurdebut'] ?> /  fin : <?= $productionDresD2Q1['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q1['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q1['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q1['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    <!-- Fin D2Q1 -->

                                    <!-- Debut D4Q1 -->
                                    <?php
                                            if($productionDresD4Q1){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD4Q1['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 4</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD4Q1" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD4Q1 as $consommationD4Q1){
                                                                $PoidsConsommeTotal += $consommationD4Q1['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD4Q1['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD4Q1['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD4Q1 as $productionD4Q1){
                                                                $PoidsProduitTotal += $productionD4Q1['prodpoids'];
                                                                $RebusTotal += $productionD4Q1['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD4Q1['prodnbBarreColis']*$productionD4Q1['prodnbcolis'])+$productionD4Q1['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q1['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD4Q1['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD4Q1['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD4Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD4Q1[0]-1)." H ".$TotalArretHReelD4Q1[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD4Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 4 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q1;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD4Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 4 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD4Q1['compteurdebut'] ?> /  fin : <?= $productionDresD4Q1['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q1['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q1['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q1['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    <!-- Fin D4Q1 -->

                                    <!-- Debut D5Q1 -->
                                    <?php
                                            if($productionDresD5Q1){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD5Q1['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 5</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD5Q1" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD5Q1 as $consommationD5Q1){
                                                                $PoidsConsommeTotal += $consommationD5Q1['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD5Q1['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD5Q1['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD5Q1 as $productionD5Q1){
                                                                $PoidsProduitTotal += $productionD5Q1['prodpoids'];
                                                                $RebusTotal += $productionD5Q1['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD5Q1['prodnbBarreColis']*$productionD5Q1['prodnbcolis'])+$productionD5Q1['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q1['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD5Q1['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD5Q1['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD5Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD5Q1[0]-1)." H ".$TotalArretHReelD5Q1[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD5Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 5 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q1;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD5Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 5 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD5Q1['compteurdebut'] ?> /  fin : <?= $productionDresD5Q1['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q1['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q1['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q1['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    <!-- Fin D5Q1 -->

                                    <!-- Debut D6Q1 -->
                                    <?php
                                            if($productionDresD6Q1){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD6Q1['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 6</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD6Q1" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD6Q1 as $consommationD6Q1){
                                                                $PoidsConsommeTotal += $consommationD6Q1['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD6Q1['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD6Q1['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD6Q1 as $productionD6Q1){
                                                                $PoidsProduitTotal += $productionD6Q1['prodpoids'];
                                                                $RebusTotal += $productionD6Q1['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD6Q1['prodnbBarreColis']*$productionD6Q1['prodnbcolis'])+$productionD6Q1['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q1['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD6Q1['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD6Q1['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD6Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD6Q1[0]-1)." H ".$TotalArretHReelD6Q1[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD6Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q1;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>                                          
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD6Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 6 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD6Q1['compteurdebut'] ?> /  fin : <?= $productionDresD6Q1['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q1['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q1['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q1['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    <!-- Fin D6Q1 -->

                                    <!-- Debut D7Q1 -->
                                    <?php
                                        if($productionDresD7Q1){
                                    ?>
                                        <div class="">
                                            <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD7Q1['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 7</p></a>
                                            <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD7Q1" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                        </div>

                                        <div class="row">
                                            <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Consommations (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($consommationsD7Q1 as $consommationD7Q1){
                                                            $PoidsConsommeTotal += $consommationD7Q1['poids'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationD7Q1['poids'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $consommationD7Q1['diametre'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Productions (KG)</th>                                                                                
                                                        <th>Diametres</th>
                                                        <th>Nombre barres par colis</th>
                                                        <th>Nombre de colis</th> 
                                                        <th>Nombre barres restant</th>
                                                        <th>Total barres</th>
                                                        <th>Longueur barres (m)</th> 
                                                        <th>Rebus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($productionsD7Q1 as $productionD7Q1){
                                                            $PoidsProduitTotal += $productionD7Q1['prodpoids'];
                                                            $RebusTotal += $productionD7Q1['proddechet'];
                                                    ?>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['prodpoids'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['proddiametre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['prodnbBarreColis'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['prodnbcolis'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['prodnbbarrerestant'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= ($productionD7Q1['prodnbBarreColis']*$productionD7Q1['prodnbcolis'])+$productionD7Q1['prodnbbarrerestant']  ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['prodlongueurbarre'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q1['proddechet'] ?></td>
                                                        </tr>
                                                    <!-- Pour le sweetAlert approuveTransfert !--> 
                                                    <?php
                                                        }
                                                    ?> 
                                                </tbody>
                                            </table>
                                            <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>       
                                                        <th>Heure début</th>                                                                                
                                                        <th>Heure Fin</th>
                                                        <th>Temps d'arret total</th>   
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productionDresD7Q1['heuredepartquart'] ?></td>
                                                        <td style="background-color:#4e73df ; color:white;"><?= $productionDresD7Q1['heurefinquart'] ?></td>
                                                        <?php
                                                            //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                        ?>
                                                        <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                            <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD7Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD7Q1[0]-1)." H ".$TotalArretHReelD7Q1[1]." min" ?></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Bouton et pagnination--> 
                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                        <div class="modal fade " id="InformationArretD7Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <?php
                                                                    //** Debut select de la production (arret)
                                                                        $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q1;";

                                                                        // On prépare la requête
                                                                        $query = $db->prepare($sql);

                                                                        // On exécute
                                                                        $query->execute();

                                                                        // On récupère les valeurs dans un tableau associatif
                                                                        $arrets = $query->fetchAll();
                                                                    //** Fin select de la production
                                                                ?>

                                                                <?php
                                                                    foreach($arrets as $arret => $key){
                                                                        ?>
                                                                            <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                            <div class="col text-center">
                                                                <a href="" class="btn btn-primary text-center">Retour</a>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer bg-primary text-muted text-center">
                                                            <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>                                            
                                        <!-- Info production --> 
                                        <div class="modal fade " id="InformationProdD2Q1" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                            <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                <div class="modal-content">
                                                    <div class="card">
                                                        <div class="card-header bg-primary text-center">
                                                            <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 7 :</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="col-lg-12 mt-5 mb-5">
                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD7Q1['compteurdebut'] ?> /  fin : <?= $productionDresD7Q1['compteurfin'] ?></span></p>
                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q1['controleur1'] ?></span></p>
                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q1['controleur2'] ?></span></p>
                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q1['observationfin']  ?></span></p>
                                                            </div>
                                                            <div class="col text-center">
                                                                <a href="" class="btn btn-primary text-center">Retour</a>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer bg-primary text-muted text-center">
                                                            <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                    <?php
                                        }
                                    ?>   
                                </div>
                                <!-- Fin D7Q1 -->
                            </div>
                            <!-- Fin quart1 -->


                            <!-- Début quart2 -->
                                <?php
                                    if($productionDresD1Q2 || $productionDresD2Q2 || $productionDresD4Q2 || $productionDresD5Q2 || $productionDresD6Q2 || $productionDresD7Q2){
                                ?>
                                    <div class="bg-secondary bg-gradient mt-3">
                                        <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 2</p>
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="row m-1 mb-3 col-lg-12">
                                    <div class="table-responsive col-lg-12">
                                        <!-- Debut D1Q2 -->
                                            <?php
                                                if($productionDresD1Q2){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD1Q2['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 1</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD1Q2" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD1Q2 as $consommationD1Q2){
                                                                    $PoidsConsommeTotal += $consommationD1Q2['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD1Q2['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD1Q2['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD1Q2 as $productionD1Q2){
                                                                    $PoidsProduitTotal += $productionD1Q2['prodpoids'];
                                                                    $RebusTotal += $productionD1Q2['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD1Q2['prodnbBarreColis']*$productionD1Q2['prodnbcolis'])+$productionD1Q2['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q2['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD1Q2['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD1Q2['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD1Q2" title="Voir details des temps d'arret" class="link-offset-2 link-underline mb-5"><?= ($TotalArretHReelD1Q2[0]-1)." H ".$TotalArretHReelD1Q2[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD1Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q2;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD1Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 1 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD1Q2['compteurdebut'] ?> /  fin : <?= $productionDresD1Q2['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q2['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q2['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q2['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D1Q2 -->

                                        <!-- Debut D2Q2 -->
                                        <?php
                                                if($productionDresD2Q2){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD2Q2['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 2</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD2Q2" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD2Q2 as $consommationD2Q2){
                                                                    $PoidsConsommeTotal += $consommationD2Q2['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD2Q2['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD2Q2['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD2Q2 as $productionD2Q2){
                                                                    $PoidsProduitTotal += $productionD2Q2['prodpoids'];
                                                                    $RebusTotal += $productionD2Q2['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD2Q2['prodnbBarreColis']*$productionD2Q2['prodnbcolis'])+$productionD2Q2['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q2['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD2Q2['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD2Q2['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD2Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD2Q2[0]-1)." H ".$TotalArretHReelD2Q2[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD2Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 2 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q2;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD2Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 2 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD2Q2['compteurdebut'] ?> /  fin : <?= $productionDresD2Q2['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q2['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q2['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q2['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D2Q2 -->

                                        <!-- Debut D4Q2 -->
                                        <?php
                                                if($productionDresD4Q2){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD4Q2['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 4</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD4Q2" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD4Q2 as $consommationD4Q2){
                                                                    $PoidsConsommeTotal += $consommationD4Q2['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD4Q2['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD4Q2['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD4Q2 as $productionD4Q2){
                                                                    $PoidsProduitTotal += $productionD4Q2['prodpoids'];
                                                                    $RebusTotal += $productionD4Q2['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD4Q2['prodnbBarreColis']*$productionD4Q2['prodnbcolis'])+$productionD4Q2['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q2['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD4Q2['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD4Q2['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD4Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD4Q2[0]-1)." H ".$TotalArretHReelD4Q2[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD4Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 4 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q2;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD4Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 4 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD4Q2['compteurdebut'] ?> /  fin : <?= $productionDresD4Q2['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q2['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q2['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q2['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D4Q2 -->

                                        <!-- Debut D5Q2 -->
                                        <?php
                                                if($productionDresD5Q2){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD5Q2['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 5</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD5Q2" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD5Q2 as $consommationD5Q2){
                                                                    $PoidsConsommeTotal += $consommationD5Q2['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD5Q2['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD5Q2['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD5Q2 as $productionD5Q2){
                                                                    $PoidsProduitTotal += $productionD5Q2['prodpoids'];
                                                                    $RebusTotal += $productionD5Q2['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD5Q2['prodnbBarreColis']*$productionD5Q2['prodnbcolis'])+$productionD5Q2['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q2['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD5Q2['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD5Q2['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD5Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD5Q2[0]-1)." H ".$TotalArretHReelD5Q2[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD5Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 5 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q2;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD5Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 5 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD5Q2['compteurdebut'] ?> /  fin : <?= $productionDresD5Q2['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q2['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q2['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q2['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D5Q2 -->

                                        <!-- Debut D6Q2 -->
                                        <?php
                                                if($productionDresD6Q2){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD6Q2['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 6</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD6Q2" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD6Q2 as $consommationD6Q2){
                                                                    $PoidsConsommeTotal += $consommationD6Q2['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD6Q2['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD6Q2['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD6Q2 as $productionD6Q2){
                                                                    $PoidsProduitTotal += $productionD6Q2['prodpoids'];
                                                                    $RebusTotal += $productionD6Q2['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD6Q2['prodnbBarreColis']*$productionD6Q2['prodnbcolis'])+$productionD6Q2['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q2['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD6Q2['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD6Q2['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD6Q2" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD6Q2[0]-1)." H ".$TotalArretHReelD6Q2[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD6Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q2;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>                                          
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD6Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 6 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD6Q2['compteurdebut'] ?> /  fin : <?= $productionDresD6Q2['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q2['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q2['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q2['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D6Q1 -->

                                        <!-- Debut D7Q1 -->
                                        <?php
                                            if($productionDresD7Q2){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD7Q2['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 7</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD7Q2" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD7Q2 as $consommationD7Q2){
                                                                $PoidsConsommeTotal += $consommationD7Q2['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD7Q2['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD7Q2['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD7Q2 as $productionD7Q2){
                                                                $PoidsProduitTotal += $productionD7Q2['prodpoids'];
                                                                $RebusTotal += $productionD7Q2['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD7Q2['prodnbBarreColis']*$productionD7Q2['prodnbcolis'])+$productionD7Q2['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q2['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD7Q2['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD7Q2['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD7Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD7Q2[0]-1)." H ".$TotalArretHReelD7Q2[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD7Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q2;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>                                            
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD2Q2" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 7 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD7Q2['compteurdebut'] ?> /  fin : <?= $productionDresD7Q2['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q2['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q2['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q2['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    </div>
                                    <!-- Fin D7Q2 -->
                                </div>
                            <!-- Fin quart2 -->

                            <!-- Début quart3 -->
                                <?php
                                    if($productionDresD1Q3 || $productionDresD2Q3 || $productionDresD4Q3 || $productionDresD5Q3 || $productionDresD6Q3 || $productionDresD7Q3){
                                ?>
                                    <div class="bg-secondary bg-gradient mt-3">
                                        <p class="font-weight-bold  text-center h2 text-uppercase mt-2 mb-2 text-light">Quart 3</p>
                                    </div>
                                <?php
                                    }
                                ?>
                                <div class="row m-1 mb-3 col-lg-12">
                                    <div class="table-responsive col-lg-12">
                                        <!-- Debut D1Q3 -->
                                            <?php
                                                if($productionDresD1Q3){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD1Q3['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 1</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD1Q3" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD1Q3 as $consommationD1Q3){
                                                                    $PoidsConsommeTotal += $consommationD1Q3['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD1Q3['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD1Q3['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD1Q3 as $productionD1Q3){
                                                                    $PoidsProduitTotal += $productionD1Q3['prodpoids'];
                                                                    $RebusTotal += $productionD1Q3['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD1Q3['prodnbBarreColis']*$productionD1Q3['prodnbcolis'])+$productionD1Q3['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD1Q3['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD1Q3['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD1Q3['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD1Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline mb-5"><?= ($TotalArretHReelD1Q3[0]-1)." H ".$TotalArretHReelD1Q3[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD1Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD1Q3;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD1Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 1 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD1Q3['compteurdebut'] ?> /  fin : <?= $productionDresD1Q3['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q3['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q3['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD1Q3['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D1Q3 -->

                                        <!-- Debut D2Q3 -->
                                        <?php
                                                if($productionDresD2Q3){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD2Q3['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 2</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD2Q3" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD2Q3 as $consommationD2Q3){
                                                                    $PoidsConsommeTotal += $consommationD2Q3['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD2Q3['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD2Q3['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD2Q3 as $productionD2Q3){
                                                                    $PoidsProduitTotal += $productionD2Q3['prodpoids'];
                                                                    $RebusTotal += $productionD2Q3['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD2Q3['prodnbBarreColis']*$productionD2Q3['prodnbcolis'])+$productionD2Q3['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD2Q3['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD2Q3['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD2Q3['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD2Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD2Q3[0]-1)." H ".$TotalArretHReelD2Q3[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD2Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 2 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD2Q3;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD2Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 2 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD2Q3['compteurdebut'] ?> /  fin : <?= $productionDresD2Q3['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q3['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q3['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD2Q3['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D2Q3 -->

                                        <!-- Debut D4Q3 -->
                                        <?php
                                                if($productionDresD4Q3){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD4Q3['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 4</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD4Q3" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD4Q3 as $consommationD4Q3){
                                                                    $PoidsConsommeTotal += $consommationD4Q3['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD4Q3['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD4Q3['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD4Q3 as $productionD4Q3){
                                                                    $PoidsProduitTotal += $productionD4Q3['prodpoids'];
                                                                    $RebusTotal += $productionD4Q3['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD4Q3['prodnbBarreColis']*$productionD4Q3['prodnbcolis'])+$productionD4Q3['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD4Q3['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD4Q3['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD4Q3['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD4Q1" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD4Q3[0]-1)." H ".$TotalArretHReelD4Q3[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD4Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 4 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD4Q3;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD4Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 4 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD4Q3['compteurdebut'] ?> /  fin : <?= $productionDresD4Q3['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q3['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q3['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD4Q3['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D4Q3 -->

                                        <!-- Debut D5Q3 -->
                                        <?php
                                                if($productionDresD5Q3){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD5Q3['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 5</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD5Q3" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD5Q3 as $consommationD5Q3){
                                                                    $PoidsConsommeTotal += $consommationD5Q3['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD5Q3['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD5Q3['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres </th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD5Q3 as $productionD5Q3){
                                                                    $PoidsProduitTotal += $productionD5Q3['prodpoids'];
                                                                    $RebusTotal += $productionD5Q3['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD5Q3['prodnbBarreColis']*$productionD5Q3['prodnbcolis'])+$productionD5Q3['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD5Q3['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD5Q3['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD5Q3['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD5Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD5Q3[0]-1)." H ".$TotalArretHReelD5Q3[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD5Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 5 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD5Q3;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD5Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 5 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD5Q3['compteurdebut'] ?> /  fin : <?= $productionDresD5Q3['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q3['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q3['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD5Q3['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D5Q3 -->

                                        <!-- Debut D6Q3 -->
                                        <?php
                                                if($productionDresD6Q3){
                                            ?>
                                                <div class="">
                                                    <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD6Q3['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 6</p></a>
                                                    <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD6Q3" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                                </div>

                                                <div class="row">
                                                    <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Consommations (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($consommationsD6Q3 as $consommationD6Q3){
                                                                    $PoidsConsommeTotal += $consommationD6Q3['poids'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD6Q3['poids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $consommationD6Q3['diametre'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Productions (KG)</th>                                                                                
                                                                <th>Diametres</th>
                                                                <th>Nombre barres par colis</th>
                                                                <th>Nombre de colis</th> 
                                                                <th>Nombre barres restant</th>
                                                                <th>Total barres</th>
                                                                <th>Longueur barres (m)</th> 
                                                                <th>Rebus</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                foreach($productionsD6Q3 as $productionD6Q3){
                                                                    $PoidsProduitTotal += $productionD6Q3['prodpoids'];
                                                                    $RebusTotal += $productionD6Q3['proddechet'];
                                                            ?>
                                                                <tr>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['prodpoids'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['proddiametre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['prodnbBarreColis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['prodnbcolis'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['prodnbbarrerestant'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= ($productionD6Q3['prodnbBarreColis']*$productionD6Q3['prodnbcolis'])+$productionD6Q3['prodnbbarrerestant']  ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['prodlongueurbarre'] ?></td>
                                                                    <td style="background-color:#4e73df ; color:white;"><?= $productionD6Q3['proddechet'] ?></td>
                                                                </tr>
                                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                                            <?php
                                                                }
                                                            ?> 
                                                        </tbody>
                                                    </table>
                                                    <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>       
                                                                <th>Heure début</th>                                                                                
                                                                <th>Heure Fin</th>
                                                                <th>Temps d'arret total</th>   
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD6Q3['heuredepartquart'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionDresD6Q3['heurefinquart'] ?></td>
                                                                <?php
                                                                    //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                                ?>
                                                                <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                    <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD6Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD6Q3[0]-1)." H ".$TotalArretHReelD6Q3[1]." min" ?></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- Bouton et pagnination--> 
                                                <!-- Pour le sweetAlert approuveTransfert !--> 
                                                <div class="modal fade " id="InformationArretD6Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <?php
                                                                            //** Debut select de la production (arret)
                                                                                $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD6Q3;";

                                                                                // On prépare la requête
                                                                                $query = $db->prepare($sql);

                                                                                // On exécute
                                                                                $query->execute();

                                                                                // On récupère les valeurs dans un tableau associatif
                                                                                $arrets = $query->fetchAll();
                                                                            //** Fin select de la production
                                                                        ?>

                                                                        <?php
                                                                            foreach($arrets as $arret => $key){
                                                                                ?>
                                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>                                          
                                                <!-- Info production --> 
                                                <div class="modal fade " id="InformationProdD6Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                    <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                        <div class="modal-content">
                                                            <div class="card">
                                                                <div class="card-header bg-primary text-center">
                                                                    <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 6 :</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="col-lg-12 mt-5 mb-5">
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD6Q3['compteurdebut'] ?> /  fin : <?= $productionDresD6Q3['compteurfin'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q3['controleur1'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q3['controleur2'] ?></span></p>
                                                                        <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD6Q3['observationfin']  ?></span></p>
                                                                    </div>
                                                                    <div class="col text-center">
                                                                        <a href="" class="btn btn-primary text-center">Retour</a>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer bg-primary text-muted text-center">
                                                                    <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                                </div>
                                                            </div>
                                                        </div>    
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            ?>   
                                        <!-- Fin D6Q3 -->

                                        <!-- Debut D7Q3 -->
                                        <?php
                                            if($productionDresD7Q3){
                                        ?>
                                            <div class="">
                                                <a href="detailsFicheDresseuse.php?idfichedresseuse=<?= $productionDresD7Q3['idfichedresseuse'] ?>" class=""><p class="m-0 font-weight-bold text-center h4 text-uppercase mt-5 mb-3 text-dark" style="">Dresseuse 7</p></a>
                                                <a style="text-decoration: none; font-family: arial; font-size: 30px;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationProdD7Q3" title="Voir details les supplémentaires" class="link-offset-2 link-underline m-5"><i class="fas fa-comments"></i></a>
                                            </div>

                                            <div class="row">
                                                <table class="table table-bordered mb-2 ml-3 mr-4 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Consommations (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($consommationsD7Q3 as $consommationD7Q3){
                                                                $PoidsConsommeTotal += $consommationD7Q3['poids'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD7Q3['poids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $consommationD7Q3['diametre'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 mr-4 col-lg-7" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Productions (KG)</th>                                                                                
                                                            <th>Diametres</th>
                                                            <th>Nombre barres par colis</th>
                                                            <th>Nombre de colis</th> 
                                                            <th>Nombre barres restant</th>
                                                            <th>Total barres</th>
                                                            <th>Longueur barres (m)</th> 
                                                            <th>Rebus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            foreach($productionsD7Q3 as $productionD7Q3){
                                                                $PoidsProduitTotal += $productionD7Q3['prodpoids'];
                                                                $RebusTotal += $productionD7Q3['proddechet'];
                                                        ?>
                                                            <tr>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['prodpoids'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['proddiametre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['prodnbBarreColis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['prodnbcolis'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['prodnbbarrerestant'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= ($productionD7Q3['prodnbBarreColis']*$productionD7Q3['prodnbcolis'])+$productionD7Q3['prodnbbarrerestant']  ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['prodlongueurbarre'] ?></td>
                                                                <td style="background-color:#4e73df ; color:white;"><?= $productionD7Q3['proddechet'] ?></td>
                                                            </tr>
                                                        <!-- Pour le sweetAlert approuveTransfert !--> 
                                                        <?php
                                                            }
                                                        ?> 
                                                    </tbody>
                                                </table>
                                                <table class="table table-bordered mb-2 col-lg-2" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>       
                                                            <th>Heure début</th>                                                                                
                                                            <th>Heure Fin</th>
                                                            <th>Temps d'arret total</th>   
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD7Q3['heuredepartquart'] ?></td>
                                                            <td style="background-color:#4e73df ; color:white;"><?= $productionDresD7Q3['heurefinquart'] ?></td>
                                                            <?php
                                                                //$TempsFonctionTotal +=  (strtotime($productioncrantC1Q1['heurefinquart']) - strtotime($productioncrantC1Q1['heuredepartquart']));
                                                            ?>
                                                            <td style="background-color:#4e73df ; color:white;" class="text-center">
                                                                <a style="text-decoration: none; font-family: arial; font-size: 20px; color:white;" href="javascript:void(0);" data-toggle="modal" data-target="#InformationArretD7Q3" title="Voir details des temps d'arret" class="link-offset-2 link-underline"><?= ($TotalArretHReelD7Q3[0]-1)." H ".$TotalArretHReelD7Q3[1]." min" ?></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- Bouton et pagnination--> 
                                            <!-- Pour le sweetAlert approuveTransfert !--> 
                                            <div class="modal fade " id="InformationArretD7Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details des temps d'arret de la Dresseuse 1 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <?php
                                                                        //** Debut select de la production (arret)
                                                                            $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$IdproductiondresD7Q3;";

                                                                            // On prépare la requête
                                                                            $query = $db->prepare($sql);

                                                                            // On exécute
                                                                            $query->execute();

                                                                            // On récupère les valeurs dans un tableau associatif
                                                                            $arrets = $query->fetchAll();
                                                                        //** Fin select de la production
                                                                    ?>

                                                                    <?php
                                                                        foreach($arrets as $arret => $key){
                                                                            ?>
                                                                                <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5"><?= $key['debutarret'] ?></span> <span class="mr-5">à</span> <span class="mr-5"><?= $key['finarret'] ?></span> <span class="mr-5 text-danger"><?= $key['raison'] ?></span></p>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>                                            
                                            <!-- Info production --> 
                                            <div class="modal fade " id="InformationProdD7Q3" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true" >
                                                <div class="modal-dialog modal-xl modal-dialog-centered" style="width=750px">
                                                    <div class="modal-content">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-center">
                                                                <h5 class="modal-title" id="fileModalLabel" style="color:white">Details supplémentaires de la Dresseuse 7 :</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-lg-12 mt-5 mb-5">
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Compteur Horaire :</span><span class="mr-5 text-primary">Départ : <?= $productionDresD7Q3['compteurdebut'] ?> /  fin : <?= $productionDresD7Q3['compteurfin'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 1 :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q3['controleur1'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Opérateur 2 :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q3['controleur2'] ?></span></p>
                                                                    <p class="m-0 font-weight-bold text-center h4 mt-2 text-primary"><span class="mr-5">Remarques :</span><span class="mr-5 text-primary"> <?= $productionDresD7Q3['observationfin']  ?></span></p>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <a href="" class="btn btn-primary text-center">Retour</a>
                                                                </div>
                                                            </div>
                                                            <div class="card-footer bg-primary text-muted text-center">
                                                                <h5 style="color:white">METAL *** AFRIQUE</h5>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </div>
                                            </div>
                                        <?php
                                            }
                                        ?>   
                                    </div>
                                    <!-- Fin D7Q3 -->
                                </div>
                            <!-- Fin quart3 -->
                        </div>
                        <div class="card-footer py-3 mt-5 bg-primary">
                            <div class="mb-4 mt-3">
                                <?php 
                                    //** Debut select de la production (consommation)
                                        $datefichedresseuse = $_GET['dateCreation'];  // On recupére l'ID de la réception par get
                                        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `dateCreation`='$datefichedresseuse';";

                                        // On prépare la requête
                                        $query = $db->prepare($sql);

                                        // On exécute
                                        $query->execute();

                                        // On récupère les valeurs dans un tableau associatif
                                        $consommationTables = $query->fetchAll();
                                        //print_r($consommations);
                                    //** Fin select de la production 
                                ?> 
                                <table class="table table-bordered mb-2 mr-4 col-lg-10 mb-5 ml-5" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>       
                                            <th style='background-color:#4e73df ; color:white;'>Diametres coupés</th>
                                            <th style='background-color:#4e73df ; color:white;'>Longueur barres (m)</th>
                                            <th style='background-color:#4e73df ; color:white;'>Nombre barres par colis</th> 
                                            <th style='background-color:#4e73df ; color:white;'>Poids total (KG)</th>                                                                                
                                            <th style='background-color:#4e73df ; color:white;'>Nombre de colis</th> 
                                            <th style='background-color:#4e73df ; color:white;'>Poids par colis</th> 
                                            <th style='background-color:#4e73df ; color:white;'>Barres restant</th>
                                            <th style='background-color:#4e73df ; color:white;'>Total barres</th>
                                            <th style='background-color:#4e73df ; color:white;'>Rebus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($consommationTables as $consommation){
                                                //** Debut select de la production (consommation)
                                                    $idfichedresseuse = $consommation['idfichedresseuse'];  // On recupére l'ID de la réception par get
                                                    $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`='$idfichedresseuse' ORDER BY `proddiametre` ASC;";

                                                    // On prépare la requête
                                                    $query = $db->prepare($sql);

                                                    // On exécute
                                                    $query->execute();

                                                    // On récupère les valeurs dans un tableau associatif
                                                    $dresseuseproductions = $query->fetchAll();
                                                    //print_r($dresseuseproductions);
                                                //** Fin select de la production 
                                                foreach($dresseuseproductions as $key => $dresseuseproduction){
                                                    echo "
                                                    <tr>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[proddiametre]</td>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[prodlongueurbarre]</td>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[prodnbBarreColis]</td>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[prodpoids]</td>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[prodnbcolis]</td>
                                                        <td style='background-color:#4e73df ; color:white;'>".round($dresseuseproduction['prodpoids']/$dresseuseproduction['prodnbcolis'],2)."</td>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[prodnbbarrerestant]</td>
                                                        <td style='background-color:#4e73df ; color:white;'>".($dresseuseproduction['prodnbBarreColis']*$dresseuseproduction['prodnbcolis'])+$dresseuseproduction['prodnbbarrerestant']."</td>
                                                        <td style='background-color:#4e73df ; color:white;'>$dresseuseproduction[proddechet]</td>
                                                    </tr>";
                                                }
                                            }
                                        ?> 
                                    </tbody>
                                </table>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;  padding-right: 10%;"><span class="mr-4"><span class="mr-4">Temps d'arret total :</span> <?php  $TempsArretTotalReel = explode(":",date("H:i",$TempsArretTotal) );  echo ($TempsArretTotalReel[0]-1)." H ".$TempsArretTotalReel[1]." min"; ?></p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-5">Poids total produit : </span> <?php echo $PoidsProduitTotal; ?> (KG)</p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white; padding-right: 10%;"><span class="mr-4">Poids total consommé : </span> <?php  echo $PoidsConsommeTotal; ?> (KG)</p>
                                <p class="m-0 mb-3 h5 d-inline" style="color: white;"><span class="mr-5">Rebus total : </span> <?php echo ($RebusTotal); ?> (KG)</p>
                            </div>
                            <!-- <p class="m-0 mt-3  h5 ml-3 mb-3 d-inline" style="color: white; padding-right: 20%;"><span class="mr-5">Temps de fonction total : </span> <?php $TotalArretHReelD1Q1 = explode(":",date("H:i",$TempsFonctionTotal) ); echo ($TotalArretHReelD1Q1[0]-1)." H ".$TotalArretHReelD1Q1[1]." min"; ?></p> -->
                        </div>
                        <div class="col-md-8 align-items-center mt-5 mb-5">
                            <div class="d-flex gap-2 pt-4">
                                <a href="etatProduction.php" class="btn btn-danger w-lg bouton ml-3"><i class="fa fa-angle-double-left mr-2"></i>Retour</a>
                            </div>
                        </div>
                    </div>
                </div><!-- div Content -->

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.1);">
                        METAL AFRIQUE © <script>document.write(new Date().getFullYear())</script> Copyright:
                        <a class="text-dark" href="https://metalafrique.com//">METALAFRIQUE.COM BY @BACHIR</a>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div><!-- End of Content Wrapper -->
        </div><!-- End of Content Wrapper -->

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