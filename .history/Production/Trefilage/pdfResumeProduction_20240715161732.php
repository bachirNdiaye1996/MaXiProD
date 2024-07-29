<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
//include "./mailTransfert.php";


//Variables
    // Quart 1
    $PoidsObjectifMinimalQ1 = 0;
    $PoidsProduitTotalQ1 = 0;
    $PoidsConsommeTotalQ1 = 0;

    // Quart 1
    $PoidsObjectifMinimalQ2 = 0;
    $PoidsProduitTotalQ2 = 0;
    $PoidsConsommeTotalQ2 = 0;

    // Quart 1
    $PoidsObjectifMinimalQ3 = 0;
    $PoidsProduitTotalQ3 = 0;
    $PoidsConsommeTotalQ3 = 0;

    $dateFichetrefilage = $_GET['dateCreation'];  // On recupére l'ID de la réception par get

    // Quart 1
    $ProdConsommationQ1 = array();
    $ProdRevisionQ1 = array();
    $ProdProductionQ1 = array();

    // Quart 2
    $ProdConsommationQ2 = array();
    $ProdRevisionQ2 = array();
    $ProdProductionQ2 = array();

    // Quart 3
    $ProdConsommationQ3 = array();
    $ProdRevisionQ3 = array();
    $ProdProductionQ3 = array();


