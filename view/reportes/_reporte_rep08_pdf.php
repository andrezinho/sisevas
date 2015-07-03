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
        
        $this->Ln(15);       
       
    }
    
    function cuerpo($rows, $tp)
    {
        switch ($tp) {
            case 1:
                $destp=utf8_decode('Objetivos de Capacitación / Cat. de Presupuesto');
                $title=('Objetivos de Capacitación según Cat. de Presupuesto'); break;
            case 2:
                $destp=utf8_decode('Eje de Capacitación / Cat. de Presupuesto');
                $title=('Eje de Capacitación según Cat. de Presupuesto'); break;
            case 3:
                $destp=utf8_decode('Personal / Cat. de Presupuesto');
                $title=('Personal según Cat. de Presupuesto'); break;
            case 4:
                $destp=utf8_decode('Objetivos de la empresa / Cat. de Presupuesto');
                $title=('Objetivos de la empresa según Cat. de Presupuesto'); break;
            case 5:
                $destp=utf8_decode('Lineas de Acción / Cat. de Presupuesto');
                $title=('Lineas de Acción según Cat. de Presupuesto'); break;
        }
        
        $anio= date('Y');
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode('Reporte por '.$title)), 0, 1, 'C');
        $this->Ln(2);
        //$this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(7);
        
        $w=48; $f=10;
        
        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('Resultados : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0; $Alt= 7;
        $h0= 5;
        $h1=20; $h2=160; $h3=25; $h4=30; $h5= 35;
        $tr1=0;$tr2=0;$tr3=0;$tr4=0;
        
        $this->SetX(10);
        /*$this->SetFillColor(224,235,255);*/
        $this->SetFont('Arial','B',9);        
        
        $this->SetWidths(array($h2,$h3,$h3,$h1,$h3,$h1));
		$this->SetAligns(array(C,C,C,C,C,C));
		$this->Row(array($destp,
			 "Subvencion a Investigadores",
			 utf8_decode("Supervisión y monitoreo"),
			 "Bienes y Servicios",
			 "Equipamiento",
			 "Total "));
                             
        /*$this->Cell($h2, $h0,strtoupper(utf8_decode($destp)), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Subvencion a Investigadores')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Supervisión y monitoreo')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Bienes y Servicios')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Equipamiento')), 1, 0, 'C');
        $this->Cell($h1, $h0,strtoupper(utf8_decode('T ')), 1, 1, 'C');*/
        foreach ($rows as $rs){ 
            $tr1= $tr1+$rs[1];
            $tr2= $tr2+$rs[2];
            $tr3= $tr3+$rs[3];
            $tr4= $tr4+$rs[4];
            $tf= $tr1+$tr2+$tr3+$tr4;
                        
            $this->SetX(10);
            $cc++;
            $this->SetFont('Arial','',7.5);            
            $this->Cell($h2, $Alt,strtoupper(utf8_decode($rs[0])), 1, 0, 'l');
            $this->SetFont('Arial','',9); 
            $this->Cell($h3, $Alt,strtoupper(number_format($rs[1],2)), 1, 0, 'R');
            $this->Cell($h3, $Alt,strtoupper(number_format($rs[2],2)), 1, 0, 'R');
            $this->Cell($h1, $Alt,strtoupper(number_format($rs[3],2)), 1, 0, 'R');
            $this->Cell($h3, $Alt,strtoupper(number_format($rs[4],2)), 1, 0, 'R');
            $this->Cell($h1, $Alt,number_format($rs[1]+$rs[2]+$rs[3],2), 1, 1,'R');
            $this->SetX(10);
            //$this->Cell(275,0,'',1,1,'C');   
        }
        $this->Cell($h2, $h0,utf8_decode('Total :'), 1, 0, 'R');
        $this->Cell($h3, $h0,number_format($tr1,2), 1, 0, 'R');
        $this->Cell($h3, $h0,number_format($tr2,2), 1, 0, 'R');
        $this->Cell($h1, $h0,number_format($tr3,2), 1, 0, 'R');
        $this->Cell($h3, $h0,number_format($tr4,2), 1, 0, 'R');
        $this->Cell($h1, $h0,number_format($tf,2), 1, 1, 'R');
        
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