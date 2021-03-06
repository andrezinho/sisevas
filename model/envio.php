<?php
include_once("Main.php");
include_once("tipodocumento.php");

class Envio extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {        
        $sql = "SELECT
            t.idtramite,
            td.descripcion,
            t.codigo,
            substr(cast(t.fechainicio as text),9,2)||'/'||substr(cast(t.fechainicio as text),6,2)||'/'||substr(cast(t.fechainicio as text),1,4),
            UPPER(p.nombres||' '||p.apellidos) AS perdestinatario,
            '<a class=\"printer box-boton boton-print\" id=\"f-'||t.idtramite||'-'||t.idtipo_documento||'\" href=\" #\" title=\"Imprimir Documento\" ></a>'
            
            FROM
            evaluacion.tramite AS t
            LEFT JOIN public.tipo_documento AS td ON td.idtipo_documento = t.idtipo_documento
            --LEFT JOIN evaluacion.derivaciones AS d ON t.idtramite = d.idtramite
            LEFT JOIN public.personal AS p ON p.idpersonal = t.idpersonalresp 
            WHERE t.anio='2015' ";

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $ver="SELECT
            t.idtramite,
            t.idtipo_documento
            FROM
            evaluacion.tramite AS t 
            WHERE t.idtramite= :p1 ";
        $stmt1 = $this->db->prepare($ver);
        $stmt1->bindParam(':p1', $id, PDO::PARAM_INT);
        $stmt1->execute();
        $row= $stmt1->fetchObject();
        $idtpdoc= $row->idtipo_documento;        

