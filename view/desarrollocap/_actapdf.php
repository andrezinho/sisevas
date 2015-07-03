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
        
        $this->Ln(15);       
       
    }
    
    function cuerpo($cab, $acuerdo, $asig)
    {
        $anio= date('Y');
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode($cab['nroacta'].'-CORPOMEDIC-'.$anio)), 0, 1, 'C');
        $this->Ln(2);
        //$this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(3);
        
        $w=48; $f=10;
        $this->SetFont('Arial','B',8);        
        $this->Cell($w, 5,strtoupper(utf8_decode('Fecha Capacitación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['fecha']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Lugar de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, strtoupper(utf8_decode($cab['lugarreunion'])), 0, 1, 'L');
        $this->Ln(3); 
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5, strtoupper(utf8_decode('Tema de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['tema']), 0, 1, 'L'); 
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5, strtoupper(utf8_decode('Hora Inicio')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        
        $hora= date_format(date_create($cab['hora']),'h:i a');
        $this->Cell(40, 5, utf8_decode($hora), 0, 0, 'L'); 
        
        $this->SetFont('Arial','B',8);
        $this->Cell(35, 5,strtoupper(utf8_decode('Hora Fin')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        
        $horafin= date_format(date_create($cab['horafin']),'h:i a');
        $this->Cell(30, 5, utf8_decode($horafin), 0, 0, 'L');
              
        $this->Ln(10);        
        
        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('ACUERDOS / AGENDAS : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0;
        $h0= 5;
        $h1=7; $h2=30; $h3=145; $h4=40;
        $this->SetX(10);
        $this->SetFillColor(224,235,255);
        $this->SetFont('Arial','B',8);
        
        $this->SetWidths(array($h1,$h3,$h4 ));
		$this->SetAligns(array(C,C,C));
		$this->Row(array( strtoupper(utf8_decode('n° ')),
			 strtoupper(utf8_decode('ACUERDO')),
			 strtoupper(utf8_decode('Responsable')) ));
        /*
        $this->Cell($h1, $h0,strtoupper(utf8_decode('n° ')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('ACUERDO')), 1, 0, 'C');
        $this->Cell($h4, $h0,strtoupper(utf8_decode('Responsable')), 1, 1, 'C');
        */
        
        foreach ($acuerdo as $rs){  
            //print_r($rs);
            $this->SetX(10);
            $cc++;
            $this->SetFont('Arial','',8);
            $this->SetWidths(array($h1,$h3,$h4 ));
            $this->SetAligns(array(C,L,L));
            $this->Row(array( strtoupper(utf8_decode($cc)),
			 strtoupper(utf8_decode($rs['acuerdo'])),
			 strtoupper(utf8_decode($rs['asistente'])) ));
            /*$this->Cell($h1, 5,strtoupper(utf8_decode($cc)), 0, 0, 'C');
            $this->MultiCell($h3,5,utf8_decode($rs['acuerdo']),0,'J',false);
            //$this->Cell($h3, 5,utf8_decode($rs['acuerdo']), 0, 0, 'L');
            $this->Cell($h4, 5,strtoupper(utf8_decode($rs['nombres'])), 0, 1, 'L');
            $y = $this->GetY();
            */
            //$this->Line(10, $y+5, 202, $y+5);
            //$this->Cell(192,0,'',1,1,'C');   
        } 
        
        $this->Ln(10);
        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('Asistentes a la Capacitación : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0; $Alt= 7;
        $h0= 5;
        $h1=10; $h2=25; $h3=90; $h4=30; $h5= 35;
        $this->SetX(10);
        $this->SetFillColor(224,235,255);
        $this->SetFont('Arial','B',9);
        
        $this->Cell($h1, $h0,strtoupper(utf8_decode('n° ')), 1, 0, 'C');
        $this->Cell($h2, $h0,strtoupper(utf8_decode('dni')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('nombres y apellidos')), 1, 0, 'C');
        $this->Cell($h4, $h0,strtoupper(utf8_decode('tipo alcance')), 1, 0, 'C');
        $this->Cell($h5, $h0,strtoupper(utf8_decode('firma')), 1, 1, 'C');
        foreach ($asig as $rs){                
            $this->SetX(10);
            $cc++;
            $this->SetFont('Arial','',8);
            $this->Cell($h1, $Alt,strtoupper(utf8_decode($cc)), 0, 0, 'C');
            $this->Cell($h2, $Alt,strtoupper(utf8_decode($rs['dni'])), 0, 0, 'C');
            $this->Cell($h3, $Alt,strtoupper(utf8_decode($rs['personal'])), 0, 0, 'L');
            $this->Cell($h4, $Alt,strtoupper(utf8_decode($rs['descripcion'])), 0, 1, 'C');
            $this->SetX(10);
            $this->Cell(190,0,'',1,1,'C');   
        } 
        
    } 

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial','',6);
        $this->Cell(0, 4, utf8_decode('Prohibida la Reproducción Total o Parcial de este documento sin la autorización del Representante de la Dirección.'), 0, 1, 'C');
        $this->Cell(0, 4, utf8_decode('SISEVAS v. 1.5'), 0, 1, 'C');
    }
    
}

//$nombre = $cabecera[0]['nombres'];
//print_r($rowsd);
$pdf= new PDF('P','mm', 'A4');
//$pdf->SetAutoPageBreak(0.2 ,0.2);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM - ACTA DE CAPACITACION ::');
$pdf->SetMargins(10,10,8);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($cab, $acuerdo, $asig);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>