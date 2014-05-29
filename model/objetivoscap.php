<?php
include_once("Main.php");
class objetivoscap extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT 
            idobejtivoscap,
            descripcion,
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end

            from capacitacion.obejtivoscap ";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM capacitacion.obejtivoscap WHERE idobejtivoscap = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO capacitacion.obejtivoscap (descripcion, estado) VALUES(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE capacitacion.obejtivoscap 
                    set 
                        descripcion = :p1, 
                        estado = :p2
                        
                    WHERE idobejtivoscap = :idobejtivoscap");

        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idobejtivoscap', $_P['idobejtivoscap'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM capacitacion.obejtivoscap WHERE idobejtivoscap = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function getList($IdZo=null)
    {
        $sql = "SELECT idobejtivoscap, descripcion from capacitacion.obejtivoscap ";
        if($IdZo!=null)
        {
            $sql .= " WHERE idubigeo = '{$IdZo}' ";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idobejtivoscap'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }


}
?>