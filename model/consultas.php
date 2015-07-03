<?php
include_once("Main.php");
class Consultas extends Main
{    
    function data_informe($g)
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
                ej.descripcion,
                COUNT(inf.idejecapacitacion)
                FROM
                calidad.informememoria AS inf
                INNER JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = inf.idejecapacitacion
                WHERE
                inf.anio = :anio and inf.idpersonal=:id
                GROUP BY
                ej.descripcion
                ORDER BY
                ej.descripcion ASC ";
                    
                $stmt1 = $this->db->prepare($sql1);
                $stmt1->bindParam(':id',$g['idp'],PDO::PARAM_INT);
                $stmt1->bindParam(':anio', $anio,PDO::PARAM_INT);
                $stmt1->execute();
                $data= $stmt1->fetchAll(); 
        }else
            {
               $sql1 = "SELECT
                ej.descripcion,
                COUNT(inf.idejecapacitacion)
                FROM
                calidad.informememoria AS inf
                INNER JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = inf.idejecapacitacion
                WHERE
                inf.anio = :anio and inf.idpersonal=:id
                GROUP BY
                ej.descripcion
                ORDER BY
                ej.descripcion ASC ";
                    
                $stmt1 = $this->db->prepare($sql1);
                $stmt1->bindParam(':id',$g['idp'],PDO::PARAM_INT);
                $stmt1->bindParam(':anio', $anio,PDO::PARAM_INT);
                $stmt1->execute();
                $data= $stmt1->fetchAll(); 
            }
        
        
        return array($data,$datos);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM produccion.almacenes WHERE idalmacen = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO produccion.almacenes(descripcion,direccion,telefono,estado)
                                    values(:p1,:p2,:p3,:p4) ");
                                           
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);       
        $stmt->bindParam(':p2', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['activo'] , PDO::PARAM_INT);        
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    
}
?>