<?php
include_once("Main.php");
class ejecap extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            idejecapacitacion,
            descripcion,
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end          
            
            FROM
            capacitacion.ejecapacitacion  ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM capacitacion.ejecapacitacion WHERE idejecapacitacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM  capacitacion.ejecapacitacionfactor
            WHERE idejecapacitacion = :id    
            ORDER BY meses ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO capacitacion.ejecapacitacion (descripcion, estado) 
                        VALUES(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE capacitacion.ejecapacitacion
                    set 
                        descripcion = :p1, 
                        estado = :p2 
                    WHERE idejecapacitacion = :id");
                    
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $_P['idejecapacitacion'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        
        $stmt = $this->db->prepare("DELETE FROM capacitacion.ejecapacitacion WHERE idejecapacitacion = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    public function RFinanciamiento($idfinanc)
    {
        $sql = "SELECT
            f.idejecapacitacion,
            f.descripcion,
            f.adicional,
            f.inicial,
            ff.meses,
            ff.factor
            FROM
            capacitacion.ejecapacitacion AS f
            INNER JOIN capacitacion.ejecapacitacionfactor AS ff ON f.idejecapacitacion = ff.idejecapacitacion

            WHERE ff.idejecapacitacion='$idfinanc' AND f.estado=1 ";    
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