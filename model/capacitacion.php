<?php

include_once("Main.php");
include_once("tipodocumento.php");

class capacitacion extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            c.idcapacitacion,
            c.codigo, c.tema,
            f.descripcion AS fuente,            
            m.descripcion,
            case c.estado 
                when 0 then '<p style=\"color:green;font-weight: bold;\">FALTA ASIGNAR</p>'
                when 1 then '<a class=\"finalizar box-boton boton-hand\" id=\"f-'||c.idcapacitacion||'\" href=\"#\" title=\"Finalizar Capacitacion\" ></a>'
                when 2 then '<a class=\"box-boton boton-ok\" title=\"Capacitacion Fonalizada\" ></a>'
            else '' end    
            
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.fuentecapacitacion AS f ON f.idfuentecapacitacion = c.idfuentecapacitacion
            INNER JOIN capacitacion.ejecapacitacion AS e ON e.idejecapacitacion = c.idejecapacitacion
            INNER JOIN capacitacion.metodoscapacitacion AS m ON m.idmetodoscapacitacion = c.idmetodoscapacitacion
            WHERE c.anio='2015' ";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT c.codigo,
                c.idcapacitacion, c.idfuentecapacitacion,
                c.idejecapacitacion, c.tema,
                c.idobejtivoscap, c.idmetodoscapacitacion,
                c.idtipoevaluacion,
                c.propuesta, c.referencias, c.palabrasclaves,
                c.externo, c.idpersonal, c.expositor,                
                d.idobejtivosemp,
                p.mail, l.descripcion
                
                FROM
                capacitacion.capacitacion AS c
                LEFT JOIN capacitacion.capacitacion_obejtivosemp AS d ON c.idcapacitacion = d.idcapacitacion
                LEFT JOIN public.obejtivosemp AS oe ON oe.idobejtivosemp = d.idobejtivosemp
                LEFT JOIN public.personal AS p ON p.idpersonal = c.idpersonal
                LEFT JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion = c.idlineaaccion
                WHERE c.idcapacitacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {

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
        
        $obj_td = new Tipodocumento();
        $idtipodocumento= 8;
        
        $idfuentecapacitacion = $_P['idfuentecapacitacion'];
        $idejecapacitacion    = $_P['idejecapacitacion'];
        $tema                 = $_P['tema'];
        $idobejtivoscap       = $_P['idobejtivoscap'];
        $idmetodoscapacitacion= $_P['idmetodoscapacitacion'];
        $idperfil             = $_P['idperfil'];
        $codigo               = $_P['codigo'];
        $propuesta            = $_P['propuesta'];
        $referencias          = $_P['referencias'];
        $palabrasclaves       = $_P['palabrasclaves'];
        $idlineaaccion        = $_P['idlineaaccion'];
        $anio= date('Y');

        $obj_td->UpdateCorrelativo($idtipodocumento);


        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            $sql= "INSERT INTO capacitacion.capacitacion( idfuentecapacitacion, idejecapacitacion, tema, idobejtivoscap, idmetodoscapacitacion, idtipoevaluacion, 
            codigo,propuesta, referencias, palabrasclaves, anio, idlineaaccion)
            VALUES($idfuentecapacitacion,$idejecapacitacion,'$tema',$idobejtivoscap,$idmetodoscapacitacion,
                $idperfil,'$codigo','$propuesta','$referencias','$palabrasclaves', $anio, $idlineaaccion) ";
            $stmt = $this->db->prepare($sql);

            /*
            $stmt->bindParam(':p1', $_P['idfuentecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['idejecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['tema'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['idobejtivoscap'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['idmetodoscapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p6', $_P['idperfil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p7', $_P['codigo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['propuesta'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['referencias'] , PDO::PARAM_STR);
            $stmt->bindParam(':p10', $_P['palabrasclaves'] , PDO::PARAM_STR);*/
            
            //$stmt->bindParam(':p14', $_P['horacap'] , PDO::PARAM_BOOL);
            //$stmt->bindParam(':p15', $_P['horacap'] , PDO::PARAM_BOOL);
            $stmt->execute();
            
            $id =  $this->IdlastInsert('capacitacion.capacitacion','idcapacitacion');
            $row = $stmt->fetchAll();
            
            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_obejtivosemp(
                                        idcapacitacion, idobejtivosemp)
                                VALUES (:p1, :p2) ");
            
            foreach($_P['idobejtivosempresa'] as $i => $idobejtivosemp)
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

    function update($_P ) {
        
        $sql = "UPDATE capacitacion.capacitacion SET 
            idfuentecapacitacion= :p1, idejecapacitacion= :p2, 
            tema= :p3, idobejtivoscap= :p4, idmetodoscapacitacion= :p5, idtipoevaluacion= :p6, 
            propuesta= :p8, referencias= :p9, palabrasclaves= :p10,
            idlineaaccion= :p11            
            WHERE idcapacitacion= :idcapacitacion";

        $stmt = $this->db->prepare($sql);
        
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            $id= $_P['idcapacitacion'];
            
            //$stmt->bindParam(':p0', $_P['correlativo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p1', $_P['idfuentecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['idejecapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['tema'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['idobejtivoscap'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $_P['idmetodoscapacitacion'] , PDO::PARAM_INT);
            $stmt->bindParam(':p6', $_P['idperfil'] , PDO::PARAM_INT);
            //$stmt->bindParam(':p7', $_P['idtipopersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p8', $_P['propuesta'] , PDO::PARAM_STR);
            $stmt->bindParam(':p9', $_P['referencias'] , PDO::PARAM_STR);
            $stmt->bindParam(':p10', $_P['palabrasclaves'] , PDO::PARAM_STR);
            $stmt->bindParam(':p11', $_P['idlineaaccion'] , PDO::PARAM_INT);
            //$stmt->bindParam(':p12', $_P['idpersonal'] , PDO::PARAM_INT);
            //$stmt->bindParam(':p13', $_P['expositor'] , PDO::PARAM_STR);
            //$stmt->bindParam(':p14', $_P['fechacap'] , PDO::PARAM_BOOL);
            //$stmt->bindParam(':p15', $_P['horacap'] , PDO::PARAM_BOOL);
            
            $stmt->bindParam(':idcapacitacion', $_P['idcapacitacion'] , PDO::PARAM_INT);
            $stmt->execute();
            
            
            $sqld="DELETE FROM capacitacion.capacitacion_obejtivosemp
                   WHERE idcapacitacion= ".$id;
                $stmt0 = $this->db->prepare($sqld);                    
                $stmt0->execute();                    
               
            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_obejtivosemp(
                                        idcapacitacion, idobejtivosemp)
                                VALUES (:p1, :p2) ");

            foreach($_P['idobejtivosempresa'] as $i => $idobejtivosemp)
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
    
    function delete($id ) {
        //echo $id;
        $stmt0 = $this->db->prepare("DELETE FROM capacitacion.capacitacion_obejtivosemp WHERE idcapacitacion = :p1");
        $stmt0->bindParam(':p1', $id , PDO::PARAM_INT);
        $stmt0->execute();

        $st= $this->db->prepare("DELETE FROM capacitacion.capacitacion_asignacion WHERE idcapacitacion = :p1");
        $st->bindParam(':p1', $id , PDO::PARAM_INT);
        $st->execute();
        
        $stmt = $this->db->prepare("DELETE FROM capacitacion.capacitacion WHERE idcapacitacion = :p1");
        $stmt->bindParam(':p1', $id , PDO::PARAM_INT);
        $p1 = $stmt->execute();

        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function end($p)
    {
        $stmt = $this->db->prepare("UPDATE capacitacion.capacitacion set estado = 2
                                    WHERE idcapacitacion = :id and estado = 1");
        $stmt->bindParam(':id',$p,PDO::PARAM_INT);
        $r = $stmt->execute();
        if($r) return array("1",'Ok, esta produccion fue finalizada');
            else return array("2",'Ha ocurrido un error, porfavor intentelo nuevamente');
    }

}
?>