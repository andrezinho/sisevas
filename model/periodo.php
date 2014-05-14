<?php
include_once("Main.php");
class periodo extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idperiodo,
                       descripcion,
                       fecha_apertura,
                       fecha_cierre,
                       anio,
                       case estado when 1 then 'APERTURADO' else 'CERRADO' end
                from evaluacion.periodo";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM evaluacion.periodo WHERE idperiodo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO evaluacion.periodo (descripcion, estado) VALUES(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE evaluacion.periodo set descripcion = :p1, estado = :p2 WHERE idperiodo = :idperiodo");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':idperiodo', $_P['idperiodo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM evaluacion.periodo WHERE idperiodo = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>