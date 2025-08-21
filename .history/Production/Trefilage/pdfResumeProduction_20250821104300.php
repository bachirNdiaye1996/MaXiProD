<?php   

session_start(); 

if(!$_SESSION){
    header("location: ../../404.php");
    return 0;
}

include "../../connexion/conexiondb.php";
require '../../fpdf/fpdf.php';


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

        if($productionTref){
            // Parcourir les tables révisions,cons et prod
            foreach($productionTref as $productionTr => $Key){

                // On recupére l'id des fiches
                $idFicheTrefilage = $Key['idfichetrefilage'];

                //** Debut select de la production (consommation)
                    //$sql = "SELECT * FROM `trefilageproduction`, `trefilagerevision` where trefilagerevision.actif=1 and trefilagerevision.idfichetrefilage=$idFicheTrefilage;";
                    $sql = "SELECT*FROM `trefilageproduction` P INNER JOIN `trefilagerevision` R ON P.idfichetrefilage=$idFicheTrefilage and R.idfichetrefilage=$idFicheTrefilage;";

                    
                    /*$sql =
                    "SELECT poidstotalproduction,produit,objectifminimal
                    FROM `trefilageproduction`
                    INNER JOIN `trefilagerevision`
                    ON trefilageproduction.idfichetrefilage = trefilagerevision.idfichetrefilage where trefilageproduction.actif=1 and trefilageproduction.idfichetrefilage=$idFicheTrefilage;";*/

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

        if($productionTref){
            // Parcourir les tables révisions,cons et prod
            foreach($productionTref as $productionTr => $Key){

                // On recupére l'id des fiches
                $idFicheTrefilage = $Key['idfichetrefilage'];

                //** Debut select de la production (consommation)
                    //$sql = "SELECT * FROM `trefilageproduction`, `trefilagerevision` where trefilagerevision.actif=1 and trefilagerevision.idfichetrefilage=$idFicheTrefilage;";
                    $sql = "SELECT*FROM `trefilageproduction` P INNER JOIN `trefilagerevision` R ON P.idfichetrefilage=$idFicheTrefilage and R.idfichetrefilage=$idFicheTrefilage;";

                    
                    /*$sql =
                    "SELECT poidstotalproduction,produit,objectifminimal
                    FROM `trefilageproduction`
                    INNER JOIN `trefilagerevision`
                    ON trefilageproduction.idfichetrefilage = trefilagerevision.idfichetrefilage where trefilageproduction.actif=1 and trefilageproduction.idfichetrefilage=$idFicheTrefilage;";*/

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

        if($productionTref){
            // Parcourir les tables révisions,cons et prod
            foreach($productionTref as $productionTr => $Key){

                // On recupére l'id des fiches
                $idFicheTrefilage = $Key['idfichetrefilage'];

                //** Debut select de la production (consommation)
                    //$sql = "SELECT * FROM `trefilageproduction`, `trefilagerevision` where trefilagerevision.actif=1 and trefilagerevision.idfichetrefilage=$idFicheTrefilage;";
                    $sql = "SELECT*FROM `trefilageproduction` P INNER JOIN `trefilagerevision` R ON P.idfichetrefilage=$idFicheTrefilage and R.idfichetrefilage=$idFicheTrefilage;";

                    
                    /*$sql =
                    "SELECT poidstotalproduction,produit,objectifminimal
                    FROM `trefilageproduction`
                    INNER JOIN `trefilagerevision`
                    ON trefilageproduction.idfichetrefilage = trefilagerevision.idfichetrefilage where trefilageproduction.actif=1 and trefilageproduction.idfichetrefilage=$idFicheTrefilage;";*/

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
        }
    /** Fin Trefilage Q3 */
/** Fin Quart  */


// Révisions et Productions
    // Variables
        $TotalProduction = 0;  
        $TotalPrevision = 0;  
    //Quart 1
        $resultProdRevisionQ1 = array();
        foreach ($ProdProductionQ1 as $item) {
            $shipping = $item['produit'];
            if (!isset($resultProdRevisionQ1[$shipping])) {
                $resultProdRevisionQ1[$shipping] = array(
                'objectifminimal' => 0,
                'poidstotalproduction' => 0,
                );
            }
            $resultProdRevisionQ1[$shipping]['objectifminimal'] += $item['objectifminimal'];
            $resultProdRevisionQ1[$shipping]['poidstotalproduction'] += $item['poidstotalproduction'];
        }
    //Quart 2
        $resultProdRevisionQ2 = array();
        foreach ($ProdProductionQ2 as $item) {
            $shipping = $item['produit'];
            if (!isset($resultProdRevisionQ2[$shipping])) {
                $resultProdRevisionQ2[$shipping] = array(
                'objectifminimal' => 0,
                'poidstotalproduction' => 0,
                );
            }
            $resultProdRevisionQ2[$shipping]['objectifminimal'] += $item['objectifminimal'];
            $resultProdRevisionQ2[$shipping]['poidstotalproduction'] += $item['poidstotalproduction'];
        }
    //Quart 3
        $resultProdRevisionQ3 = array();
        foreach ($ProdProductionQ3 as $item) {
        $shipping = $item['produit'];
        if (!isset($resultProdRevisionQ3[$shipping])) {
            $resultProdRevisionQ3[$shipping] = array(
            'objectifminimal' => 0,
            'poidstotalproduction' => 0,
            );
        }
        $resultProdRevisionQ3[$shipping]['objectifminimal'] += $item['objectifminimal'];
        $resultProdRevisionQ3[$shipping]['poidstotalproduction'] += $item['poidstotalproduction'];
        }
// Fin

    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',13);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5," DU ",0,1,'c');

        $pdf->SetTextColor(50,60,100);
    $pdf->Cell(55,29,'METAL AFRIQUE',1,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(139,8,utf8_decode('                          Systéme de Management Intégré                                       ').utf8_decode("DATE : $_GET[dateCreation]"),0,1);
    $pdf->SetFont('Arial','B',19);
    $pdf->Cell(55,28,'           * * *',0,0);
    $pdf->SetFont('Arial','B',8);    
    $pdf->Cell(139,8,utf8_decode('                                                                                                                         '.utf8_decode("QUART : Les 3")/*.$_POST['date']*/),0,1);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(148,13,"                                            RESUME PAR DIAMETRE PRODUIT ET PAR QUART AU TREFILAGE",0,0,'C');
    $pdf->Line(160,39,19,39);
    $pdf->Line(160,26,65,26);
    $pdf->Line(204,18,158,18);
    $pdf->Line(204,10,204,27);
    $pdf->Line(204,10,65,10);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(46,13,utf8_decode('Code : PS4_ENR_03_00'),1,1);
    $pdf->Line(158,10,158,27);

    $pdf->SetTextColor(0,0,0);

    $pdf->SetTextColor(50,60,100);
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,14,utf8_decode(""),0,1,'C');
    $pdf->Cell(190,14,utf8_decode("     OPERATEURS : $Cranteuse[controleur1] ET $Cranteuse[controleur2]        "."HORAIRES : $Cranteuse[heuredepartquart]  -  $Cranteuse[heurefinquart]"),0,1,'C');
   

    //Pour quart 1
        if($resultProdRevisionQ1){
            // Objectif
            $pdf->SetMargins(35,25,25);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(194,10,'',0,1);
            $pdf->SetTextColor(50,60,100);
            $pdf->Cell(140,8,utf8_decode("QUART I"),0,1,'C');
            $pdf->SetFont('Arial','B',7);

            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,utf8_decode('Diametre'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Objectif (KG)'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Production (KG)'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Réalisation (%)'),1,1,'C');

            foreach($resultProdRevisionQ1 as $shipping => $values){    
                // Pour la production et les objectifs totaux
                $TotalProduction += $values['poidstotalproduction'];  
                $TotalPrevision += $values['objectifminimal'];

                $pdf->SetTextColor(23,84,223);
                $pdf->Cell(35,5,utf8_decode($shipping),1,0,'C');
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(35,5,utf8_decode($values['objectifminimal']),1,0,'C');
                $pdf->Cell(35,5,utf8_decode($values['poidstotalproduction']),1,0,'C');
                $pdf->Cell(35,5,utf8_decode(round($values['poidstotalproduction']/$values['objectifminimal'] * 100 ,2)),1,1,'C');
            }
        }
    //Fin quart 1

    //Pour quart 2
        if($resultProdRevisionQ2){
            // Objectif
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(194,10,'',0,1);
            $pdf->SetTextColor(50,60,100);
            $pdf->Cell(140,8,utf8_decode("QUART II"),0,1,'C');
            $pdf->SetFont('Arial','B',7);

            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,utf8_decode('Diametre'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Objectif (KG)'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Production (KG)'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Réalisation (%)'),1,1,'C');


            foreach($resultProdRevisionQ2 as $shipping => $values){ 
                $TotalProduction += $values['poidstotalproduction'];  
                $TotalPrevision += $values['objectifminimal'];   

                $pdf->SetTextColor(23,84,223);
                $pdf->Cell(35,5,utf8_decode($shipping),1,0,'C');
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(35,5,utf8_decode($values['objectifminimal']),1,0,'C');
                $pdf->Cell(35,5,utf8_decode($values['poidstotalproduction']),1,0,'C');
                $pdf->Cell(35,5,utf8_decode(round($values['poidstotalproduction']/$values['objectifminimal'] * 100 ,2)),1,1,'C');

            }
        }
    //Fin quart 2

    //Pour quart 3
        if($resultProdRevisionQ3){
            // Objectif
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(194,10,'',0,1);
            $pdf->SetTextColor(50,60,100);
            $pdf->Cell(140,8,utf8_decode("QUART III"),0,1,'C');
            $pdf->SetFont('Arial','B',7);

            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(35,5,utf8_decode('Diametre'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Objectif (KG)'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Production (KG)'),1,0,'C');
            $pdf->Cell(35,5,utf8_decode('Réalisation (%)'),1,1,'C');
    

            foreach($resultProdRevisionQ3 as $shipping => $values){ 
                $TotalProduction += $values['poidstotalproduction'];  
                $TotalPrevision += $values['objectifminimal'];   

                $pdf->SetTextColor(23,84,223);
                $pdf->Cell(35,5,utf8_decode($shipping),1,0,'C');
                $pdf->SetTextColor(0,0,0);
                $pdf->Cell(35,5,utf8_decode($values['objectifminimal']),1,0,'C');
                $pdf->Cell(35,5,utf8_decode($values['poidstotalproduction']),1,0,'C');
                $pdf->Cell(35,5,utf8_decode(round($values['poidstotalproduction']/$values['objectifminimal'] * 100 ,2)),1,1,'C');

            }
        }
    //Fin quart 3

    //Pour Les totaux
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(194,10,'',0,1);
        $pdf->SetTextColor(50,60,100);
        $pdf->Cell(140,8,utf8_decode("TOTAL"),0,1,'C');
        $pdf->SetFont('Arial','B',7);

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(40,5,utf8_decode('Total objectif (KG)'),1,0,'C');
        $pdf->Cell(40,5,utf8_decode('Total production (KG)'),1,0,'C');
        $pdf->Cell(60,5,utf8_decode('Pourcentage de réalisation (%)'),1,1,'C');


        $pdf->SetTextColor(223,53,23);
        $pdf->Cell(40,5,utf8_decode($TotalPrevision),1,0,'C');
        $pdf->Cell(40,5,utf8_decode($TotalProduction),1,0,'C');
        $pdf->Cell(60,5,utf8_decode(round($TotalProduction/$TotalPrevision * 100 ,2)),1,1,'C');

        
    //Fin quart 1

 


    $pdf->Output();

