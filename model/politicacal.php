<?php
include_once("Main.php");
class politicacal extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idpolitica_calidad,
               descripcion,
               '<a href=\"images/index/'||img||'\" target=\"_blank\" class=\"btn-evaluar box-boton boton-recibido\"></a>',
               case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from politica_calidad";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM politica_calidad WHERE idpolitica_calidad = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO politica_calidad (descripcion, estado, img) VALUES(:p1,:p2, :p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p3', $_P['archivo'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
	//echo 
	$id=$_P['idpolitica_calidad'];
        $stmt = $this->db->prepare("UPDATE politica_calidad 
			set 
			descripcion = :p1, 
			estado = :p2, img= :p3
			WHERE idpolitica_calidad = ".$id);
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p3', $_P['archivo'], PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM politica_calidad WHERE idpolitica_calidad = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>