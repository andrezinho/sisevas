<?php
include_once("Main.php");
class valores extends Main
{    
    function edit($id)
    {   
        $sql="SELECT *  
              FROM  evaluacion.valores
              WHERE idaspecto = :id ";
        $stmt = $this->db->prepare($sql);        
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function save($items,$idc,$ida) 
    {       
        $fecha_reg = date('Y-m-d');
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $estado = 1;
        $ids = "";



        try
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();


            if($idc==0)
            {
                $sql = "SELECT idperfil FROM seguridad.perfil ";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                $perfiles = array();
                foreach ($stmt->fetchAll() as $r)                 
                    $perfiles[] = $r[0];            

                //eliminamos todos los valores para estos perfiles
                foreach ($perfiles as $p) 
                {
                    $delete_query = "DELETE FROM evaluacion.valores where idaspecto = ".$ida." and idperfil = ".$p;
                    $delete = $this->db->prepare($delete_query);
                    $delete->execute();
                }
            }
            else
            {
                //Eleminamos los Eliminados              

                foreach ($items as $k => $v) 
                {
                    if($v->idvalor!="")
                        $ids .= $v->idvalor.",";
                }
                $ids .= "0";
                $delete_query = "DELETE FROM evaluacion.valores where idvalor not in (".$ids.") and idaspecto = ".$ida." and idperfil = ".$idc;
                $delete = $this->db->prepare($delete_query);
                $delete->execute();
            }

            //News y Updates
            foreach ($items as $k => $v) 
            {
                if($v->idvalor=="")
                {
                    //*** New                    
                    $n = $this->vParametro(array($v->idparam,$v->idperfil));
                    if($n==0)
                    {
                        if($idc==0)
                        {
                            foreach($perfiles as $p)
                            {
                                $insert = $this->db->prepare("INSERT INTO evaluacion.valores (idaspecto,
                                                                                          idparametro,
                                                                                          idperfil,
                                                                                          orden,
                                                                                          valor,
                                                                                          fecha_reg,
                                                                                          estado,
                                                                                          idperiodo) 
                                                            VALUES (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8); ");
                                $insert->bindParam(':p1',$v->idaspecto,PDO::PARAM_INT);
                                $insert->bindParam(':p2',$v->idparam,PDO::PARAM_INT);
                                $insert->bindParam(':p3',$p,PDO::PARAM_INT);
                                $insert->bindParam(':p4',$v->order,PDO::PARAM_INT);
                                $insert->bindParam(':p5',$v->valor,PDO::PARAM_INT);
                                $insert->bindParam(':p6',$fecha_reg,PDO::PARAM_STR);
                                $insert->bindParam(':p7',$estado,PDO::PARAM_INT);
                                $insert->bindParam(':p8',$idperiodo,PDO::PARAM_INT);
                                $insert->execute();
                            }
                        }
                        else
                        {
                            $insert = $this->db->prepare("INSERT INTO evaluacion.valores (idaspecto,
                                                                                          idparametro,
                                                                                          idperfil,
                                                                                          orden,
                                                                                          valor,
                                                                                          fecha_reg,
                                                                                          estado,
                                                                                          idperiodo) 
                                                            VALUES (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8); ");
                            $insert->bindParam(':p1',$v->idaspecto,PDO::PARAM_INT);
                            $insert->bindParam(':p2',$v->idparam,PDO::PARAM_INT);
                            $insert->bindParam(':p3',$v->idperfil,PDO::PARAM_INT);
                            $insert->bindParam(':p4',$v->order,PDO::PARAM_INT);
                            $insert->bindParam(':p5',$v->valor,PDO::PARAM_INT);
                            $insert->bindParam(':p6',$fecha_reg,PDO::PARAM_STR);
                            $insert->bindParam(':p7',$estado,PDO::PARAM_INT);
                            $insert->bindParam(':p8',$idperiodo,PDO::PARAM_INT);
                            $insert->execute();
                        }
                        
                    }
                }
                else 
                {
                    //Edit 
                    $update = $this->db->prepare("UPDATE evaluacion.valores set valor = :p1, 
                                                                                orden = :p2 
                                                        where idvalor = :p0 ");
                    $update->bindParam(':p1',$v->valor,PDO::PARAM_INT);
                    $update->bindParam(':p2',$v->order,PDO::PARAM_INT);
                    $update->bindParam(':p0',$v->idvalor,PDO::PARAM_INT);
                    $update->execute();
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
    
    function getValores($_G)
    {
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $idperfil = $_G['idperfil'];
        $idaspecto = $_G['idaspecto'];

        $stmt = $this->db->prepare("SELECT  v.idvalor,
                                            v.idparametro,
                                            p.descripcion,
                                            v.orden,
                                            v.valor
                                    FROM evaluacion.valores as v inner join evaluacion.parametros as p 
                                            on p.idparametro = v.idparametro 
                                    WHERE v.idperiodo = :p1 and v.idperfil = :p2 and v.idaspecto = :p3
                                    order by v.orden");
        $stmt->bindParam(':p1',$idperiodo,PDO::PARAM_INT);
        $stmt->bindParam(':p2',$idperfil,PDO::PARAM_INT);
        $stmt->bindParam(':p3',$idaspecto,PDO::PARAM_INT);
        $stmt->execute();
        $data = array();
        foreach ($stmt->fetchAll() as $row) 
        {
            $data[] = array('idvalor'=>$row['idvalor'],
                            'idparametro'=>$row['idparametro'],
                            'parametro'=>$row['descripcion'],
                            'order'=>$row['orden'],
                            'valor'=>(int)$row['valor']);
        }
        return $data;
    }
    function vParametro($g)
    {
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $stmt = $this->db->prepare("SELECT count(*) as n from evaluacion.valores 
                                    where idparametro = :p1 and idperfil = :p2 and idperiodo = :p3");
        $stmt->bindParam(':p1',$g['idparametro'],PDO::PARAM_INT);
        $stmt->bindParam(':p2',$g['idperfil'],PDO::PARAM_INT);
        $stmt->bindParam(':p3',$idperiodo,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        return $r->n;
    }
}
?>