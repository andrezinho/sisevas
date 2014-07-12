<div style="padding:20px; text-align:center">
	<h2>Personal: <?php echo $datos[0] ?></h2>
	<p>Consultorio: <?php echo $datos[1] ?></p>
	<br/>
	<div class="ui-widget-content ui-corner-all ui-widget-header" style="text-align:left;">
		<ul>
		<?php 
			foreach ($rows as $k => $v) 
			{
				?>
				<li><?php echo $v['descripcion']; ?></li>
				<?php
			}
		?>
		</ul>
	</div>
</div>