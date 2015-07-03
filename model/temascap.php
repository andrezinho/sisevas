<?php
include_once("Main.php");
class temascap extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT a.idtemas,
            c.descripcion,
            a.descripcion,
            case a.estado when 1 then 'ACTIVO' else 'INACTIVO' END
            FROM capacitacion.temas as a 
            INNER JOIN capacitacion.lineaaccion as c on c.idlineaaccion = a.idlineaaccion ";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }
    
    function edit($id)
    {   
        $sql="SELECT * FROM  capacitacion.temas WHERE idtemas = :id ";
        $stmt = $this->db->prepare($sql);        
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {       
        //$fecha_reg = date('Y-m-d');
        $stmt = $this->db->prepare("INSERT INTO capacitacion.temas(descripcion, idlineaaccion, estado)
            VALUES (:p1, :p2, :p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idlineaaccion'] , PDO::PARAM_INT);
        //$stmt->bindParam(':p3', $fecha_reg , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
    }
    
    function update($_P ) 
    {
         $stmt = $this->db->prepare("UPDATE capacitacion.temas SET 
            descripcion=:p1, idlineaaccion= :p2, estado=:p3
            WHERE idtemas = :p4;");         
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idlineaaccion'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['idtemas'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();        
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
    }

    function getAspectos($idc)
    {
        $stmt = $this->db->prepare("SELECT idtemas, descripcion 
                                    from capacitacion.temas 
                                    where estado = 1 and idlineaaccion = :id");
        $stmt->bindParam(':id',$idc,PDO::PARAM_INT);
        $stmt->execute();
        $data = array();
        foreach ($stmt->fetchAll() as $r) 
        {            
            $data[] = array('id'=>$r['idtemas'],'descripcion'=>$r['descripcion']);
        }        
        return $data;
    }
    
    
}
?>