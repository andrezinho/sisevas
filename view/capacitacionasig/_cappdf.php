<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
    function Header()
    {
        //global ;
        /*$this->Line(7, 17, 142, 17);         
        //$this->Image('../../images/logos.jpg',7,4,30,12);
        $this->SetFont('Arial','B',8); 
        $this->SetXY(40, 19);
        //$this->Cell(0,5,'MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN',1,1,'L');
        /*$this->MultiCell(55,4,utf8_decode('MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN'),0,'C');
        $this->SetXY(105, 18);
        $this->SetFont('Arial','I',6);
        //$this->Cell(12,4,'CODIGO :',0,0,'L');
        //$this->Cell(0,4,$cab[0]['codigo'],0,1,'L');
        $this->SetXY(105, 21);
        $this->Cell(12,4,'VERSION :',0,0,'L');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->Line(7, 28, 142, 28);  */          
        
        $this->Ln(15);       
       
    }
    
    function cuerpo($cab,$objemp,$asig)
    {
        
        $this->SetFont('Arial','B',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('CAPACITACIÓN : '.$cab['codigo'])), 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(3);
        
        $this->SetFont('Arial','B',7);        
        $this->Cell(44, 5,strtoupper(utf8_decode('Fuente de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['fuente']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Eje de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['eje']), 0, 1, 'L');

        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Tema de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['tema']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Objetivo de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->MultiCell(85,5,utf8_decode($cab['obejtivoscap']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',7);
        $this->Cell(54, 5,strtoupper(utf8_decode('Alcance al Objetivo de la empresa')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',9);        
        
        $c=0;
        foreach ($objemp as $r){                
            $this->SetX(20);
            $c++;
            $this->MultiCell(125,4,utf8_decode($c.".- ".$r['descripcion']),0,'J',false);
            $this->Ln(5);      
        }                
        $this->Ln(3);         
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Método de capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        //$this->Cell(90, 5, utf8_decode($cab['metodo']), 1, 1, 'L');
        $this->MultiCell(85,5,utf8_decode($cab['metodo']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Tipo de evaluación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['tipoeval']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Propuesta (Contenido)')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',9);
        $this->SetX(20);
        $this->MultiCell(122,5,utf8_decode($cab['propuesta']),0,'J',false);
        $this->Ln(15);
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Referencia Bibliográfica')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',9);
        $this->SetX(20);
        $this->MultiCell(122,5,utf8_decode($cab['referencias']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Palabras Claves del Tema')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',9);
        $this->SetX(20);
        $this->MultiCell(122,5,utf8_decode($cab['palabrasclaves']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Expositor')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['expoitor']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Email del Expositor')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['mail']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Fecha de la Capacitación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['fecha']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',7);
        $this->Cell(44, 5,strtoupper(utf8_decode('Hora de la Capacitación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',9);
        $this->Cell(0, 5, utf8_decode($cab['hora']), 0, 1, 'L');
        $this->Ln(3);

        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, utf8_decode('Asignados (as) a la Capacitación : '), 0, 1, 'L');
        $this->Ln(2);
        $cc=0;

        $this->SetX(20);
        $this->SetFont('Arial','B',7);
        $this->Cell(10, 4,strtoupper(utf8_decode('n° ')), 1, 0, 'C');
        $this->Cell(20, 4,strtoupper(utf8_decode('dni')), 1, 0, 'C');
        $this->Cell(50, 4,strtoupper(utf8_decode('nombres')), 1, 0, 'C');
        $this->Cell(30, 4,strtoupper(utf8_decode('tipo alcance')), 1, 1, 'C');

        foreach ($asig as $rs){                
            $this->SetX(20);
            $cc++;
            $this->SetFont('Arial','',7);
            $this->Cell(10, 5,strtoupper(utf8_decode($cc)), 0, 0, 'C');
            $this->Cell(20, 5,strtoupper(utf8_decode($rs['dni'])), 0, 0, 'C');
            $this->Cell(50, 5,strtoupper(utf8_decode($rs['personal'])), 0, 0, 'L');
            $this->Cell(30, 5,strtoupper(utf8_decode($rs['descripcion'])), 0, 1, 'L');
            $this->SetX(20);
            $this->Cell(110,0,'',1,1,'C');   
        }                
        
        
    } 

    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial','',6);
        $this->Cell(0, 4, utf8_decode('Prohibida la Reproducción Total o Parcial de este documento sin la autorización del Representante de la Dirección.'), 0, 1, 'C');
        $this->Cell(0, 4, utf8_decode('SISEVAS v. 1.5'), 0, 1, 'C');
    }

    
}

//$nombre = $cabecera[0]['nombres'];
//print_r($objemp);
$pdf= new PDF('P','mm', 'A5');
$pdf->SetAutoPageBreak(0.2 ,0.2);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM - CAPACITACION ::');
$pdf->SetMargins(10,5,7);
$pdf->AliasNbPages();
$pdf->AddPage('P','A5');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($cab,$objemp,$asig);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>