/** Quart */
    /** Trefilage Q1 */
        //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `dateCreation`='$dateFichetrefilage' and `quart`='1';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionTref = $query->fetchAll();
        //** Fin select de la production 

        // Parcourir les tables révisions,cons et prod
        foreach($productionTref as $productionTr => $Key){

            // On recupére l'id des fiches
            $idFicheTrefilage = $Key['idfichetrefilage'];

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageconsommation` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageconsommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsQ1 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($consommationsQ1 as $production => $Key){
                array_push($ProdConsommationQ1, $Key);
            }

            //** Debut select de la production (consommation)
                //$sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $revisionsQ1 = $query->fetchAll();
            //** Fin select de la production 

            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($revisionsQ1 as $production => $Key){
                array_push($ProdRevisionQ1, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageproduction` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageproduction` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsQ1 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($productionsQ1 as $production => $Key){
                array_push($ProdProductionQ1, $Key);
            }
        }
        
    /** Fin Trefilage Q1 */

    /** Trefilage Q2 */
        //** Debut select de la production (Pour trefilage 1)
            $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `dateCreation`='$dateFichetrefilage' and `quart`='2';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionTref = $query->fetchAll();
        //** Fin select de la production 

        // Parcourir les tables révisions,cons et prod
        foreach($productionTref as $productionTr => $Key){

            // On recupére l'id des fiches
            $idFicheTrefilage = $Key['idfichetrefilage'];

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageconsommation` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageconsommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsQ2 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($consommationsQ2 as $production => $Key){
                array_push($ProdConsommationQ2, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $revisionsQ2 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($revisionsQ2 as $production => $Key){
                array_push($ProdRevisionQ2, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageproduction` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageproduction` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsQ2 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($productionsQ2 as $production => $Key){
                array_push($ProdProductionQ2, $Key);
            }
        }
        
    /** Fin Trefilage Q2 */

    /** Trefilage Q3 */
        //** Debut select de la production (Pour trefilage 3)
            $sql = "SELECT * FROM `fichetrefilage` where `actif`=1 and `dateCreation`='$dateFichetrefilage' and `quart`='3';";

            // On prépare la requête
            $query = $db->prepare($sql);

            // On exécute
            $query->execute();

            // On récupère les valeurs dans un tableau associatif
            $productionTref = $query->fetchAll();
        //** Fin select de la production 

        // Parcourir les tables révisions,cons et prod
        foreach($productionTref as $productionTr => $Key){

            // On recupére l'id des fiches
            $idFicheTrefilage = $Key['idfichetrefilage'];

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageconsommation` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageconsommation` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $consommationsQ3 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($consommationsQ3 as $production => $Key){
                array_push($ProdConsommationQ3, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $revisionsQ3 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($revisionsQ3 as $production => $Key){
                array_push($ProdRevisionQ3, $Key);
            }

            //** Debut select de la production (consommation)
                $sql = "SELECT * FROM `trefilageproduction` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilageproduction` DESC;";

                // On prépare la requête
                $query = $db->prepare($sql);

                // On exécute
                $query->execute();

                // On récupère les valeurs dans un tableau associatif
                $productionsQ3 = $query->fetchAll();
            //** Fin select de la production 
            // On pousse les consommations dans un tableaux qu'on va utiliser aprés
            foreach($productionsQ3 as $production => $Key){
                array_push($ProdProductionQ3, $Key);
            }
        }
    /** Fin Trefilage Q3 */
/** Fin Quart  */


/*
$grouped_array = array();
foreach ($ProdRevisionQ1 as $prodRevision) {
    $grouped_array[$prodRevision['produit']][] = $prodRevision;
}*/

//print_r($grouped_array);

// Révisions
    //Quart 1
        $resultProdRevisionQ1 = array();
        foreach ($ProdRevisionQ1 as $item) {
        $shipping = $item['produit'];
        if (!isset($resultProdRevisionQ1[$shipping])) {
            $resultProdRevisionQ1[$shipping] = array(
            'objectifminimal' => 0,
            );
        }
        $resultProdRevisionQ1[$shipping]['objectifminimal'] += $item['objectifminimal'];
        }
    //Quart 2
        $resultProdRevisionQ2 = array();
        foreach ($ProdRevisionQ2 as $item) {
        $shipping = $item['produit'];
        if (!isset($resultProdRevisionQ2[$shipping])) {
            $resultProdRevisionQ2[$shipping] = array(
            'objectifminimal' => 0,
            );
        }
        $resultProdRevisionQ2[$shipping]['objectifminimal'] += $item['objectifminimal'];
        }
    //Quart 3
        $resultProdRevisionQ3 = array();
        foreach ($ProdRevisionQ3 as $item) {
        $shipping = $item['produit'];
        if (!isset($resultProdRevisionQ3[$shipping])) {
            $resultProdRevisionQ3[$shipping] = array(
            'objectifminimal' => 0,
            );
        }
        $resultProdRevisionQ3[$shipping]['objectifminimal'] += $item['objectifminimal'];
        }

// Production
    //Quart 1
    $resultProdProductionQ1 = array();
    foreach ($ProdProductionQ1 as $item) {
    $shipping = $item['produit'];
    if (!isset($resultProdProductionQ1[$shipping])) {
        $resultProdProductionQ1[$shipping] = array(
        'objectifminimal' => 0,
        );
    }
    $resultProdProductionQ1[$shipping]['objectifminimal'] += $item['objectifminimal'];
    }
    //Quart 2
    $resultProdProductionQ2 = array();
    foreach ($ProdProductionQ2 as $item) {
    $shipping = $item['produit'];
    if (!isset($resultProdProductionQ2[$shipping])) {
        $resultProdProductionQ2[$shipping] = array(
        'objectifminimal' => 0,
        );
    }
    $resultProdProductionQ2[$shipping]['objectifminimal'] += $item['objectifminimal'];
    }
    //Quart 3
    $resultProdProductionQ3 = array();
    foreach ($ProdProductionQ3 as $item) {
    $shipping = $item['produit'];
    if (!isset($resultProdProductionQ3[$shipping])) {
        $resultProdProductionQ3[$shipping] = array(
        'objectifminimal' => 0,
        );
    }
    $resultProdProductionQ3[$shipping]['objectifminimal'] += $item['objectifminimal'];
    }

// Consommation
    //Quart 1
    $resultProdConsommationQ1 = array();
    foreach ($ProdConsommationQ1 as $item) {
    $shipping = $item['produit'];
    if (!isset($resultProdConsommationQ1[$shipping])) {
        $ProdConsommationQ1[$shipping] = array(
        'objectifminimal' => 0,
        );
    }
    $resultProdConsommationQ1[$shipping]['objectifminimal'] += $item['objectifminimal'];
    }
    //Quart 2
    $resultProdConsommationQ2 = array();
    foreach ($ProdConsommationQ2 as $item) {
    $shipping = $item['produit'];
    if (!isset($resultProdConsommationQ2[$shipping])) {
        $resultProdConsommationQ2[$shipping] = array(
        'objectifminimal' => 0,
        );
    }
    $resultProdConsommationQ2[$shipping]['objectifminimal'] += $item['objectifminimal'];
    }
    //Quart 3
    $resultProdConsommationQ3 = array();
    foreach ($ProdConsommationQ3 as $item) {
    $shipping = $item['produit'];
    if (!isset($resultProdConsommationQ3[$shipping])) {
        $resultProdConsommationQ3[$shipping] = array(
        'objectifminimal' => 0,
        );
    }
    $resultProdConsommationQ3[$shipping]['objectifminimal'] += $item['objectifminimal'];
    }


// Print the results
foreach ($resultProdRevisionQ1 as $shipping => $values) {
  echo $shipping.' objectifminimal: '.$values['objectifminimal']."\n";
}


    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5,"FICHE DE PRODUCTION $Cranteuse[machine]",0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,14,utf8_decode(""),0,1,'C');
    $pdf->Cell(190,14,utf8_decode("DATE : $Cranteuse[dateCreation]          QUART : $Cranteuse[quart]            CONTROLEURS : $Cranteuse[controleur1] ET $Cranteuse[controleur2]"),0,1,'C');
    $pdf->Cell(190,2,utf8_decode("HORAIRES : $Cranteuse[heuredepartquart]  -  $Cranteuse[heurefinquart]             "),0,1,'C');


    //Pour les arrets
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(194,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,8,utf8_decode("Géstion des temps d'arret"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,5,utf8_decode('Début arrets'),1,0,'C');
    $pdf->Cell(30,5,utf8_decode('Fin arrets'),1,0,'C');
    $pdf->Cell(130,5,utf8_decode('Raisons'),1,1,'C');

    $TotalArretH=0;
    foreach($arrets as $arret){        
        $pdf->Cell(30,5,utf8_decode($arret['debutarret']),1,0,'C');
        $pdf->Cell(30,5,utf8_decode($arret['finarret']),1,0,'C');
        $pdf->Cell(130,5,utf8_decode($arret['raison']),1,1,'C');

        if(((strtotime($arret['finarret']) - strtotime($arret['debutarret'])) > 0)){
            $TotalArretH +=  (strtotime($arret['finarret']) - strtotime($arret['debutarret']));
        }else{
            $TotalArretH +=  (-strtotime($arret['debutarret']) + strtotime($arret['finarret']));
        }
    }

    //Pour les consommations
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(190,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,8,utf8_decode("Consommations"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(38,5,utf8_decode('Diamétre'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Numéro fil machine'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Poids'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Heure de montage'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Déchet'),1,1,'C');
    foreach($consommations as $consommation){        
        $pdf->Cell(38,5,utf8_decode($consommation['diametre']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['numerofin']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['poids']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['heuremontagebobine']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['dechet']),1,1,'C');
    }

    //Pour les productions
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(194,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(114,8,utf8_decode("Productions"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(38,5,utf8_decode('Diamétre'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Numéro fil machine'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Poids'),1,1,'C');
    foreach($productions as $production){        
        $pdf->Cell(38,5,utf8_decode($production['proddiametre']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($production['prodnumerofin']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($production['prodpoids']),1,1,'C');
    }

    //Pour les echantillons
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(194,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(114,8,utf8_decode("Echantillons"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(38,5,utf8_decode('Diamétre'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Longueur'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Numéro DF'),1,1,'C');
    foreach($echantillons as $echantillon){        
        $pdf->Cell(38,5,utf8_decode($echantillon['echandiametre']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($echantillon['echanlongueur']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($echantillon['echandf']),1,1,'C');
    }

    //C'est pour les arrets
    $TotalArretHReel = explode(':',date('H:i',$TotalArretH) );
    $TotalArretHReelH = $TotalArretHReel[0]-1;

    //C'est pour le temps de fonction
    $TotalHeureTravaille = 0;
    if(((strtotime($Cranteuse['heurefinquart']) - strtotime($Cranteuse['heuredepartquart'])) > 0)){
        $TotalHeureTravaille =  (strtotime($Cranteuse['heurefinquart']) - strtotime($Cranteuse['heuredepartquart']));
    }else{
        $TotalHeureTravaille =  (-strtotime($Cranteuse['heurefinquart']) + strtotime($Cranteuse['heuredepartquart']));
    }
    $TotalHeureTravaillerelle = explode(":",date("H:i",$TotalHeureTravaille - $TotalArretH) );
    $TotalHeureTravaillerelleH = $TotalHeureTravaillerelle[0]-1;

    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,15,utf8_decode(""),0,1,'C');
    $pdf->Cell(190,13,utf8_decode("Total arret : $TotalArretHReelH Heures $TotalArretHReel[1] minutes          Vitesse : $Cranteuse[vitesse]          Poids estimatif travaillé et non noté : $Cranteuse[poidsestimetravaillenonnote] "),0,1,'C');
    $pdf->Cell(190,2,utf8_decode("Temps de fonction : $TotalHeureTravaillerelleH Heures $TotalHeureTravaillerelle[1] min   "),0,1,'C');


    $pdf->Output();

