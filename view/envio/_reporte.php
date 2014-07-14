<div style="padding:20px; text-align:center">
	<h2>Personal: <?php echo $datos[0] ?></h2>
	<p>Consultorio: <?php echo $datos[1] ?></p>
	<br/>
	<div class="ui-widget-content ui-corner-all " style="text-align:left;">
		<table border="1" cellpadding="4" width="100%">
			<tr class="ui-widget-header">
				<th>ASUNTO</th>
				<th>FECHA</th>
				<th>CODIGO</th>
				<th>PROBLEMA</th>
			</tr>
		<?php 
			foreach ($rows as $k => $v) 
			{
				?>
				<tr>
				<td><?php echo $v['asunto']; ?></td>
				<td><?php echo $v['fechainicio']; ?></td>
				<td><?php echo $v['codigo']; ?></td>
				<td><?php echo $v['problema']; ?></td>
				</tr>
				<?php
			}
		?>
		</table>
	</div>
</div>