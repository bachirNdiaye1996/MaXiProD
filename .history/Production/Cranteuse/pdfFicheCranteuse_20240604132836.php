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




$pdf->Output();

