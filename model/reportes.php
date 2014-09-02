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
                                            'valor'=>$r[2],
                                            'valor_max'=>$r[3]);
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
                                            'periodo'=>array(0 => array($r[2],$r[1]));                                            
            }
            $c += 1;
        }
        return array($data,$datos);
    }
}
?>