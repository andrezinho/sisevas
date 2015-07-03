<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
    function Header()
    {
        //global ;
        //$this->Ln(10);
        $fechahoy= date('d/m/Y');
        $this->Line(8, 32, 285, 32);  
        //$this->Line(8, 18, 202, 18);         
        //$this->Image('../../images/logos.jpg',8,4,30,12);
        $this->SetFont('Arial','B',9); 
        $this->SetXY(80, 34);
        //$this->Cell(0,5,'MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN',1,1,'L');
        $this->MultiCell(80, 6,utf8_decode('MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN'),0,'C');
        $this->SetXY(120, 18);
        $this->SetFont('Arial','I',6);
        //$this->Cell(12,4,'CODIGO :',0,0,'L');
        //$this->Cell(0,4,$cab[0]['codigo'],0,1,'L');
        $this->SetXY(180, 36);
        $this->Cell(12,4,'VERSION :',0,0,'L');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->SetXY(180, 41);
        $this->Cell(12,4,'Fecha :',0,0,'L');
        $this->Cell(12,4,$fechahoy,0,1,'L');
        
        $this->Line(8, 47, 285, 47);           
        
        $this->Ln(12);       
       
    }
    
    function cuerpo($rows, $tp)
    {
        switch ($tp) {
            case 1:
                $destp='Objetivos de CapacitaciÓn / Tipo Alcance';
                $title='Objetivos de CapacitaciÓn segÚn Tipo Alcance'; break;
            case 2:
                $destp='Tiempo de DedicaciÓn / Tipo Alcance';
                $title='Tiempo de DedicaciÓn segÚn Tipo Alcance'; break;
            case 3:
                $destp='Personal / Tipo Alcance';
                $title='Personal segÚn Tipo Alcance'; break;
            case 4:
                $destp='Objetivos de la empresa / Tipo Alcance';
                $title='Objetivos de la empresa segÚn Tipo Alcance'; break;
            case 5:
                $destp='Lineas de AcciÓn / Tipo Alcance';
                $title='Lineas de AcciÓn segÚn Tipo Alcance'; break;
        }
        
        $anio= date('Y');
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode('Reporte por '.$title)), 0, 1, 'C');
        $this->Ln(3);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,0,'INDICADOR DE ESTRUCTURA',0,1,'C'); 
        $this->Ln(7);
        
        $w=48; $f=10;
        
        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('Resultados : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0; $Alt= 7;
        $h0= 5;
        $h1=10; $h2=185; $h3=25; $h4=30; $h5= 35;
        $tr1=0;$tr2=0;$tr3=0;
        
        $this->SetX(10);
        $this->SetFillColor(224,235,255);
        $this->SetFont('Arial','B',8);        
        
        $this->Cell($h2, $h0,strtoupper(utf8_decode($destp)), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Planificado')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Obligatorio')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Voluntario')), 1, 0, 'C');
        $this->Cell($h1, $h0,strtoupper(utf8_decode('T ')), 1, 1, 'C');
        foreach ($rows as $rs){ 
            $tr1= $tr1+$rs[1];
            $tr2= $tr2+$rs[2];
            $tr3= $tr3+$rs[3];
            $tf= $tr1+$tr2+$tr3;
                        
            $this->SetX(10);
            $cc++;
            $this->SetFont('Arial','',9.5);            
            $this->Cell($h2, $Alt,utf8_decode($rs[0]), 0, 0, 'l');
            $this->SetFont('Arial','',9); 
            $this->Cell($h3, $Alt,strtoupper(utf8_decode($rs[1])), 0, 0, 'C');
            $this->Cell($h3, $Alt,strtoupper(utf8_decode($rs[2])), 0, 0, 'C');
            $this->Cell($h3, $Alt,strtoupper(utf8_decode($rs[3])), 0, 0, 'C');
            $this->Cell($h1, $Alt,utf8_decode($rs[1]+$rs[2]+$rs[3]), 0, 1, 'C');
            $this->SetX(10);
            $this->Cell(270,0,'',1,1,'C');   
        }
        $this->Cell($h2, $h0,strtoupper(utf8_decode('Total :')), 1, 0, 'R');
        $this->Cell($h3, $h0,strtoupper(utf8_decode($tr1)), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode($tr2)), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode($tr3)), 1, 0, 'C');
        $this->Cell($h1, $h0,strtoupper(utf8_decode($tf)), 1, 1, 'C');
        
    } 

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial','',6);
        $this->Cell(0, 4, utf8_decode('Prohibida la Reproducción Total o Parcial de este documento sin la autorización del Representante de la Dirección.'), 0, 1, 'C');
        $this->Cell(0, 4, utf8_decode('SISEVAS v. 1.5'), 0, 1, 'C');
    }
    
}

$tp = $_GET['tp'];
$pdf= new PDF('P','mm', 'A4');
//$pdf->SetAutoPageBreak(0.2 ,0.2);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM - ACTA DE CAPACITACION ::');
$pdf->SetMargins(10,10,8);
$pdf->AliasNbPages();
$pdf->AddPage('A','A4');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($rows, $tp);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>