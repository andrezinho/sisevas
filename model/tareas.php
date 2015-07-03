<?php

include_once("Main.php");

class tareas extends Main {

    function indexGrid($page, $limit, $sidx, $sord, $filtro, $query, $cols) {
        $sql = "SELECT t.idtareas, 
            p.nombres||' '||p.apellidos AS personal,            
            t.tarea,  
            substr(cast(t.fechareg as text),9,2)||'/'||substr(cast(t.fechareg as text),6,2)||'/'||substr(cast(t.fechareg as text),1,4),
            case t.idimportancia
                when 1 then '<p style=\"background:#084B8A;\">&nbsp;</p>'
                when 2 then '<p style=\"background:#31B404;\">&nbsp;</p>'
                when 3 then '<p style=\"background:#FFFF15;\">&nbsp;</p>'
                when 4 then '<p style=\"background:#D50000;\">&nbsp;</p>'                
            else '' end,
            ej.descripcion 
            FROM calidad.tareas AS t
            LEFT JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion= t.idejecapacitacion
            LEFT JOIN public.personal AS p ON p.idpersonal= t.idpersonalreg
            WHERE t.estado!=3";
        return $this->execQuery($page, $limit, $sidx, $sord, $filtro, $query, $cols, $sql);
    }

    function edit($id) {
        $sql = "SELECT * FROM  calidad.tareas WHERE idtareas = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P) {
        $fecha_reg = date('Y-m-d');
        $idpersonalreg = $_SESSION['idusuario'];

        $stmt = $this->db->prepare("INSERT INTO calidad.tareas( tarea, fechareg, idejecapacitacion,
            idpersonalreg, estado, idobejtivosemp, idfuncionesuop, idmediosverificacion, indicador,
            gradoavance, nrominutos, idimportancia )
            VALUES ( :p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12 ) ");
        $stmt->bindParam(':p1', $_P['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['fechareg'], PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idejecapacitacion'], PDO::PARAM_STR);
        $stmt->bindParam(':p4', $idpersonalreg, PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['estado'], PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['idobejtivosemp'], PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['idfuncionesuop'], PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['idmediosverificacion'], PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['indicador'], PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['gradoavance'], PDO::PARAM_INT);
        $stmt->bindParam(':p11', $_P['nrominutos'], PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['idimportancia'], PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();

        return array($p1, $p2[2]);
    }

    function update($_P) {
                
        $stmt = $this->db->prepare("UPDATE calidad.tareas SET 
            tarea= :p1, fechareg= :p2, idejecapacitacion=:p3, estado= :p4,
            idobejtivosemp= :p6, idfuncionesuop= :p7, idmediosverificacion= :p8, 
            indicador= :p9, gradoavance= :p10, nrominutos=:p11,
            idimportancia= :p12
            WHERE idtareas= :p5;");
        $stmt->bindParam(':p1', $_P['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['fechareg'], PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idejecapacitacion'], PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['estado'], PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idtareas'], PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['idobejtivosemp'], PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['idfuncionesuop'], PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['idmediosverificacion'], PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['indicador'], PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['gradoavance'], PDO::PARAM_INT);
        $stmt->bindParam(':p11', $_P['nrominutos'], PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['idimportancia'], PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();

        return array($p1, $p2[2]);
    }
    
    function getVer($tabla,$campo,$id)
    {
        $sql = "SELECT idpersonalreg from {$tabla} where {$campo} = {$id}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $r = $stmt->fetchObject();
        return $r->idpersonalreg;
    } 
    
    function getTareas($G) {

        $idper = $G['idper'];
        $fechai= $G['fechai'];
        $fechaf= $G['fechaf'];
        
        $sql="SELECT t.idtareas,
            t.tarea, ej.descripcion,
            ob.descripcion,
            t.indicador,
            t.gradoavance

            FROM calidad.tareas AS t
            LEFT JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = t.idejecapacitacion
            LEFT JOIN public.obejtivosemp AS ob ON ob.idobejtivosemp = t.idobejtivosemp
            WHERE t.fechareg BETWEEN CAST ('$fechai' AS DATE) AND CAST ( '$fechaf' AS DATE )
            AND t.estado=1 AND t.idpersonalreg= ".$idper." ORDER BY t.fechareg ASC ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array( 'id'=>$r[0], 'tarea'=>$r[1], 'eje'=>$r[2], 'obj'=>$r[3], 'indicador'=>$r[4], 'grado'=>$r[5] );
        }
        //print_r($data);
        return $data;

    }

}

?>