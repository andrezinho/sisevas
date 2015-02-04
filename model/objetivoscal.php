<?php
include_once("Main.php");
class objetivoscal extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT 
            idobejtivoscalidad,
            descripcion,
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end

            from obejtivoscalidad ";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM obejtivoscalidad WHERE idobejtivoscalidad = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO obejtivoscalidad (descripcion, img, estado) VALUES(:p1, :p2, :p3)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['archivo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        $id =  $this->IdlastInsert('obejtivosemp','idobejtivosemp');
        $Upd="UPDATE obejtivosemp
            SET img= :p2
          WHERE idobejtivosemp!= :p1";
        $stmt1 = $this->db->prepare($Upd);
        $stmt1->bindParam(':p1', $id , PDO::PARAM_INT);
        $stmt1->bindParam(':p2', $_P['archivo'] , PDO::PARAM_STR);
        $stmt1->execute();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE obejtivoscalidad 
            SET descripcion = :p1, img= :p2, estado = :p3
            WHERE idobejtivoscalidad = :idobejtivoscalidad");

        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['archivo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idobejtivoscalidad', $_P['idobejtivoscalidad'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        $id =  $_P['idobejtivoscalidad'];
        $Upd="UPDATE obejtivoscalidad
            SET img= :p2
          WHERE idobejtivoscalidad!= :p1";
        $stmt1 = $this->db->prepare($Upd);
        //print_r($stmt1);
        $stmt1->bindParam(':p1', $id , PDO::PARAM_INT);
        $stmt1->bindParam(':p2', $_P['archivo'] , PDO::PARAM_STR);
        $stmt1->execute();
        
        return array($p1 , $p2[2]);
    }

    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM obejtivoscalidad WHERE idobejtivoscalidad = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function getList($IdZo=null)
    {
        $sql = "SELECT idobejtivoscalidad, descripcion from obejtivoscalidad ";
        if($IdZo!=null)
        {
            $sql .= " WHERE idubigeo = '{$IdZo}' ";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idobejtivoscalidad'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }


}
?>