<?php 
	header("Content-type: application/vnd.ms-excel; name='excel'");  
	header("Content-Disposition: filename=Reporte_detallado_resultados.xls");  
	header("Pragma: no-cache");  
	header("Expires: 0");
?>

<style type="text/css">
	table tr td { border:1px solid #000000;}
</style>

<table border="0" cellpadding="0" cellspacing="0">
<tr><td colspan="3">&nbsp;</td></tr>
<?php 
$st=0;
$smt=0;
foreach ($rows as $k => $v) 
{
	?>	
		<tr>
			<th style="" colspan="3"><?php echo strtoupper($v['des']); ?></th>
		</tr>
		<tr>
			<th style="background:#dadada; border:1px solid #000000">Capacidades</th>
			<th style="background:#dadada; border:1px solid #000000">Puntaje</th>
			<th style="background:#dadada; border:1px solid #000000">Maximo</th>
		</tr>
		<?php 
		$s = 0;
		$sm = 0;
		foreach ($v['res'] as $i => $r) 
		{
			$s += $r['valor'];
			$sm += $r['valor_max'];
			?>
			<tr>
				<td style="border-bottom:1px dotted #000000;vertical-align:middle;border-right:1px dotted #000000;"><?php echo utf8_decode($r['aspecto']); ?></td>
				<td style="border-bottom:1px dotted #000000;border-right:1px dotted #000000;vertical-align:middle;" align="center"><?php echo (int)$r['valor']; ?></td>
				<td style="border-bottom:1px dotted #000000;border-right:1px dotted #000000;vertical-align:middle;" align="center"><?php echo (int)$r['valor_max']; ?></td>
			</tr>
			<?php
		}	
		$st += $s;
		$smt += $sm;	
		?>
		<tr>
			<td>&nbsp;</td>
			<td align="center" style="border:1px dotted #000000;vertical-align:middle;"><b><?php echo (int)$s; ?></b></td>
			<td align="center" style="border:1px dotted #000000;vertical-align:middle;"><b><?php echo (int)$sm; ?></b></td>
		</tr>
		<tr><td colspan="3" style="border:0">&nbsp;</td></tr>
	<?php
}
?>
<tr>
	<td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td colspan="" align="right"><b>TOTALES&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
	<td align="center" style="border:1px dotted #000000;vertical-align:middle;"><b><?php echo (int)$st; ?></b></td>
	<td align="center" style="border:1px dotted #000000;vertical-align:middle;"><b><?php echo (int)$smt; ?></b></td>
</tr>
<tr>
	<td colspan="" align="right"><b>PORCENTAJE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
	<td colspan="2" align="center" style="border:1px dotted #000000;vertical-align:middle;"><b><?php echo number_format($st*100/$smt,0); ?>%</b></td>
</tr>
</table>