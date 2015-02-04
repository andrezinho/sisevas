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
            INNER JOIN capacitacion.metodoscapacitacion AS m ON m.idmetodoscapacitacion = c.idmetodoscapacitacion
            WHERE c.anio='2015' "; 
               
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
    
    function getDetailsPre($id)
    {
        
        $stmt = $this->db->prepare("SELECT
            p.idcapacitacion,
            p.idcatpresupuesto,
            cat.descripcion AS categoria,
            p.idconcepto,
            co.descripcion AS concepto,
            p.tiempo,
            p.idunidad_medida,
            un.descripcion AS unidad,            
            p.cantidad,
            p.preciounitario,
            p.subtotal
            FROM
            capacitacion.presupuesto AS p
            INNER JOIN capacitacion.capacitacion AS c ON c.idcapacitacion = p.idcapacitacion
            LEFT JOIN capacitacion.categoriapresupuesto AS cat ON cat.idcatpresupuesto = p.idcatpresupuesto
            LEFT JOIN public.conceptos AS co ON co.idconcepto = p.idconcepto
            LEFT JOIN public.unidad_medida AS un ON un.idunidad_medida = p.idunidad_medida
            WHERE p.idcapacitacion = :id ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function update($_P ) {   
        //print_r($_P);     
        
        $id           = $_P['idcapacitacion'];
        $idcapacitador= $_P['idpersonal'];
        $si           = $_P['activo'];
        $estado       = 1;
        $sql = "UPDATE capacitacion.capacitacion SET 
            idfuentecapacitacion= :p1, idejecapacitacion= :p2, 
            tema= :p3, idobejtivoscap= :p4, idmetodoscapacitacion= :p5, idtipoevaluacion= :p6, 
            propuesta= :p8, referencias= :p9, palabrasclaves= :p10, externo= :p11, 
            idpersonal= :p12, expositor= :p13, fecha= :p14, hora= :p15, estado= :p16,
            nrohoras= :p17
            WHERE idcapacitacion= :idcapacitacion";

        $stmt = $this->db->prepare($sql);
        
        $sqlper= "INSERT INTO personal(dni, nombres, apellidos, mail) VALUES (:p1, :p2, :p3, :p4)";
        $stmt1 = $this->db->prepare($sqlper);

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            //echo $_P['nrohoras'];
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
                $stmt->bindParam(':p17', $_P['nrohoras'] , PDO::PARAM_INT);
                
                $stmt->bindParam(':idcapacitacion', $_P['idcapacitacion'] , PDO::PARAM_INT);
                $stmt->execute();
            }
            else
                {
                    //echo $_P['nrohoras'];
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
                    $stmt->bindParam(':p17', $_P['nrohoras'] , PDO::PARAM_INT);
                    
                    $stmt->bindParam(':idcapacitacion', $_P['idcapacitacion'] , PDO::PARAM_INT);
                    $stmt->execute();
                }
            
            /**** INSERTAMOS obejtivos del empresa ****/
            $sqldel="DELETE FROM capacitacion.capacitacion_obejtivosemp WHERE idcapacitacion= ".$id;
            $exec = $this->db->prepare($sqldel);                    
            $exec->execute();                    
               
            $stmt2  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_obejtivosemp(
                                        idcapacitacion, idobejtivosemp)
                                VALUES (:p1, :p2) ");

            if($_P['idobejtivosemp'][0]!= ''){
                foreach($_P['idobejtivosemp'] as $i => $idobejtivosemp)
                {   
                    //print_r($_P['idobejtivosemp']);
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p2',$idobejtivosemp,PDO::PARAM_INT);
                    $stmt2->execute();                

                }
            }
           
            /**** ASIGANACION de capacitación ****/
            $sqldasig="DELETE FROM capacitacion.capacitacion_asignacion WHERE idcapacitacion= ".$id;
            $stmt01 = $this->db->prepare($sqldasig);                    
            $stmt01->execute();  
                
            $stmt3  = $this->db->prepare("INSERT INTO capacitacion.capacitacion_asignacion(
                                        idcapacitacion, idpersonalasig, idtipoalcance)
                                VALUES (:p1, :p2, :p3) ");

            if($_P['idpersonalasignado']!= '')
            {
                foreach($_P['idpersonalasignado'] as $i => $idpersonalasig)
                {                
                    $stmt3->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt3->bindParam(':p2',$idpersonalasig,PDO::PARAM_INT);
                    $stmt3->bindParam(':p3',$_P['idtipoalcance'][$i],PDO::PARAM_INT);
                    $stmt3->execute();                

                }
            }
            
            
            /**** PRESUPUESTO ****/
            $sqlPre="DELETE FROM capacitacion.presupuesto
                   WHERE idcapacitacion= ".$id;
                $stmt01 = $this->db->prepare($sqlPre);                    
                $stmt01->execute();  
                
            $stmt4  = $this->db->prepare("INSERT INTO capacitacion.presupuesto(
                idcapacitacion, idcatpresupuesto, idconcepto, tiempo, idunidad_medida, 
                cantidad, preciounitario, subtotal)
                VALUES (:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8) ");

            if($_P['idcatpresupuestodet']!= '')
            {
                foreach($_P['idcatpresupuestodet'] as $i => $idcatpresupuestodet)
                {   
                    if($_P['tiempodet']== '' || $_P['tiempodet']== 0)
                    {
                        $_P['tiempodet']=0;
                    }

                    if($_P['idconceptodet']== '' || $_P['idconceptodet']== 0)
                    {
                        $_P['idconceptodet']=0;
                    }

                    if($_P['idunidad_medidadet']== '' || $_P['idunidad_medidadet']== 0)
                    {
                        $_P['idunidad_medidadet']=0;
                    }

                    $stmt4->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt4->bindParam(':p2',$idcatpresupuestodet,PDO::PARAM_INT);
                    $stmt4->bindParam(':p3',$_P['idconceptodet'][$i],PDO::PARAM_INT);
                    $stmt4->bindParam(':p4',$_P['tiempodet'][$i],PDO::PARAM_INT);
                    $stmt4->bindParam(':p5',$_P['idunidad_medidadet'][$i],PDO::PARAM_INT);
                    $stmt4->bindParam(':p6',$_P['cantidaddet'][$i],PDO::PARAM_INT);
                    $stmt4->bindParam(':p7',$_P['preciodet'][$i],PDO::PARAM_INT);
                    $stmt4->bindParam(':p8',$_P['subtotal'][$i],PDO::PARAM_INT);
                    $stmt4->execute();                

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
    
    function upload_files($_P,$_F)
    {
        $result = array();
        if (!empty($_F)) 
        {
            $tempFile  = $_F['Filedata']['tmp_name'];                          // 1
            $fileparts = pathinfo($_F['Filedata']['name']);
            $ext       = $fileparts['extension'];
         
            $targetPath = 'files_uploads/';
            $filetypes = array("pdf","doc","odt","docx","rtf","ppt","pptx","jpg","jpeg","png","gif","xls","xlsx");
            $flag = false;
            foreach($filetypes as $typ)
            {
                if($typ== strtolower($ext))
                {
                    $flag = true;
                }
            }    
            if($flag)
            {
                //Generamos el nuevo registro
                $name = "anexo_".date('d-m-Y-h-i-s').".".$ext;
                $stmt = $this->db->prepare("INSERT INTO capacitacion.anexos (idcapacitacion,descripcion) values (:p1,:p2)");
                $stmt->bindParam(':p1',$_P['idcapacitacion'],PDO::PARAM_INT);
                $stmt->bindParam(':p2',$name,PDO::PARAM_STR);
                $stmt->execute();

                $stmt = $this->db->prepare("SELECT max(idanexo) as idanexo from capacitacion.anexos");
                $stmt->execute();
                $r = $stmt->fetchObject();
                $idanexo = $r->idanexo;

                $targetFile =  str_replace('//','/',$targetPath).str_replace(' ','_',$name);
                
                if( move_uploaded_file($tempFile,$targetFile))
                {   
                    $result = '1###Ok';
                    chmod($targetFile, 0777);
                }
                else
                    {
                        $stmt = $this->db->prepare("DELETE from capacitacion.anexos WHERE idanexo = ".$idanexo);
                        $stmt->execute();                    
                        $result = '0###Error al intentar subir el archivo.';
                    }
            }
            else 
                {
                    $result = '0###Extension no apcetada, debe ser (doc, odt, docx, rtf, pdf, imagenes)';
                }    
        }        
        return $result;
    }

    function getAnexos($idc)
    {
        $stmt = $this->db->prepare("SELECT * from capacitacion.anexos WHERE idcapacitacion = :id ORDER BY idanexo");
        $stmt->bindParam(':id',$idc,PDO::PARAM_INT);
        $stmt->execute();
        $data = array();
        foreach ($stmt->fetchAll() as $row) 
        {
            $name = $row['descripcion'];
            $extencion = explode(".", $name);
            $data[] = array('idanexo'=>$row['idanexo'],
                            'nombre'=>$extencion[0],
                            'icono'=>$this->icon_file($extencion[1]),
                            'ext'=>$extencion[1]);
        }
        return $data;
    }

    function icon_file($extencion)
    {
        $icon = "";
        switch ($extencion) {
            case 'doc':
            case 'docx':
            case 'odt':
            case 'rtf':
                $icon = "word.png";
                break;
            case 'ppt':
            case 'pptx':
                $icon = "point.png";
            case 'xls':
            case 'xlsx':
                $icon = "excel.png";
                break;
            case 'pdf':
                $icon = "pdf.png";
                break;
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
                $icon = "imagen.png";
                break;
            default:
                $icon = "undefined.png";
                break;
        }
        return $icon;
    }

    function delete_anexo($ida)
    {
        $stmt = $this->db->prepare("DELETE from capacitacion.anexos WHERE idanexo = ".$ida);
        $stmt->execute();                    
    }

}
?>