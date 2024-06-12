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
$pdf->SetFont('Arial','B',16);

/* Pour l'entete */

$pdf->SetTextColor(50,60,100);
$pdf->Cell(190,18,"FICHE DE PRODUCTION $Cranteuseq1[machine]",0,0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(50,60,100);
$pdf->Cell(190,18,"DATE : $Cranteuseq1[dateCreation]          QUART : $Cranteuseq1['quart']",0,0,'C');





$pdf->Output();

