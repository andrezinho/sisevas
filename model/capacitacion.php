<?php
include_once("Main.php");
class capacitacion extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT s.idrutas,
                       s.descripcion,
                       case s.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                from rutas AS s";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM capacitacion.capacitacion WHERE idcapacitacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        
        $stmt = $this->db->prepare("INSERT INTO capacitacion.capacitacion(
            idfuentecapacitacion, idejecapacitacion, tema, idobejtivosemp, idmetodoscapacitacion, idtipoevaluacion, idalcance, 
            propuesta, referencias, palabrasclaves, externo, idpersonal, expositor, fecha, hora)
            VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15) ");
            
        $stmt->bindParam(':p1', $_P['idfuentecapacitacion'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['idejecapacitacion'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['tema'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['idobejtivosemp'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idmetodoscapacitacion'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['idtipoevaluacion'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['idalcance'] , PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['propuesta'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['referencias'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['palabrasclaves'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['externo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['idpersonal'] , PDO::PARAM_INT);
        $stmt->bindParam(':p13', $_P['expositor'] , PDO::PARAM_STR);
        $stmt->bindParam(':p14', $_P['fecha'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p15', $_P['hora'] , PDO::PARAM_BOOL);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE rutas set descripcion = :p1, estado = :p2 WHERE idrutas = :idrutas");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':idrutas', $_P['idrutas'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM rutas WHERE idrutas = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>