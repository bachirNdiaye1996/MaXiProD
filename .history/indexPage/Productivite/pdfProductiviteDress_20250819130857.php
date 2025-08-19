<?php

    // On se connecte à là base de données
    session_start(); 
    
    if(!$_SESSION){
        header("location: ../../404.php");
        return 0;
    }

    include "../../connexion/conexiondb.php";

    require '../../fpdf/fpdf.php';
    
    //Variables
    $PeriodeReel = "'Aucun travailleur'";

    if($_SERVER["REQUEST_METHOD"]=='GET'){
        //Recherche une fiche
        $dateFiche=htmlspecialchars($_GET['mois']); 

            //** Debut select des production cranteuse
                $sql = "SELECT * FROM `fichedresseuse` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dateFiche';";          // On tire les fiches du mois courant
            
                // On prépare la requête
                $query = $db->prepare($sql);
            
                // On exécute
                $query->execute();
            
                // On récupère les valeurs dans un tableau associatif
                $FichesDresseuse = $query->fetchAll();
            //** Fin select des production cranteuse

            //** Debut select des production (Poids,...)
                $sql = "SELECT SUM(prodpoids) as prodpoids, idfichedresseuse as idfichedresseuse FROM `dresseuseproduction` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dateFiche' GROUP BY `idfichedresseuse`;";          
            
                // On prépare la requête
                $query = $db->prepare($sql);
            
                // On exécute
                $query->execute();
            
                // On récupère les valeurs dans un tableau associatif
                $DressProduction = $query->fetchAll();
            //** Fin select des production (Poids,...)

            //** Debut select des temps d'arret (duree,...)
                $sql = "SELECT SUM(duree) as duree, idfichedresseuse as idfichedresseuse, dateCreation as dateCreation FROM `dresseusearret` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dateFiche' GROUP BY `idfichedresseuse`;";          
            
                // On prépare la requête
                $query = $db->prepare($sql);
            
                // On exécute
                $query->execute();
            
                // On récupère les valeurs dans un tableau associatif
                $DressTempsArret = $query->fetchAll();
            //** Fin select des temps d'arret (duree,...)

        }
    }else{
        $dt = time();
        $dtm = date( "m", $dt );  // On extrait le mois courant.

        //** Debut select des production cranteuse
            $sql = "SELECT * FROM `fichedresseuse` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dtm';";          // On tire les fiches du mois courant
        
            // On prépare la requête
            $query = $db->prepare($sql);
        
            // On exécute
            $query->execute();
        
            // On récupère les valeurs dans un tableau associatif
            $FichesDresseuse = $query->fetchAll();
        //** Fin select des production cranteuse

        //** Debut select des production (Poids,...)
            $sql = "SELECT SUM(prodpoids) as prodpoids, idfichedresseuse as idfichedresseuse FROM `dresseuseproduction` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dtm' GROUP BY `idfichedresseuse`;";          
        
            // On prépare la requête
            $query = $db->prepare($sql);
        
            // On exécute
            $query->execute();
        
            // On récupère les valeurs dans un tableau associatif
            $DressProduction = $query->fetchAll();
        //** Fin select des production (Poids,...)

        //** Debut select des temps d'arret (duree,...)
            $sql = "SELECT SUM(duree) as duree, idfichedresseuse as idfichedresseuse, dateCreation as dateCreation FROM `dresseusearret` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dtm' GROUP BY `idfichedresseuse`;";          
        
            // On prépare la requête
            $query = $db->prepare($sql);
        
            // On exécute
            $query->execute();
        
            // On récupère les valeurs dans un tableau associatif
            $DressTempsArret = $query->fetchAll();
        //** Fin select des temps d'arret (duree,...)
    }

    
    $controleur1 = array_unique(array_column($FichesDresseuse,'controleur1'));
    $controleur2 = array_unique(array_column($FichesDresseuse,'controleur2'));
    //$array3 = $controleur1 + $controleur2;

    $unions = array_unique(array_merge($controleur1,$controleur2));

    // Récupération des fiches par controleur
    $ArrayFichesParControleur = array(array());
    $IdFichesDresseuse = array(array());
    $CompteurFichesDresseuse = array(array());
    foreach($unions as $union){
        foreach($FichesDresseuse as $fichesDresseuse){
            if($fichesDresseuse['controleur1']=="$union" || $fichesDresseuse['controleur2']=="$union"){
                $ArrayFichesParControleur["$union"][] = $fichesDresseuse;
                $IdFichesDresseuse["$union"][] = $fichesDresseuse['idfichedresseuse'];
                $CompteurFichesDresseuse["$union"][] = $fichesDresseuse['compteurfin']-$fichesDresseuse['compteurdebut'];
            }
        }
    }

    // Récupération des productions par controleur
    $i=0;
    //$ProductionParControleur = array(array());
    $ProductionParControleur = array ( array ());
    foreach($IdFichesDresseuse as $key => $idFichesDresseuses){
        $tempProductionParControleur=null;
        foreach($idFichesDresseuses as $idFichesDresseuse){
            foreach($DressProduction as $dressProduction){
                if($dressProduction['idfichedresseuse'] == $idFichesDresseuse){
                    $tempProductionParControleur += $dressProduction['prodpoids'];
                }
            }
        }
        $tempTempsArretParControleur=null;
        foreach($idFichesDresseuses as $idFichesDresseuse){
            foreach($DressTempsArret as $dressTempsArret){
                if($dressTempsArret['idfichedresseuse'] == $idFichesDresseuse){
                    $tempTempsArretParControleur += $dressTempsArret['duree'];
                }
                // Prendre le mois
                $Periode = $dressTempsArret['dateCreation'];
            }
        }
        $ProductionParControleur[$key]["poids"] = $tempProductionParControleur;
        $ProductionParControleur[$key]["tempsarret"] = $tempTempsArretParControleur;
        $i++;
    }


    $mois = explode( "-", $Periode); 
    switch ($mois[1]) {
        case "01":
            $PeriodeReel = "Janvier";
            break;
        case "02":
            $PeriodeReel = "Fevrier";
            break;
        case "03":
            $PeriodeReel = "Mars";
            break;
        case "04":
            $PeriodeReel = "Avril";
            break;
        case "05":
            $PeriodeReel = "Mai";
            break;
        case "06":
            $PeriodeReel = "Juin";
            break;
        case "07":
            $PeriodeReel = "Juillet";
            break;
        case "08":
            $PeriodeReel = "Aout";
            break;
        case "09":
            $PeriodeReel = "Septembre";
            break;
        case "10":
            $PeriodeReel = "Octobre";
            break;
        case "11":
            $PeriodeReel = "Novembre";
            break;
        case "12":
            $PeriodeReel = "Decembre";
            break;
    }


    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5,"DETAILS PRODUCTION",0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,14,utf8_decode(""),0,1,'C');
    $pdf->Cell(190,14,utf8_decode("La productivité des opérateurs durant le mois de $PeriodeReel à la machine dresseuse"),0,1,'C');


    //Pour les consommations
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(190,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,8,utf8_decode(""),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(60,7,utf8_decode('Prenom et Nom opérateur'),1,0,'C');
    $pdf->Cell(60,7,utf8_decode('Poids produit par opérateur (KG)'),1,0,'C');
    $pdf->Cell(60,7,utf8_decode('Temps arret par opérateur'),1,1,'C');

    $i=0;
    foreach($ProductionParControleur as $key  => $productionParControleur){
        if($i>0){   
            $pdf->Cell(60,7,utf8_decode($key),1,0,'C');
            $pdf->SetTextColor(50,60,100);
            $pdf->Cell(60,7,utf8_decode($productionParControleur['poids']),1,0,'C');
            $pdf->SetTextColor(0,0,0);
            $TotalArret = $productionParControleur["tempsarret"];
            $TotalArret = explode(":",date("H:i",$TotalArret) );
            if(($TotalArret[0]-1) == 0){
                if($TotalArret[1] == 0){}else{$pdf->Cell(60,7,utf8_decode($TotalArret[1]." minutes"),1,1,'C');}
            }else{ 
                if($TotalArret[1] == 0){
                    $pdf->Cell(60,7,utf8_decode(($TotalArret[0]-1)." Heures "),1,1,'C');
                }else{
                    $pdf->Cell(60,7,utf8_decode(($TotalArret[0]-1)." Heures ".$TotalArret[1]." minutes"),1,1,'C');
                }
            }           
        }
        $i++;
    }


    $pdf->Output();

