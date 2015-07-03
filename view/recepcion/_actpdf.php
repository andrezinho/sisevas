<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
    function Header()
    {
        //global ;
        $this->Line(7, 17, 142, 17);         
        //$this->Image('../../images/logos.jpg',7,4,30,12);
        $this->SetFont('Arial','B',8); 
        $this->SetXY(40, 19);
        //$this->Cell(0,5,'MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN',1,1,'L');
        $this->MultiCell(55,4,utf8_decode('MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN'),0,'C');
        $this->SetXY(105, 18);
        $this->SetFont('Arial','I',6);
        //$this->Cell(12,4,'CODIGO :',0,0,'L');
        //$this->Cell(0,4,$cab[0]['codigo'],0,1,'L');
        $this->SetXY(105, 21);
        $this->Cell(12,4,'VERSION :',0,0,'L');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->Line(7, 28, 142, 28);            
        
        $this->Ln(15);       
       
    }
    
    function cuerpo($cab, $det)
    {
        $hoy = $cab[0]['anio']; 
        $idtpdoc = $cab[0]['idtipo_documento'];
        //N° de documento
        $this->SetFont('Arial','B',9);
        $this->Cell(0, 5, strtoupper(utf8_decode($cab[0]['descripcion'].' N° '.$hoy.'-'.$cab[0]['codigo'])), 0, 1, 'C');
        $this->Ln(4);
        
        //FECHA DE EMISION
        $this->SetFont('Arial','',8);
        $this->Cell(14, 5, 'FECHA', 0, 0, 'L');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        $this->SetFont('Arial','B',8);        
        $this->Cell(20, 5, utf8_decode($cab[0]['fecha']), 0, 0, 'L');
        
        $this->Cell(4, 5, '', 0, 0, 'R');
        
        $this->SetFont('Arial','',8);        
        $this->Cell(20, 5, 'HORA INICIO', 0, 0, 'L');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        $this->SetFont('Arial','B',8);
        $horai= date_format(date_create($cab[0]['horainicio']),'h:i a');
        $this->Cell(22, 5, utf8_decode($horai), 0, 0, 'L');
        
        $this->Cell(2, 5, '', 0, 0, 'R');
        
        $this->SetFont('Arial','',8);        
        $this->Cell(18, 5, 'HORA FIN', 0, 0, 'L');
        $this->Cell(2, 5, ':', 0, 0, 'R');
        $this->SetFont('Arial','B',8);
        $horaf= date_format(date_create($cab[0]['horafin']),'h:i a');
        $this->Cell(30, 5, utf8_decode($horaf), 0, 1, 'L');
        
        $this->SetFont('Arial','',8.5);
        $this->Cell(30, 5, 'LUGAR DE REUNION', 0, 0, 'L');
        $this->Cell(2, 5, ':', 0, 1, 'R');
        $this->SetX(13);
        $this->SetFont('Arial','B',8.5);
        $this->Cell(10, 5, strtoupper(utf8_decode($cab[0]['lugarreu'])), 0, 1, 'L');
        $this->Ln();
        if($idtpdoc==10)
        {
            $this->SetFont('Arial','',8.5);
            $this->Cell(50, 5, 'TEMA DE CAPACITACION / AGENDA', 0, 0, 'L');
            $this->Cell(2, 5, ':', 0, 1, 'R');
            $this->SetX(13);
            $this->SetFont('Arial','B',8.5);
            $this->MultiCellp(130, 4, strtoupper(utf8_decode($cab[0]['asunto'])), 0, 'J'); 
        }
        //$this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(8);

        $this->SetFont('Arial','',8);
        $this->Cell(20, 5, 'ACUERDOS', 0, 0, 'L');
        $this->Cell(2, 5, ':', 0, 1, 'R');
        $this->SetFont('Arial','',9);
        $this->MultiCellp(130,4,utf8_decode($cab[0]['problema']),0,'J');
        $this->Ln(5);
        /*$y1 = $this->GetY();
        $dy= $y1 - $y;*/
        $this->SetFont('Arial','B',8);
        //$this->SetXY($x, $y1 + $dy+ 85);
        $this->Cell(10, 5, strtoupper(utf8_decode('ASISTENTES : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0; $h0= 5;
        $h1=7; $h2=30; $h3=122;
        $this->SetX(10);
        $this->SetFont('Arial','B',8);
        
        foreach ($det as $rs){
            $this->SetX(10);
            $cc++;
            $this->SetFont('Arial','',8);
            $this->SetWidths(array($h1,$h3));
            $this->SetAligns(array(C,L));
            $this->Row(array( strtoupper(utf8_decode($cc)),
                utf8_decode($rs['asistentes'].", ".$rs['descripcion'])
            
            ));
            
        }
    } 
    
    function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('Arial','',6);
        $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
       
    }

}

//$idtpdoc= $_GET('idtpdoc');
$pdf= new PDF('P','mm', 'A5');
//$pdf->SetAutoPageBreak(1 ,0.5);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM TRAMITE DOCUMENTARIO ::');
$pdf->SetMargins(10,10,7);
$pdf->AliasNbPages();
$pdf->AddPage('P','A5');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($cab, $det);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>