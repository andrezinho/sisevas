<?php
include_once("Main.php");
class medioverificacion extends Main
{    
    //indexGridi -> Grilla del index de ingresos.
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idmediosverificacion, 
            descripcion, 
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
            FROM calidad.mediosverificacion";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM calidad.mediosverificacion
            WHERE idmediosverificacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO calidad.mediosverificacion (descripcion,estado) 
                    VALUES( :p1, :p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);

    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE calidad.mediosverificacion 
                SET descripcion = :p1,
                estado = :p2
                WHERE idmediosverificacion = :idmediosverificacion");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idmediosverificacion', $_P['idmediosverificacion'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM calidad.mediosverificacion WHERE idmediosverificacion = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

}
?>