<?php

include_once("Main.php");

class informeme extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT i.idinforme,
        i.codigo,
        p.nombres||' '||p.apellidos AS evaluado,
        substr(cast(i.fechaini as text),9,2)||'/'||substr(cast(i.fechaini as text),6,2)||'/'||substr(cast(i.fechaini as text),1,4) AS fechaini,
        substr(cast(i.fechafin as text),9,2)||'/'||substr(cast(i.fechafin as text),6,2)||'/'||substr(cast(i.fechafin as text),1,4) AS fechafin,
        '<a class=\"printer box-boton boton-print\" id=\"f-'||i.idinforme||'\" href=\" #\" title=\"Imprimir Informe\" ></a>'
        FROM calidad.informememoria AS i
        INNER JOIN public.personal AS p ON i.idpersonal = p.idpersonal";
        
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT i.*
            FROM calidad.informememoria AS i
            
            WHERE idinforme = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            t.idtareas, t.tarea,
            ej.descripcion AS eje,
            ob.descripcion AS obj,
            t.gradoavance
            FROM
            calidad.tareas AS t
            LEFT JOIN calidad.informememoria AS i ON i.idinforme = t.idinforme
            LEFT JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = t.idejecapacitacion
            LEFT JOIN obejtivosemp AS ob ON ob.idobejtivosemp = t.idobejtivosemp
            WHERE t.idinforme = :id ORDER BY t.fechareg ASC ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    function insert($_P ) {
         
        $fechareg = date('Y-m-d');
        $fechaini  = $_P['fechaini'];
        $fechafin  = $_P['fechafin'];//fdate($_P['fechaini'],'EN');
        $idconsultorio = $_P['idconsultorio'];
        $idpersonalreg = $_SESSION['idusuario'];
        $idpersonal    = $_P['idpersonal'];
        $correlativo   = $_P['correlativo'];
        /*
        $idejecapacitacion   = $_P['idejecapacitacion'];
        $idobejtivosemp= $_P['idobejtivosemp'];        
        $idfuncionesuop    = $_P['idfuncionesuop'];
        $idmediosverificacion = $_P['idmediosverificacion'];
        $indicador     = $_P['indicador'];
        $gradoavance   = $_P['gradoavance'];
        $idtramite = $_P['idtramite'];
        */
        $observaciones = $_P['observaciones'];
        $notas = $_P['notas'];
        $codigo= $_P['codigo'];
        $anio= date('Y');

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            $sql= "INSERT INTO calidad.informememoria(fechareg, fechaini, idconsultorio, idpersonalreg, 
                idpersonal, correlativo, observaciones, anio, fechafin, codigo, notas)
            VALUES('$fechareg', '$fechaini', $idconsultorio, $idpersonalreg, $idpersonal, $correlativo, 
                '$observaciones', $anio, '$fechafin', '$codigo', '$notas' ) ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $id =  $this->IdlastInsert('calidad.informememoria','idinforme');
            $row= $stmt->fetchAll();
                        
            foreach($_P['idtareasdet'] as $i => $idtareas)
            {   
                $Upd="UPDATE calidad.tareas
                    SET idinforme= :p1, gradoavance= :p2, estado=3
                    WHERE idtareas=:p0 ";
                $stmt2 = $this->db->prepare($Upd);
                $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                $stmt2->bindParam(':p2',$_P['gradodet'][$i],PDO::PARAM_STR);                
                $stmt2->bindParam(':p0',$idtareas,PDO::PARAM_INT);
                $stmt2->execute();            
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

    function update($_P ) {
        
        $fechareg = date('Y-m-d');
        $fechaini  = $_P['fechaini'];
        $fechafin  = $_P['fechafin']; //fdate($_P['fechaini'],'EN');
        $idconsultorio = $_P['idconsultorio'];
        $idpersonalreg = $_SESSION['idusuario'];
        $idpersonal    = $_P['idpersonal'];
        $idejecapacitacion   = $_P['idejecapacitacion'];
        $idobejtivosemp= $_P['idobejtivosemp'];        
        $correlativo = $_P['idejecap'];
        $idfuncionesuop    = $_P['idfuncionesuop'];
        $idmediosverificacion = $_P['idmediosverificacion'];
        $indicador     = $_P['indicador'];
        $gradoavance   = $_P['gradoavance'];
        $observaciones = $_P['observaciones'];       
        $idtramite = $_P['idtramite'];
        $codigo= $_P['codigo'];
        $notas = $_P['notas'];
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            
            $id= $_P['idinforme'];
            
            $sql = "UPDATE calidad.informememoria SET 
            fechaini='$fechaini', fechafin='$fechafin', idconsultorio=$idconsultorio, idpersonal=$idpersonal,             
            observaciones='$observaciones', notas='$notas'
            WHERE idinforme= ".$id;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();            
            
            $IdTar_= $_P['tareasdet'];
            if($IdTar_!='')
            {
                $sqld="DELETE FROM calidad.tareas WHERE idinforme= ".$id;
                $stmt0 = $this->db->prepare($sqld);                    
                $stmt0->execute();                    

                $stmt2  = $this->db->prepare("INSERT INTO calidad.tareas(idinforme, tarea) VALUES (:p1, :p2) ");

                foreach($_P['tareasdet'] as $i => $tareasdet)
                {                
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p2',$tareasdet,PDO::PARAM_STR);
                    $stmt2->execute();
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
    
    function delete($id ) {
        //echo $id;
        $stmt0 = $this->db->prepare("DELETE FROM calidad.tareas WHERE idinforme = :p1");
        $stmt0->bindParam(':p1', $id , PDO::PARAM_INT);
        $stmt0->execute();
        
        $stmt = $this->db->prepare("DELETE FROM calidad.informememoria WHERE idinforme = :p1");
        $stmt->bindParam(':p1', $id , PDO::PARAM_INT);
        $p1 = $stmt->execute();

        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    public function GCorrelativo($g)
    {
        $idc= $g['idc'];
        $id = $g['idper'];
        $anio = date('Y');
        
        $sql = "SELECT MAX(correlativo) AS num FROM calidad.informememoria
            WHERE idconsultorio=$idc AND idpersonal=$id AND anio=$anio ";    
        $stmt=$this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        $row= $stmt->fetchObject();        
        $Num =$row->num;
        
        if($Num==0 && $anio=2015)
        { $Num=19; }
        
        $Num= $Num+1;
        $Abreviatura= 'INFMEM';
        $Numcor= str_pad($Num, 6,"00000", STR_PAD_LEFT);
        $codigo= $Abreviatura.''.$Numcor;
        //}
        
        //$data = array('serie'=>$Serie,'numero'=>$Num, 'abre'=>$Abreviatura);
        $data = array('codigo' =>$codigo, 'correlativo'=> $Num );
        return $data;
    }
    
    function printDoc($id)
    {           
        //echo $id;        
        $cab= "SELECT i.idinforme, 
            i.fechaini, 
            i.fechafin, 
            i.codigo, i.anio, 
            UPPER(c.descripcion) AS consultorio, 
            UPPER(p.nombres||' '||p.apellidos) AS responsable,
            i.observaciones,
            i.notas
            FROM 
            calidad.informememoria i
            INNER JOIN public.consultorio c ON c.idconsultorio = i.idconsultorio
            INNER JOIN public.personal p ON p.idpersonal = i.idpersonal
            WHERE i.idinforme=".$id;

        $stmt = $this->db->prepare($cab); 
        $stmt->execute();
        $cab= $stmt->fetch();
        
        $asig= "SELECT t.idtareas, UPPER(t.tarea) AS tarea,
            UPPER(ej.descripcion) AS eje,
            UPPER(ob.descripcion) AS obj,
            UPPER(f.descripcion) AS func,
            t.gradoavance,
            t.nrominutos
            FROM
            calidad.tareas AS t
            LEFT JOIN calidad.informememoria AS i ON i.idinforme = t.idinforme
            LEFT JOIN capacitacion.ejecapacitacion AS ej ON ej.idejecapacitacion = t.idejecapacitacion
            LEFT JOIN obejtivosemp AS ob ON ob.idobejtivosemp = t.idobejtivosemp
            LEFT JOIN funcionesuop AS f ON f.idfuncionesuop = t.idfuncionesuop
            WHERE t.idinforme =".$id." ORDER BY t.fechareg ASC";
        $stmt2 = $this->db->prepare($asig); 
        $stmt2->execute();
        $tar= $stmt2->fetchAll();  
        
        return array($cab, $tar);
    }
    

}
?>