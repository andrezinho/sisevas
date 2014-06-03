<?php
session_start();
require("../lib/fpdf/fpdf.php");
class PDF extends FPDF
{
    var $anio;
    var $personal;
    var $consultorio;
    var $maxw;
    var $widths;
    
    public function setValues($datos,$maxw)
    {
        $this->personal = $datos[0];
        $this->consultorio = $datos[1];
        $this->anio = $datos[2];
        $this->maxw = $maxw;
    }
    
	function Header()
	{                
        $maxw = $this->maxw;                
        $this->SetMargins(20,20,20);
        $this->SetFont('Arial','B',12);
        $this->Ln();         
        $this->Cell(0, 5,'REPORTE DE RESULTADOS DE EVALUACION - ANUAL', 0, 0, 'L', false);
        $this->Ln();        
        $this->SetFont('Times','',9);        
        $this->Cell(0, 3, strtoupper(utf8_decode($this->anio.' | CONSULTORIO: '.$this->consultorio)), 0, 0, 'L', false);                
        $this->SetXY($maxw-20,12);
        $fecha = date('d-M-Y');
        $this->Write(0,$fecha);
        $this->Ln(2);
        $this->Cell(0,5,'','B',0,'C',false);
        $this->Ln(6);
        $this->Cell(0, 3,utf8_decode('Personal: '.$this->personal), 0, 0, 'L', false);
        $this->Ln(10);
	}
	
	function Footer()
	{
        $this->SetY(-13);
        $this->SetFont('Arial','I',7);
        $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
	}
	
	function ffecha($fecha)
    {
        $n = explode("-",$fecha);
        return $n[2]."/".$n[1]."/".$n[0];
    }	       

	function FancyTable($rows)
	{
        $i = 0;
        $h = 5;
        $border = 'BLT';
        $st=0;
		$smt=0;
		foreach ($rows as $k => $v) 
		{
			$s = 0;
			$sm = 0;			
            $fill = false;
            $this->SetFont('Arial','B',9);
            $this->Cell(0, $h,strtoupper($v['des']), 0, 0, 'L', $fill);
            $this->Ln();
            $this->SetFont('Arial','B',9);
            $this->Cell(140, $h,utf8_decode('Capacidades'), $border, 0, 'L', $fill);
            $this->Cell(15, $h,utf8_decode('Puntaje'), 1, 0, 'C', $fill);
            $this->Cell(15, $h,utf8_decode('Máximo'), 1, 0, 'C', $fill);
            $this->Ln();
			foreach ($v['res'] as $i => $r)
			{
				$s += $r['valor'];
				$sm += $r['valor_max'];
				$this->SetFont('Arial','',9);
				$this->Cell(140, $h,utf8_decode($r['aspecto']), $border, 0, 'L', $fill);
	            $this->Cell(15, $h,(int)$r['valor'], 1, 0, 'C', $fill);
	            $this->Cell(15, $h,(int)$r['valor_max'], 1, 0, 'C', $fill);
	            $this->Ln();
			}
			
			$this->SetFont('Arial','B',9);
			$this->Cell(140, $h,'', 0, 0, 'L', $fill);
            $this->Cell(15, $h,(int)$s, 1, 0, 'C', $fill);
            $this->Cell(15, $h,(int)$sm, 1, 0, 'C', $fill);
            $this->Ln();

			$st += $s;
			$smt += $sm;

			$this->Ln();
		}

			$this->Cell(140, $h,'TOTALES   ', 0, 0, 'R', $fill);
            $this->Cell(15, $h,(int)$st, 1, 0, 'C', $fill);
            $this->Cell(15, $h,(int)$smt, 1, 0, 'C', $fill);
            $this->Ln();
            $this->Cell(140, $h,'PORCENTAJE   ', 0, 0, 'R', $fill);
            $this->Cell(30, $h,number_format($st*100/$smt,0).' %', 1, 0, 'C', $fill);
            $this->Ln();
	}
}

$pdf=new PDF();

$maxw=190;
$pdf->setValues($datos, $maxw);
$orientacion = 'P';
$pdf->AddPage($orientacion);
$pdf->AliasNbPages();
$pdf->FancyTable($rows);
$pdf->Output();

?>