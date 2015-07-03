<?php

session_start();
require("../lib/fpdf/fpdf.php");

class PDF extends FPDF {

    var $periodo;
    var $personal;
    var $consultorio;
    var $maxw;
    var $widths;

    public function setValues($datos, $maxw) {
        $this->personal = $datos[0];
        $this->consultorio = $datos[1];
        $this->periodo = $datos[2];
        $this->cargo = $datos[3];
        $this->unidadop = $datos[4];
        $this->asumircargo = $datos[5];
        $this->evaluador = $datos[6];
        $this->maxw = $maxw;
    }

    function Header() {
        $maxw = $this->maxw;
        $this->setY(35);
        $this->SetFont('Arial', 'B', 12);
        $this->Ln();
        $this->Cell(0, 5, 'REPORTE DE RESULTADOS DE EVALUACION - PERIODO', 0, 0, 'L', false);
        $this->Ln();
        $this->SetFont('Times', '', 9);
        $this->Cell(0, 4, strtoupper(utf8_decode($this->periodo . ' | PERFIL: ' . $this->consultorio)), 0, 0, 'L', false);
        $this->SetXY($maxw - 35, 37);
        $fecha = date('d-M-Y');
        $this->Write(0, $fecha);
        
        $this->Ln(2);
        $this->Cell(0, 5, '', 'B', 0, 'C', false);
        $this->Ln(9);
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
        $smtp = 0;
        foreach ($rows as $k => $v)
        {
            $s = 0;
            $sm = 0;
            $smp = 0;
            $fill = false;
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(0, $h, strtoupper($v['des']), 0, 0, 'L', $fill);
            $this->Ln();
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(137, $h, utf8_decode('Capacidades'), $border, 0, 'L', $fill);
            $this->Cell(15, $h, utf8_decode('Puntaje'), 1, 0, 'C', $fill);
            $this->Cell(15, $h, utf8_decode('Máximo'), 1, 0, 'C', $fill);
            $this->Cell(15, $h, utf8_decode('Prom'), 1, 0, 'C', $fill);
            $this->Ln();
            foreach ($v['res'] as $i => $r) 
            {
                $s += $r['valor'];
                $sm += $r['valor_max'];
                $smp += $r['promedio'];
                $this->SetFont('Arial', '', 9);
                $this->Cell(137, $h, utf8_decode($r['aspecto']), $border, 0, 'L', $fill);
                $this->Cell(15, $h, (int) $r['valor'], 1, 0, 'C', $fill);
                $this->Cell(15, $h, (int) $r['valor_max'], 1, 0, 'C', $fill);
                $this->Cell(15, $h, number_format($r['promedio'],2), 1, 0, 'C', $fill);
                $this->Ln();
            }

            $this->SetFont('Arial', 'B', 9);
            $this->Cell(137, $h, '', 0, 0, 'L', $fill);
            $this->Cell(15, $h, (int) $s, 1, 0, 'C', $fill);
            $this->Cell(15, $h, (int) $sm, 1, 0, 'C', $fill);
            $this->Cell(15, $h, number_format($smp,2), 1, 0, 'C', $fill);
            $this->Ln();

            $st += $s;
            $smt += $sm;
            $smtp += $smp;

            $this->Ln();
        }

        $this->Cell(137, $h, 'TOTALES   ', 0, 0, 'R', $fill);
        $this->Cell(15, $h, (int) $st, 1, 0, 'C', $fill);
        $this->Cell(15, $h, (int) $smt, 1, 0, 'C', $fill);
        $this->Cell(15, $h, number_format($smtp,2), 1, 0, 'C', $fill);
        $this->Ln();
        $this->Cell(137, $h, 'PORCENTAJE   ', 0, 0, 'R', $fill);
        $this->Cell(30, $h, number_format($st * 100 / $smt, 0) . ' %', 1, 1, 'C', $fill);
        $this->Ln(20);
        
        $this->SetFont('Arial', '', 9);
        
        //$this->Ln(8);
        $this->Cell(17, 4,utf8_decode('Personal'), 0, 0, 'L');
        $this->Cell(2, 4,':', 0, 0, 'C');
        $this->Cell(75, 4,strtoupper(utf8_decode($this->personal)), 0, 0, 'L');
        $this->Cell(5, 4,'', 0, 0, 'L');
        $this->Cell(20, 4,utf8_decode('Cargo'), 0, 0, 'L');
        $this->Cell(2, 4,':', 0, 0, 'C');
        $this->Cell(75, 4,strtoupper(utf8_decode($this->cargo)), 0, 1, 'L');
        
        $this->Cell(17, 4,utf8_decode('Unidad Op.'), 0, 0, 'L');
        $this->Cell(2, 4,':', 0, 0, 'C');
        $this->Cell(75, 4,strtoupper(utf8_decode($this->unidadop)), 0, 0, 'L');
        $this->Cell(5, 4,'', 0, 0, 'L');
        $this->Cell(40, 4,utf8_decode('Fecha de asunción del Cargo'), 0, 0, 'L');
        $this->Cell(2, 4,':', 0, 0, 'C');
        $this->Cell(75, 4,strtoupper(utf8_decode($this->asumircargo)), 0, 1, 'L');
        $this->Ln();
        
        $this->Cell(17, $h, 'Evaluador', 0, 0, 'R');
        $this->Cell(2, 4,':', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 8.5);
        $this->Cell(140, $h,strtoupper(utf8_decode($this->evaluador)) ,0 , 0, 'L');
        
    }
    
    function Footer() {
        $this->SetY(-13);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }


}

$pdf = new PDF();

$maxw = 205;
$pdf->setValues($datos, $maxw);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->SetMargins(12, 30, 20);
$pdf->AliasNbPages();
$pdf->FancyTable($rows);
$pdf->Output();
?>