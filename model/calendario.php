<?php
include_once("Main.php");
class calendario extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idcalendario, 
            descripcion,
            dia||' '||mes||' '||anio,
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
            FROM calendario";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM cargo WHERE idcargo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO calendario( descripcion, dia, mes, anio, estado)
                VALUES(:p1, :p2, :p3, :p4, :p5)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['dia'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['mes'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['anio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['activo'] , PDO::PARAM_BOOL);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE calendario SET 
            descripcion= :p1, dia= :p2, mes= :p3, anio= :p4, estado= :p5
        WHERE idcalendario = :idcalendario");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['dia'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['mes'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['anio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['activo'] , PDO::PARAM_BOOL);
        
        $stmt->bindParam(':idcalendario', $_P['idcalendario'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM calendario WHERE idcalendario = :p1");
        $stmt->bindParam(':p1', $_P['idcalendario'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>