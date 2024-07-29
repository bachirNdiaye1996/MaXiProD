<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
require '../../fpdf/fpdf.php';
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
                $sql = "SELECT * FROM `trefilagerevision` where `actif`=1 and `idfichetrefilage`=$idFicheTrefilage ORDER BY `idtrefilagerevision` DESC;";

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
    $shipping = $item['diametre'];
    if (!isset($resultProdProductionQ1[$shipping])) {
        $resultProdProductionQ1[$shipping] = array(
        'poidstotalproduction' => 0,
        );
    }
    $resultProdProductionQ1[$shipping]['poidstotalproduction'] += $item['poidstotalproduction'];
    }
    //Quart 2
    $resultProdProductionQ2 = array();
    foreach ($ProdProductionQ2 as $item) {
    $shipping = $item['diametre'];
    if (!isset($resultProdProductionQ2[$shipping])) {
        $resultProdProductionQ2[$shipping] = array(
        'poidstotalproduction' => 0,
        );
    }
    $resultProdProductionQ2[$shipping]['poidstotalproduction'] += $item['poidstotalproduction'];
    }
    //Quart 3
    $resultProdProductionQ3 = array();
    foreach ($ProdProductionQ3 as $item) {
    $shipping = $item['diametre'];
    if (!isset($resultProdProductionQ3[$shipping])) {
        $resultProdProductionQ3[$shipping] = array(
        'poidstotalproduction' => 0,
        );
    }
    $resultProdProductionQ3[$shipping]['poidstotalproduction'] += $item['poidstotalproduction'];
    }

/*
// Print the results
foreach ($resultProdRevisionQ1 as $shipping => $values) {
  echo $shipping.' objectifminimal: '.$values['objectifminimal']."\n";
}

foreach (array_combine($resultProdRevisionQ1, $resultProdRevisionQ3) as $course => $section)
{
    print_r($course);
}
*/

    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5,"RESUME PAR DIAMETRE PRODUIT ET PAR QUART AU TREFILAGE",0,1,'C');


    //Pour les arrets
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(194,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,8,utf8_decode("OBJECTIFS"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(30,5,utf8_decode('Diametre'),1,0,'C');
    $pdf->Cell(30,5,utf8_decode('Objectif (KG)'),1,1,'C');

    $i=0;
    foreach($resultProdRevisionQ1 as $shipping => $values){        
        $pdf->Cell(30,5,utf8_decode($shipping),1,0,'C');
        if(count($resultProdRevisionQ1)){
            $pdf->Cell(30,5,utf8_decode($values['objectifminimal']),1,1,'C');
        }else{
            $pdf->Cell(30,5,utf8_decode($values['objectifminimal']),1,0,'C');
        }
    }

    $pdf->Cell(30,5,utf8_decode(count($resultProdRevisionQ1)),0,0,'C');

    $pdf->Output();

