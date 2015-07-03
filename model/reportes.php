<?php
include_once("Main.php");
class reportes extends Main
{    
    function data_rep02($g)
    {
        if(isset($g['idperiodo'])&&$g['idperiodo']!="")
            $idperiodo = $g['idperiodo'];
        else 
            $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];

        $anio = $g['anio'];

        $s = "SELECT descripcion FROM evaluacion.periodo WHERE idperiodo = ".$idperiodo;
        $stmt = $this->db->prepare($s);
        $stmt->execute();
        $rec = $stmt->fetchObject();

        $periodo = $rec->descripcion;

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
        
        $datos = array($personal, $perfil, $anio, $cargo, $unidadop, $asumircargo);

        $sql = "SELECT idcompetencia,descripcion FROM evaluacion.competencias ORDER BY idcompetencia";
                
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
                        FROM evaluacion.valores as v inner join evaluacion.periodo as p on p.idperiodo = v.idperiodo
                        	 RIGHT OUTER JOIN evaluacion.aspectos as a on
                        a.idaspecto = v.idaspecto and p.anio = :anio and v.idperfil = :idcon
                        WHERE a.idcompetencia = :idcom
                        GROUP BY a.idaspecto,a.descripcion ) as t1

                    LEFT OUTER JOIN

                    (SELECT  a.idaspecto as idaspecto,
                        a.descripcion as aspecto,   
                        avg(r.valor) as valor
                    FROM evaluacion.resultados as r inner join evaluacion.periodo as p on p.idperiodo = r.idperiodo 
                    	INNER JOIN evaluacion.valores as v on v.idvalor = r.idvalor and r.estado = 1
                        INNER JOIN evaluacion.aspectos as a on a.idaspecto = v.idaspecto    
                    WHERE v.idperfil = :idcon AND a.idcompetencia = :idcom and p.anio = :anio and r.idpersonal = :idpers
                    group by a.idaspecto,a.descripcion
                        ) 
                    as t2 on t1.idaspecto = t2.idaspecto

                    LEFT OUTER JOIN 

                    (
                        SELECT  a.idaspecto as idaspecto,
                        a.descripcion as aspecto,   
                        avg(r.valor) as valor
                        FROM evaluacion.resultados as r inner join evaluacion.periodo as p on p.idperiodo = r.idperiodo 
                            INNER JOIN evaluacion.valores as v on v.idvalor = r.idvalor and r.estado = 1
                            INNER JOIN evaluacion.aspectos as a on a.idaspecto = v.idaspecto    
                        WHERE v.idperfil = :idcon AND a.idcompetencia = :idcom and p.anio = :anio
                        group by a.idaspecto,a.descripcion
                    )
                    as t3 on t1.idaspecto = t3.idaspecto
                    ORDER BY t1.idaspecto";
            $Q = $this->db->prepare($s);
            $Q->bindParam(':idcon',$idperfil,PDO::PARAM_INT);
            $Q->bindParam(':idcom',$row[0],PDO::PARAM_INT);
            $Q->bindParam(':anio',$anio,PDO::PARAM_INT);
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

    function data_rep03($g)
    {
        if(isset($g['idperiodo'])&&$g['idperiodo']!="")
            $idperiodo = $g['idperiodo'];
        else 
            $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];

        $anio = $g['anio'];

        //Obtenemos todos los periodos de ese año
        $sql = "SELECT idperiodo from evaluacion.periodo where anio = ".$anio;
        $q = $this->db->prepare($sql);
        $q->execute();

        $s = "SELECT descripcion from evaluacion.periodo where idperiodo = ".$idperiodo;
        $stmt = $this->db->prepare($s);
        $stmt->execute();
        $rec = $stmt->fetchObject();

        $periodo = $rec->descripcion;

        $sql = "SELECT p.idperfil,p.nombres,p.apellidos,c.descripcion as perfil 
                FROM personal as p inner join seguridad.perfil as c on 
                    c.idperfil = p.idperfil
                WHERE p.idpersonal = :id ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $idperfil = $r->idperfil;
        $personal = $r->nombres.' '.$r->apellidos;
        $perfil = $r->perfil;

        $datos = array($personal, $perfil, $anio);
        $sql = "SELECT idcompetencia,descripcion 
                from evaluacion.competencias order by idcompetencia";        
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
                          t1.valor_max
                    FROM (
                        SELECT  a.idaspecto as idaspecto,
                            a.descripcion as aspecto,
                            coalesce(max(v.valor),0) as valor_max
                        FROM evaluacion.valores as v inner join evaluacion.periodo as p on p.idperiodo = v.idperiodo
                             RIGHT OUTER JOIN evaluacion.aspectos as a on
                        a.idaspecto = v.idaspecto and p.anio = :anio and v.idperfil = :idcon
                        WHERE a.idcompetencia = :idcom
                        GROUP BY a.idaspecto,a.descripcion ) as t1

                    LEFT OUTER JOIN

                    (SELECT  a.idaspecto as idaspecto,
                        a.descripcion as aspecto,   
                        r.valor as valor
                    FROM evaluacion.resultados as r inner join evaluacion.periodo as p on p.idperiodo = r.idperiodo 
                        INNER JOIN evaluacion.valores as v on v.idvalor = r.idvalor and r.estado = 1
                        INNER JOIN evaluacion.aspectos as a on a.idaspecto = v.idaspecto    
                    WHERE v.idperfil = :idcon AND a.idcompetencia = :idcom and p.anio = :anio and r.idpersonal = :idpers) as t2 on t1.idaspecto = t2.idaspecto
                    ORDER BY t1.idaspecto";
            $Q = $this->db->prepare($s);
            $Q->bindParam(':idcon',$idperfil,PDO::PARAM_INT);
            $Q->bindParam(':idcom',$row[0],PDO::PARAM_INT);
            $Q->bindParam(':anio',$anio,PDO::PARAM_INT);
            $Q->bindParam(':idpers',$g['idp'],PDO::PARAM_INT);
            $Q->execute();
            foreach ($Q->fetchAll() as $r) 
            {
                $data[$c]['res'][] = array('idaspecto'=>$r[0],
                                            'aspecto'=>$r[1],
                                            'periodo'=>array(0 => array($r[2],$r[1])));
            }
            $c += 1;
        }
        return array($data,$datos);
    }
    
    function data_rep05($g)
    {
        if(isset($g['idperiodo'])&&$g['idperiodo']!="")
            $idperiodo = $g['idperiodo'];
        else 
            $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];

        $anio = $g['anio'];
        $todos= $g['todos'];
        
        $s = "SELECT descripcion from evaluacion.periodo where idperiodo = ".$idperiodo;
        $stmt = $this->db->prepare($s);
        $stmt->execute();
        $rec = $stmt->fetchObject();
        $periodo = $rec->descripcion;

        $sql = "SELECT p.idperfil,p.nombres,p.apellidos,c.descripcion as perfil 
                FROM personal as p inner join seguridad.perfil as c on 
                    c.idperfil = p.idperfil
                WHERE p.idpersonal = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $idperfil = $r->idperfil;
        $personal = $r->nombres.' '.$r->apellidos;
        $perfil = $r->perfil;

        $datos = array($personal, $perfil, $anio);
        
        if($todos!= 1)
        {
            $sql1 = "SELECT
            c.codigo, c.tema,
            c.fecha, c.hora,
            ex.nombres||' '||ex.apellidos AS expositor,
            c.estado, 
            c.totalpromediado AS total
            FROM capacitacion.capacitacion AS c
            INNER JOIN capacitacion.capacitacion_asignacion AS a ON a.idcapacitacion = c.idcapacitacion
            INNER JOIN public.personal AS p ON p.idpersonal = a.idpersonalasig
            INNER JOIN public.personal AS ex ON ex.idpersonal = c.idpersonal
            WHERE a.idpersonalasig = :id AND c.anio= :anio
            ORDER BY 
            c.idcapacitacion ";
                
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->bindParam(':id',$g['idp'],PDO::PARAM_INT);
            $stmt1->bindParam(':anio', $anio,PDO::PARAM_INT);
            $stmt1->execute();
            $data= $stmt1->fetchAll();
        }else
            {
               $sql1 = "SELECT DISTINCT c.idcapacitacion,
                c.codigo, c.tema,
                c.fecha, c.hora,
                p.nombres||' '||p.apellidos AS expositor,
                c.estado,
                c.total AS total          
                FROM capacitacion.capacitacion AS c                
                INNER JOIN public.personal AS p ON p.idpersonal = c.idpersonal                
                WHERE c.anio= :anio
                ORDER BY 
                c.idcapacitacion ";
                    
                $stmt1 = $this->db->prepare($sql1);
                //$stmt1->bindParam(':id',$g['idp'],PDO::PARAM_INT);
                $stmt1->bindParam(':anio', $anio,PDO::PARAM_INT);
                $stmt1->execute();
                $data= $stmt1->fetchAll(); 
            }
        
        
        return array($data,$datos);
    }
    
    function data_rep06($g)
    {
        $anio = $g['anio'];
        $idtipodoc= $g['idtipo_documento'];
        $idpersonal=$g['idp'];

        $sql = "SELECT p.idperfil,p.nombres,p.apellidos,c.descripcion as perfil 
                FROM personal as p inner join seguridad.perfil as c on 
                    c.idperfil = p.idperfil
                WHERE p.idpersonal = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $idperfil = $r->idperfil;
        $personal = $r->nombres.' '.$r->apellidos;
        $perfil = $r->perfil;

        $datos = array($personal, $perfil, $anio, $idtipodoc, $idpersonal);
        
        if($idpersonal==0 && $idtipodoc=='')
        {
            //echo "too";
            $sql1="SELECT
                COUNT(t.idtipo_documento) AS nro,
                tpd.descripcion

                FROM
                evaluacion.tramite AS t
                INNER JOIN public.tipo_documento AS tpd ON tpd.idtipo_documento = t.idtipo_documento
                WHERE
                t.anio=".$anio." 
                GROUP BY
                tpd.descripcion ";
            
        }
        else {
            
            if($idpersonal==0)
            {
                //echo "asdasdsa";
                $where=" ";
                $where.=" INNER JOIN public.personal AS p ON p.idpersonal = t.idpersonalresp
                        WHERE t.idtipo_documento= $idtipodoc AND t.anio= $anio";
                $sql1 = "SELECT t.idtramite,
                t.idtipo_documento,
                p.idpersonal,
                t.idpersonalresp,
                t.codigo, t.asunto,
                t.fechainicio,
                p.nombres||' '||p.apellidos AS remitente,
                t.estado
                FROM
                evaluacion.tramite AS t             
                ".$where."
                ORDER BY t.idtramite DESC";
            }else
                {
                    $where=" AND d.idpersonal= $idpersonal";
                    $where.=" INNER JOIN public.personal AS p ON p.idpersonal = t.idpersonalresp
                        WHERE t.idtipo_documento= $idtipodoc AND t.anio= $anio ";

                    $sql1 = "SELECT t.idtramite,
                    t.idtipo_documento,
                    d.idpersonal,
                    t.idpersonalresp,
                    t.codigo, t.asunto,
                    t.fechainicio,
                    p.nombres||' '||p.apellidos AS remitente
                    t.estado
                    FROM
                    evaluacion.tramite AS t            
                    INNER JOIN evaluacion.derivaciones AS d ON t.idtramite = d.idtramite
                    
                    ".$where."
                    ORDER BY t.idtramite DESC";

                }
        }     
               
        $stmt1 = $this->db->prepare($sql1);
        
        $stmt1->execute();
        $data= $stmt1->fetchAll();
        
        return array($data,$datos);
    }
    
    function data_rep07($g)
    {
        $tp= $g['tp'];
        $anio= $g['anio'];
        
        if($tp== 1)
        {
            $sql1 = "SELECT obj.descripcion,
                sum(detalle.Planificado) as Planificado,
                sum(detalle.Obligatorio) as Obligatorio,
                sum(detalle.Voluntario) as Voluntario
                FROM (
                SELECT  distinct c.idobejtivoscap,
                CASE
                	 WHEN c.idalcancegeneral = 1 THEN sum(1)
                	 ELSE 0
                END AS Planificado,
                CASE
                	 WHEN c.idalcancegeneral = 2 THEN sum(1)
                	 ELSE 0
                END AS Obligatorio,
                CASE
                	 WHEN c.idalcancegeneral = 3 THEN sum(1)
                	 ELSE 0
                END AS Voluntario
                
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = c.idalcancegeneral 
                WHERE c.estado <> 0 AND c.anio=".$anio."
                GROUP BY c.idobejtivoscap,c.idalcancegeneral ) as detalle 
                INNER JOIN capacitacion.obejtivoscap as obj on obj.idobejtivoscap=detalle.idobejtivoscap
                GROUP BY obj.descripcion
                ORDER BY obj.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 2)
        {
            $sql1 = "SELECT eje.descripcion,
                sum(detalle.Planificado) as Planificado,
                sum(detalle.Obligatorio) as Obligatorio,
                sum(detalle.Voluntario) as Voluntario
                FROM (
                	SELECT  distinct c.idejecapacitacion,
                	CASE
                		 WHEN c.idalcancegeneral = 1 THEN sum(1)
                		 ELSE 0
                	END AS Planificado,
                	CASE
                		 WHEN c.idalcancegeneral = 2 THEN sum(1)
                		 ELSE 0
                	END AS Obligatorio,
                	CASE
                		 WHEN c.idalcancegeneral = 3 THEN sum(1)
                		 ELSE 0
                	END AS Voluntario
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = c.idalcancegeneral                   
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idejecapacitacion,c.idalcancegeneral ) AS detalle 
                INNER JOIN capacitacion.ejecapacitacion AS eje on eje.idejecapacitacion=detalle.idejecapacitacion
                GROUP BY eje.descripcion
                ORDER BY eje.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 3)
        {
            $sql1 = "SELECT p.nombres||' '||p.apellidos AS personal,
                sum(detalle.Planificado) AS Planificado,
                sum(detalle.Obligatorio) AS Obligatorio,
                sum(detalle.Voluntario) AS Voluntario
                
                FROM (
                    SELECT  distinct d.idpersonalasig,
                    CASE
                        WHEN c.idalcancegeneral = 1 THEN sum(1)
                        ELSE 0
                    END AS Planificado,
                    CASE
                        WHEN c.idalcancegeneral = 2 THEN sum(1)
                        ELSE 0
                    END AS Obligatorio,
                    CASE
                        WHEN c.idalcancegeneral = 3 THEN sum(1)
                        ELSE 0
                    END AS Voluntario
                    FROM
                    capacitacion.capacitacion AS c	
                    INNER JOIN capacitacion.capacitacion_asignacion AS d ON d.idcapacitacion = c.idcapacitacion
                    INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = c.idalcancegeneral
                    WHERE c.estado <> 0 AND c.anio=".$anio."
                    GROUP BY d.idpersonalasig,c.idalcancegeneral ) AS detalle 
                INNER JOIN public.personal AS p ON p.idpersonal=detalle.idpersonalasig
                GROUP BY p.nombres, p.apellidos
                ORDER BY p.nombres, p.apellidos ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 4)
        {
            $sql1 = "SELECT objem.descripcion,
                sum(detalle.Planificado) AS Planificado,
                sum(detalle.Obligatorio) AS Obligatorio,
                sum(detalle.Voluntario) AS Voluntario
                FROM (
                    SELECT  distinct c.idobejtivosemp,
                    CASE
                        WHEN c.idalcancegeneral = 1 THEN sum(1)
                        ELSE 0
                    END AS Planificado,
                    CASE
                        WHEN c.idalcancegeneral = 2 THEN sum(1)
                        ELSE 0
                    END AS Obligatorio,
                    CASE
                        WHEN c.idalcancegeneral = 3 THEN sum(1)
                        ELSE 0
                    END AS Voluntario
                    FROM
                    capacitacion.capacitacion AS c                    
                    INNER JOIN public.obejtivosemp AS objem ON objem.idobejtivosemp = c.idobejtivosemp
                    INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = c.idalcancegeneral
                    WHERE c.estado <> 0 AND c.anio=".$anio."
                    GROUP BY c.idobejtivosemp, c.idalcancegeneral ) AS detalle 
                INNER JOIN public.obejtivosemp AS objem ON objem.idobejtivosemp = detalle.idobejtivosemp
                GROUP BY objem.descripcion
                ORDER BY objem.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 5)
        {
            $sql1 = "SELECT l.descripcion,
                sum(detalle.Planificado) as Planificado,
                sum(detalle.Obligatorio) as Obligatorio,
                sum(detalle.Voluntario) as Voluntario
                FROM (
                	SELECT  distinct c.idlineaaccion,
                	CASE
                		 WHEN c.idalcancegeneral = 1 THEN sum(1)
                		 ELSE 0
                	END AS Planificado,
                	CASE
                		 WHEN c.idalcancegeneral = 2 THEN sum(1)
                		 ELSE 0
                	END AS Obligatorio,
                	CASE
                		 WHEN c.idalcancegeneral = 3 THEN sum(1)
                		 ELSE 0
                	END AS Voluntario
                	FROM
                	capacitacion.capacitacion AS c
                	INNER JOIN capacitacion.tipoalcance AS t ON c.idalcancegeneral = t.idtipoalcance
                
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idlineaaccion,c.idalcancegeneral ) AS detalle 
                INNER JOIN capacitacion.lineaaccion AS l on l.idlineaaccion =detalle.idlineaaccion
                GROUP BY l.descripcion
                ORDER BY l.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data, $tp);
        
        }       
        
    }
    
    function data_rep08($g)
    {
        $tp= $g['tp'];
        $anio= $g['anio'];
        
        if($tp== 1)
        {
            $sql1 = "SELECT obj.descripcion,
                sum(detalle.Subvencion) as Subvencion,
                sum(detalle.Monitoreo) as Monitoreo,
                sum(detalle.Bienes) as Bienes,
                sum(detalle.Equipamiento) as Equipamiento
                FROM (
                	SELECT  distinct c.idobejtivoscap,
                	CASE
                		 WHEN p.idcatpresupuesto = 1 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Subvencion,
                	CASE
                		 WHEN p.idcatpresupuesto = 2 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Monitoreo,
                	CASE
                		 WHEN p.idcatpresupuesto = 3 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Bienes,
                	CASE
                		 WHEN p.idcatpresupuesto = 4 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Equipamiento
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.presupuesto AS p ON c.idcapacitacion = p.idcapacitacion
                	INNER JOIN capacitacion.categoriapresupuesto AS cp ON cp.idcatpresupuesto = p.idcatpresupuesto
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idobejtivoscap,p.idcatpresupuesto ) as detalle 
                INNER JOIN capacitacion.obejtivoscap as obj on obj.idobejtivoscap=detalle.idobejtivoscap
                GROUP BY obj.descripcion
                ORDER BY obj.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 2)
        {
            $sql1 = "SELECT eje.descripcion,
                sum(detalle.Subvencion) as Subvencion,
                sum(detalle.Monitoreo) as Monitoreo,
                sum(detalle.Bienes) as Bienes,
                sum(detalle.Equipamiento) as Equipamiento
                FROM (
                	SELECT  distinct c.idejecapacitacion,
                	CASE
                		 WHEN p.idcatpresupuesto = 1 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Subvencion,
                	CASE
                		 WHEN p.idcatpresupuesto = 2 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Monitoreo,
                	CASE
                		 WHEN p.idcatpresupuesto = 3 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Bienes,
                	CASE
                		 WHEN p.idcatpresupuesto = 4 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Equipamiento
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.presupuesto AS p ON c.idcapacitacion = p.idcapacitacion
                	INNER JOIN capacitacion.categoriapresupuesto AS cp ON cp.idcatpresupuesto = p.idcatpresupuesto
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idejecapacitacion,p.idcatpresupuesto ) as detalle 
                INNER JOIN capacitacion.ejecapacitacion AS eje on eje.idejecapacitacion=detalle.idejecapacitacion
                GROUP BY eje.descripcion
                ORDER BY eje.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 3)
        {
            $sql1 = "SELECT p.nombres||' '||p.apellidos AS personal,
                sum(detalle.Subvencion) as Subvencion,
                sum(detalle.Monitoreo) as Monitoreo,
                sum(detalle.Bienes) as Bienes,
                sum(detalle.Equipamiento) as Equipamiento
                FROM (
                	SELECT DISTINCT d.idpersonalasig,
                	CASE
                		 WHEN p.idcatpresupuesto = 1 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Subvencion,
                	CASE
                		 WHEN p.idcatpresupuesto = 2 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Monitoreo,
                	CASE
                		 WHEN p.idcatpresupuesto = 3 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Bienes,
                	CASE
                		 WHEN p.idcatpresupuesto = 4 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Equipamiento
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.presupuesto AS p ON c.idcapacitacion = p.idcapacitacion
                	INNER JOIN capacitacion.categoriapresupuesto AS cp ON cp.idcatpresupuesto = p.idcatpresupuesto
                  INNER JOIN capacitacion.capacitacion_asignacion AS d ON d.idcapacitacion = c.idcapacitacion
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY d.idpersonalasig,p.idcatpresupuesto ) as detalle 
                INNER JOIN public.personal AS p ON p.idpersonal=detalle.idpersonalasig
                GROUP BY p.nombres, p.apellidos
                ORDER BY p.nombres, p.apellidos ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 4)
        {
            $sql1 = "SELECT objem.descripcion,
                sum(detalle.Subvencion) as Subvencion,
                sum(detalle.Monitoreo) as Monitoreo,
                sum(detalle.Bienes) as Bienes,
                sum(detalle.Equipamiento) as Equipamiento
                FROM (
                	SELECT DISTINCT dobj.idobejtivosemp,
                	CASE
                		 WHEN p.idcatpresupuesto = 1 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Subvencion,
                	CASE
                		 WHEN p.idcatpresupuesto = 2 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Monitoreo,
                	CASE
                		 WHEN p.idcatpresupuesto = 3 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Bienes,
                	CASE
                		 WHEN p.idcatpresupuesto = 4 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Equipamiento
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.presupuesto AS p ON c.idcapacitacion = p.idcapacitacion
                	INNER JOIN capacitacion.categoriapresupuesto AS cp ON cp.idcatpresupuesto = p.idcatpresupuesto
                  INNER JOIN capacitacion.capacitacion_obejtivosemp AS dobj ON c.idcapacitacion = dobj.idcapacitacion
                  INNER JOIN public.obejtivosemp AS objem ON objem.idobejtivosemp = dobj.idobejtivosemp
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY dobj.idobejtivosemp,p.idcatpresupuesto ) as detalle 
                INNER JOIN public.obejtivosemp AS objem ON objem.idobejtivosemp = detalle.idobejtivosemp
                GROUP BY objem.descripcion
                ORDER BY objem.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 5)
        {
            $sql1 = "SELECT l.descripcion,
                sum(detalle.Subvencion) as Subvencion,
                sum(detalle.Monitoreo) as Monitoreo,
                sum(detalle.Bienes) as Bienes,
                sum(detalle.Equipamiento) as Equipamiento
                FROM (
                	SELECT DISTINCT c.idlineaaccion,
                	CASE
                		 WHEN p.idcatpresupuesto = 1 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Subvencion,
                	CASE
                		 WHEN p.idcatpresupuesto = 2 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Monitoreo,
                	CASE
                		 WHEN p.idcatpresupuesto = 3 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Bienes,
                	CASE
                		 WHEN p.idcatpresupuesto = 4 THEN sum(p.subtotal)
                		 ELSE 0
                	END AS Equipamiento
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.presupuesto AS p ON c.idcapacitacion = p.idcapacitacion
                	INNER JOIN capacitacion.categoriapresupuesto AS cp ON cp.idcatpresupuesto = p.idcatpresupuesto
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idlineaaccion,p.idcatpresupuesto ) as detalle 
                INNER JOIN capacitacion.lineaaccion AS l on l.idlineaaccion =detalle.idlineaaccion
                GROUP BY l.descripcion
                ORDER BY l.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data, $tp);
        
        }       
        
    }
    
    function data_rep09($g)
    {
        $tp= $g['tp'];
        $anio= $g['anio'];
        
        if($tp== 1)
        {
            $sql = "SELECT
                f.descripcion,
                COUNT(c.idfuentecapacitacion)
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.fuentecapacitacion AS f ON f.idfuentecapacitacion = c.idfuentecapacitacion
                WHERE
                c.estado <> 0 AND c.anio=".$anio."
                GROUP BY
                f.descripcion
                ORDER BY
                f.descripcion ASC ";
                    
            $stmt = $this->db->prepare($sql);        
            $stmt->execute();
            $data= $stmt->fetchAll();
            
            $sql1 = "SELECT
                sum(a.subtotal) AS total
                FROM 
                (SELECT
                f.descripcion,
                COUNT(c.idfuentecapacitacion) AS subtotal
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.fuentecapacitacion AS f ON f.idfuentecapacitacion = c.idfuentecapacitacion
                WHERE
                c.estado <> 0 AND c.anio=".$anio."
                GROUP BY
                f.descripcion) a ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $r= $stmt1->fetchObject();
            $total= $r->total;
            $data1 = array($total);
            
            return array($data,$data1);
        
        }
        
        if($tp== 2)
        {
            $sql = "SELECT
                l.descripcion,
                COUNT(c.idlineaaccion)
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion = c.idlineaaccion
                WHERE
                c.estado <> 0 AND c.anio=".$anio."
                GROUP BY
                l.descripcion
                ORDER BY
                l.descripcion ASC ";
                    
            $stmt = $this->db->prepare($sql);        
            $stmt->execute();
            $data= $stmt->fetchAll();
            
            $sql1 = "SELECT
                sum(a.subtotal) AS total
                FROM 
                (SELECT
                COUNT(c.idlineaaccion) AS subtotal
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion = c.idlineaaccion
                WHERE
                c.estado <> 0 AND c.anio=".$anio."
                GROUP BY l.descripcion) a ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $r= $stmt1->fetchObject();
            $total= $r->total;
            $data1 = array($total);
            
            return array($data,$data1);
        
        }
        
        if($tp== 3)
        {
            $sql = "SELECT
                m.descripcion,
                Count(c.idmetodoscapacitacion)
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.metodoscapacitacion AS m ON m.idmetodoscapacitacion = c.idmetodoscapacitacion
                WHERE
                c.estado <> 0 AND c.anio =".$anio."
                GROUP BY
                m.descripcion
                ORDER BY m.descripcion ASC ";
                    
            $stmt = $this->db->prepare($sql);        
            $stmt->execute();
            $data= $stmt->fetchAll();
            
            $sql1 = "SELECT
                sum(a.subtotal) AS total
                FROM 
                (SELECT
                Count(c.idmetodoscapacitacion) AS subtotal
                FROM
                capacitacion.capacitacion AS c
                INNER JOIN capacitacion.metodoscapacitacion AS m ON m.idmetodoscapacitacion = c.idmetodoscapacitacion
                WHERE
                c.estado <> 0 AND c.anio = ".$anio."
                GROUP BY m.descripcion) a ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $r= $stmt1->fetchObject();
            $total= $r->total;
            $data1 = array($total);
            
            return array($data,$data1);
        
        }
        
        if($tp== 4)
        {
            $sql = "SELECT
            ej.descripcion,
            COUNT(c.idejecapacitacion)
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = c.idejecapacitacion
            WHERE
            c.estado <> 0 AND c.anio = ".$anio."
            GROUP BY
            ej.descripcion
            ORDER BY ej.descripcion ASC";
                    
            $stmt = $this->db->prepare($sql);        
            $stmt->execute();
            $data= $stmt->fetchAll();
            
            $sql1 = "SELECT
            sum(a.subtotal) AS total
            FROM 
            (SELECT
            COUNT(c.idejecapacitacion) AS subtotal
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = c.idejecapacitacion
            WHERE
            c.estado <> 0 AND c.anio = ".$anio."
            GROUP BY ej.descripcion) a";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $r= $stmt1->fetchObject();
            $total= $r->total;
            $data1 = array($total);
            
            return array($data,$data1);
        
        }
        
        if($tp== 5)
        {
            $sql = "SELECT
            t.descripcion,
            COUNT(c.idalcancegeneral)
            FROM
            capacitacion.capacitacion AS c
            --INNER JOIN capacitacion.capacitacion_asignacion AS d ON d.idcapacitacion = c.idcapacitacion
            INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = c.idalcancegeneral
            WHERE
            c.anio = ".$anio." AND c.estado<>0
            GROUP BY
            t.descripcion
            ORDER BY
            t.descripcion ASC";
                    
            $stmt = $this->db->prepare($sql);        
            $stmt->execute();
            $data= $stmt->fetchAll();
            
            $sql1 = "SELECT
            sum(a.subtotal) AS total
            FROM 
            (SELECT
            COUNT(c.idalcancegeneral) AS subtotal
            FROM
            capacitacion.capacitacion AS c
            INNER JOIN capacitacion.capacitacion_asignacion AS d ON d.idcapacitacion = c.idcapacitacion
            INNER JOIN capacitacion.tipoalcance AS t ON t.idtipoalcance = c.idalcancegeneral
            WHERE
            c.estado <> 0 AND c.anio = ".$anio."
            GROUP BY
            t.descripcion) a";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $r= $stmt1->fetchObject();
            $total= $r->total;
            $data1 = array($total);
            
            return array($data,$data1);
        
        }       
        
    }
    
    function data_rep10($g)
    {
        $tp= $g['tp'];
        $anio= $g['anio'];
        
        if($tp== 1)
        {
            $sql1 = "SELECT l.descripcion,
                sum(detalle.Comunicacion) as Comunicacion,
                sum(detalle.Identidad) as Identidad,
                sum(detalle.Imagen) as Imagen,
                sum(detalle.Imagen1) as Imagen1,
                sum(detalle.Comunicacion1) as Comunicacion1,
                sum(detalle.Identidad1) as Identidad1
                FROM (
                	SELECT DISTINCT c.idlineaaccion,
                	CASE
                		 WHEN c.idobejtivosemp = 1 THEN sum(1)
                		 ELSE 0
                	END AS Comunicacion,
                	CASE
                		 WHEN c.idobejtivosemp = 2 THEN sum(1)
                		 ELSE 0
                	END AS Identidad,
                	CASE
                		 WHEN c.idobejtivosemp = 3 THEN sum(1)
                		 ELSE 0
                	END AS Imagen,
                	CASE
                		 WHEN c.idobejtivosemp = 4 THEN sum(1)
                		 ELSE 0
                	END AS Imagen1,
                	CASE
                		 WHEN c.idobejtivosemp = 5 THEN sum(1)
                		 ELSE 0
                	END AS Comunicacion1,
                	CASE
                		 WHEN c.idobejtivosemp = 6 THEN sum(1)
                		 ELSE 0
                	END AS Identidad1
                
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN obejtivosemp AS o ON o.idobejtivosemp = c.idobejtivosemp
                        INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion = c.idlineaaccion
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idlineaaccion, c.idobejtivosemp) as detalle 
                INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion =detalle.idlineaaccion
                GROUP BY l.descripcion
                ORDER BY l.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 2)
        {
            $sql1 = "SELECT l.descripcion,
                sum(detalle.Desarrollar) as Desarrollar,
                sum(detalle.Fortalecer) as Fortalecer,
                sum(detalle.Lograr) as Lograr,
                sum(detalle.Desarrollar1) as Desarrollar1,
                sum(detalle.Optimizar) as Optimizar,
                sum(detalle.Promover) as Promover
                FROM (
                    SELECT DISTINCT c.idlineaaccion,
                    CASE
                        WHEN c.idobejtivoscap = 1 THEN sum(1)
                        ELSE 0
                    END AS Desarrollar,
                    CASE
                        WHEN c.idobejtivoscap = 2 THEN sum(1)
                        ELSE 0
                    END AS Fortalecer,
                    CASE
                        WHEN c.idobejtivoscap = 3 THEN sum(1)
                        ELSE 0
                    END AS Lograr,
                    CASE
                        WHEN c.idobejtivoscap = 4 THEN sum(1)
                        ELSE 0
                    END AS Desarrollar1,
                    CASE
                        WHEN c.idobejtivoscap = 5 THEN sum(1)
                        ELSE 0
                    END AS Optimizar,
                    CASE
                        WHEN c.idobejtivoscap = 6 THEN sum(1)
                        ELSE 0
                    END AS Promover
                
                    FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.obejtivoscap AS ob ON ob.idobejtivoscap = c.idobejtivoscap
                        INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion = c.idlineaaccion
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idlineaaccion, c.idobejtivoscap) as detalle 
                INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion =detalle.idlineaaccion
                GROUP BY l.descripcion
                ORDER BY l.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        }
        
        if($tp== 3)
        {
            $sql1 = "SELECT l.descripcion,
                sum(detalle.Asistencial) as Asistencial,
                sum(detalle.Preventivo) as Preventivo,
                sum(detalle.Gestion) as Gestion,
                sum(detalle.Investigacion) as Investigacion,
                sum(detalle.Administrativo) as Administrativo,
                sum(detalle.Calidad) as Calidad
                FROM (
                	SELECT DISTINCT c.idlineaaccion,
                	CASE
                		 WHEN c.idejecapacitacion = 1 THEN sum(1)
                		 ELSE 0
                	END AS Asistencial,
                	CASE
                		 WHEN c.idejecapacitacion = 2 THEN sum(1)
                		 ELSE 0
                	END AS Preventivo,
                	CASE
                		 WHEN c.idejecapacitacion = 3 THEN sum(1)
                		 ELSE 0
                	END AS Gestion,
                	CASE
                		 WHEN c.idejecapacitacion = 4 THEN sum(1)
                		 ELSE 0
                	END AS Investigacion,
                	CASE
                		 WHEN c.idejecapacitacion = 5 THEN sum(1)
                		 ELSE 0
                	END AS Administrativo,
                	CASE
                		 WHEN c.idejecapacitacion = 6 THEN sum(1)
                		 ELSE 0
                	END AS Calidad
                
                	FROM
                	capacitacion.capacitacion AS c	
                	INNER JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = c.idejecapacitacion
                        INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion = c.idlineaaccion
                	WHERE c.estado <> 0 AND c.anio=".$anio."
                	GROUP BY c.idlineaaccion, c.idejecapacitacion) as detalle 
                INNER JOIN capacitacion.lineaaccion AS l ON l.idlineaaccion =detalle.idlineaaccion
                GROUP BY l.descripcion
                ORDER BY l.descripcion ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data);
        
        } 
        
    }   
    
    function data_rankingeva($g)
    {
        //if(isset($g['idperiodo'])&&$g['idperiodo']!="")
            $idperiodo = $g['idperiodo'];
        //else 
            //$idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];

        //$anio = $g['anio'];
        //$todos= $g['todos'];
        
        $s = "SELECT anio,descripcion from evaluacion.periodo where idperiodo = ".$idperiodo;
        $stmt = $this->db->prepare($s);
        $stmt->execute();
        $rec = $stmt->fetchObject();
        $periodo = $rec->descripcion;
        $anio   = $rec->anio;
        $datos = array($periodo, $anio);
        
        //if($todos!= 1)
        //{
            $sql1 = "SELECT
                p.nombres||' '||p.apellidos as personal,
                Sum(r.valor) AS total                
                FROM evaluacion.resultados AS r
                INNER JOIN evaluacion.periodo AS pe ON r.idperiodo = pe.idperiodo
                INNER JOIN public.personal AS p ON r.idpersonal = p.idpersonal
                WHERE r.idperiodo=:id  AND r.estado=1
                GROUP BY
                p.nombres, p.apellidos
                ORDER BY
                Sum(r.valor) DESC ";
                
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->bindParam(':id',$idperiodo,PDO::PARAM_INT);
            $stmt1->execute();
            $data= $stmt1->fetchAll();
        //}       
        
        return array($data,$datos);
    }
    
    function data_parametros($g)
    {
        $tp= $g['tp'];
        
        $anio= $g['anio'];
        $idper= $g['idper'];
        $idcomp= $g['idcomp'];
        $idasp= $g['idasp'];
        
        if($idper==0)
        { 
            $where=" ";
            
        
        }else 
            { $where=' AND r.idperiodo= '.$idper; }
        
        if($tp== 1)
        {
            $s = "SELECT descripcion FROM evaluacion.periodo WHERE idperiodo = ".$idper;
            $stmt = $this->db->prepare($s);
            $stmt->execute();
            $rec = $stmt->fetchObject();
            $periodo = $rec->descripcion;
            //$dat0 = array($periodo);
            
            $sql="SELECT idcompetencia, descripcion FROM evaluacion.competencias WHERE idcompetencia=".$idcomp;
            $stmt0 = $this->db->prepare($sql);        
            $stmt0->execute();
            $rec0 = $stmt0->fetchObject();
            $idcompetencia = $rec0->idcompetencia;
            $competencia = $rec0->descripcion;
            
            $dat1 = array($idcompetencia, $competencia, $periodo);
        
            $sql1 = "SELECT
            p.nombres||' '||p.apellidos AS personal,
            SUM(detalle.valor) as competencia
            FROM (
                    SELECT DISTINCT r.idpersonal,
                    c.descripcion AS competencia,
                    sum(r.valor) AS valor
                    FROM
                    evaluacion.resultados AS r
                    INNER JOIN evaluacion.periodo AS p ON p.idperiodo = r.idperiodo
                    INNER JOIN evaluacion.valores AS v ON v.idvalor = r.idvalor
                    INNER JOIN evaluacion.aspectos AS a ON a.idaspecto = v.idaspecto
                    INNER JOIN evaluacion.competencias AS c ON c.idcompetencia = a.idcompetencia
                    WHERE r.estado <> 0 AND a.idcompetencia=".$idcomp." 
                    AND p.anio=".$anio." ".$where." 
                    GROUP BY r.idpersonal,c.descripcion ) as detalle 
            INNER JOIN public.personal AS p ON p.idpersonal=detalle.idpersonal
            GROUP BY p.nombres, p.apellidos
            ORDER BY SUM(detalle.valor) DESC ";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data, $dat0, $dat1);
        
        }
        
        if($tp== 2)
        {
            $s = "SELECT descripcion FROM evaluacion.periodo WHERE idperiodo = ".$idper;
            $stmt = $this->db->prepare($s);
            $stmt->execute();
            $rec = $stmt->fetchObject();
            $periodo = $rec->descripcion;
            //$dat0 = array($periodo);
            
            $sq="SELECT idcompetencia, descripcion FROM evaluacion.competencias WHERE idcompetencia=".$idcomp;
            $stmt0 = $this->db->prepare($sq);        
            $stmt0->execute();
            $rec0 = $stmt0->fetchObject();
            $idcompetencia = $rec0->idcompetencia;
            $competencia = $rec0->descripcion;
            
            $sql="SELECT a.idaspecto, UPPER(a.descripcion) as descripcion, MAX(v.valor) AS valmax
            FROM evaluacion.aspectos AS a
            INNER JOIN evaluacion.valores v ON a.idaspecto= v.idaspecto
            WHERE a.idaspecto=".$idasp." GROUP BY a.idaspecto, a.descripcion";
            $stm0 = $this->db->prepare($sql);        
            $stm0->execute();
            $rec1 = $stm0->fetchObject();
            $idaspecto = $rec1->idaspecto;
            $aspecto = $rec1->descripcion;
            $valmax= $rec1->valmax;
            $dat1 = array($idcompetencia, $competencia, $periodo, $idaspecto, $aspecto, $valmax);
            
            $sql1 = "SELECT
            p.nombres||' '||p.apellidos AS personal,
            r.valor
            FROM evaluacion.resultados AS r
            INNER JOIN evaluacion.periodo AS pe ON pe.idperiodo = r.idperiodo
            INNER JOIN evaluacion.valores AS v ON v.idvalor = r.idvalor
            INNER JOIN evaluacion.aspectos AS a ON a.idaspecto = v.idaspecto
            INNER JOIN evaluacion.competencias AS c ON c.idcompetencia = a.idcompetencia
            INNER JOIN public.personal AS p ON p.idpersonal=r.idpersonal
            WHERE r.estado <> 0 AND a.idcompetencia=".$idcomp." AND a.idaspecto=".$idasp."
            AND pe.anio=".$anio." ".$where." 
            ORDER BY r.valor DESC";
                    
            $stmt1 = $this->db->prepare($sql1);        
            $stmt1->execute();
            $data= $stmt1->fetchAll();
            
            return array($data, $dat0, $dat1);
        
        }
    }
    
    
     
}
?>