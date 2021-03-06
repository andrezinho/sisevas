<?php
include_once("Main.php");
class TipoPersonal extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idtipopersonal,
               descripcion,
               '<a href=\"tipoperfil/'||file||'\" target=\"_blank\" class=\"btn-evaluar box-boton boton-recibido\"></a>',
               case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from tipo_personal";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM tipo_personal WHERE idtipopersonal = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO tipo_personal (descripcion, estado, file) VALUES(:p1,:p2, :p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p3', $_P['archivo'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
	//echo 
	$id=$_P['idtipopersonal'];
        $stmt = $this->db->prepare("UPDATE tipo_personal 
			set 
			descripcion = :p1, 
			estado = :p2, file= :p3
			WHERE idtipopersonal = ".$id);
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p3', $_P['archivo'], PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM tipo_personal WHERE idtipopersonal = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>