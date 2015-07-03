<?php

session_start();
require("../lib/fpdf/fpdf.php");

class PDF extends FPDF {

    var $anio;
    var $personal;
    var $consultorio;
    var $maxw;
    var $widths;

    public function setValues($datos, $maxw) {
        $this->personal   = $datos[0];
        $this->consultorio = $datos[1];
        $this->anio = $datos[2];
        $this->tpdocumento = $datos[3];
        $this->idpersonal   = $datos[4];
        $this->maxw = $maxw; 
    }

    function Header() {        
        
        $maxw = $this->maxw;
        $this->setY(30);
        $this->SetFont('Arial', 'B', 12);
        //$this->Ln();
        $this->Cell(0, 5, 'REPORTE : DOCUMENTOS ENVIADOS POR PERSONAL - ANUAL', 0, 0, 'L', false);
        $this->Ln();
        $this->SetFont('Times', '', 9);
        $this->Cell(0, 5, strtoupper(utf8_decode($this->anio . ' | PERFIL: ' . $this->consultorio)), 0, 0, 'L', false);
        $this->SetXY($maxw - 30, 34);
        $fecha = date('d-M-Y');
        $this->Write(0, $fecha);
        $this->Ln(2);
        $this->Cell(0, 5, '', 'B', 0, 'C', false);
        $this->Ln(7);
        $this->SetFont('Arial', '', 10);
        $this->Cell(20, 5, utf8_decode('Personal: '), 0, 0, 'R', false);
        $this->SetFont('Arial', 'B', 10.5);
        //print_r($this->personal);
        if($this->personal==' '){$this->personal='TODOS';}
        $this->Cell(0, 5, utf8_decode($this->personal), 0, 0, 'L', false);
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-13);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    function ffecha($fecha) {
        $n = explode("-", $fecha);
        return $n[2] . "/" . $n[1] . "/" . $n[0];
    }

    function FancyTable($rows) {
        $idp    = $this->idpersonal;
        $idtpdoc= $this->tpdocumento;
        if($idtpdoc=='' && $idp==0)
        {
            $this->SetX(20);
            $s = 0;
            $sm = 0;
            $h = 5;
            $ttd = 0;
            $smt = 0;
            $smR = 0;
            $border = 'BLT';
            $st = 0;
            $smt = 0;
            $w1=28; $w2=75; $w3=18; $w4=70; $w5=25;
            $this->SetFont('Arial', 'B', 10);
            $this->Cell($w2, $h, utf8_decode('Tipo documento'), $border, 0, 'C', $fill);
            $this->Cell($w3, $h, utf8_decode('N°'), 1, 0, 'C', $fill);
            $this->Cell($w3, $h, utf8_decode('%'), 1, 1, 'C', $fill);
            
            $tot=0;
            foreach ($rows as $i => $r) 
            {$tot= $tot+$r['nro'];}
                    
            foreach ($rows as $k => $r) {
                $e= $r['estado'];
                $this->SetX(20);
                $sm= $sm + $r['nro'];
                $fill = false;
                if($e=='T')
                {
                    $smt = $smt+1;
                }
                
                if($e=='R')
                {
                    $smR = $smR+1;
                }
                $ttd++;
                
                $this->SetFont('Arial', '', 9);
                $this->Cell($w2, $h, utf8_decode($r['descripcion']), $border, 0, 'L', $fill);
                $this->Cell($w3, $h, utf8_decode($r['nro']), 1, 0, 'R', $fill);
                $this->Cell($w3, $h, number_format(($r['nro']*100)/$tot, 2), 1, 1, 'R', $fill);
            } 
            
                    
        }
        else
        {
            $i = 0;
            $h = 5;
            $border = 'BLT';
            $ttd = 0;
            $smt = 0;
            $smR = 0;
            $w1=28; $w2=75; $w3=18; $w4=70; $w5=25; $w6=52;
            $this->SetFont('Arial', 'B', 9);
            $this->Cell($w1, $h, utf8_decode('Código'), $border, 0, 'C', $fill);
            $this->Cell($w2, $h, utf8_decode('Asunto'), 1, 0, 'C', $fill);
            $this->Cell($w3, $h, utf8_decode('Fecha'), 1, 0, 'C', $fill);
            $this->Cell($w4, $h, utf8_decode('Remitente'), 1, 1, 'C', $fill);
            //$this->Cell($w5, $h, utf8_decode('Estado'), 1, 1, 'C', $fill);
            foreach ($rows as $k => $r) {
                $e= $r['estado'];
                switch ($e) {
                    case 0:
                        $est='Falta Asignar'; break;
                    case 1:
                        $est='En Proceso'; break;
                    case 2:
                        $est='Finalizado'; break;
                }
                
                if($e=='T')
                {
                    $smt = $smt+1;
                }
                
                if($e=='R')
                {
                    $smR = $smR+1;
                }
                $ttd++;
                
                $fill = false;

                $this->SetFont('Arial', '', 7);
                $this->Cell($w1, $h, utf8_decode($r['codigo']), $border, 0, 'C', $fill);
                $this->Cell($w2, $h, utf8_decode($r['asunto']), 1, 0, 'L', $fill);
                $this->Cell($w3, $h, utf8_decode($this->ffecha($r['fechainicio'])), 1, 0, 'C', $fill);
                if($idtpdoc==3)
                {
                    if($e=='T')
                    {
                        $this->Cell($w6, $h, utf8_decode($r['remitente']), 1, 0, 'L', $fill);                    
                        $this->Cell($w3, $h, utf8_decode($e), 1, 1, 'C', $fill);
                    }
                    else
                    {
                        $this->Cell($w6, $h, utf8_decode($r['remitente']), 1, 0, 'L', $fill);                    
                        $this->Cell($w3, $h, '', 1, 1, 'C', $fill);
                    }
                    
                }else
                {
                    $this->Cell($w4, $h, utf8_decode($r['remitente']), 1, 0, 'L', $fill);
                }
            }
                        
            $this->Ln();
                $this->SetX(20);
                
                $this->SetFont('Arial', '', 9); 
                $this->Cell(20, $h, utf8_decode('Total de Doc :'), 0, 0, 'R', $fill);
                $this->SetFont('Arial', 'B', 9); 
                $this->Cell(6, $h, $ttd, 0, 0, 'C', $fill);
                
            if($idtpdoc==3)
            {
                                
                $this->SetFont('Arial', '', 9); 
                $this->Cell(28, $h, utf8_decode('Ejecutados :'), 0, 0, 'R', $fill);
                $this->SetFont('Arial', 'B', 9); 
                $this->Cell(6, $h, $smR, 0, 0, 'C', $fill);
                
                $this->SetFont('Arial', '', 9); 
                $this->Cell(28, $h, utf8_decode('En tramite (T) :'), 0, 0, 'R', $fill);
                $this->SetFont('Arial', 'B', 9); 
                $this->Cell(6, $h, $smt, 0, 1, 'C', $fill);
            }    
        }
        
            

    }

}

//echo ($_GET);
//$idper= $_GET("idp");
$pdf = new PDF();

$maxw = 200;
$pdf->setValues($datos, $maxw);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->AliasNbPages();
$pdf->FancyTable($rows);
$pdf->Output();
?>