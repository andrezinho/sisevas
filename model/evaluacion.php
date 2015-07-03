<?php
include_once("Main.php");
class evaluacion extends Main
{
    function getAspectos($g)
    {
        //Obtengo el perfil al cual pertenece el personal a ser evaluado
        $sql = "SELECT idperfil from personal where idpersonal = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $idperfil = $r->idperfil;
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $sql=" SELECT * FROM evaluacion.aspectos 
               WHERE idcompetencia = :c 
                    and estado = 1; ";
        $stmt = $this->db->prepare($sql);        
        $stmt->bindParam(':c', $g['idc'] , PDO::PARAM_STR);
        $stmt->execute();
        $data = array();
        $c = 0;


        foreach($stmt->fetchAll() as $row)
        {

            $data[$c] = array('idaspecto'=>$row['idaspecto'],'descripcion'=>$row['descripcion'],'parametros'=>array());
            $s = "SELECT  distinct v.idvalor,
                            p.descripcion,
                            v.orden,
                            v.idaspecto,
                            r.idvalor as idvalorr
                    from evaluacion.resultados as r right outer join 
                    evaluacion.valores as v on v.idvalor = r.idvalor and r.estado = 1 and r.idpersonal = ".$g['idp']."
                    inner join evaluacion.parametros as p on p.idparametro = v.idparametro
                    where v.idaspecto = ".$row['idaspecto']." and v.idperfil = ".$idperfil." and v.idperiodo = ".$idperiodo." 
                    order by v.orden, v.idaspecto";
            
            $stmt2 = $this->db->prepare($s);
            $stmt2->execute();
            
            foreach ($stmt2->fetchAll() as $ro)
            {
                $data[$c]['parametros'][] = array('idvalor'=>$ro['idvalor'],
                                                    'parametro'=>$ro['descripcion'],
                                                    'orden'=>$ro['orden'],
                                                    'idaspecto'=>$ro['idaspecto'],
                                                    'idvalorr'=>$ro['idvalorr']
                                                  );
            }
            $c += 1;
        }
        return $data;
    }
    
    function getEvaluaciones()
    {
        
    }
    function getCompetencias($idp)
    {
        $sql = "SELECT  t1.idcompetencia,
                    t1.descripcion,
                    coalesce(t2.n,0)*100/t1.nro_aspectos as percent 
                from (
                    select c.idcompetencia, c.descripcion, count(a.idaspecto) as nro_aspectos
                    from evaluacion.competencias as c inner join evaluacion.aspectos as a 
                    on a.idcompetencia = c.idcompetencia 
                    group by c.idcompetencia, c.descripcion
                      ) as t1 left outer join 
                      (
                    select count(v.idaspecto) as n, a.idcompetencia
                    from evaluacion.resultados as r inner join evaluacion.valores as v  
                    on v.idvalor = r.idvalor
                    inner join evaluacion.aspectos as a on a.idaspecto = v.idaspecto
                    where r.idpersonal = ".$idp." and r.estado = 1 and v.idperiodo = ".$_SESSION['idperiodo']."
                    group by a.idcompetencia
                      ) as t2 on t1.idcompetencia = t2.idcompetencia
                    order by t1.idcompetencia";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach ($stmt->fetchAll() as $row) { $data[] = array('idc'=>$row[0],'des'=>$row[1],'percent'=>$row[2]); }
        return $data;
    }
    
