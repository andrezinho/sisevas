<?php
include_once("Main.php");
class capacitacionasig extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            c.idcapacitacion,
            c.tema,                        
            f.descripcion,
            c.expositor,
            substr(cast(c.fecha as text),9,2)||'/'||substr(cast(c.fecha as text),6,2)||'/'||substr(cast(c.fecha as text),1,4),
            case c.estado 
                when 0 then '<p style=\"color:green;font-weight: bold;\">FALTA ASIGNAR</p>'
                when 1 then '<a class=\"finalizar box-boton boton-hand\" id=\"f-'||c.idcapacitacion||'\" href=\"#\" title=\"Finalizar Capacitacion\" ></a>'
                when 2 then '<a class=\"box-boton boton-ok\" title=\"Capacitacion Fonalizada\" ></a>'
            else '' end ,
            case c.estado 
                when 1 then '<a class=\"printer box-boton boton-print\" id=\"f-'||c.idcapacitacion||'\" href=\" #\" title=\"Imprimir Capacitacion\" ></a>'
                when 2 then '<a class=\"printer box-boton boton-print\" id=\"f-'||c.idcapacitacion||'\" href=\" #\" title=\"Imprimir Capacitacion\" ></a>'
            else '' end
                        
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.fuentecapacitacion AS f ON f.idfuentecapacitacion = c.idfuentecapacitacion
            INNER JOIN capacitacion.ejecapacitacion AS e ON e.idejecapacitacion = c.idejecapacitacion
            INNER JOIN capacitacion.metodoscapacitacion AS m ON m.idmetodoscapacitacion = c.idmetodoscapacitacion"; 
               
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
            c.fecha, 
            substr(cast(c.hora as text),1,8) AS hora,          
            d.idobejtivosemp, 
            p.mail, p.dni,p.nombres, p.apellidos
            
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

    function update($_P ) {        
        
        $id           = $_P['idcapacitacion'];
        $idcapacitador= $_P['idpersonal'];
        $si           = $_P['activo'];
        $estado       = 1;
        $sql = "UPDATE capacitacion.capacitacion SET 
            idfuentecapacitacion= :p1, idejecapacitacion= :p2, 
            tema= :p3, idobejtivoscap= :p4, idmetodoscapacitacion= :p5, idtipoevaluacion= :p6, 
            propuesta= :p8, referencias= :p9, palabrasclaves= :p10, externo= :p11, 
            idpersonal= :p12, expositor= :p13, fecha= :p14, hora= :p15, estado= :p16

            WHERE idcapacitacion= :idcapacitacion";

        $stmt = $this->db->prepare($sql);
        
        $sqlper= "INSERT INTO personal(dni, nombres, apellidos, mail) VALUES (:p1, :p2, :p3, :p4)";
        $stmt1 = $this->db->prepare($sqlper);

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            //echo $_P['fechacap'];
            if($idcapacitador== '' || $_P['activo']== 1)
            {

                $stmt1->bindParam(':p1', $_P['expositordni'] , PDO::PARAM_INT);
                $stmt1->bindParam(':p2', $_P['nombresexpositor'] , PDO::PARAM_INT);
                $stmt1->bindParam(':p3', $_P['apellidosexpositor'] , PDO::PARAM_STR);
                $stmt1->bindParam(':p3', $_P['emailexp'] , PDO::PARAM_STR);
                $stmt1->execute();

                $idpercar =  $this->IdlastInsert('personal','idpersonal');
                $row = $stmt->fetchAll();

                $nombresexpositor= $_P['nombresexpositor'].' '.$_P['apellidosexpositor'];
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
                $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);
                $stmt->bindParam(':p12', $idpercar , PDO::PARAM_INT);
                $stmt->bindParam(':p13', $nombresexpositor , PDO::PARAM_STR);
                $stmt->bindParam(':p14', $_P['fechacap'] , PDO::PARAM_BOOL);
                $stmt->bindParam(':p15', $_P['horacap'] , PDO::PARAM_BOOL);
                $stmt->bindParam(':p16', $estado , PDO::PARAM_INT);

                $stmt->bindParam(':idcapacitacion', $_P['idcapacitacion'] , PDO::PARAM_INT);
                $stmt->execute();
            }
            else
                {

                    $nombresexpositor= $_P['nombresexpositor'].' '.$_P['apellidosexpositor'];

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
                    $stmt->bindParam(':p11', $_P['activo'] , PDO::PARAM_INT);
                    $stmt->bindParam(':p12', $_P['idpersonal'] , PDO::PARAM_INT);
                    $stmt->bindParam(':p13', $nombresexpositor , PDO::PARAM_STR);
                    $stmt->bindParam(':p14', $_P['fechacap'] , PDO::PARAM_BOOL);
                    $stmt->bindParam(':p15', $_P['horacap'] , PDO::PARAM_BOOL);
                    $stmt->bindParam(':p16', $estado , PDO::PARAM_INT);

                    $stmt->bindParam(':idcapacitacion', $_P['idcapacitacion'] , PDO::PARAM_INT);
                    $stmt->execute();
                }

            
            /**/
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
            
            
            /**/
            $sqldasig="DELETE FROM capacitacion.capacitacion_asignacion
                   WHERE idcapacitacion= ".$id;
                $stmt01 = $this->db->prepare($sqldasig);                    
                $stmt01->execute();  
                
            $stmt3  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_asignacion(
                                        idcapacitacion, idpersonalasig, idtipoalcance)
                                VALUES (:p1, :p2, :p3) ");

            foreach($_P['idpersonalasignado'] as $i => $idpersonalasig)
            {                
                $stmt3->bindParam(':p1',$id,PDO::PARAM_INT);                    
                $stmt3->bindParam(':p2',$idpersonalasig,PDO::PARAM_INT);
                $stmt3->bindParam(':p3',$_P['idtipoalcance'][$i],PDO::PARAM_INT);
                $stmt3->execute();                
            
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
    
    function printDoc($id)
    {   
        
        //echo $id;        
        $cab= "SELECT
            ca.idcapacitacion, ca.codigo,
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

            FROM
            capacitacion.capacitacion AS ca
            INNER JOIN public.personal AS pe ON pe.idpersonal = ca.idpersonal
            INNER JOIN capacitacion.fuentecapacitacion AS fu ON ca.idfuentecapacitacion = fu.idfuentecapacitacion
            INNER JOIN capacitacion.ejecapacitacion AS ej ON ca.idejecapacitacion = ej.idejecapacitacion
            INNER JOIN capacitacion.obejtivoscap AS ob ON ca.idobejtivoscap = ob.idobejtivoscap
            INNER JOIN capacitacion.metodoscapacitacion AS me ON ca.idmetodoscapacitacion = me.idmetodoscapacitacion
            INNER JOIN seguridad.perfil AS p ON ca.idtipoevaluacion = p.idperfil
        
            WHERE
            ca.idcapacitacion=".$id;

        $stmt = $this->db->prepare($cab); 
        $stmt->execute();
        $cab= $stmt->fetch();
        
        $objemp= "SELECT
            o.descripcion
            FROM
            capacitacion.capacitacion_obejtivosemp AS d
            INNER JOIN capacitacion.capacitacion AS c ON d.idcapacitacion = c.idcapacitacion
            INNER JOIN public.obejtivosemp AS o ON d.idobejtivosemp = o.idobejtivosemp
            WHERE
            d.idcapacitacion=".$id;
        $stmt1 = $this->db->prepare($objemp); 
        $stmt1->execute();
        $objemp= $stmt1->fetchAll();
        
        $asig= "SELECT
            p.dni,
            p.nombres||' '||p.apellidos AS personal,
            t.descripcion
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.capacitacion_asignacion AS d ON d.idcapacitacion = c.idcapacitacion
            INNER JOIN public.personal AS p ON p.idpersonal = d.idpersonalasig
            INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = d.idtipoalcance
            WHERE
            d.idcapacitacion=".$id;
        $stmt2 = $this->db->prepare($asig); 
        $stmt2->execute();
        $asig= $stmt2->fetchAll();

        return array($cab,$objemp,$asig);
    }

}
?>