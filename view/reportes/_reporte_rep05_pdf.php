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
        $this->personal = $datos[0];
        $this->consultorio = $datos[1];
        $this->anio = $datos[2];
        $this->maxw = $maxw;
    }

    function Header() {
        $xx= 22;
        $maxw = $this->maxw;
        $this->setY(20);        
        $this->SetFont('Arial', 'B', 12);
        
        $this->SetX($xx);
        $this->Cell(0, 5, 'REPORTE : CAPACITACIONES POR PERSONAL', 0, 0, 'L', false);
        $this->Ln();
        $this->SetFont('Times', '', 9);
        $this->SetX($xx);
        $this->Cell(0, 5, strtoupper(utf8_decode($this->anio . ' | PERFIL: ' . $this->consultorio)), 0, 0, 'L', false);
        $this->SetXY($maxw - 10, 22);
        $fecha = date('d-M-Y');
        $this->Write(0, $fecha);
        $this->Ln(4);
        $this->SetX($xx);
        $this->Cell(0, 5, '', 'B', 0, 'C', false);
        $this->Ln(7);
        $this->SetFont('Arial', '', 10);
        $this->SetX($xx-3);
        $this->Cell(20, 5, utf8_decode('Personal: '), 0, 0, 'R', false);
        $this->SetFont('Arial', 'B', 10.5);
        $this->Cell(0, 5, utf8_decode($this->personal), 0, 0, 'L', false);
        $this->Ln(10);
    }

    function Footer() {
        $this->SetTextColor(0, 0, 0); //Letra color Azul
        $this->SetY(-13);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    function ffecha($fecha) {
        $n = explode("-", $fecha);
        return $n[2] . "/" . $n[1] . "/" . $n[0];
    }

    function cuerpo($rows) {
        $xx=22;
        $i = 0;
        $h = 5;
        $border = 'BLT';
        $st = 0;
        $smt = 0;
        $w1=28; $w2=90; $w3=21; $w4=60; $w5=25; $w6=34; $w7=199;
        $this->SetX($xx);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w1, $h, utf8_decode('Código'), $border, 0, 'C', $fill);
        $this->Cell($w2, $h, utf8_decode('Tema'), 1, 0, 'C', $fill);
        $this->Cell($w3, $h, utf8_decode('Fecha'), 1, 0, 'C', $fill);
        $this->Cell($w4, $h, utf8_decode('Expositor'), 1, 0, 'C', $fill);
        $this->Cell($w6, $h, utf8_decode('Presupuesto (S/.)'), $border, 0, 'C', $fill);
        $this->Cell($w5, $h, utf8_decode('Estado'), 1, 1, 'C', $fill);
        
        $es1=0; $es2=0; $es3=0;
        $s = 0; $sm = 0;
        foreach ($rows as $k => $r) {
            
            switch ($r['estado']) {
                case 0:
                    $est='Falta Asignar'; break;
                case 1:
                    $est='En Proceso'; break;
                case 2:
                    $est='Finalizado'; break;
            }
            $sm= $sm + $r['total'];
            
            $fill = false;
          
            $this->SetFont('Arial', '', 9.5);
            /*$this->Cell($w1, $h, utf8_decode($r['codigo']), $border, 0, 'C', $fill);
            $this->Cell($w2, $h, utf8_decode($r['tema']), 1, 0, 'L', $fill);
            $this->Cell($w3, $h, utf8_decode($this->ffecha($r['fecha'])), 1, 0, 'C', $fill);
            $this->Cell($w4, $h, utf8_decode($r['expositor']), 1, 0, 'L', $fill);
            $this->Cell($w5, $h, utf8_decode($est), 1, 1, 'C', $fill);*/
            
            $this->SetWidths(array($w1,$w2,$w3,$w4,$w6,$w5));
            $this->SetAligns(array(C,L,C,L,R));
            $this->Row(array(utf8_decode(strtoupper($r['codigo'])),
                utf8_decode($r['tema']),
                utf8_decode(strtoupper($this->ffecha($r['fecha']))),
                utf8_decode($r['expositor']),
                number_format($r['total'],2),
                utf8_decode(strtoupper($est))
            ));  
        }
        $h=5;
        $this->SetFont('Arial', B, 9.5);
        $this->Cell($w7, $h, 'TOTAL', 1, 0, 'R', $fill);
        $this->Cell($w6, $h, number_format($sm, 2), 1, 1, 'R', $fill);
            
        $es1=0; $es2=0; $es3=0;
        foreach ($rows as $i => $rs) 
        {
            $tc= count($rows);
            if($rs['estado']==0)
            {
                $es1++;
            }
            if($rs['estado']==1)
            {
                $es2++;
            }
            if($rs['estado']==2)
            {
                $es3++;
            }
        }
        
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 9.5);        
        
        $w4=45;
        /*$this->Cell($w4, $h, utf8_decode('Capacitaciones Asignadas'), 0, 0, 'L');
        $this->Cell(2, $h, ':' ,0, 0, 'C');
        $this->Cell(10, $h, $es1 ,0, 1, 'C');*/
        
        $this->SetTextColor(240, 0, 0); //Letra color Rojo
        $this->Cell($w4, $h, utf8_decode('Capacitaciones en Proceso'), 0, 0, 'L');
        $this->Cell(2, $h, ':' ,0, 0, 'C');
        $this->Cell(10, $h, $es2 ,0, 1, 'C');
        
        $this->SetTextColor(41, 152, 78); //Letra color Verde
        $this->Cell($w4, $h, utf8_decode('Capacitaciones Finalizadas'), 0, 0, 'L');
        $this->Cell(2, $h, ':' ,0, 0, 'C');
        $this->Cell(10, $h, $es3 ,0, 1, 'C');
        
        $this->SetTextColor(0, 51, 102); //Letra color Azul
        $this->Cell($w4, $h, utf8_decode('Total de Capacitaciones'),0, 0, 'L');
        $this->Cell(2, $h, ':' ,0, 0, 'C');
        $this->Cell(10, $h, $tc ,0, 1, 'C');
        
    }

}
//print_r($rows);
$pdf = new PDF();

$maxw = 200;
$pdf->SetTitle(':: CMSM - CAPACITACIONES ::');
$pdf->setValues($datos, $maxw);
$orientacion = 'A';

$pdf->AddPage($orientacion);
$pdf->SetMargins(22,10,15);
$pdf->AliasNbPages();
$pdf->cuerpo($rows);
$pdf->Output();
?>