    function save($valores,$idp)
    {
        $fecha_reg = date('Y-m-d');        
        $hora_reg  = date('H:i:s');
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $idusuario = $_SESSION['idusuario'];
        $estado = 1;
        if($_SESSION['estado']==1)
        {
            try
            {
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db->beginTransaction();
                foreach ($valores as $v) 
                {
                    $data = $this->db->prepare('SELECT idperfil,valor,idaspecto
                                                from evaluacion.valores where idvalor = :id and estado = 1 and idperiodo = '.$idperiodo);
                    $data->bindParam(':id',$v,PDO::PARAM_INT);
                    $data->execute();
                    $n = $data->rowCount();
                    $row = $data->fetchObject();

                    if($n>0)
                    {

                        $s = $this->db->prepare('SELECT idresultado from evaluacion.resultados as r inner join 
                                                evaluacion.valores as v on v.idvalor = r.idvalor and r.idpersonal = '.$idp.'
                                                where v.idaspecto='.$row->idaspecto);                    
                        $s->execute();
                        $n = $s->rowCount();                    
                        if($n>0)
                        {
                            foreach ($s->fetchAll() as $re) 
                            {
                                $sql = "UPDATE evaluacion.resultados set estado = 0 where idresultado = ".$re['idresultado']." and idpersonal = ".$idp." and idperiodo = ".$idperiodo;
                                $stmt = $this->db->prepare($sql);
                                $stmt->execute();
                            }
                        }
                        
                        $sql = "INSERT INTO evaluacion.resultados(
                                    idperiodo, idpersonal, idperfil, idevaluador, 
                                    idvalor, fecha_reg, hora_reg, estado,valor) values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9)";
                        $stmt = $this->db->prepare($sql);
                        $stmt->bindParam(':p1',$idperiodo,PDO::PARAM_INT);
                        $stmt->bindParam(':p2',$idp,PDO::PARAM_INT);
                        $stmt->bindParam(':p3',$row->idperfil,PDO::PARAM_INT);
                        $stmt->bindParam(':p4',$idusuario,PDO::PARAM_INT);
                        $stmt->bindParam(':p5',$v,PDO::PARAM_INT);
                        $stmt->bindParam(':p6',$fecha_reg,PDO::PARAM_STR);
                        $stmt->bindParam(':p7',$hora_reg,PDO::PARAM_STR);
                        $stmt->bindParam(':p8',$estado,PDO::PARAM_INT);
                        $stmt->bindParam(':p9',$row->valor,PDO::PARAM_INT);
                        $stmt->execute();
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
        else
        {
            return array('2','Ya no se puede guardar la evaluacion debido a que el periodo ya está cerrado');
        }
    }

    function reporte_detallado($g)
    {
        //$periodo = (!isset($_SESSION['periodo'])) ? 'PERIODO 2014-I' : $_SESSION['periodo'];
        $idpersonal= $g['idp'];
        if(isset($g['idperiodo'])&&$g['idperiodo']!="")
            $idperiodo = $g['idperiodo'];
        else 
            $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];

        $s = "SELECT idperiodo, descripcion from evaluacion.periodo where idperiodo = ".$idperiodo;
        $stmt = $this->db->prepare($s);
        $stmt->execute();
        $rec = $stmt->fetchObject();
        $idperiodo = $rec->idperiodo;
        $periodo = $rec->descripcion;
        
        $eva="SELECT DISTINCT r.idperiodo,
            ev.nombres||' '||ev.apellidos AS evaluador
            FROM
            evaluacion.resultados AS r
            INNER JOIN public.personal AS p ON p.idpersonal = r.idpersonal
            INNER JOIN public.personal AS ev ON ev.idpersonal = r.idevaluador
            WHERE
            r.idperiodo=".$idperiodo." AND r.idpersonal= ".$idpersonal;
        $stmt1 = $this->db->prepare($eva);
        $stmt1->execute();
        $eva = $stmt1->fetchObject();
        
        $evaluador= $eva->evaluador;
        
        $sql = "SELECT
            p.idperfil,
            p.nombres,
            p.apellidos,
            pe.descripcion AS perfil,
            c.descripcion AS cargo,
            a.descripcion AS unidadop,
            
            substr(cast(p.asumircargo as text),9,2)||'/'||substr(cast(p.asumircargo as text),6,2)||'/'||substr(cast(p.asumircargo as text),1,4) AS asumircargo
            FROM
            public.personal AS p
            INNER JOIN seguridad.perfil AS pe ON pe.idperfil = p.idperfil
            INNER JOIN public.cargo AS c ON c.idcargo = p.idcargo
            INNER JOIN public.consultorio AS a ON a.idconsultorio = p.idarea
            WHERE p.idpersonal = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $idperfil = $r->idperfil;
        $personal = $r->nombres.' '.$r->apellidos;
        $perfil = $r->perfil;
        $cargo = $r->cargo;
        $unidadop = $r->unidadop;
        $asumircargo = $r->asumircargo;
        
        $datos = array($personal, $perfil, $periodo, $cargo, $unidadop, $asumircargo, $evaluador);

        $sql = "SELECT idcompetencia,descripcion 
                FROM evaluacion.competencias order by idcompetencia";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        $c = 0;
        foreach ($stmt->fetchAll() as $row) 
        {
            $data[$c] = array(
                            'idc'=>$row[0],
                            'des'=>$row[1],
                            'res'=>array()
                           );

            $s = "SELECT  t1.idaspecto,
                          t1.aspecto,
                          coalesce(t2.valor,0) as valor,
                          t1.valor_max,
                          coalesce(t3.valor,0) as promedio
                    FROM (
                        SELECT  a.idaspecto as idaspecto,
                            a.descripcion as aspecto,
                            coalesce(max(v.valor),0) as valor_max
                        FROM evaluacion.valores as v RIGHT OUTER JOIN evaluacion.aspectos as a on
                        a.idaspecto = v.idaspecto and v.idperiodo = :idper and v.idperfil = :idcon
                        WHERE a.idcompetencia = :idcom
                        GROUP BY a.idaspecto,a.descripcion ) as t1

                    LEFT OUTER JOIN

                    (SELECT  a.idaspecto as idaspecto,
                        a.descripcion as aspecto,   
                        r.valor as valor
                    FROM    evaluacion.resultados as r INNER JOIN 
                        evaluacion.valores as v on v.idvalor = r.idvalor and r.estado = 1
                        INNER JOIN evaluacion.aspectos as a on a.idaspecto = v.idaspecto    
                    WHERE v.idperfil = :idcon AND a.idcompetencia = :idcom and v.idperiodo = :idper and r.idpersonal = :idpers) as t2 
                    on t1.idaspecto = t2.idaspecto

                    LEFT OUTER JOIN 

                    (SELECT  a.idaspecto as idaspecto,
                        a.descripcion as aspecto,   
                        avg(r.valor) as valor
                    FROM    evaluacion.resultados as r INNER JOIN 
                        evaluacion.valores as v on v.idvalor = r.idvalor and r.estado = 1
                        INNER JOIN evaluacion.aspectos as a on a.idaspecto = v.idaspecto    
                    WHERE v.idperfil = :idcon AND a.idcompetencia = :idcom and v.idperiodo = :idper
                    group by a.idaspecto,a.descripcion) as t3
                    on t1.idaspecto = t3.idaspecto

                    ORDER BY t1.idaspecto";
            $Q = $this->db->prepare($s);
            $Q->bindParam(':idcon',$idperfil,PDO::PARAM_INT);
            $Q->bindParam(':idcom',$row[0],PDO::PARAM_INT);
            $Q->bindParam(':idper',$idperiodo,PDO::PARAM_INT);
            $Q->bindParam(':idpers',$g['idp'],PDO::PARAM_INT);
            $Q->execute();
            foreach ($Q->fetchAll() as $r) 
            {
                $data[$c]['res'][] = array('idaspecto'=>$r[0],
                                            'aspecto'=>$r[1],
                                            'valor'=>$r[2],
                                            'valor_max'=>$r[3],
                                            'promedio'=>$r[4]);
            }
            $c += 1;
        }
        return array($data,$datos);
    }
    
    function deleteevaluacion($_P) {
        
        $idevaluado= $_P['idtabs'];
        $idperiodo= $_P['idper'];        
        
        $sql="DELETE FROM evaluacion.resultados WHERE idpersonal = ".$idevaluado." AND idperiodo= ".$idperiodo;
        $stmt = $this->db->prepare($sql);
        //$stmt->bindParam(':p1', $idevaluado , PDO::PARAM_INT);
        //$stmt->bindParam(':p2', $idperiodo , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
}
?>