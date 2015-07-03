<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
    function Header()
    {
        //global ;
        $fec=  date('d-m-Y');
        $this->Line(10, 17, 283, 17);         
        $this->Image('images/logo.jpg',230,18,33,13);
        $this->SetFont('Arial','B',8); 
        $this->SetXY(110, 20);
        //$this->Cell(0,5,'MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN',1,1,'L');
        $this->MultiCell(55,4,utf8_decode('MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN'),0,'C');
        $this->SetXY(105, 18);
        $this->SetFont('Arial','I',6);
        $this->SetXY(175, 20);
        $this->Cell(12,4,'VERSION :',0,0,'L');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->SetXY(175, 23);
        $this->Cell(12,4,'FECHA :',0,0,'L');
        $this->Cell(0,4,$fec,0,1,'L');
        $this->Line(10, 30, 283, 30);            
        
        $this->Ln(10);       
       
    }
    
    function cuerpo($cab, $tar)
    {
        $hoy = $cab['anio']; 
        $dtpdoc= 'INFORME MEMORIA';
        $comple= 'CORE-CORPOMEDIC';
        //N° de documento
        $this->SetFont('Arial','B',9);
        $this->Cell(0, 5, strtoupper(utf8_decode($dtpdoc.' N° '.$hoy.'-'.$cab['codigo'].'-'.$comple)), 0, 1, 'C');
        $this->Ln(4);
        
        $this->SetX(60);
        //FECHA DE EMISION
        $this->SetFont('Arial','',8);
        $this->Cell(23, 5, 'FECHA INICIO', 0, 0, 'R');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        $this->SetFont('Arial','B',8);        
        $this->Cell(20, 5, $this->DecFecha($cab['fechaini']), 0, 0, 'L');
        
        $this->Cell(23, 5, '', 0, 0, 'R');
        
        $this->SetFont('Arial','',8);        
        $this->Cell(16, 5, 'FECHA FIN', 0, 0, 'R');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        $this->SetFont('Arial','B',8);
        $this->Cell(20, 5, $this->DecFecha($cab['fechafin']), 0, 0, 'L');
        
                
        $this->SetFont('Arial','',8);        
        $this->Cell(40, 5, 'UNIDAD OPERATIVA ', 0, 0, 'R');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        $this->SetFont('Arial','B',8);
        $this->Cell(30, 5, utf8_decode(strtoupper($cab['consultorio'])), 0, 1, 'L');
        
        $this->SetX(60);
        $this->SetFont('Arial','',8);
        $this->Cell(23, 5, 'RESPONSABLE', 0, 0, 'R');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        //$this->SetX(13);
        $this->SetFont('Arial','B',8);
        $this->Cell(10, 5, strtoupper(utf8_decode($cab['responsable'])), 0, 1, 'L');
        $this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(4);
 
        $this->SetFont('Arial','',8);
        $this->Cell(41, 5, strtoupper(utf8_decode('Obserevaciones')), 0,0, 'L');
        $this->Cell(2, 5, ':', 0, 1, 'R');
        $this->SetFont('Arial','B',8.5);
        $this->MultiCellp(0,4,utf8_decode($cab['observaciones']),0,'J');        
        $this->Ln(7);        
        
        //$this->SetXY(20,$this->GetY()+15);
        $this->SetFont('Arial','',9);
        $this->Cell(41, 5, strtoupper(utf8_decode('Tareas')), 0,0, 'L');
        $this->Cell(2, 5, ':', 0, 1, 'R');        
        $cc=0; $h= 6;
        $h1=7; $h2=30; $h3=122;
        $this->SetX(10);
        $this->SetFont('Arial','B',9);
        $border = 'BLT';
        $ga = 0;
        $num = 0;
        $w1=6; $w2=73; $w3=81; $w4=32; $w5=62; $w6=14; $w7=254;
        $this->Cell($w1, $h, utf8_decode('N°'), 1, 0, 'C');
        $this->Cell($w2, $h, utf8_decode('Tareas'), 1, 0, 'C');
        $this->Cell($w3, $h, utf8_decode('MOF'), 1, 0, 'C');
        $this->Cell($w4, $h, utf8_decode('Tiempo Dedicación'), 1, 0, 'C');
        $this->Cell($w5, $h, utf8_decode('Obj. Empresa'), 1, 0, 'C');
        $this->Cell($w6, $h, utf8_decode('Av. (%) '), 1, 0, 'C');
        $this->Cell($w6, $h, utf8_decode('T. (min.) '), 1, 1, 'C');
        foreach ($tar as $rs){ 
            $num= $rs['nrominutos']+$num;
            $ga= $rs['gradoavance']+$ga;
            $this->SetX(10);
            $cc++; 
            $this->SetFont('Arial','',7);
            $this->SetWidths(array($w1,$w2, $w3, $w4, $w5, $w6, $w6));
            $this->SetAligns(array(C,L, L, L, L, C, R));
            $this->Row(array( $cc, utf8_decode($rs['tarea']),
                utf8_decode($rs['func']),
                utf8_decode($rs['eje']),
                utf8_decode($rs['obj']),
                utf8_decode($rs['gradoavance']),
                utf8_decode($rs['nrominutos'])
            ));
            
        }
        $this->Ln();
        $this->SetFont('Arial','B',9);
        $this->Cell($w7, 6, utf8_decode('Total :'), 1, 0, 'R');
        $this->Cell($w6, 6, number_format($ga/$cc,2), 1, 0, 'C');
        $this->Cell($w6, 6, number_format($num/60)." Hrs", 1, 1, 'C');
        
        $this->Ln(4);
        $this->SetFont('Arial','',8);
        $this->Cell(41, 5, strtoupper(utf8_decode('Notas')), 0,0, 'L');
        $this->Cell(2, 5, ':', 0, 1, 'R');
        $y= $this->GetY();
        $this->SetFont('Arial','B',8.5);
        $this->MultiCell(0,4,utf8_decode($cab['notas']),'0','J');
                
    } 
    /*
    function Footer()
    {
         $this->SetY(-10);
        $this->SetFont('Arial','',6);
        $this->Cell(0, 4, utf8_decode('Prohibida la Reproducción Total o Parcial de este documento sin la autorización del Representante de la Dirección.'), 0, 1, 'C');
       
    }

    */
}

//print_r($tar[0]);
//$idtpdoc= $_GET('idtpdoc');
$pdf= new PDF('P','mm', 'A4');
//$pdf->SetAutoPageBreak(1 ,0.5);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM TRAMITE DOCUMENTARIO ::');
$pdf->SetMargins(10,15,15);
$pdf->AliasNbPages();
$pdf->AddPage('A','A4');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($cab, $tar);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>