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


    $idfichecranteuse = $_GET['idfichecranteuse']; 

    //** Debut select de la production (erreur)
        $sql = "SELECT * FROM `cranteuseq1arret` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuseq1 ORDER BY `idcranteuseq1arret` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productioncrantq1 = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production (consommation)
        $sql = "SELECT * FROM `cranteuseq1consommation` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuseq1 ORDER BY `idcranteuseq1consommation` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $consommation = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production (consommation)
        $sql = "SELECT * FROM `cranteuseq1production` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuseq1 ORDER BY `idcranteuseq1production` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $production = $query->fetchAll(); 
    //** Fin select de la production 

    //** Debut select de la production (echantillon)
        $sql = "SELECT * FROM `cranteuseechantillon` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuseq1 ORDER BY `idcranteuseechantillon` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $echantion = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production
        $sql = "SELECT * FROM `fichecranteuseq1` where `actif`=1 and `idfichecranteuseq1`=$idfichecranteuseq1";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $Cranteuseq1 = $query->fetch();
    //** Fin select de la production



    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,18,"FICHE DE PRODUCTION $Cranteuseq1[machine]",0,0,'C');
    $pdf->SetFont('Arial','B',8);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,18,"DATE : $Cranteuse[dateCreation]          QUART : $Cranteuse['quart']                 CONTROLEURS : $Cranteuseq1['controleur1'] */* $Cranteuseq1['controleur2']",0,0,'C');




    $pdf->Output();

