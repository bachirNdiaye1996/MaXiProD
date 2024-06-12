<?php

    // On se connecte à là base de données
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";
    include "./mailProductionCranteuse.php";
    require '../../fpdf/fpdf.php';


    $idfichecranteuseq1 = $_GET['dateCreation'];  // On recupére l'ID de la réception par get

    /** Quart 1 */
        /** Cranteuse1 Q1 */
            //** Debut select de la production (Pour cranteuse 1)
                $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 1' and `quart`='1';";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $productioncrantC1Q1 = $query->fetch();
            //** Fin select de la production 
    
            if ($productioncrantC1Q1) {
    
                $IdproductioncrantC1Q1 = $productioncrantC1Q1['idfichecranteuseq1'];    // Id de productioncrantC1Q1
    
                //** Debut select de la production (consommation)
                    $sql = "SELECT sum(poids) as piodstotal, diametre, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1 GROUP BY `diametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $consommationsC1Q1 = $query->fetchAll();
                //** Fin select de la production 
    
                //** Debut select de la production (arret)
                    $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $arretsC1Q1 = $query->fetchAll();
                //** Fin select de la production
    
                $TotalArretH = null;
                // Calcul du temps d'arret
                    foreach($arretsC1Q1 as $arretC1Q1){
                        if(((strtotime($arretC1Q1['finarret']) - strtotime($arretC1Q1['debutarret'])) > 0)){
                            $TotalArretH +=  (strtotime($arretC1Q1['finarret']) - strtotime($arretC1Q1['debutarret']));
                        }else{
                            $TotalArretH +=  (-strtotime($arretC1Q1['debutarret']) + strtotime($arretC1Q1['finarret']));
                        }
                    }
    
                    $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                    $TotalArretHReelC1Q1 = explode(":",date("H:i",$TotalArretH) );
                // Fin calcul du temps d'arret
    
    
                //** Debut select de la production (prod)
                    $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q1 GROUP BY `proddiametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $productionsC1Q1 = $query->fetchAll();
                //** Fin select de la production 
            }
            
        /** Fin Cranteuse1 Q1 */
    
        /** Fin Cranteuse2 Q1 */
            //** Debut select de la production (Pour cranteuse 2)
                $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 2' and `quart`='1';";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $productioncrantC2Q1 = $query->fetch();
            //** Fin select de la production 
    
            if ($productioncrantC2Q1) {
    
                $IdproductioncrantC2Q1 = $productioncrantC2Q1['idfichecranteuseq1'];    // Id de productioncrantC1Q1
    
                //** Debut select de la production (consommation)
                    $sql = "SELECT sum(poids) as piodstotal, diametre, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q1 GROUP BY `diametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $consommationsC2Q1 = $query->fetchAll();
                //** Fin select de la production 
    
                //** Debut select de la production (arret)
                    $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q1;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $arretsC2Q1 = $query->fetchAll();
                //** Fin select de la production
    
                $TotalArretH = null;
                // Calcul du temps d'arret
                    foreach($arretsC2Q1 as $arretC2Q1){
                        if(((strtotime($arretC2Q1['finarret']) - strtotime($arretC2Q1['debutarret'])) > 0)){
                            $TotalArretH +=  (strtotime($arretC2Q1['finarret']) - strtotime($arretC2Q1['debutarret']));
                        }else{
                            $TotalArretH +=  (-strtotime($arretC2Q1['debutarret']) + strtotime($arretC2Q1['finarret']));
                        }
                    }
    
                    $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                    $TotalArretHReelC2Q1 = explode(":",date("H:i",$TotalArretH) );
                // Fin calcul du temps d'arret
    
    
                //** Debut select de la production (prod)
                    $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q1 GROUP BY `proddiametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $productionsC2Q1 = $query->fetchAll();
                //** Fin select de la production 
            }
        /** Fin Cranteuse2 Q1 */
    /** Fin Quart 1 */
    
    /** Quart 2 */
        /** Cranteuse1 Q1 */
            //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 1' and `quart`='2';";
    
            // On prépare la requête
            $query = $db->prepare($sql);
    
            // On exécute
            $query->execute();
    
            // On récupère les valeurs dans un tableau associatif
            $productioncrantC1Q2 = $query->fetch();
        //** Fin select de la production 
    
        if ($productioncrantC1Q2) {
    
            $IdproductioncrantC1Q2 = $productioncrantC1Q2['idfichecranteuseq1'];    // Id de productioncrantC1Q1
    
            //** Debut select de la production (consommation)
                $sql = "SELECT sum(poids) as piodstotal, diametre, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2 GROUP BY `diametre`;";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $consommationsC1Q2 = $query->fetchAll();
            //** Fin select de la production 
    
            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2;";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $arretsC1Q2 = $query->fetchAll();
            //** Fin select de la production
    
            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsC1Q2 as $arretC1Q2){
                    if(((strtotime($arretC1Q2['finarret']) - strtotime($arretC1Q2['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretC1Q2['finarret']) - strtotime($arretC1Q2['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretC1Q2['debutarret']) + strtotime($arretC1Q2['finarret']));
                    }
                }
    
                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelC1Q2 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret
    
    
            //** Debut select de la production (prod)
                $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q2 GROUP BY `proddiametre`;";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $productionsC1Q2 = $query->fetchAll();
            //** Fin select de la production 
        }
            
        /** Fin Cranteuse1 Q2 */
    
        /** Debut Cranteuse2 Q2 */
            //** Debut select de la production (Pour cranteuse 2)
                $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 2' and `quart`='2';";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $productioncrantC2Q2 = $query->fetch();
            //** Fin select de la production 
    
            if ($productioncrantC2Q2) {
    
                $IdproductioncrantC2Q2 = $productioncrantC2Q2['idfichecranteuseq1'];    // Id de productioncrantC1Q1
    
                //** Debut select de la production (consommation)
                    $sql = "SELECT sum(poids) as piodstotal, diametre, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2 GROUP BY `diametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $consommationsC2Q2 = $query->fetchAll();
                //** Fin select de la production 
    
                //** Debut select de la production (arret)
                    $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $arretsC2Q2 = $query->fetchAll();
                //** Fin select de la production
    
                $TotalArretH = null;
                // Calcul du temps d'arret
                    foreach($arretsC2Q2 as $arretC2Q2){
                        if(((strtotime($arretC2Q2['finarret']) - strtotime($arretC2Q2['debutarret'])) > 0)){
                            $TotalArretH +=  (strtotime($arretC2Q2['finarret']) - strtotime($arretC2Q2['debutarret']));
                        }else{
                            $TotalArretH +=  (-strtotime($arretC2Q2['debutarret']) + strtotime($arretC2Q2['finarret']));
                        }
                    }
    
                    $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                    $TotalArretHReelC2Q2 = explode(":",date("H:i",$TotalArretH) );
                // Fin calcul du temps d'arret
    
    
                //** Debut select de la production (prod)
                    $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q2 GROUP BY `proddiametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $productionsC2Q2 = $query->fetchAll();
                //** Fin select de la production 
            }
        /** Fin Cranteuse2 Q1 */
    /** Fin Quart 2 */
    
    
    /** Quart 3 */
        /** Cranteuse1 Q3 */
            //** Debut select de la production (Pour cranteuse 1)
            $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 1' and `quart`='3';";
    
            // On prépare la requête
            $query = $db->prepare($sql);
    
            // On exécute
            $query->execute();
    
            // On récupère les valeurs dans un tableau associatif
            $productioncrantC1Q3 = $query->fetch();
        //** Fin select de la production 
    
        if ($productioncrantC1Q3) {
    
            $IdproductioncrantC1Q3 = $productioncrantC1Q3['idfichecranteuseq1'];    // Id de productioncrantC1Q1
    
            //** Debut select de la production (consommation)
                $sql = "SELECT sum(poids) as piodstotal, diametre, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3 GROUP BY `diametre`;";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $consommationsC1Q3 = $query->fetchAll();
            //** Fin select de la production 
    
            //** Debut select de la production (arret)
                $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3;";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $arretsC1Q3 = $query->fetchAll();
            //** Fin select de la production
    
            $TotalArretH = null;
            // Calcul du temps d'arret
                foreach($arretsC1Q3 as $arretC1Q3){
                    if(((strtotime($arretC1Q3['finarret']) - strtotime($arretC1Q3['debutarret'])) > 0)){
                        $TotalArretH +=  (strtotime($arretC1Q3['finarret']) - strtotime($arretC1Q3['debutarret']));
                    }else{
                        $TotalArretH +=  (-strtotime($arretC1Q3['debutarret']) + strtotime($arretC1Q3['finarret']));
                    }
                }
    
                $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                $TotalArretHReelC1Q3 = explode(":",date("H:i",$TotalArretH) );
            // Fin calcul du temps d'arret
    
    
            //** Debut select de la production (prod)
                $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC1Q3 GROUP BY `proddiametre`;";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $productionsC1Q3 = $query->fetchAll();
            //** Fin select de la production 
        }
            
        /** Fin Cranteuse1 Q1 */
    
        /** Fin Cranteuse2 Q1 */
            //** Debut select de la production (Pour cranteuse 2)
                $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `dateCreation`='$idfichecranteuseq1' and `machine`='cranteuse 2' and `quart`='3';";
    
                // On prépare la requête
                $query = $db->prepare($sql);
    
                // On exécute
                $query->execute();
    
                // On récupère les valeurs dans un tableau associatif
                $productioncrantC2Q3 = $query->fetch();
            //** Fin select de la production 
    
            if ($productioncrantC2Q3) {
    
                $IdproductioncrantC2Q3 = $productioncrantC2Q3['idfichecranteuseq1'];    // Id de productioncrantC1Q1
    
                //** Debut select de la production (consommation)
                    $sql = "SELECT sum(poids) as piodstotal, diametre, sum(dechet) as dechet FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3 GROUP BY `diametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $consommationsC2Q3 = $query->fetchAll();
                //** Fin select de la production 
    
                //** Debut select de la production (arret)
                    $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $arretsC2Q3 = $query->fetchAll();
                //** Fin select de la production
    
                $TotalArretH = null;
                // Calcul du temps d'arret
                    foreach($arretsC2Q3 as $arretC2Q3){
                        if(((strtotime($arretC2Q3['finarret']) - strtotime($arretC2Q3['debutarret'])) > 0)){
                            $TotalArretH +=  (strtotime($arretC2Q3['finarret']) - strtotime($arretC2Q3['debutarret']));
                        }else{
                            $TotalArretH +=  (-strtotime($arretC2Q3['debutarret']) + strtotime($arretC2Q3['finarret']));
                        }
                    }
    
                    $TempsArretTotal += $TotalArretH;             //Calcul du temps d'arret
                    $TotalArretHReelC2Q3 = explode(":",date("H:i",$TotalArretH) );
                // Fin calcul du temps d'arret
    
    
                //** Debut select de la production (prod)
                    $sql = "SELECT sum(prodpoids) as piodstotal, proddiametre, sum(proddechet) as dechet FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$IdproductioncrantC2Q3 GROUP BY `proddiametre`;";
    
                    // On prépare la requête
                    $query = $db->prepare($sql);
    
                    // On exécute
                    $query->execute();
    
                    // On récupère les valeurs dans un tableau associatif
                    $productionsC2Q3 = $query->fetchAll();
                //** Fin select de la production 
            }
        /** Fin Cranteuse2 Q1 */
    /** Fin Quart 3 */





    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5,"ETAT DE PRODUCTION Etat DE PRODUCTION JOURNALIER - SECTION CRANTEUSE JOURNEE DU : ",0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,14,utf8_decode("DATE : $Cranteuse[dateCreation]          QUART : $Cranteuse[quart]            CONTROLEURS : $Cranteuse[controleur1] ET $Cranteuse[controleur2]"),0,1,'C');
    $pdf->Cell(190,2,utf8_decode("HORAIRES : $Cranteuse[heuredepartquart]  -  $Cranteuse[heurefinquart]             OBSERVATIONS (DEBUT) : $Cranteuse[observationdebut]"),0,1,'C');


    //Pour les arrets
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(194,14,'',0,1);
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
    $pdf->Cell(190,18,utf8_decode("Total arret : $TotalArretHReelH Heures $TotalArretHReel[1] minutes          Vitesse : $Cranteuse[vitesse]          Poids estimatif travaillé et non noté : $Cranteuse[poidsestimetravaillenonnote] "),0,1,'C');
    $pdf->Cell(190,2,utf8_decode("Temps de fonction : $TotalHeureTravaillerelleH Heures $TotalHeureTravaillerelle[1] min              OBSERVATIONS (FIN) : $Cranteuse[observationfin]"),0,1,'C');


    $pdf->Output();

