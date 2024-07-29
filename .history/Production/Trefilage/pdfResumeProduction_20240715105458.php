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


    $dateCreation = $_GET['dateCreation']; 

    //** Debut select de la production (arret)
        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuse ORDER BY `idcranteuseq1arret` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $arrets = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production (consommation)
        $sql = "SELECT * FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuse ORDER BY `idcranteuseq1consommation` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $consommations = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production (consommation)
        $sql = "SELECT * FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuse ORDER BY `idcranteuseq1production` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productions = $query->fetchAll(); 
    //** Fin select de la production 

    //** Debut select de la production (echantillon)
        $sql = "SELECT * FROM `cranteuseechantillon` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuse ORDER BY `idcranteuseechantillon` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $echantillons = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production
        $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuse";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $Cranteuse = $query->fetch();
    //** Fin select de la production



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

