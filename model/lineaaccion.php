<?php
include_once("Main.php");
class lineaaccion extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            idlineaaccion,
            descripcion,
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end          
            
            FROM
            capacitacion.lineaaccion  ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM capacitacion.lineaaccion WHERE idlineaaccion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM  capacitacion.lineaaccionfactor
            WHERE idlineaaccion = :id    
            ORDER BY meses ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO capacitacion.lineaaccion (descripcion, estado) 
                        VALUES(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE capacitacion.lineaaccion
                    set 
                        descripcion = :p1, 
                        estado = :p2 
                    WHERE idlineaaccion = :id");
                    
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $_P['idlineaaccion'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        
        $stmt = $this->db->prepare("DELETE FROM capacitacion.lineaaccion WHERE idlineaaccion = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function get($query,$field)
    {
    
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT 
                    idlineaaccion, descripcion                                        
                    FROM capacitacion.lineaaccion
                    WHERE {$field} ilike :query and estado=1
                    limit 10");                                        
        //print_r ($statement);                               
        $statement->bindParam (":query", $query , PDO::PARAM_STR);        
        $statement->execute();
        return $statement->fetchAll();
    }
    
    public function RFinanciamiento($idfinanc)
    {
        $sql = "SELECT
            f.idlineaaccion,
            f.descripcion,
            f.adicional,
            f.inicial,
            ff.meses,
            ff.factor
            FROM
            capacitacion.lineaaccion AS f
            INNER JOIN capacitacion.lineaaccionfactor AS ff ON f.idlineaaccion = ff.idlineaaccion

            WHERE ff.idlineaaccion='$idfinanc' AND f.estado=1 ";    
        $stmt=$this->db->prepare($sql);
        $stmt->execute();       
        $data = array();
        foreach ($stmt->fetchAll() as $row) {
            $data[] = array(
                    'codigo'=>$row[0],
                    'descripcion'=>$row[1],
                    'adicional'=>$row[2],
                    'inicial'=>$row[3],
                    'meses'=>$row[4],
                    'factor'=>$row[5]
                );
        }
        return $data;
    }

}
?>