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
        
        $this->Ln(10);       
       
    }
    
    function cuerpo($rows, $tp)
    {
        switch ($tp) {
            case 1:
                $destp=utf8_decode('Lineas de Acción / Objetivos de la empresa');
                $title=('Lineas de AcciÓn segÚn Objetivos de la empresa'); break;
            case 2:
                $destp=utf8_decode('Lineas de Acción / Objetivos de la capacitación');
                $title=('Lineas de AcciÓn segÚn Objetivos de la capacitaciÓn'); break;
            case 3:
                $destp=utf8_decode('Lineas de Acción / Ejes de la capacitación');
                $title=('Lineas de AcciÓn segÚn Tiempos de DedicaciÓn'); break;
        }
        
        $anio= date('Y');
        $Serie= str_pad($Serie, 4, "000", STR_PAD_LEFT);
        
        $this->SetFont('Arial','B',11);
        $this->Cell(0, 5, strtoupper(utf8_decode('Reporte por '.$title)), 0, 1, 'C');
        $this->Ln(3);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,0,'INDICADOR DE PROCESO',0,1,'C'); 
        $this->Ln(7);
        
        $w=48; $f=10;
        
        $this->SetFont('Arial','U',9);
        $this->Cell(0, 5, strtoupper(utf8_decode('Resultados : ')), 0, 1, 'L');
        $this->Ln(2);
        $cc=0; $Alt= 7;
        $h0= 5;
        
        $this->SetX(10);
        
        if($tp==1)
        {
            $h1=20; $h2=62; $h3=35; $h4=31; $h5= 30; $h6=12;
            $this->SetFont('Arial','B',9); 
            $this->SetWidths(array($h2,$h3,$h4,$h3,$h5,$h3,$h3,$h6));
    		$this->SetAligns(array(C,C,C,C,C,C,C,C,C));
    		$this->Row(array($destp,
                    utf8_decode("Impulsar acciones de Salud Comunitaria en base a paquetes de atención"),
                    utf8_decode("Fortalecer la orientación y consejería del consultorio de GO"),
                    utf8_decode("Mantener el programa de calidad implementada por la SGS"),
                    utf8_decode("Fortalecer el programa de inversiones de la empresa"),
                    utf8_decode("Desarrollo de un sistema de captación de clientes"),
                    utf8_decode("Promover el desarrollo de las competencias del RRHH"),
                    utf8_decode("")
            ));
            
            foreach ($rows as $rs){ 
                $tr1= $tr1+$rs[1];
                $tr2= $tr2+$rs[2];
                $tr3= $tr3+$rs[3];
                $tr4= $tr4+$rs[4];
                $tr5= $tr5+$rs[5];
                $tr6= $tr6+$rs[6];
                $td = $rs[1]+$rs[2]+$rs[3]+$rs[4]+$rs[5]+$rs[6];
                $tf= $tr1+$tr2+$tr3+$tr4+$tr5+$tr6;
                            
                $this->SetX(10);
                $this->SetFont('Arial','',9);
                $this->SetWidths(array($h2,$h3,$h4,$h3,$h5,$h3,$h3,$h6));
    		    $this->SetAligns(array(L,C,C,C,C,C,C,C,C));
    		    $this->Row(array(
                        utf8_decode($rs[0]),
    			utf8_decode($rs[1]),
    			utf8_decode($rs[2]),
    			utf8_decode($rs[3]),
    			utf8_decode($rs[4]),
                        utf8_decode($rs[5]),
    			utf8_decode($rs[6]),
                        $td
                ));   
            }
            $this->Cell($h2, $h0,utf8_decode('Total :'), 1, 0, 'R');
            $this->Cell($h3, $h0,number_format($tr1,0), 1, 0, 'C');
            $this->Cell($h4, $h0,number_format($tr2,0), 1, 0, 'C');
            $this->Cell($h3, $h0,number_format($tr3,0), 1, 0, 'C');
            $this->Cell($h5, $h0,number_format($tr4,0), 1, 0, 'C');
            $this->Cell($h3, $h0,number_format($tr5,0), 1, 0, 'C');
            $this->Cell($h3, $h0,number_format($tr6,0), 1, 0, 'C');
            $this->SetFont('Arial','B',10);
            $this->Cell($h6, $h0,number_format($tf,0), 1, 1, 'C');
            
        }
        
        if($tp==2)
        {
            $h1=30; $h2=55; $h3=40; $h4=12; $h5= 35; $h6= 12;
            $this->SetFont('Arial','B',9); 
            $this->SetWidths(array($h2,$h3,$h5,$h3,$h1,$h5,$h6,$h4));
    		$this->SetAligns(array(C,C,C,C,C,C,C,C,C));
    		$this->Row(array($destp,
                    utf8_decode("Desarrollar aptitudes, habilidades y destrezas en el personal según el área de trabajo proporcionando"),
                    utf8_decode("Fortalecer los estándares de calidad en los servicios para mantener las BPMG"),
                    utf8_decode("Lograr cambios en el comportamiento del personal con el fin de contribuir a la mejora de las relaciones"),
                    utf8_decode("Desarrollar el perfil del capacitador y supervisor del establecimiento"),
                    utf8_decode("Optimizar los recursos financieros de la Empresa / Incrementar la productividad"),
                    utf8_decode("Promover un mayor ambiente de seguridad en el trabajo"),
                    utf8_decode("")
            ));
            
            foreach ($rows as $rs){ 
                $tr1= $tr1+$rs[1];
                $tr2= $tr2+$rs[2];
                $tr3= $tr3+$rs[3];
                $tr4= $tr4+$rs[4];
                $tr5= $tr5+$rs[5];
                $tr6= $tr6+$rs[6];
                $td = $rs[1]+$rs[2]+$rs[3]+$rs[4]+$rs[5]+$rs[6];
                $tf= $tr1+$tr2+$tr3+$tr4+$tr5+$tr6;
                            
                $this->SetX(10);
                $this->SetFont('Arial','',9);
                $this->SetWidths(array($h2,$h3,$h5,$h3,$h1,$h5,$h6,$h4));
    		    $this->SetAligns(array(L,C,C,C,C,C,C,C,C));
    		    $this->Row(array(utf8_decode($rs[0]),
                        utf8_decode($rs[1]),
                        utf8_decode($rs[2]),
                        utf8_decode($rs[3]),
                        utf8_decode($rs[4]),
                        utf8_decode($rs[5]),
    			utf8_decode($rs[6]),
                        $td
                ));   
            }
            $this->Cell($h2, $h0,utf8_decode('Total :'), 1, 0, 'R');
            $this->Cell($h3, $h0,number_format($tr1,0), 1, 0, 'C');
            $this->Cell($h5, $h0,number_format($tr2,0), 1, 0, 'C');
            $this->Cell($h3, $h0,number_format($tr3,0), 1, 0, 'C');
            $this->Cell($h1, $h0,number_format($tr4,0), 1, 0, 'C');
            $this->Cell($h5, $h0,number_format($tr5,0), 1, 0, 'C');
            $this->Cell($h6, $h0,number_format($tr6,0), 1, 0, 'C');
            $this->SetFont('Arial','B',10);
            $this->Cell($h4, $h0,number_format($tf,0), 1, 1, 'C');
            
        }
        
        if($tp==3)
        {
            $h1=20; $h2=65; $h3=35; $h4=25; $h5= 42; $h6= 12;
            $tr1=0;$tr2=0;$tr3=0;$tr4=0;$tr5=0;$tr6=0;
        
            $this->SetFont('Arial','B',9); 
            $this->SetWidths(array($h2,$h3,$h5,$h4,$h3,$h3,$h6));
    		$this->SetAligns(array(C,C,C,C,C,C,C,C,C));
    		$this->Row(array($destp,
                    utf8_decode("Asistencial / Medico"),
                    utf8_decode("Preventivo Promocional / Salud Comunitaria"),
                    utf8_decode("Gestión"),
                    utf8_decode("Investigación"),
                    utf8_decode("Administrativo"),
                    //utf8_decode("Calidad"),
                    utf8_decode("")
            ));
            
            foreach ($rows as $rs){ 
                $tr1= $tr1+$rs[1];
                $tr2= $tr2+$rs[2];
                $tr3= $tr3+$rs[3];
                $tr4= $tr4+$rs[4];
                $tr5= $tr5+$rs[5];
                $tr6= $tr6+$rs[6];
                $td = $rs[1]+$rs[2]+$rs[3]+$rs[4]+$rs[5]+$rs[6];
                $tf= $tr1+$tr2+$tr3+$tr4+$tr5+$tr6;
                            
                $this->SetX(10);
                $this->SetFont('Arial','',9);
                $this->SetWidths(array($h2,$h3,$h5,$h4,$h3,$h3,$h6));
    		    $this->SetAligns(array(L,C,C,C,C,C,C,C,C));
    		    $this->Row(array(utf8_decode($rs[0]),
                        utf8_decode($rs[1]),
                        utf8_decode($rs[2]),
                        utf8_decode($rs[3]),
                        utf8_decode($rs[4]),
                        utf8_decode($rs[5]),
                        //utf8_decode($rs[6]),
                        $td
                ));   
            }
            
            $this->Cell($h2, $h0,utf8_decode('Total :'), 1, 0, 'R');
            $this->Cell($h3, $h0,number_format($tr1,0), 1, 0, 'C');
            $this->Cell($h5, $h0,number_format($tr2,0), 1, 0, 'C');
            $this->Cell($h4, $h0,number_format($tr3,0), 1, 0, 'C');
            $this->Cell($h3, $h0,number_format($tr4,0), 1, 0, 'C');
            $this->Cell($h3, $h0,number_format($tr5,0), 1, 0, 'C');
            //$this->Cell($h4, $h0,number_format($tr6,0), 1, 0, 'C');
            $this->SetFont('Arial','B',10);
            $this->Cell($h6, $h0,number_format($tf,0), 1, 1, 'C');
            
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

$title= ':: CMSM - ACTA DE CAPACITACION ::';
$tp = $_GET['tp'];
$pdf= new PDF('P','mm', 'A4');
//$pdf->SetAutoPageBreak(0.2 ,0.2);
$pdf->SetTitle($title);
//$pdf->SetTitle(':: CMSM - ACTA DE CAPACITACION ::');
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