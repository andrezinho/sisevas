<?php
include_once("Main.php");
class objetivosemp extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
                idobejtivosemp,
                descripcion,
                case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                FROM
                public.obejtivosemp ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM obejtivosemp WHERE idobejtivosemp = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO obejtivosemp (descripcion,estado) 
                    VALUES(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        $stmt = $this->db->prepare("SELECT max(idobejtivosemp) as cod from obejtivosemp");
        $stmt->execute();
        $row = $stmt->fetchObject();

        return array($p1 , $p2[2], $row->cod, $_P['descripcion']. ' - '.$_P['espesor']);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE obejtivosemp 
                set 
                    descripcion = :p1, 
                    estado = :p2
                WHERE idobejtivosemp = :idobejtivosemp");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idobejtivosemp', $_P['idobejtivosemp'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM obejtivosemp WHERE idobejtivosemp = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function getList($idmad=null)
    {
        $sql = "SELECT idobejtivosemp, descripcion from obejtivosemp ";
        if($idmad!=null)
        {
            $sql .= " WHERE idlinea = {$idmad}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idobejtivosemp'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }
}
?>