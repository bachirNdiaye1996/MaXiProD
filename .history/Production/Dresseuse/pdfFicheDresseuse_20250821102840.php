<?php

    // On se connecte à là base de données
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";

    require '../../fpdf/fpdf.php';

    // Variables
    $idfichedresseuse = $_GET['idfichedresseuse']; 
    $TotalPoids = 0;
    $TotalBarres = 0;

    //** Debut select de la production (arret)
        $sql = "SELECT * FROM `dresseusearret` where `actif`=1 and `idfichedresseuse`=$idfichedresseuse ORDER BY `iddresseusearret` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $arrets = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production (consommation)
        $sql = "SELECT * FROM `dresseuseconsommation` where `actif`=1 and `idfichedresseuse`=$idfichedresseuse ORDER BY `iddresseuseconsommation` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $consommations = $query->fetchAll();
    //** Fin select de la production 

    //** Debut select de la production (consommation)
        $sql = "SELECT * FROM `dresseuseproduction` where `actif`=1 and `idfichedresseuse`=$idfichedresseuse ORDER BY `iddresseuseproduction` DESC;";

        // On prépare la requête
        $query = $db->prepare($sql);

        // On exécute
        $query->execute();

        // On récupère les valeurs dans un tableau associatif
        $productions = $query->fetchAll(); 
    //** Fin select de la production 


    //** Debut select de la production
        $sql = "SELECT * FROM `fichedresseuse` where `actif`=1 and `idfichedresseuse`=$idfichedresseuse";

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
    $pdf->Cell(55,29,'METAL AFRIQUE',1,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(139,8,utf8_decode('                          Systéme de Management Intégré                                       ').utf8_decode("DATE : $Cranteuse[dateCreation]"),0,1);
    $pdf->SetFont('Arial','B',19);
    $pdf->Cell(55,28,'           * * *',0,0);
    $pdf->SetFont('Arial','B',8);    
    $pdf->Cell(139,8,utf8_decode('                                                                                                                         '.utf8_decode("QUART : $Cranteuse[quart]")/*.$_POST['date']*/),0,1);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(148,13,"                                              FICHE DE PRODUCTION $Cranteuse[machine]",0,0,'C');
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


    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5,"FICHE DE PRODUCTION $Cranteuse[machine]",0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,14,utf8_decode(""),0,1,'C');
    $pdf->Cell(190,14,utf8_decode("     OPERATEURS : $Cranteuse[controleur1] ET $Cranteuse[controleur2]        "."HORAIRES : $Cranteuse[heuredepartquart]  -  $Cranteuse[heurefinquart]"),0,1,'C');



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
    $pdf->Cell(152,8,utf8_decode("Consommations"),0,1,'C');
    $pdf->SetFont('Arial','B',7); 

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(38,5,utf8_decode('Diamétre'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Numéro fil machine'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Poids'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Heure de montage'),1,1,'C');
    foreach($consommations as $consommation){        
        $pdf->Cell(38,5,utf8_decode($consommation['diametre']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['numerofin']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['poids']),1,0,'C');
        $pdf->Cell(38,5,utf8_decode($consommation['heuremontagebobine']),1,1,'C');
    }

    //Pour les productions
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(194,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,8,utf8_decode("Productions"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(21,5,utf8_decode('Diamétre'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('N° fil machine'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('Nbre barres / colis'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('Nbre de colis'),1,0,'C');
    $pdf->Cell(22,5,utf8_decode('Nbre barres restant'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('Longueur barres'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('Total barres'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('Poids'),1,0,'C');
    $pdf->Cell(21,5,utf8_decode('Déchet (KG)'),1,1,'C');
    $pdf->SetFont('Arial','B',8);
    foreach($productions as $production){ 
        // On calcule les valeurs totales
        $TotalPoids += $production['prodpoids'];
        $TotalBarres += ($production['prodnbBarreColis']*$production['prodnbcolis'])+$production['prodnbbarrerestant'];       

        $pdf->Cell(21,5,utf8_decode($production['proddiametre']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode($production['prodnumerofin']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode($production['prodnbBarreColis']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode($production['prodnbcolis']),1,0,'C');
        $pdf->Cell(22,5,utf8_decode($production['prodnbbarrerestant']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode($production['prodlongueurbarre']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode(($production['prodnbBarreColis']*$production['prodnbcolis'])+$production['prodnbbarrerestant']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode($production['prodpoids']),1,0,'C');
        $pdf->Cell(21,5,utf8_decode($production['proddechet']),1,1,'C');
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
    $pdf->Cell(190,8,utf8_decode("Total arret : $TotalArretHReelH Heures $TotalArretHReel[1] minutes    Total poids produit : $TotalPoids     Vitesse : $Cranteuse[vitesse]"),0,1,'C');
    $pdf->Cell(190,8,utf8_decode("Temps de fonction : $TotalHeureTravaillerelleH Heures $TotalHeureTravaillerelle[1] min     Total barres produites : $TotalBarres      Poids estimatif travaillé et non noté : $Cranteuse[poidsestimetravaillenonnote] "),0,1,'C');


    $pdf->Output();

