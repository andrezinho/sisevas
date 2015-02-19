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
        $maxw = $this->maxw;
        $this->SetMargins(10, 20, 10);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln();
        $this->Cell(0, 5, 'REPORTE : CAPACITACIONES POR PERSONAL - ANUAL', 0, 0, 'L', false);
        $this->Ln();
        $this->SetFont('Times', '', 9);
        $this->Cell(0, 5, strtoupper(utf8_decode($this->anio . ' | PERFIL: ' . $this->consultorio)), 0, 0, 'L', false);
        $this->SetXY($maxw - 20, 12);
        $fecha = date('d-M-Y');
        $this->Write(0, $fecha);
        $this->Ln(3);
        $this->Cell(0, 5, '', 'B', 0, 'C', false);
        $this->Ln(7);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 5, utf8_decode('Personal: ' . $this->personal), 0, 0, 'L', false);
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
        $i = 0;
        $h = 5;
        $border = 'BLT';
        $st = 0;
        $smt = 0;
        $w1=28; $w2=70; $w3=18; $w4=50; $w5=25;
        $this->SetFont('Arial', 'B', 10);
        $this->Cell($w1, $h, utf8_decode('Código'), $border, 0, 'C', $fill);
        $this->Cell($w2, $h, utf8_decode('Tema'), 1, 0, 'C', $fill);
        $this->Cell($w3, $h, utf8_decode('Fecha'), 1, 0, 'C', $fill);
        $this->Cell($w4, $h, utf8_decode('Expositor'), 1, 0, 'C', $fill);
        $this->Cell($w5, $h, utf8_decode('Estado'), 1, 1, 'C', $fill);
        
        $es1=0; $es2=0; $es3=0;
        
        foreach ($rows as $k => $r) {
            switch ($r['estado']) {
                case 0:
                    $est='Falta Asignar'; break;
                    $es1=0;
                case 1:
                    $est='En Proceso'; break;
                    $es2=0;
                case 2:
                    $est='Finalizado'; break;
                    $es3=0;
            }
            
            $s = 0;
            $sm = 0;
            $fill = false;
          
            $this->SetFont('Arial', '', 9);
            $this->Cell($w1, $h, utf8_decode($r['codigo']), $border, 0, 'C', $fill);
            $this->Cell($w2, $h, utf8_decode($r['tema']), 1, 0, 'L', $fill);
            $this->Cell($w3, $h, utf8_decode($this->ffecha($r['fecha'])), 1, 0, 'C', $fill);
            $this->Cell($w4, $h, utf8_decode($r['expositor']), 1, 0, 'L', $fill);
            $this->Cell($w5, $h, utf8_decode($est), 1, 1, 'C', $fill);
        }
        
        /*$this->Ln(10);
        foreach ($rows as $k => $rs) {
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
        $this->Cell($w1, $h, utf8_decode('Total Cap:'), 0, 0, 'C');
        $this->Cell($w1, $h, $es1, 0, 0, 'C');
        */
    }

}
//print_r($rows);
$pdf = new PDF();

$maxw = 200;
$pdf->setValues($datos, $maxw);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->AliasNbPages();
$pdf->FancyTable($rows);
$pdf->Output();
?>