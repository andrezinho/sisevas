<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
    function Header()
    {
        //global ;
        /*$this->Line(8, 18, 142, 18);         
        //$this->Image('../../images/logos.jpg',8,4,30,12);
        $this->SetFont('Arial','B',8); 
        $this->SetXY(40, 1$f);
        //$this->Cell(0,5,'MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN',1,1,'L');
        /*$this->MultiCell(55,4,utf8_decode('MANUAL DE BUENAS PRÁCTICAS DE MANUFACTURA Y GESTIÓN'),0,'C');
        $this->SetXY(105, 18);
        $this->SetFont('Arial','I',6);
        //$this->Cell(12,4,'CODIGO :',0,0,'L');
        //$this->Cell(0,4,$cab[0]['codigo'],0,1,'L');
        $this->SetXY(105, 21);
        $this->Cell(12,4,'VERSION :',0,0,'L');
        $this->Cell(0,4,'1.0',0,1,'L');
        $this->Line(8, 28, 142, 28);  */          
        
        $this->Ln(28);       
       
    }
    
    function cuerpo($cab,$objemp,$asig, $rowsd)
    {
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode('CAPACITACIÓN : '.$cab['codigo'])), 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(0,0,'',1,1,'C'); 
        $this->Ln(3);
        
        $w=48; $f=10;
        $this->SetFont('Arial','B',8);        
        $this->Cell($w, 5,strtoupper(utf8_decode('Fuente de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['fuente']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Eje de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['eje']), 0, 1, 'L');

        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Tema de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['tema']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Objetivo de la capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->MultiCell(140,5,utf8_decode($cab['obejtivoscap']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',8);
        $this->Cell(54, 5,strtoupper(utf8_decode('Alcance al Objetivo de la empresa')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',$f);        
        
        $c=0;
        foreach ($objemp as $r){                
            $this->SetX(20);
            $c++;
            $this->MultiCell(125,4,utf8_decode($c.".- ".$r['descripcion']),0,'J',false);
            $this->Ln(5);      
        }                
        $this->Ln(3);         
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Método de capacitaciÓn')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        //$this->Cell($f0, 5, utf8_decode($cab['metodo']), 1, 1, 'L');
        $this->MultiCell(130,5,utf8_decode($cab['metodo']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Tipo de evaluación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['tipoeval']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Propuesta (Contenido)')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',$f);
        $this->SetX(20);
        $this->MultiCell(180,5,utf8_decode($cab['propuesta']),0,'J',false);
        $this->Ln(15);
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Referencia Bibliográfica')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',$f);
        $this->SetX(20);
        $this->MultiCell(170,5,utf8_decode($cab['referencias']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Palabras Claves del Tema')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 1, 'C');
        $this->SetFont('Arial','',$f);
        $this->SetX(20);
        $this->MultiCell(170,5,utf8_decode($cab['palabrasclaves']),0,'J',false);
        $this->Ln(10);
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Expositor')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['expoitor']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Email del Expositor')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['mail']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Fecha de la Capacitación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['fecha']), 0, 1, 'L');
        
        $this->SetFont('Arial','B',8);
        $this->Cell($w, 5,strtoupper(utf8_decode('Hora de la Capacitación')), 0, 0, 'L');        
        $this->Cell(3, 5, ' :', 0, 0, 'C');
        $this->SetFont('Arial','',$f);
        $this->Cell(0, 5, utf8_decode($cab['hora']), 0, 1, 'L');
        $this->Ln(3);

        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('Asignados (as) a la Capacitación : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0;
        $h0= 5;
        $h1=15; $h2=30; $h3=70; $h4=40;
        $this->SetX(20);
        $this->SetFillColor(224,235,255);
        $this->SetFont('Arial','B',9);
        
        $this->Cell($h1, $h0,strtoupper(utf8_decode('n° ')), 1, 0, 'C');
        $this->Cell($h2, $h0,strtoupper(utf8_decode('dni')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('nombres y apellidos')), 1, 0, 'C');
        $this->Cell($h4, $h0,strtoupper(utf8_decode('tipo alcance')), 1, 1, 'C');

        foreach ($asig as $rs){                
            $this->SetX(20);
            $cc++;
            $this->SetFont('Arial','',9);
            $this->Cell($h1, 5,strtoupper(utf8_decode($cc)), 0, 0, 'C');
            $this->Cell($h2, 5,strtoupper(utf8_decode($rs['dni'])), 0, 0, 'C');
            $this->Cell($h3, 5,strtoupper(utf8_decode($rs['personal'])), 0, 0, 'L');
            $this->Cell($h4, 5,strtoupper(utf8_decode($rs['descripcion'])), 0, 1, 'L');
            $this->SetX(20);
            $this->Cell(155,0,'',1,1,'C');   
        } 
        
        $this->AddPage('A','A4');
        //$this->Ln(3);
        
        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('Presupuesto detallado del proyecto : ')), 0, 1, 'L');
        $this->Ln(2);
        
        $con=1;
        
        $h1=160; $h2=10; $h3=15; $h4=20; $h5=155; $h6=150; $h7=25;
        $this->SetFont('Arial','B',9);
        $this->Cell($h1, $h0,strtoupper(utf8_decode('Concepto')), 1, 0, 'C');
        $this->Cell($h2, $h0,strtoupper(utf8_decode('')), 1, 0, 'C');
        $this->Cell($h3, $h0,strtoupper(utf8_decode('Unidad')), 1, 0, 'C');
        $this->Cell($h4, $h0,strtoupper(utf8_decode('Cantidad')), 1, 0, 'C');
        $this->Cell($h7, $h0,strtoupper(utf8_decode('Precio Uni.')), 1, 0, 'C');
        $this->Cell($h4, $h0,strtoupper(utf8_decode('Sub Total')), 1, 1, 'C');
        //$this->Cell($h4, $h0,strtoupper(utf8_decode('Total')), 1, 1, 'C');
        
         $Total=0; $subtotal=0; $TotalF=0;
        foreach ($rowsd as $i => $r) 
        {   
            $cond=1;
            $this->SetFont('Arial','B',9);
            $this->Cell(5, $h0,$con." .", 0, 0, 'C');
            $this->Cell($h5, $h0,strtoupper(utf8_decode($r['Cat'])), 0, 0, 'L');
            $this->Cell($h2, $h0,strtoupper(''), 0, 0, 'C');
            $this->Cell($h3, $h0,strtoupper(''), 0, 0, 'C');
            $this->Cell($h4, $h0,strtoupper(''), 0, 0, 'C');
            $this->Cell($h7, $h0,strtoupper(''), 0, 0, 'C');
            $this->Cell($h4, $h0,strtoupper(''), 0, 1, 'C');
            //$this->Cell($h4, $h0,number_format($subtotals, 2) , 0, 1, 'C');
            
            
            foreach ($r['Det'] as $f => $d) 
            {
                $tiempo= $d['tiempo'];
                
                if($tiempo==0){
                    
                    $subtotal= ($d['preciounitario'] * $d['cantidad']);
                    //$subtotal= number_format($subtotal, 2);
                    $tiempo='';
                    
                }else
                    {
                        $subtotal= ($d['preciounitario'] * $d['cantidad'] * $tiempo);
                        //$subtotal= number_format($subtotal, 2);
                    }         
                $Total= $Total + $subtotal;
                $this->SetFont('Arial','',9);
                $this->Cell(5, $h0,"", 0, 0, 'C');
                if($d['descripcion']!= '')
                {
                    $this->Cell(5, $h0,$con.".".$cond, 0, 0, 'C');
                }else
                    {
                        $this->Cell(5, $h0,"", 0, 0, 'C');
                    }
                $this->Cell($h6, $h0,strtoupper(utf8_decode($d['descripcion'])), 0, 0, 'L');
                $this->Cell($h2, $h0,$tiempo, 0, 0, 'C');
                $this->Cell($h3, $h0,strtoupper(utf8_decode($d['unidad'])), 0, 0, 'L');
                $this->Cell($h4, $h0,$d['cantidad'], 0, 0, 'C');
                $this->Cell($h7, $h0,strtoupper($d['preciounitario']), 0, 0, 'R');
                $this->Cell($h4, $h0,strtoupper(number_format($subtotal,2)), 0, 1, 'R');
                //$this->Cell($h4, $h0,strtoupper(''), 0, 1, 'C');
                $cond++;
            }          
            
            $con++;
        }
        $TotalF= $TotalF+ $Total;
        
        $this->Ln(2);
        $this->SetFont('Arial','B',10);
        $this->Cell($h1, $h0,strtoupper(utf8_decode('Total')), 0, 0, 'C');
        $this->Cell($h2, $h0,strtoupper(utf8_decode('')), 0, 0, 'C');
        $this->Cell($h3, $h0,'', 0, 0, 'C');
        $this->Cell($h4, $h0,strtoupper(utf8_decode('')), 0, 0, 'C');
        $this->Cell($h7, $h0,strtoupper(utf8_decode('')), 0, 0, 'C');
        $this->Cell($h4, $h0,$TotalF, 0, 1, 'R');
        
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
//print_r($rowsd);
$pdf= new PDF('P','mm', 'A4');
$pdf->SetAutoPageBreak(0.2 ,0.2);
//$pdf->SetTitle($title);
$pdf->SetTitle(':: CMSM - CAPACITACION ::');
$pdf->SetMargins(10,5,8);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->AliasNbPages();
//$pdf->AddPage();
$pdf->cuerpo($cab,$objemp,$asig, $rowsd);
//$pdf->Header($cab);
$pdf->Output();	

//$pdf->Output($ruta, 'F');

?>