        if ($idtpdoc== 2 || $idtpdoc== 3) {
            $stmt = $this->db->prepare("SELECT
                t.idtramite, t.fechainicio,
                t.horainicio, t.asunto,
                t.problema, t.docref,
                t.idperdestinatario,
                t.idtipo_problema,
                t.idtipo_documento,
                t.codigo, t.idareai,
                t.idpersonalresp,
                t.resultados,
                p.idpaciente,
                p.nrodocumento,
                p.nombres,
                p.appat, p.apmat,
                p.direccion, p.telefono,
                p.celular
                
                FROM
                evaluacion.tramite AS t
                INNER JOIN tipo_documento AS td ON td.idtipo_documento = t.idtipo_documento
                LEFT JOIN paciente AS p ON p.idpaciente = t.idpaciente

                WHERE t.idtramite = :id ");
            $stmt->bindParam(':id', $id , PDO::PARAM_INT);
            $stmt->execute();
        }
            else {

            $stmt = $this->db->prepare("SELECT
                t.idtramite,
                t.fechainicio,
                t.idpersonalresp,
                substr(cast(t.horainicio as text),1,5) AS horainicio,
                t.asunto,
                t.problema,
                t.docref,
                t.idperdestinatario,
                t.idtipo_documento,
                t.codigo, t.lugarreu,
                substr(cast(t.horafin as text),1,5) AS horafin
                FROM
                evaluacion.tramite AS t
                INNER JOIN tipo_documento AS td ON td.idtipo_documento = t.idtipo_documento
                WHERE
                t.idtramite = :id ");
            $stmt->bindParam(':id', $id , PDO::PARAM_INT);
            $stmt->execute();
        }
        
        return $stmt->fetchObject();
    }
    
    function getDetails($id, $idtpdoc)
    {
        //echo $idtpdoc;
        $stmt = $this->db->prepare("SELECT
            d.idtramite,
            d.idpersonal,
            p.nombres||' '||p.apellidos AS destinatario

            FROM
            evaluacion.derivaciones AS d
            INNER JOIN evaluacion.tramite AS t ON t.idtramite = d.idtramite
            INNER JOIN public.personal AS p ON p.idpersonal = d.idpersonal

            WHERE d.idtramite = :id ORDER BY p.nombres ASC");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) 
    {
        //print_r($_P) ;
        $obj_td = new Tipodocumento();
        
        $estado='T';
        $idtipodocumento= $_P['idtipo_documento'];
        $idpaciente= $_P['idremitente'];
        $idpersonalreg= $_SESSION['idusuario'];
        $horafin= date('H:i:s');
        $fechafin= date('Y-m-d');   
        $anio= date('Y');
        $derivado='N';

        $obj_td->UpdateCorrelativo($idtipodocumento);
        
        /* MEMORANDUN */
        $sql = "INSERT INTO evaluacion.tramite( idtipo_documento, problema, fechainicio, horainicio, 
            idpersonalresp, asunto, estado, docref, codigo,derivado, anio)
            VALUES(:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11) ";

        $st = $this->db->prepare($sql);

                   
        /* INGRESAR PACIENTE NUEVO */
        $sqlcli="INSERT INTO paciente(nrodocumento,nombres,appat,apmat,direccion,telefono,celular)
            VALUES ( :p11, :p21,:p31, :p41, :p51, :p61, :p71) ";

        $stmt3  = $this->db->prepare($sqlcli);

        /* SNC y IR */
        $sqlf1 = "INSERT INTO evaluacion.tramite(idpaciente, idtipo_documento, problema, 
            fechainicio, horainicio, usuarioreg, estado, codigo, 
            idtipo_problema, idareai, idpersonalresp,derivado, anio)
            VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13) ";
        
        $stmt1 = $this->db->prepare($sqlf1);
                
        /* ACTA DE REU. DE GESTION */
        $sql2 = "INSERT INTO evaluacion.tramite( idtipo_documento, fechainicio, horainicio, 
            horafin, idpersonalresp, asunto, problema, lugarreu, estado, codigo, derivado, anio)
            VALUES(:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12) ";
        $stmt2 = $this->db->prepare($sql2);
        
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            if ($_P['idtipo_documento']== 2 || $_P['idtipo_documento']== 3) {

                if ($idpaciente=='') {
                                                    
                        $stmt3->bindParam(':p11', $_P['dni'] , PDO::PARAM_STR);
                        $stmt3->bindParam(':p21', $_P['nombres'], PDO::PARAM_STR);
                        $stmt3->bindParam(':p31', $_P['apellidopat'] , PDO::PARAM_STR);
                        $stmt3->bindParam(':p41', $_P['apellidomat'] , PDO::PARAM_STR);
                        $stmt3->bindParam(':p51', $_P['direccion'] , PDO::PARAM_STR);
                        $stmt3->bindParam(':p61', $_P['telefono'], PDO::PARAM_STR);
                        $stmt3->bindParam(':p71', $_P['celular'] , PDO::PARAM_STR);

                        $stmt3->execute();
                        $idpaciente =  $this->IdlastInsert('paciente','idpaciente');
                    }  

                    $tprob= $_P['idtipo_problema'];
                    if($tprob == 1)
                    {
                        $idcon= $_P['idareai'];
                        $idperinvestigad= 0;
                    }else
                        {
                            $idperinvestigad =$_P['idareai'];
                            $idcon= 0;
                        }
                    
                    $stmt1->bindParam(':p1', $idpaciente , PDO::PARAM_INT);
                    $stmt1->bindParam(':p2', $_P['idtipo_documento'] , PDO::PARAM_INT);
                    $stmt1->bindParam(':p3', $_P['problema'] , PDO::PARAM_STR);
                    //$stmt1->bindParam(':p4', $_P['resultados'] , PDO::PARAM_STR);
                    $stmt1->bindParam(':p4', $_P['fechainicio'] , PDO::PARAM_STR);
                    $stmt1->bindParam(':p5', $_P['horainicio'] , PDO::PARAM_STR);
                                            
                    //$stmt1->bindParam(':p7', $fechafin , PDO::PARAM_STR);
                    //$stmt1->bindParam(':p8', $horafin , PDO::PARAM_STR);
                    $stmt1->bindParam(':p6', $idpersonalreg , PDO::PARAM_INT);
                    $stmt1->bindParam(':p7', $estado , PDO::PARAM_STR);
                    //$stmt1->bindParam(':p11', $_P['idcierre'] , PDO::PARAM_INT);
                    $stmt1->bindParam(':p8', $_P['correlativo'] , PDO::PARAM_STR);

                    $stmt1->bindParam(':p9', $_P['idtipo_problema'] , PDO::PARAM_INT);
                    $stmt1->bindParam(':p10', $idcon , PDO::PARAM_INT);
                    $stmt1->bindParam(':p11', $idperinvestigad , PDO::PARAM_INT);
                    $stmt1->bindParam(':p12', $derivado , PDO::PARAM_STR);
                    $stmt1->bindParam(':p13', $anio , PDO::PARAM_INT);
                    $stmt1->execute();
                    //print_r($stmt1);
                    
                    $id =  $this->IdlastInsert('evaluacion.tramite','idtramite');
                    $row = $stmt1->fetchAll();
                    
                    $st2= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                    horader, capacitacion) VALUES($id ,$idperinvestigad,'$fechafin','$horafin','$derivado')" );
                    $st2->execute();
                    
