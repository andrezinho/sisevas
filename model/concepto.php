<?php
include_once("Main.php");
class Concepto extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            idconcepto,
            descripcion,
            case estado WHEN 1 then 'ACTIVO' else 'INCANTIVO' end
            FROM conceptos";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM  conceptos WHERE idconcepto = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO conceptos(descripcion,estado) values(:p1,:p2) ");
               
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);    
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);        
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE  conceptos 
                set  descripcion=:p1,                    
                    estado=:p2
                                   
                WHERE idconcepto = :idconcepto";
        $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);            
            $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
            
            $stmt->bindParam(':idconcepto', $_P['idconcepto'] , PDO::PARAM_INT);


        $p1 = $stmt->execute();

        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM  conceptos WHERE idconcepto = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function get($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT idconcepto,descripcion
            FROM conceptos WHERE {$field} ilike :query and estado=1 limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);       
        //print_r($statement);
        $statement->execute();
        return $statement->fetchAll();
    }
    
    function getList($id)
    {
        $sql = "SELECT
        d.idconcepto,
        co.descripcion
        FROM
        capacitacion.categoriapresupuesto AS c
        INNER JOIN capacitacion.detcategconcepto AS d ON d.idcatpresupuesto = c.idcatpresupuesto
        INNER JOIN public.conceptos AS co ON d.idconcepto = co.idconcepto
        WHERE
        d.idcatpresupuesto = {$id} AND co.estado= 1 
        ORDER BY
        co.descripcion ASC ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idconcepto'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }
}
?>