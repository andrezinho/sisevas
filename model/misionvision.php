<?php
include_once("Main.php");
class misionvision extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT idmisionvision,
               mision,
               vision
                FROM misionvision";    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM misionvision WHERE idmisionvision = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO misionvision ( mision, vision, , img_v) VALUES(:p1,:p2,:p3,:p4)");
        $stmt->bindParam(':p1', $_P['mision'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['vision'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['archivo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['archivo_v'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
	//echo 
	$id=$_P['idmisionvision'];
        $stmt = $this->db->prepare("UPDATE misionvision 
			set 
			mision = :p1, 
			vision = :p2, img_m= :p3 , img_v= :p4
            
			WHERE idmisionvision = ".$id);
        $stmt->bindParam(':p1', $_P['mision'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['vision'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['archivo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['archivo_v'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM misionvision WHERE idmisionvision = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>