                    //Hacer llegar a la oficina de Calidad
                    $st3= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                    horader, capacitacion) VALUES($id , 9,'$fechafin','$horafin','$derivado')" );                    
                    $st3->execute();
                                
            }
            
            if ($_P['idtipo_documento']== 1 || $_P['idtipo_documento']== 4 || $_P['idtipo_documento']== 5)
            {

                $st->bindParam(':p1', $_P['idtipo_documento'] , PDO::PARAM_STR);
                $st->bindParam(':p2', $_P['problema'] , PDO::PARAM_STR);
                $st->bindParam(':p3', $_P['fechainicio'] , PDO::PARAM_STR);
                $st->bindParam(':p4', $_P['horainicio'] , PDO::PARAM_STR);                    
                $st->bindParam(':p5', $_P['idperremitente'] , PDO::PARAM_STR);
                $st->bindParam(':p6', $_P['asunto'] , PDO::PARAM_STR);
                $st->bindParam(':p7', $estado , PDO::PARAM_STR);
                $st->bindParam(':p8', $_P['docref'] , PDO::PARAM_STR);
                $st->bindParam(':p9', $_P['correlativo'] , PDO::PARAM_STR);
                $st->bindParam(':p10', $derivado , PDO::PARAM_STR);
                $st->bindParam(':p11', $anio , PDO::PARAM_INT);
                $st->execute();

                $id =  $this->IdlastInsert('evaluacion.tramite','idtramite');
                $row = $st->fetchAll();

                 /* DETALLE DE TRAMITE */                    
                foreach($_P['idpersonaldet'] as $i => $iddet)
                {
                    $st2= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                    horader, capacitacion) VALUES($id ,$iddet,'$fechafin','$horafin','$derivado')" );
                    //print_r($st2);
                    $st2->execute();                                 
                    //print_r($stmt2);
                }

            }
            
            if ($_P['idtipo_documento']== 10 || $_P['idtipo_documento']== 11 || $_P['idtipo_documento']== 12) {
                
                $stmt2->bindParam(':p1', $_P['idtipo_documento'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p2', $_P['fechainicio'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p3', $_P['horainicio'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p4', $_P['horafin'] , PDO::PARAM_STR);                    
                $stmt2->bindParam(':p5', $idpersonalreg , PDO::PARAM_STR);
                $stmt2->bindParam(':p6', $_P['asunto'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p7', $_P['problema'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p8', $_P['lugarreu'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p9', $estado , PDO::PARAM_STR);
                $stmt2->bindParam(':p10', $_P['correlativo'] , PDO::PARAM_STR);
                $stmt2->bindParam(':p11', $derivado , PDO::PARAM_INT);
                $stmt2->bindParam(':p12', $anio , PDO::PARAM_INT);
                $stmt2->execute();

                $id =  $this->IdlastInsert('evaluacion.tramite','idtramite');
                $row = $st->fetchAll();

                 /* DETALLE DE TRAMITE */                    
                foreach($_P['idpersonaldet'] as $i => $iddet)
                {
                    $st2= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                    horader, capacitacion) VALUES($id ,$iddet,'$fechafin','$horafin','$derivado')" );
                    //print_r($st2);
                    $st2->execute();                                 
                    //print_r($stmt2);
                }

            }   
            
            $this->db->commit();            
            return array('1','Bien!',$idpaciente);
        }

        catch(PDOException $e) 
            {
                $this->db->rollBack();
                return array('2',$e->getMessage().$str,'');
            } 
        
    }

    function update($_P ) 
    {
        $idtpdoc= $_P['idtipo_documento'];        
                
        $sqlm = "UPDATE evaluacion.tramite
            SET 
            idpersonalresp= :p1, 
            asunto= :p2, 
            problema= :p3, 
            docref= :p4

            WHERE idtramite= :idtramite";

        $stmt = $this->db->prepare($sqlm);
                        
        $sqlo = "UPDATE evaluacion.tramite
            SET 
            idpaciente= :p1, 
            problema= :p2, 
            idtipo_problema= :p3,
            idareai= :p4,
            idperdestinatario= :p5            
        WHERE idtramite= :idtramite";        
        
        $stmt1 = $this->db->prepare($sqlo);        
        
        $sql10 = "UPDATE evaluacion.tramite SET 
            horainicio= :p1, 
            horafin= :p2, 
            asunto= :p3,
            problema= :p4,
            lugarreu= :p5
        WHERE idtramite= :idtramite";        
        
        $stmt10 = $this->db->prepare($sql10);
        

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            if ($idtpdoc== 2 || $idtpdoc== 3){
                
                $tprob= $_P['idtipo_problema'];
                    if($tprob == 1)
                    {
                        $idcon= $_P['idareai'];
                        $idperinvestigad= 0;

                    }else
                        {
                            $idperinvestigad =$_P['idareai'];
                            $idcon= 0;
                        }
                
                $id= $_P['idtramite'];
                $derivado= 'N';
                $fecha= $_P['fechainicio'];
                $hora= $_P['horainicio'];
                    
                $stmt1->bindParam(':p1', $_P['idpaciente'] , PDO::PARAM_INT);        
                $stmt1->bindParam(':p2', $_P['problema'] , PDO::PARAM_STR);
                $stmt1->bindParam(':p3', $tprob , PDO::PARAM_INT);     
                $stmt1->bindParam(':p4', $idcon , PDO::PARAM_INT);
                $stmt1->bindParam(':p5', $idperinvestigad , PDO::PARAM_INT);
                
                $stmt1->bindParam(':idtramite', $_P['idtramite'] , PDO::PARAM_INT);
                $stmt1->execute();

                $sqld="DELETE FROM evaluacion.derivaciones
                        WHERE idtramite= ".$id;
                $stmt0 = $this->db->prepare($sqld);                    
                $stmt0->execute();                    
               
                $st2= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                            horader, capacitacion) VALUES($id ,$idperinvestigad,'$fecha','$hora','$derivado')" );
                            //print_r($st2);
                            $st2->execute();

            }
            
            if ($idtpdoc== 1 || $idtpdoc== 4 || $idtpdoc== 5){
                    
                $id= $_P['idtramite'];
                $derivado= 'N';
                $fecha= $_P['fechainicio'];
                $hora= $_P['horainicio'];

                $stmt->bindParam(':p1', $_P['idperremitente'] , PDO::PARAM_INT);        
                $stmt->bindParam(':p2', $_P['asunto'] , PDO::PARAM_STR);
                $stmt->bindParam(':p3', $_P['problema'] , PDO::PARAM_STR);     
                $stmt->bindParam(':p4', $_P['docref'] , PDO::PARAM_STR);
                //$stmt->bindParam(':p5', $_P['idpersonal'] , PDO::PARAM_INT);                    
                $stmt->bindParam(':idtramite', $_P['idtramite'] , PDO::PARAM_INT);
                $stmt->execute();

                $sqld="DELETE FROM evaluacion.derivaciones
                    WHERE idtramite= ".$id;

                $stmt0 = $this->db->prepare($sqld);                    
                $stmt0->execute();

                //print_r($_P['idpersonaldet']);
                foreach($_P['idpersonaldet'] as $i => $iddet)
                {
                    //echo $iddet;
                    $st2= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                        horader, capacitacion) VALUES($id ,$iddet,'$fecha','$hora','$derivado')" );
                        //print_r($st2);
                        $st2->execute();
                }
                
            }                            
            
            if ($idtpdoc== 10 || $idtpdoc== 11 || $idtpdoc== 12){
                    
                $id= $_P['idtramite'];
                $derivado= 'N';
                $fecha= $_P['fechainicio'];
                $horai= $_P['horainicio'];
                $horaf= $_P['horafin'];

                $stmt10->bindParam(':p1', $horai , PDO::PARAM_STR);        
                $stmt10->bindParam(':p2', $horaf , PDO::PARAM_STR);
                $stmt10->bindParam(':p3', $_P['asunto'] , PDO::PARAM_STR);     
                $stmt10->bindParam(':p4', $_P['problema'] , PDO::PARAM_STR);
                $stmt10->bindParam(':p5', $_P['lugarreu'] , PDO::PARAM_STR);
                
                $stmt10->bindParam(':idtramite', $id , PDO::PARAM_INT);
                $stmt10->execute();

                $sqld="DELETE FROM evaluacion.derivaciones WHERE idtramite= ".$id;
                $stmt0 = $this->db->prepare($sqld);                    
                $stmt0->execute();

                //print_r($_P['idpersonaldet']);
                foreach($_P['idpersonaldet'] as $i => $iddet)
                {
                    //echo $iddet;
                    $st2= $this->db->prepare(" INSERT INTO evaluacion.derivaciones( idtramite, idpersonal, fechader, 
                        horader, capacitacion) VALUES($id ,$iddet,'$fecha','$horai','$derivado')" );
                        //print_r($st2);
                    $st2->execute();
                }
            }
            
            $this->db->commit();            
            return array('1','Bien!',$idtpdoc);

        }
        
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('2',$e->getMessage().$str,'');
        } 
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM evaluacion.tramite WHERE idtramite = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function nuevos()
    {
        $stmt = $this->db->prepare("SELECT
                count(t.idtramite)
                FROM
                evaluacion.tramite AS t
                WHERE
                t.idperdestinatario =:p AND t.estado = 'T' ");
        $stmt->bindParam(':p',$_SESSION['idusuario'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchAll();
        return array($r[0][0],'');
    }
    
    function getPrice($id)
    {
        $stmt = $this->db->prepare("SELECT precio_u FROM produccion.producto WHERE idproducto = :p1");
        $stmt->bindParam(':p1', $id, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        return $r->precio_u;
    }

    function getStock($id,$a)
    {
        $sql = "SELECT t.idm,t.c,t.item
                FROM (
                SELECT max(idmovimiento) as idm ,ctotal_current as c, item
                FROM movimientosdetalle
                WHERE idtipoproducto = 2 AND idproducto = :idp AND idalmacen = :ida 
                group by ctotal_current,item,idmovimiento
                ORDER BY idmovimiento desc
                limit 1) as t
                ORDER BY t.item desc ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idp',$id,PDO::PARAM_INT);
        $stmt->bindParam(':ida',$a,PDO::PARAM_INT); 
        $stmt->execute();
        $row = $stmt->fetchObject();
        if($row->c>0)
            return $row->c;
        else return '0.000';
    }

    function reporte_detallado($g)
    {
        $anio= date('Y');
        $idtp= $g['idtp'];

        $periodo = (!isset($_SESSION['periodo'])) ? 'PERIODO 2014-I' : $_SESSION['periodo'];
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $sql = "SELECT p.idarea,p.nombres,p.apellidos,c.descripcion as consultorio 
                FROM personal as p inner join consultorio as c on 
                    c.idconsultorio = p.idarea
                WHERE p.idpersonal = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();

        $idconsultorio = $r->idarea;
        $personal = $r->nombres.' '.$r->apellidos;
        $consultorio = $r->consultorio;

        $datos = array($personal, $consultorio, $periodo);

        $sql = "SELECT asunto, problema, codigo,
            fechainicio, estado
                FROM evaluacion.tramite
                WHERE idtipo_documento = :idtp AND anio= $anio 
                    AND idtramite in ( SELECT idtramite 
                    FROM evaluacion.derivaciones WHERE idpersonal = :id )
                ORDER BY idtramite ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':idtp',$g['idtp'],PDO::PARAM_INT);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);

        $stmt->execute();
        $data = array();
        
        foreach ($stmt->fetchAll() as $row) 
        {
            $data[] = array('asunto'=>$row[0],
                            'problema'=>$row[1],
                            'codigo'=>$row[2],
                            'fechainicio'=>$this->fdate($row[3],'ES'),
                            'estado'=>$row[4]);            
        }
       
        return array($data,$datos);
    }
    
    function get($query,$field)
    {
    
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT 
            idtramite, idtipo_documento, 
            codigo, asunto
            FROM evaluacion.tramite
            WHERE {$field} ilike :query limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);        
        $statement->execute();
        return $statement->fetchAll();
    }
    
    
}
?>