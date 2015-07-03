<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    $Servidor = "localhost";
    $Puerto = "5432";
    $Usuario = "postgres";
    $Password = "torres04";
    $Base = "sisevas";
    
    try {
        $conexion = & new PDO("pgsql:dbname=$Base;host=$Servidor", $Usuario, $Password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //echo utf8_decode('Conexion Establecida');
    } catch (PDOException $e) {
        echo utf8_decode('Fallo la conexion'); //. $e->getMessage();
    }
    
    $Sql="SELECT idcapacitacion FROM capacitacion.capacitacion WHERE anio=2015 ";
    foreach($conexion->query($Sql)->fetchAll() as $row)
    {
        $Sql="SELECT COUNT(idcapacitacion) FROM capacitacion.capacitacion_asignacion
        WHERE idcapacitacion= ".$row['idcapacitacion'];
        $rs= $conexion->query($Sql)->fetch();
        $nro= $rs[0];
        
        $Sql1="SELECT SUM(subtotal) FROM capacitacion.presupuesto
        WHERE idcapacitacion= ".$row['idcapacitacion'];
        $rs1= $conexion->query($Sql1)->fetch();
        $tot= $rs1[0];
        
        $TotProm= intval($tot)/ intval($nro);
        $TotProm= number_format($TotProm, 2);
                
        $Upd="UPDATE capacitacion.capacitacion SET total='$tot', 
            totalpromediado='$TotProm', nroasignados=$nro
            WHERE idcapacitacion= ".$row['idcapacitacion'];
        $result= $conexion->query($Upd);
    }
    
    if (!$result) {
        $conexion->rollBack();
        echo "Erro en la insersion";
    }
    else {
        
        echo "Very Good";
    }
    $conexion = null;
    
?>
