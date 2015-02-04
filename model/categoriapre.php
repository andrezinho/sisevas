<?php
include_once("Main.php");
class categoriapre extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = " SELECT
                idcatpresupuesto,
                descripcion,
                case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
                
                FROM
                capacitacion.categoriapresupuesto";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM capacitacion.categoriapresupuesto WHERE idcatpresupuesto = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            d.idcatpresupuesto,
            d.idconcepto,
            c.descripcion
            FROM
            capacitacion.detcategconcepto AS d
            INNER JOIN public.conceptos AS c ON c.idconcepto = d.idconcepto
            
            WHERE idcatpresupuesto = :id ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO capacitacion.categoriapresupuesto(descripcion,estado) VALUES (:p1,:p2) ");
        
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);        
            $stmt->execute();
            $id =  $this->IdlastInsert('capacitacion.categoriapresupuesto','idcatpresupuesto');
            $row = $stmt->fetchAll();

            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.detcategconcepto( idcatpresupuesto, idconcepto) VALUES ( :p1, :p2) ");
			
			if($_P['idconceptodet']!= '')
			{
                foreach($_P['idconceptodet'] as $i => $idconcepto)
                {
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idconcepto,PDO::PARAM_INT); 
                   
                    $stmt2->execute();
                }
			}
			
            $this->db->commit();            
            return array('1','Bien!',$id);

        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('2',$e->getMessage().$str,'');
        } 
        
    }

    function update($_P ) 
    {
        $idcatpresupuesto= $_P['idcatpresupuesto'];
        
        $del="DELETE FROM capacitacion.detcategconcepto WHERE idcatpresupuesto='$idcatpresupuesto' ";
        $res = $this->db->prepare($del);
        $res->execute();
        
        $sql = "UPDATE capacitacion.categoriapresupuesto  SET  descripcion=:p1, estado=:p2
            WHERE idcatpresupuesto = :idcatpresupuesto";
        $stmt = $this->db->prepare($sql);
            
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);            
            $stmt->bindParam(':idcatpresupuesto', $_P['idcatpresupuesto'] , PDO::PARAM_INT);
            $stmt->execute();
            
            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.detcategconcepto( idcatpresupuesto, idconcepto) VALUES ( :p1, :p2) ");

                foreach($_P['idconceptodet'] as $i => $idconcepto)
                {
                    $stmt2->bindParam(':p1',$idcatpresupuesto,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idconcepto,PDO::PARAM_INT); 
                   
                    $stmt2->execute();
                }


            $this->db->commit();            
            return array('1','Bien!',$idcatpresupuesto);

        }
        catch(PDOException $e) 
            {
                $this->db->rollBack();
                return array('2',$e->getMessage().$str,'');
            } 
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM capacitacion.categoriapresupuesto WHERE idcatpresupuesto = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>