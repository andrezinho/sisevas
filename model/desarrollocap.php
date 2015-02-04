<?php
include_once("Main.php");
include_once("tipodocumento.php");

class desarrollocap extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            c.idcapacitacion,
            c.tema,
            c.expositor,
            substr(cast(c.fecha as text),9,2)||'/'||substr(cast(c.fecha as text),6,2)||'/'||substr(cast(c.fecha as text),1,4),
            case c.estado 
                when 0 then '<p style=\"color:green;font-weight: bold;\">FALTA ASIGNAR</p>'
                when 1 then '<a class=\"finalizar box-boton boton-hand\" id=\"f-'||c.idcapacitacion||'\" href=\"#\" title=\"Finalizar Capacitacion\" ></a>'
                when 2 then '<a class=\"box-boton boton-ok\" title=\"Capacitacion Finalizada\" ></a>'
            else '' end ,
            case c.estado 
                when 1 then '<a class=\"printer box-boton boton-print\" id=\"f-'||c.idcapacitacion||'\" href=\" #\" title=\"Imprimir Capacitacion\" ></a>'
                when 2 then '<a class=\"printer box-boton boton-print\" id=\"f-'||c.idcapacitacion||'\" href=\" #\" title=\"Imprimir Capacitacion\" ></a>'
            else '' end,
            case c.estado                 
                when 2 then '<a class=\"printerac box-boton boton-print\" id=\"f-'||c.idcapacitacion||'\" href=\" #\" title=\"Imprimir Acta de Reunion\" ></a>'
            else '' end
                        
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.fuentecapacitacion AS f ON f.idfuentecapacitacion = c.idfuentecapacitacion
            INNER JOIN capacitacion.ejecapacitacion AS e ON e.idejecapacitacion = c.idejecapacitacion
            INNER JOIN capacitacion.metodoscapacitacion AS m ON m.idmetodoscapacitacion = c.idmetodoscapacitacion
            WHERE (c.estado=1 OR c.estado=2) AND c.anio= ".date(Y); 
               
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT
                c.idcapacitacion, c.idfuentecapacitacion,
                c.idejecapacitacion, c.tema,
                c.idobejtivoscap, c.idmetodoscapacitacion,
                c.idtipoevaluacion, 
                c.propuesta, c.referencias, c.palabrasclaves,
                c.externo, c.idpersonal, c.expositor,    
                c.fecha, substr(cast(c.hora as text),1,5) AS hora,          
                d.idobejtivosemp, p.mail, p.dni,p.nombres, p.apellidos,
                c.nrohoras
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
    
    function getAcuerdos($id)
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
    
    function getDetailsAsig($id)
    {
        
        $stmt = $this->db->prepare("SELECT
            a.idpersonalasig,
            a.idtipoalcance,
            p.nombres||' '||p.apellidos AS asistentes,
            t.descripcion
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.capacitacion_asignacion AS a ON a.idcapacitacion = c.idcapacitacion
            INNER JOIN public.personal AS p ON a.idpersonalasig = p.idpersonal
            INNER JOIN capacitacion.tipoalcance AS t ON a.idtipoalcance = t.idtipoalcance
            WHERE c.idcapacitacion = :id ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    
    function update($_P ) 
    {   
        $obj_td = new Tipodocumento();
        $idtipodocumento= 9;
        
        $id        = $_P['idcapacitacion'];
        $horacap   = $_P['horacap'];
        $horacapfin= $_P['horacapfin'];
        $si        = $_P['activo'];
        $nroacta   = $_P['nroacta'];
        $lugar     = $_P['lugarreunion'];
        if($si!= 1) { $si=1; }else{ $si=2; }        
        
        $sql = "UPDATE capacitacion.capacitacion SET 
            hora= :p1, horafin= :p2, estado= :p3, nroacta= :p4,
            lugarreunion= :p5
            WHERE idcapacitacion= :idcapacitacion ";
        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':p1', $horacap , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $horacapfin , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $si , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $nroacta , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $lugar , PDO::PARAM_STR);
        $stmt->bindParam(':idcapacitacion', $id , PDO::PARAM_INT);
        $stmt->execute();
        
        $obj_td->UpdateCorrelativo($idtipodocumento);
        
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();            
            
            /**** INSERTAMOS Acuerdos de Capacitacion ****/
            $sqldel="DELETE FROM capacitacion.capacitacion_acuerdos WHERE idcapacitacion= ".$id;
            $exec = $this->db->prepare($sqldel);                    
            $exec->execute();                    
               
            $sqlac= "INSERT INTO capacitacion.capacitacion_acuerdos (
                idcapacitacion, acuerdo, idasistente ) 
                VALUES ( :p1, :p2, :p3)";
            $stmt2 = $this->db->prepare($sqlac);

            if($_P['idasistente'][0]!= ''){
                foreach($_P['idasistente'] as $i => $idasistente)
                {   
                    //print_r($_P['acuerdocap']);
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p2',$_P['acuerdocap'][$i],PDO::PARAM_STR);
                    $stmt2->bindParam(':p3', $idasistente ,PDO::PARAM_INT);
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

    function printDoc($id)
    {           
        //echo $id;        
        $cab= "SELECT ca.idcapacitacion, ca.codigo,
            fu.descripcion AS fuente,
            ej.descripcion AS eje,
            ca.tema, me.descripcion AS metodo,
            ob.descripcion AS obejtivoscap,
            p.descripcion AS tipoeval,
            ca.propuesta, ca.referencias,
            ca.palabrasclaves, ca.externo,
            substr(cast(ca.fecha as text),9,2)||'/'||substr(cast(ca.fecha as text),6,2)||'/'||substr(cast(ca.fecha as text),1,4) AS fecha,
            substr(cast(ca.hora as text),1,8) AS hora,
            ca.estado, pe.dni,
            pe.nombres||' '||pe.apellidos AS expoitor,
            pe.mail

            FROM capacitacion.capacitacion AS ca
            INNER JOIN public.personal AS pe ON pe.idpersonal = ca.idpersonal
            INNER JOIN capacitacion.fuentecapacitacion AS fu ON ca.idfuentecapacitacion = fu.idfuentecapacitacion
            INNER JOIN capacitacion.ejecapacitacion AS ej ON ca.idejecapacitacion = ej.idejecapacitacion
            INNER JOIN capacitacion.obejtivoscap AS ob ON ca.idobejtivoscap = ob.idobejtivoscap
            INNER JOIN capacitacion.metodoscapacitacion AS me ON ca.idmetodoscapacitacion = me.idmetodoscapacitacion
            INNER JOIN seguridad.perfil AS p ON ca.idtipoevaluacion = p.idperfil
        
            WHERE ca.idcapacitacion=".$id;

        $stmt = $this->db->prepare($cab); 
        $stmt->execute();
        $cab= $stmt->fetch();
        
        $objemp= "SELECT o.descripcion
            FROM capacitacion.capacitacion_obejtivosemp AS d
            INNER JOIN capacitacion.capacitacion AS c ON d.idcapacitacion = c.idcapacitacion
            INNER JOIN public.obejtivosemp AS o ON d.idobejtivosemp = o.idobejtivosemp
            WHERE
            d.idcapacitacion=".$id;
        $stmt1 = $this->db->prepare($objemp); 
        $stmt1->execute();
        $objemp= $stmt1->fetchAll();
        
        $asig= "SELECT p.dni,
            p.nombres||' '||p.apellidos AS personal,
            t.descripcion
            FROM capacitacion.capacitacion AS c
            INNER JOIN capacitacion.capacitacion_asignacion AS d ON d.idcapacitacion = c.idcapacitacion
            INNER JOIN public.personal AS p ON p.idpersonal = d.idpersonalasig
            INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = d.idtipoalcance
            WHERE d.idcapacitacion=".$id;
        $stmt2 = $this->db->prepare($asig); 
        $stmt2->execute();
        $asig= $stmt2->fetchAll();  
        
        return array($cab, $objemp, $asig);
    }
    
    function printPre($id)
    {        
        /*-------- PRESUPUESTO -----------*/
        $caT="SELECT
            cp.idcatpresupuesto,
            cp.descripcion,
            cp.estado
            FROM
            capacitacion.categoriapresupuesto AS cp
            INNER JOIN capacitacion.presupuesto AS p ON cp.idcatpresupuesto = p.idcatpresupuesto
            INNER JOIN capacitacion.capacitacion AS c ON c.idcapacitacion = p.idcapacitacion
            WHERE
            p.idcapacitacion=".$id."
            GROUP BY
            cp.idcatpresupuesto,
            cp.descripcion,
            cp.estado";
        $stmt3 = $this->db->prepare($caT); 
        $stmt3->execute();
        $data= array();
        
        foreach ($stmt3->fetchAll() as $f)
        {
            $DetCat="SELECT            
                c.descripcion,
                p.tiempo,
                u.descripcion AS unidad,
                p.cantidad,
                p.preciounitario
                FROM
                capacitacion.presupuesto AS p
                INNER JOIN capacitacion.capacitacion AS ca ON ca.idcapacitacion = p.idcapacitacion
                LEFT JOIN public.conceptos AS c ON c.idconcepto = p.idconcepto
                LEFT JOIN public.unidad_medida AS u ON u.idunidad_medida = p.idunidad_medida
                WHERE p.idcapacitacion=".$id." and p.idcatpresupuesto= ".$f['idcatpresupuesto'];
            //print_r($DetCat);
            $stmt4 = $this->db->prepare($DetCat); 
            $stmt4->execute();
            
            $data[]= array(
                'Cat' => $f['descripcion'],
                'Det' => $stmt4->fetchAll()
            );
        }
        
        return $data;   
    }
    
    function VerNroActa($Id)
    {
        $stmt = $this->db->prepare("SELECT nroacta FROM capacitacion.capacitacion WHERE idcapacitacion = :id ");
        $stmt->bindParam(':id',$Id,PDO::PARAM_INT);
        $stmt->execute();
        $data = array();
        $row= $stmt->fetchObject();
        $nroacta= $row->nroacta; 
        
        $data = array('nroacta' =>$nroacta );
        return $data;
        
    }

}
?>