<?php
include_once("Main.php");
class metodoscap extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT 
                idmetodoscapacitacion, 
                descripcion, 
                case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
            FROM capacitacion.metodoscapacitacion";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM capacitacion.metodoscapacitacion WHERE idmetodoscapacitacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $tipopro=1;
        $idmaderb= 1;
        $stmt = $this->db->prepare("INSERT into capacitacion.metodoscapacitacion(descripcion,estado)
                                    values(:p1,:p2)");
        
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "UPDATE capacitacion.metodoscapacitacion 
                    set     
                        descripcion=:p1,                        
                        estado=:p2

                WHERE idmetodoscapacitacion = :idmetodoscapacitacion";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);

        $stmt->bindParam(':idmetodoscapacitacion', $_P['idmetodoscapacitacion'] , PDO::PARAM_INT);            
            
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM capacitacion.metodoscapacitacion WHERE idmetodoscapacitacion = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function getPrice($id)
    {
        $stmt = $this->db->prepare("SELECT precio_u from capacitacion.metodoscapacitacion WHERE idmetodoscapacitacion = :p1");
        $stmt->bindParam(':p1', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        return $r->precio_u;
    }

    function getStock($id,$a)
    {
        $sql = "SELECT t.idm,t.c,t.item
                from (
                SELECT max(idmovimiento) as idm ,ctotal_current as c, item
                FROM movimientosdetalle
                where idtipoproducto = 1 and idmetodoscapacitacion = :idp and idalmacen = :ida 
                group by ctotal_current,item,idmovimiento
                order by idmovimiento desc
                limit 1) as t
                order by t.item desc";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idp',$id,PDO::PARAM_INT);
        $stmt->bindParam(':ida',$a,PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->fetchObject();
        if($row->c>0)
            return $row->c;
        else return '0.000';
    }
}
?>