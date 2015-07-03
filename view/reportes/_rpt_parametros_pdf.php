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
        $this->Cell(12,4,'VERSION :',0,0,'R');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->SetXY(140, 41);
        $this->Cell(12,4,'Fecha :',0,0,'R');
        $this->Cell(12,4,$fechahoy,0,1,'L');
        
        $this->Line(8, 47, 202, 47);           
        
        $this->Ln(15); 
       
    }
    
    function cuerpo($rows, $tp, $dat1)
    {
        $destp=('Ranking de Evaluación');
        $anio = $_GET['anio'];
        $periodo = $dat1[2];
        if($periodo==''){ $periodo='TODOS';}
        
        $comp= $dat1[1];
        $asp=$dat1[4];
        if($asp==''){ $asp='NINGUNO';}
        
        $idcomp= $dat1[0];
        $idasp= $dat1[3];
        
        if($idasp== '')
        {
            switch ($idcomp) {
                case 1:
                    $ptm=110;break;                            
                case 2:
                    $ptm=105; break;
                case 3:
                    $ptm=100; break;
                case 4:
                    $ptm=100; break;
            }
        }
        
        switch ($tp) {
            case 1:
                $destp=utf8_encode('PERSONAL POR COMPETENCIAS'); 
                $des=$dat1[1];
                break;            
            case 2:
                $destp=utf8_encode('PERSONAL POR ASPECTOS'); 
                $des=$dat1[4];
                $ptm= $dat1[5];
                break;
        }
                            
        $anio= date('Y');
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode('Reporte segÚn '.$destp)), 0, 1, 'C');
        $this->Ln(2);
        //$this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(7);
        
        $w=48; $f=10;
        
        $this->SetFont('Arial','U',9);
        $this->Cell(51, 5, strtoupper(utf8_decode('Resultados de consultar : ')), 0, 1, 'L');
        $this->Ln(3);
        
        $xx=20;
        $this->SetX($xx);        
        $this->SetFont('Arial','B',10);
        $this->Cell(30, 5, utf8_decode('Año :'), 1, 0, 'R');
        $this->SetFont('Arial','',10);
        $this->Cell(25, 5, utf8_decode($anio), 0, 1, 'L');
        
        $this->SetX($xx);
        $this->SetFont('Arial','B',10);
        $this->Cell(30, 5, utf8_decode('Periodo :'), 1, 0, 'R');
        $this->SetFont('Arial','',10);
        $this->Cell(40, 5, utf8_decode($periodo), 0, 1, 'L');
        
        $this->SetX($xx);
        $this->SetFont('Arial','B',10);
        $this->Cell(30, 5, utf8_decode(' Competencia :'), 1, 0, 'R');
        $this->SetFont('Arial','',10);
        $this->Cell(25, 5, utf8_decode($comp), 0, 1, 'L');
        
        $this->SetX($xx);
        $this->SetFont('Arial','B',10);
        $this->Cell(30, 5, utf8_decode('Aspecto :'), 1, 0, 'R');
        $this->SetFont('Arial','',10);
        $this->Cell(40, 5, strtoupper(utf8_decode($asp)), 0, 1, 'L');        
        $this->Ln(3);
        
        $cc=0; $Alt= 7;
        $h0= 5;
        $h1=20; $h2=100; $h3=35; $h4=30; $h5= 35;
        $tr1=0; $td=0;
        $this->SetX(15);
        /*$this->SetFillColor(224,235,255);*/
        $this->SetFont('Arial','B',9);        
        
        $this->SetWidths(array(7,$h2,$h3,$h3));
		$this->SetAligns(array(C,C,C,C));
		$this->Row(array(utf8_decode('N°'),
            utf8_decode('Personal'),
			 utf8_decode("Puntaje Obtenido"),
			 utf8_decode("Puntaje Obtenido (%)") ));
                             
        /*$this->Cell($h2, $h0,strtoupper(utf8_decode($destp)), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Subvencion a Investigadores')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Supervisión y monitoreo')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Bienes y Servicios')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Equipamiento')), 1, 0, 'C');
        $this->Cell($h1, $h0,strtoupper(utf8_decode('T ')), 1, 1, 'C');*/
        foreach ($rows as $rs){ 
            $cc++;
            $tr1= $tr1+$rs[1];
            $td= ($rs[1]*100)/$ptm;                        
            $this->SetX(15);            
            $this->SetFont('Arial','',7.5);
            $this->Cell(7,$Alt,$cc,1,0,'C');          
            $this->Cell($h2, $Alt,strtoupper(utf8_decode($rs[0])), 1, 0, 'l');
            $this->SetFont('Arial','',9); 
            $this->Cell($h3, $Alt,number_format($rs[1],0), 1, 0, 'R');
            $this->Cell($h3, $Alt,strtoupper(number_format($td,0)), 1, 1, 'R');
            $this->SetX(15);
            //$this->Cell(275,0,'',1,1,'C');   
        }
        $this->Ln(5);
        $this->Cell($h2+7, $h0,utf8_decode('Puntaje Maximo :'), 0, 0, 'R');
        $this->Cell($h3, $h0,$ptm, 1, 0, 'R');
        //$this->Cell($h3, $h0,number_format('100'), 1, 1, 'R');
        
    } 

    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial','',6);
        $this->Cell(0, 4, utf8_decode('Prohibida la Reproducción Total o Parcial de este documento sin la autorización del Representante de la Dirección.'), 0, 1, 'C');
        $this->Cell(0, 4, utf8_decode('SISEVAS v. 1.5'), 0, 1, 'C');
    }
    
}
//print_r($dat1);
$tp = $_GET['tp'];
$pdf= new PDF('P','mm', 'A4');
$tt = 415;
//$pdf->SetAutoPageBreak(0.2 ,0.2);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM - ACTA DE CAPACITACION ::');
$pdf->SetMargins(15,10,8);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($rows, $tp, $dat1);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>