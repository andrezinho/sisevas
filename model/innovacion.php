<?php
include_once("Main.php");
class Innovacion extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            i.idinnovacion,
            p.nombres||' '||p.apellidos,
            i.descripcion,
            substr(cast(i.fechain as text),9,2)||'/'||substr(cast(i.fechain as text),6,2)||'/'||substr(cast(i.fechain as text),1,4),
            i.horain
            FROM
            evaluacion.innovacion AS i
            INNER JOIN public.personal AS p ON p.idpersonal = i.idpersonal ";
            
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM evaluacion.innovacion WHERE idinnovacion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO evaluacion.innovacion (idpersonal, descripcion, fechain, horain) 
                        VALUES(:p1,:p2,:p3,:p4)");
                        
        $stmt->bindParam(':p1', $_P['idpersonal'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['fechain'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['horain'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE evaluacion.innovacion set 
                            idpersonal = :p1, 
                            descripcion = :p2
                            
                    WHERE idinnovacion = :idinnovacion");
        $stmt->bindParam(':p1', $_P['idpersonal'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        //$stmt->bindParam(':p3', $_P['fechain'] , PDO::PARAM_STR);
        //$stmt->bindParam(':p4', $_P['horain'] , PDO::PARAM_STR);
        
        $stmt->bindParam(':idinnovacion', $_P['idinnovacion'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM evaluacion.innovacion WHERE idinnovacion = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>