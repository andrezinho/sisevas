<?php
include_once("Main.php");
class funcionesuop extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            f.idfuncionesuop,
            c.descripcion,
            ca.descripcion,
            f.descripcion,
            case f.estado when 1 then 'ACTIVO' else 'INCANTIVO' end,
            case f.idejecapacitacion 
                when 1 then '<p style=\"background:#084B8A;\">&nbsp;</p>'
                when 2 then '<p style=\"background:#31B404;\">&nbsp;</p>'
                when 3 then '<p style=\"background:#BF00FF;\">&nbsp;</p>'
                when 4 then '<p style=\"background:#BDBDBD;\">&nbsp;</p>'
                when 5 then '<p style=\"background:#F7BE81;\">&nbsp;</p>'
                when 6 then '<p style=\"background:#BF00FF;\">&nbsp;</p>'
            else '' end

            FROM
            funcionesuop AS f
            INNER JOIN consultorio AS c ON c.idconsultorio = f.idconsultorio
            LEFT JOIN cargo AS ca ON ca.idcargo = f.idcargo ";

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM funcionesuop WHERE idfuncionesuop = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO funcionesuop( descripcion, idconsultorio, estado, idcargo, idejecapacitacion)
                    values(:p1, :p2, :p3, :p4, :p5 ) ");
             
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idconsultorio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['idcargo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idejecapacitacion'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE funcionesuop SET 
            descripcion= :p1, idconsultorio= :p2, estado= :p3,
            idcargo= :p4, idejecapacitacion= :p5
            WHERE idfuncionesuop = :idfuncionesuop ";
        $stmt = $this->db->prepare($sql);
            
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idconsultorio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['idcargo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idejecapacitacion'] , PDO::PARAM_INT);
        $stmt->bindParam(':idfuncionesuop', $_P['idfuncionesuop'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();

        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM funcionesuop WHERE idfuncionesuop = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function getFuncionesxArea($G)
    {
        $idper= $G['idper'];
        $idc= $G['idc'];
        $idfun= $G['idfun'];
        
        $idcargo= $G['idcargo'];
        
        if ($idcargo!='')
        {
            
            $sql = "SELECT idfuncionesuop, descripcion FROM funcionesuop 
            WHERE idcargo=".$idcargo."  ORDER BY descripcion ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = array();
            foreach($stmt->fetchAll() as $r)
            {
                $data[] = array('id'=>$r[0],'descripcion'=>$r[1]);
            }
            return $data;
        }
        else
        {
            $ver="SELECT p.idcargo FROM personal AS p
            INNER JOIN cargo AS c ON c.idcargo= p.idcargo
            WHERE p.idpersonal=".$idper;
            $stmt0 = $this->db->prepare($ver);
            $stmt0->execute();
            $row= $stmt0->fetchObject();

            $idcargo =$row->idcargo;

            $sql = "SELECT idfuncionesuop, descripcion FROM funcionesuop 
            WHERE idconsultorio=".$idc." AND idcargo=".$idcargo."  ORDER BY descripcion ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = array();
            foreach($stmt->fetchAll() as $r)
            {
                $data[] = array('id'=>$r[0],'descripcion'=>$r[1]);
            }
            return $data;
        }
            
    }

    function getEjes($G)
    {
        $idf= $G['idf'];
        
        $sql = "SELECT f.idejecapacitacion, e.descripcion
        FROM public.funcionesuop AS f 
        INNER JOIN capacitacion.ejecapacitacion as e ON e.idejecapacitacion= f.idejecapacitacion
        WHERE f.idfuncionesuop=".$idf;
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $row= $stmt->fetchObject();
        
        $ideje =$row->idejecapacitacion;
        $eje =$row->descripcion;
        $data = array('ideje' =>$ideje, 'descripcion'=> $eje );
        return $data;
    }

}
?>