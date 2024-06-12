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




$pdf = new FPDF('P','mm','A4');


$pdf->AddPage();
$pdf->SetFont('Arial','B',18);

/* Pour l'entete */

$pdf->SetTextColor(50,60,100);
$pdf->Cell(55,29,'METAL AFRIQUE',1,0);
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(139,8,utf8_decode('                          Systéme de Management Intégré                                       ').utf8_decode('Création : ').$articleDA['datecreation'],0,1);
$pdf->SetFont('Arial','B',19);
$pdf->Cell(55,28,'           * * *',0,0);
$pdf->SetFont('Arial','B',8);    
if(empty($articleDA['datelivraison'])){
    $pdf->Cell(139,8,utf8_decode('                                                                                                                         '.utf8_decode('Livraison : ')."En attente livraison"/*.$_POST['date']*/),0,1);
}else{
    //$pdf->Cell(139,8,utf8_decode('                                                                                                                         '.utf8_decode('Livraison : ').$articleDA['datelivraison']/*.$_POST['date']*/),0,1);
}
$pdf->SetFont('Arial','B',12);
$pdf->Cell(148,13,"                                              DEMANDE D'APPROVISIONNEMENT (D.A)",0,0,'C');
$pdf->Line(160,39,19,39);
$pdf->Line(160,26,65,26);
$pdf->Line(204,18,158,18);
$pdf->Line(204,10,204,27);
$pdf->Line(204,10,65,10);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(46,13,utf8_decode('Code : PS4_ENR_03_00'),1,1);
$pdf->Line(158,10,158,27);

$pdf->SetTextColor(0,0,0);
/* Pour Identification poste */
$pdf->SetFont('Arial','B',14);
$pdf->Cell(194,3,'',0,1);
$pdf->SetTextColor(50,60,100);
//$pdf->Cell(194,10,'DA NUMERO '.$_GET['id'],1,1,'C');
$pdf->SetTextColor(0,0,0);

$pdf->Cell(194,2,'',0,1);
$pdf->SetTextColor(50,60,100);
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(194,6,utf8_decode("DEMANDE DES PIECES (".$nb_articlesP.")"),0,1,'C');
$pdf->SetTextColor(0,0,0);



$i=0;
//foreach($articles as $article){
    $i++;

/* Pour Identification */
$pdf->SetFont('Arial','B',7);
$pdf->Cell(194,1,'',0,1);
$pdf->SetTextColor(50,60,100);
$pdf->Cell(194,4,utf8_decode("Demande N° ".$i),1,1,'C');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(70,5,utf8_decode('Quantités'),1,0);
$pdf->Cell(70,5,utf8_decode('Désignations'),1,0);
//$pdf->Cell(124,5,utf8_decode($article['designations']),1,1,'C');
$pdf->Cell(70,5,utf8_decode('Références'),1,0);
$pdf->Cell(70,5,utf8_decode('Priorités'),1,0);
$pdf->Cell(70,5,utf8_decode('Nombre de piéces livré'),1,0);
$pdf->Cell(70,5,'Status',1,0);
$pdf->Cell(70,5,utf8_decode('Créée par'),1,0);
//$sql3 = "SELECT * FROM `transporteur` where id=$idDemandeur1;";

//}



$pdf->Output();

