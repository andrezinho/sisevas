<?php
include_once("Main.php");
class capacitacion extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            c.idcapacitacion,
            c.tema,
            f.descripcion AS fuente,            
            c.expositor,
            substr(cast(c.fecha as text),9,2)||'/'||substr(cast(c.fecha as text),6,2)||'/'||substr(cast(c.fecha as text),1,4),
            substr(cast(c.hora as text),1,8)
            
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.fuentecapacitacion AS f ON f.idfuentecapacitacion = c.idfuentecapacitacion
            INNER JOIN capacitacion.ejecapacitacion AS e ON e.idejecapacitacion = c.idejecapacitacion";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT
                c.idcapacitacion, c.idfuentecapacitacion,
                c.idejecapacitacion, c.tema,
                c.idobejtivoscap, c.idmetodoscapacitacion,
                c.idtipoevaluacion, c.idalcance,
                c.propuesta, c.referencias, c.palabrasclaves,
                c.externo, c.idpersonal, c.expositor,
                substr(cast(c.fecha as text),9,2)||'/'||substr(cast(c.fecha as text),6,2)||'/'||substr(cast(c.fecha as text),1,4) AS fecha,
                substr(cast(c.hora as text),1,8) AS hora,
                d.idobejtivosemp,
                p.mail
                
                FROM
                capacitacion.capacitacion AS c
                LEFT JOIN capacitacion.capacitacion_obejtivosemp AS d ON c.idcapacitacion = d.idcapacitacion
                LEFT JOIN public.obejtivosemp AS oe ON oe.idobejtivosemp = d.idobejtivosemp
                LEFT JOIN public.personal AS p ON p.idpersonal = c.idpersonal
                
                WHERE c.idcapacitacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        //print_r($stmt);
        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {

        //echo $idtpdoc;
        $stmt = $this->db->prepare("SELECT
            d.idobejtivosemp,
            d.idcapacitacion,
            oe.descripcion
            FROM
            capacitacion.capacitacion AS c
            LEFT JOIN capacitacion.capacitacion_obejtivosemp AS d ON c.idcapacitacion = d.idcapacitacion
            LEFT JOIN public.obejtivosemp AS oe ON oe.idobejtivosemp = d.idobejtivosemp

            WHERE c.idcapacitacion = :id ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    function insert($_P ) {
        
        $stmt = $this->db->prepare("INSERT INTO capacitacion.capacitacion(
            idfuentecapacitacion, idejecapacitacion, tema, idobejtivoscap, idmetodoscapacitacion, idtipoevaluacion, idalcance, 
            propuesta, referencias, palabrasclaves, externo, idpersonal, expositor, fecha, hora)
            VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15) ");
        
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            $ext= $_P['externo'];
            if(isset($ext))
        	{$exter=1;} 
        	else
        	{$exter=0;}    
            $stmt->bindParam(':p1', $_P['idfuentecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['idejecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['tema'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['idobejtivoscap'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['idmetodoscapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p6', $_P['idperfil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p7', $_P['idtipopersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p8', $_P['propuesta'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['referencias'] , PDO::PARAM_STR);
            $stmt->bindParam(':p10', $_P['palabrasclaves'] , PDO::PARAM_STR);
            $stmt->bindParam(':p11', $exter , PDO::PARAM_INT);
            $stmt->bindParam(':p12', $_P['idpersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p13', $_P['expositor'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14', $_P['horacap'] , PDO::PARAM_BOOL);
            $stmt->bindParam(':p15', $_P['horacap'] , PDO::PARAM_BOOL);
            $stmt->execute();
            
            $id =  $this->IdlastInsert('capacitacion.capacitacion','idcapacitacion');
            $row = $stmt->fetchAll();
            
            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_obejtivosemp(
                                        idcapacitacion, idobejtivosemp)
                                VALUES (:p1, :p2) ");

            foreach($_P['idobejtivosemp'] as $i => $idobejtivosemp)
            {                
                $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                $stmt2->bindParam(':p2',$idobejtivosemp,PDO::PARAM_INT);
                $stmt2->execute();                
            
            }
            
            $this->db->commit();            
            return array('1','Bien!',$id);
            
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('2',$e->getMessage().$str,'');
        } 
        //$p1 = $stmt->execute();
        //$p2 = $stmt->errorInfo();
        //return array($p1 , $p2[2]);
    }

    function update($_P ) {
        
        $sql = "UPDATE capacitacion.capacitacion SET 
            idfuentecapacitacion= :p1, idejecapacitacion= :p2, 
            tema= :p3, idobejtivoscap= :p4, idmetodoscapacitacion= :p5, idtipoevaluacion= :p6, 
            idalcance= :p7, propuesta= :p8, referencias= :p9, palabrasclaves= :p10, externo= :p11, 
            idpersonal= :p12, expositor= :p13, fecha= :p14, hora= :p15

            WHERE idcapacitacion= :idcapacitacion";

        $stmt = $this->db->prepare($sql);
        
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            $id= $_P['idcapacitacion'];
            
            $ext= $_P['externo'];
            if(isset($ext))
        	{$exter=1;} 
        	else
        	{$exter=0;} 
            
            $stmt->bindParam(':p1', $_P['idfuentecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['idejecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['tema'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['idobejtivoscap'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['idmetodoscapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p6', $_P['idperfil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p7', $_P['idtipopersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p8', $_P['propuesta'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['referencias'] , PDO::PARAM_STR);
            $stmt->bindParam(':p10', $_P['palabrasclaves'] , PDO::PARAM_STR);
            $stmt->bindParam(':p11', $exter , PDO::PARAM_INT);
            $stmt->bindParam(':p12', $_P['idpersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p13', $_P['expositor'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14', $_P['fechacap'] , PDO::PARAM_BOOL);
            $stmt->bindParam(':p15', $_P['horacap'] , PDO::PARAM_BOOL);
            
            $stmt->bindParam(':idcapacitacion', $_P['idcapacitacion'] , PDO::PARAM_INT);
            $stmt->execute();
            
            
            $sqld="DELETE FROM capacitacion.capacitacion_obejtivosemp
                   WHERE idcapacitacion= ".$id;
                $stmt0 = $this->db->prepare($sqld);                    
                $stmt0->execute();                    
               
            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_obejtivosemp(
                                        idcapacitacion, idobejtivosemp)
                                VALUES (:p1, :p2) ");

            foreach($_P['idobejtivosemp'] as $i => $idobejtivosemp)
            {                
                $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                $stmt2->bindParam(':p2',$idobejtivosemp,PDO::PARAM_INT);
                $stmt2->execute();                
            
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
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM rutas WHERE idrutas = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>