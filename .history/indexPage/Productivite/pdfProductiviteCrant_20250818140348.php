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


  if($_SERVER["REQUEST_METHOD"]=='POST'){
    //Recherche une fiche
        if(isset($_POST['ChercheTempsArret'])){
            $dateFiche=htmlspecialchars($_POST['dateFiche']); 

            //** Debut select des production cranteuse
                $sql = "SELECT * FROM `fichecranteuseq1` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dateFiche';";          // On tire les fiches du mois courant
            
                // On prépare la requête
                $query = $db->prepare($sql);
            
                // On exécute
                $query->execute();
            
                // On récupère les valeurs dans un tableau associatif
                $FichesCranteuse = $query->fetchAll();
            //** Fin select des production cranteuse

            //** Debut select des production (Poids,...)
                $sql = "SELECT SUM(prodpoids) as prodpoids, idfichecranteuseq1 as idfichecranteuseq1 FROM `cranteuseq1production` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dateFiche' GROUP BY `idfichecranteuseq1`;";          
            
                // On prépare la requête
                $query = $db->prepare($sql);
            
                // On exécute
                $query->execute();
            
                // On récupère les valeurs dans un tableau associatif
                $CrantProduction = $query->fetchAll();
            //** Fin select des production (Poids,...)

            //** Debut select des temps d'arret (duree,...)
                $sql = "SELECT SUM(duree) as duree, idfichecranteuseq1 as idfichecranteuseq1, dateCreation as dateCreation FROM `cranteuseq1arret` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dateFiche' GROUP BY `idfichecranteuseq1`;";          
            
                // On prépare la requête
                $query = $db->prepare($sql);
            
                // On exécute
                $query->execute();
            
                // On récupère les valeurs dans un tableau associatif
                $CrantTempsArret = $query->fetchAll();
            //** Fin select des temps d'arret (duree,...)

        }
    }else{
        $dt = time();
        $dtm = date( "m", $dt );  // On extrait le mois courant.

        //** Debut select des production cranteuse
            $sql = "SELECT * FROM `fichecranteuseq1` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dtm';";          // On tire les fiches du mois courant
        
            // On prépare la requête
            $query = $db->prepare($sql);
        
            // On exécute
            $query->execute();
        
            // On récupère les valeurs dans un tableau associatif
            $FichesCranteuse = $query->fetchAll();
        //** Fin select des production cranteuse

        //** Debut select des production (Poids,...)
            $sql = "SELECT SUM(prodpoids) as prodpoids, idfichecranteuseq1 as idfichecranteuseq1 FROM `cranteuseq1production` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dtm' GROUP BY `idfichecranteuseq1`;";          
        
            // On prépare la requête
            $query = $db->prepare($sql);
        
            // On exécute
            $query->execute();
        
            // On récupère les valeurs dans un tableau associatif
            $CrantProduction = $query->fetchAll();
        //** Fin select des production (Poids,...)

        //** Debut select des temps d'arret (duree,...)
            $sql = "SELECT SUM(duree) as duree, idfichecranteuseq1 as idfichecranteuseq1, dateCreation as dateCreation FROM `cranteuseq1arret` WHERE `actif`=1 AND MONTH(`dateCreation`)='$dtm' GROUP BY `idfichecranteuseq1`;";          
        
            // On prépare la requête
            $query = $db->prepare($sql);
        
            // On exécute
            $query->execute();
        
            // On récupère les valeurs dans un tableau associatif
            $CrantTempsArret = $query->fetchAll();
        //** Fin select des temps d'arret (duree,...)
    }

    
    $controleur1 = array_unique(array_column($FichesCranteuse,'controleur1'));
    $controleur2 = array_unique(array_column($FichesCranteuse,'controleur2'));
    //$array3 = $controleur1 + $controleur2;

    $unions = array_unique(array_merge($controleur1,$controleur2));

    // Récupération des fiches par controleur
    $ArrayFichesParControleur = array(array());
    $IdFichesCranteuse = array(array());
    $CompteurFichesCranteuse = array(array());
    foreach($unions as $union){
        foreach($FichesCranteuse as $fichesCranteuse){
            if($fichesCranteuse['controleur1']=="$union" || $fichesCranteuse['controleur2']=="$union"){
                $ArrayFichesParControleur["$union"][] = $fichesCranteuse;
                $IdFichesCranteuse["$union"][] = $fichesCranteuse['idfichecranteuseq1'];
                $CompteurFichesCranteuse["$union"][] = $fichesCranteuse['compteurfin']-$fichesCranteuse['compteurdebut'];
            }
        }
    }

    // Récupération des productions par controleur
    $i=0;
    $ProductionParControleur = array ( array ());
    foreach($IdFichesCranteuse as $key => $idFichesCranteuses){
        $tempProductionParControleur=null;
        foreach($idFichesCranteuses as $idFichesCranteuse){
            foreach($CrantProduction as $crantProduction){
                if($crantProduction['idfichecranteuseq1'] == $idFichesCranteuse){
                    $tempProductionParControleur += $crantProduction['prodpoids'];
                }
            }
        }
        $tempTempsArretParControleur=null;
        foreach($idFichesCranteuses as $idFichesCranteuse){
            foreach($CrantTempsArret as $crantTempsArret){
                if($crantTempsArret['idfichecranteuseq1'] == $idFichesCranteuse){
                    $tempTempsArretParControleur += $crantTempsArret['duree'];
                }
                // Prendre le mois
                $Periode = $crantTempsArret['dateCreation'];
            }
        }
        $ProductionParControleur[$key]["poids"] = $tempProductionParControleur;
        $ProductionParControleur[$key]["tempsarret"] = $tempTempsArretParControleur;
        $i++;
    } 
    $PeriodeReel = implode('-',array_reverse  (explode('-',$Periode))); 


    $pdf = new FPDF('P','mm','A4');


    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);

    /* Pour l'entete */

    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,5,"FICHE DE PRODUCTION",0,1,'C');
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,14,utf8_decode(""),0,1,'C');
    $pdf->Cell(190,14,utf8_decode("La productivité des opérateurs dans la période du  $PeriodeReel à la machine cranteuse"),0,1,'C');


    //Pour les consommations
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(190,10,'',0,1);
    $pdf->SetTextColor(50,60,100);
    $pdf->Cell(190,8,utf8_decode("Consommations"),0,1,'C');
    $pdf->SetFont('Arial','B',7);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(38,5,utf8_decode('Prenom et Nom opérateur'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Poids produit par opérateur'),1,0,'C');
    $pdf->Cell(38,5,utf8_decode('Temps arret par opérateur'),1,1,'C');

    $i=0;
    foreach($ProductionParControleur as $key  => $productionParControleur){
        if($i>0){   
            $pdf->Cell(38,5,utf8_decode($key),1,0,'C');
            $pdf->Cell(38,5,utf8_decode($productionParControleur['poids']),1,0,'C');
            $TotalArret = $productionParControleur["tempsarret"];
            $TotalArret = explode(":",date("H:i",$TotalArret) );
            $pdf->Cell(38,5,
                if(($TotalArret[0]-1) == 0){
                    if($TotalArret[1] == 0){}else{echo $TotalArret[1]." minutes";}
                }else{
                    echo ($TotalArret[0]-1)." Heures ";
                    if($TotalArret[1] == 0){}else{echo $TotalArret[1]." minutes";}
                }           
            ,1,1,'C');
        }
    }


    $pdf->Output();

