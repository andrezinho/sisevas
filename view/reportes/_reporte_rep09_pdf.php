<?php
session_start();
     
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{    
        
    function Header()
    {
        $fechahoy= date('d/m/Y');
        $this->Line(8, 32, 202, 32);  
        //$this->Line(8, 18, 202, 18);         
        //$this->Image('../../images/logos.jpg',8,4,30,12);
        $this->SetFont('Arial','B',9); 
        $this->SetXY(45, 34);
        //$this->Cell(0,5,'MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN',1,1,'L');
        $this->MultiCell(80, 6,utf8_decode('MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN'),0,'C');
        $this->SetXY(120, 18);
        $this->SetFont('Arial','I',6);
        //$this->Cell(12,4,'CODIGO :',0,0,'L');
        //$this->Cell(0,4,$cab[0]['codigo'],0,1,'L');
        $this->SetXY(140, 36);
        $this->Cell(12,4,'VERSION :',0,0,'L');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->SetXY(140, 41);
        $this->Cell(12,4,'Fecha :',0,0,'L');
        $this->Cell(12,4,$fechahoy,0,1,'L');
        
        $this->Line(8, 47, 202, 47);           
        
        $this->Ln(13); 
       
    }
    
    function cuerpo($rows, $tp, $tt)
    {
        switch ($tp) {
            case 1:
                $destp=('Fuentes de CapacitaciÓn'); break;
            case 2:
                $destp=('Lineas de AcciÓn'); break;
            case 3:
                $destp=('Metodo de CapacitaciÓn'); break;
            case 4:
                $destp=('Tiempo de DedicaciÓn'); break;
            case 5:
                $destp=('Tipo de Alcance'); break;
        }
        
        $anio= date('Y');
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode('Reporte segÚn '.$destp)), 0, 1, 'C');
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
        $h1=20; $h2=130; $h3=25; $h4=30; $h5= 35;
        $tr1=0; $td=0;
        $this->SetX(15);
        /*$this->SetFillColor(224,235,255);*/
        $this->SetFont('Arial','B',9);        
        
        $this->SetWidths(array($h2,$h3,$h3,$h1,$h3,$h1));
		$this->SetAligns(array(C,C,C,C,C,C));
		$this->Row(array(strtoupper(utf8_decode($destp)),
			 utf8_decode("N°"),
			 utf8_decode("%") ));
        foreach ($rows as $rs){ 
            $tr1= $tr1+$rs[1];
            $td= ($rs[1]*100)/$tt;
            $tf= $tr1+$tr2+$tr3+$tr4;
                        
            $this->SetX(15);
            $cc++;
            $this->SetFont('Arial','',10);            
            $this->Cell($h2, $Alt,utf8_decode($rs[0]), 1, 0, 'l');
            $this->SetFont('Arial','',9); 
            $this->Cell($h3, $Alt,$rs[1], 1, 0, 'R');
            $this->Cell($h3, $Alt,strtoupper(number_format($td,2)), 1, 1, 'R');
            $this->SetX(15);
            //$this->Cell(275,0,'',1,1,'C');   
        }
        $this->Cell($h2, $h0,utf8_decode('Total :'), 1, 0, 'R');
        $this->Cell($h3, $h0,$tr1, 1, 0, 'R');
        $this->Cell($h3, $h0,number_format('100'), 1, 1, 'R');
        
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
$tt =$tt[0];
//$pdf->SetAutoPageBreak(0.2 ,0.2);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM - ACTA DE CAPACITACION ::');
$pdf->SetMargins(15,10,8);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($rows, $tp, $tt);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>