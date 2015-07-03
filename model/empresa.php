<?php
include_once("Main.php");
class empresa extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            em.idempresa,
            em.razonsocial,
            em.ruc,
            em.direccion,
            em.telefono
            FROM
            public.empresa AS em";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM public.empresa WHERE idempresa = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO public.empresa (razonsocial, ruc, direccion, telefono, web, email, 
            logo) VALUES(:p1, :p2, :p3, :p4, :p5, :p6, :p7)");
        $stmt->bindParam(':p1', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['ruc'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['web'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['archivo'] , PDO::PARAM_STR);
        //$stmt->bindParam(':p8', '252501' , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
	//echo 
	$id=$_P['idempresa'];
        $stmt = $this->db->prepare("UPDATE public.empresa SET 
			razonsocial = :p1, ruc = :p2, direccion= :p3,
            telefono = :p4, web= :p5, email = :p6, logo= :p7
			WHERE idempresa = ".$id);
        $stmt->bindParam(':p1', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['ruc'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['web'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['archivo'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM public.empresa WHERE idempresa = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>