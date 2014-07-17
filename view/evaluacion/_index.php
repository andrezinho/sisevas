<script type="text/javascript" src="js/app/evt_evaluacion.js"></script>
<div class="container">
	<?php 
		$display = "none";
		if($rows->idpersonal=="")
			$display = "block";
	?>
	<header style="display:<?php echo $display; ?>">
		<h1>
			Buscar Personal
		</h1>
		<form name="form-search" id="form-search" action="index.php" method="get">
			<input type="hidden" name="idp" id="idp" value="" />
			<input type="hidden" name="controller" id="controller" value="evaluacion" />
			<input type="text" name="personal_name" id="personal_name" value="" placeholder="Nombre del Personal" style="width:65%" class="text" />
			<a href="#" id="load_personal" class="myButton">Cargar</a>
			<a href="#" id="btn-close-search-personal" class="myButton">Cerrar</a>
		</form>
	</header>	
	<nav id="mp-menu" class="mp-menu">		
		<div class="mp-level">		
			<div style=" padding:0 10px;">				
				<span class="box-options-top"><a id="btn-logo" class="options-icons" href="index.php" title="Sistema"><b>SISEVAS</b></a></span>
				<span class="box-options-top"><a id="btn-periodo" class="options-icons" href="#" title="Periodo"><?php echo $_SESSION['periodo'] ?></a></span>
				<span class="box-options-top"><a id="btn-search-personal" class="options-icons" href="#" title="Buscar y/o Cambiar de Personal">Buscar Personal</a></span>
			</div>
			<div id="box-search-personal">
				 
			</div>
			<div class="title-head">
				<input type="hidden" name="idpersonal" id="idpersonal" value="<?php echo $rows->idpersonal; ?>" />
				<h1><?php echo $rows->nombres." ".$rows->apellidos; ?>					
					<span><?php echo strtoupper($rows->perfil); ?><br/></span>
					<p>Evaluador: <?php echo $_SESSION['name']; ?></p>
				</h1>
			</div>
			<div style="border-top:1px dotted #666;"></div>
			<div style="display:none">
				<?php echo $competencias; ?>
			</div>
			<h2>Competencias</h2>
			<ul>
				<?php
					foreach ($competencias_r as $k => $v) 
					{
						?>
						<li><a class="comp-option" href="#" id="comp-<?php echo $v['idc'] ?>"><?php echo ucwords(strtolower($v['des'])); ?> (<?php echo $v['percent'] ?>%)</a></li>
						<?php	
					}
				?>
			</ul>
			<div style="text-align:center; padding:10px 0;">
                <a href="#" id="reporte_in" class="myButton">Innovaciones</a>
                <a href="#" id="reporte_me" class="myButton">Memos</a>
				<a href="#" id="reporte_as" class="myButton">Reporte</a>
				<br/><br/>
				<a href="#" id="save_as" class="myButton">&nbsp;&nbsp;&nbsp;&nbsp;Grabar&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
			</div>
		</div>
	</nav>
</div>
<div id="dialog-reporte">
	<div style="text-align:center; padding:30px 0 0">
		<a id="reporte_as_pdf" target="_blank" href="index.php?controller=evaluacion&action=reporte_detallado&idp=<?php echo $rows->idpersonal; ?>&tipo=pdf" style="font-weight:bold;font-size:14px;color:#00588A">PDF</a>
		<a id="reporte_as_excel" href="#" style="font-weight:bold;font-size:14px;color:#00588A;margin-left:20px;">EXCEL</a>
	</div>
</div>