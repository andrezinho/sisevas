<?php
include_once("Main.php");
include_once("../lib/class.upload.php");
class Personal extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            p.idpersonal,
            p.dni,
            p.nombres,
            p.apellidos,
            p.telefono,
            p.direccion,
            c.descripcion,
            case p.estado when 1 then 'ACTIVO' else 'INCANTIVO' end,
            '<a href=\"index.php?controller=evaluacion&idp='||p.idpersonal||'\" target=\"_blank\" class=\"btn-evaluar box-boton boton-recibido\"></a>'
            FROM
            public.personal AS p
            INNER JOIN public.estado_civil AS e ON e.idestado_civil = p.idestado_civil
            INNER JOIN public.consultorio AS c ON c.idconsultorio = p.idarea ";
                    
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT  p.*,
                                c.descripcion as consult,
                                p2.descripcion as perfil
                        FROM personal as p inner join consultorio as c
                            on c.idconsultorio = p.idarea 
                            inner join seguridad.perfil as p2 on p.idperfil = p2.idperfil
                        WHERE p.idpersonal = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        //print_r($_P);
        $dni=$_P['dni'];
        $estado=1;
        $tdoc= $_P['iddocumento_identidad'];
        
        if($_P['cumpleesposa']=='')
        { $_P['cumpleesposa']=null; } 

        if($_P['cumplehijo']=='')
        { $_P['cumplehijo']=null; }

        if($_P['vacacionesinicio']=='')
        { $_P['vacacionesinicio']=null; }

        if($_P['vacacionesfin']=='')
        { $_P['vacacionesfin']=null; }

        if($_P['sueldo']=='')
        { $_P['sueldo']=0; }
    
        $sql="INSERT INTO personal(
            iddocumento_identidad, dni, nombres, apellidos, telefono, direccion, sexo,idestado_civil, estado, idarea,
            idcargo, idperfil, usuario,clave, ruc,idespecialidad,idgradinstruccion,idtipopersonal, codessalud, codafp, nrobrevete,
            file, file_hc, fechareg, fechanaci, cumpleesposa, cumplehijo,mail,asumircargo,contrato, sueldo, vacacionesinicio,
            vacacionesfin)   
            values(:p0,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18,:p19,:p20,:p21,:p22,
                :p23, :p24, :p25, :p26, :p27, :p28, :p29, :p30, :p31, :p32) ";
        
        //$stmt = $this->db->prepare("INSERT INTO personal(iddocumento_identidad, dni, nombres, apellidos, telefono, direccion, sexo, idestado_civil,
        //    estado,idarea,idcargo,idperfil, usuario,clave,ruc,idespecialidad,idgradinstruccion,idtipopersonal,codessalud,
        //    codafp,nrobrevete,file,file_hc, fechareg,fechanaci,cumpleesposa,cumplehijo)
        //    values(:p0,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18,:p19,:p20,:p21,:p22,:p23,:p24,:p25,:p26 ");
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':p0', $tdoc , PDO::PARAM_STR);
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['idestado_civil'] , PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idconsultorio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['idcargo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p11', $_P['idperfil'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['usuario'] , PDO::PARAM_STR);
        $stmt->bindParam(':p13', $_P['clave'] , PDO::PARAM_STR);
        $stmt->bindParam(':p14', $_P['ruc'] , PDO::PARAM_STR);

        $stmt->bindParam(':p15', $_P['idespecialidad'] , PDO::PARAM_STR);
        $stmt->bindParam(':p16', $_P['idgradinstruccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p17', $_P['idtipopersonal'] , PDO::PARAM_STR);
        $stmt->bindParam(':p18', $_P['codessalud'] , PDO::PARAM_STR);
        $stmt->bindParam(':p19', $_P['codafp'] , PDO::PARAM_STR);
        $stmt->bindParam(':p20', $_P['nrobrevete'] , PDO::PARAM_STR);
        $stmt->bindParam(':p21', $_P['archivo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p22', $_P['archivo_hc'] , PDO::PARAM_STR);
		$stmt->bindParam(':p23', $_P['fechaing'] , PDO::PARAM_STR);
        $stmt->bindParam(':p24', $_P['fechanaci'] , PDO::PARAM_STR);
		$stmt->bindParam(':p25', $_P['cumpleesposa'] , PDO::PARAM_STR);
        $stmt->bindParam(':p26', $_P['cumplehijo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p27', $_P['email'] , PDO::PARAM_STR);
        $stmt->bindParam(':p28', $_P['asumircargo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p29', $_P['contrato'] , PDO::PARAM_STR);
        
        $stmt->bindParam(':p30', $_P['sueldo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p31', $_P['vacacionesinicio'] , PDO::PARAM_STR);
        $stmt->bindParam(':p32', $_P['vacacionesfin'] , PDO::PARAM_STR);    
        //print_r($stmt);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
         
        $dni=$_P['dni'];

        if($_P['cumpleesposa']=='')
        { $_P['cumpleesposa']=null; } 

        if($_P['cumplehijo']=='')
        { $_P['cumplehijo']=null; }

        if($_P['vacacionesinicio']=='')
        { $_P['vacacionesinicio']=null; }

        if($_P['vacacionesfin']=='')
        { $_P['vacacionesfin']=null; }

        if($_P['sueldo']=='')
        { $_P['sueldo']=0; }

        $sql = "UPDATE personal set 
                    dni = :p1, nombres=:p2,
                    apellidos=:p3, telefono=:p4,
                    direccion=:p5, sexo=:p6,
                    idestado_civil=:p7,
                    estado=:p8, idarea=:p9,
                    idcargo=:p10, idperfil=:p11,
                    usuario=:p12, clave=:p13,
                    ruc=:p14, fechanaci= :p15,
                    mail=:p16, fechareg= :p17,
					idespecialidad=:p18,
                    idgradinstruccion=:p19,
                    idtipopersonal=:p20,
                    codessalud=:p21,
                    codafp=:p22, file=:p23,file_hc=:p24,
                    cumpleesposa=:p25, cumplehijo=:p26,
                    asumircargo= :p27, contrato= :p28,
                    sueldo= :p29, vacacionesinicio= :p30,
                    vacacionesfin= :p31
                    
                where idpersonal = :idpersonal";

        $stmt = $this->db->prepare($sql);
                
            $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);        
            $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['idestado_civil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p9', $_P['idconsultorio'] , PDO::PARAM_INT);
            $stmt->bindParam(':p10', $_P['idcargo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p11', $_P['idperfil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p12', $_P['usuario'] , PDO::PARAM_STR);
            $stmt->bindParam(':p13', $_P['clave'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14', $_P['ruc'] , PDO::PARAM_STR);
            $stmt->bindParam(':p15', $_P['fechanaci'] , PDO::PARAM_STR);			
			
            $stmt->bindParam(':p16', $_P['email'] , PDO::PARAM_STR);
			$stmt->bindParam(':p17', $_P['fechaing'] , PDO::PARAM_STR);            
            $stmt->bindParam(':p18', $_P['idespecialidad'] , PDO::PARAM_STR);
            $stmt->bindParam(':p19', $_P['idgradinstruccion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p20', $_P['idtipopersonal'] , PDO::PARAM_STR);
            $stmt->bindParam(':p21', $_P['codessalud'] , PDO::PARAM_STR);
            $stmt->bindParam(':p22', $_P['codafp'] , PDO::PARAM_STR);
            $stmt->bindParam(':p23', $_P['archivo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p24', $_P['archivo_hc'] , PDO::PARAM_STR);
            $stmt->bindParam(':p25', $_P['cumpleesposa'] , PDO::PARAM_STR);
            $stmt->bindParam(':p26', $_P['cumplehijo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p27', $_P['asumircargo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p28', $_P['contrato'] , PDO::PARAM_STR);
            $stmt->bindParam(':p29', $_P['sueldo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p30', $_P['vacacionesinicio'] , PDO::PARAM_STR);
            $stmt->bindParam(':p31', $_P['vacacionesfin'] , PDO::PARAM_STR);

            $stmt->bindParam(':idpersonal', $_P['idpersonal'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM personal WHERE idpersonal = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function get($query,$field)
    {
    
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT 
            idpersonal, mail, 
            dni, nombres || ' ' || apellidos AS nompersonal,
            nombres, apellidos
            FROM personal
            WHERE {$field} ilike :query AND dni <> '' AND estado=1 limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);        
        $statement->execute();
        return $statement->fetchAll();
    }

    function viewTrab($Gets)
    {
        //echo $id= $Gets['mes'];
        $produccion="SELECT
            pro.descripcion AS produccion,
            substr(cast(pro.fechaini as text),9,2)||'/'||substr(cast(pro.fechaini as text),6,2)||'/'||substr(cast(pro.fechaini as text),1,4) AS fechaini,
            substr(cast(pro.fechafin as text),9,2)||'/'||substr(cast(pro.fechafin as text),6,2)||'/'||substr(cast(pro.fechafin as text),1,4) as fechafin,
            tpp.descripcion,
            pro.fecha
            FROM
            personal AS p
            INNER JOIN produccion.produccion AS pro ON p.idpersonal = pro.idpersonal
            INNER JOIN produccion.producciontipo AS tpp ON tpp.idproducciontipo = pro.idproducciontipo
            WHERE
            pro.idpersonal= :id and  extract(YEAR FROM pro.fecha)=:p2 AND extract(MONTH FROM pro.fecha)=:p1 ";

            $stmt = $this->db->prepare($produccion);
            $stmt->bindParam(':id', $Gets['idpersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p1', $Gets['mes'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $Gets['anio'] , PDO::PARAM_STR);

            $stmt->execute();
            $produccion= $stmt->fetchAll();
        
        $acabado="SELECT
            a.cantidad,
            ps.descripcion || ' ' || sps.descripcion AS producto,
            a.idpersonal,
            substr(cast(a.fechaini as text),9,2)||'/'||substr(cast(a.fechaini as text),6,2)||'/'||substr(cast(a.fechaini as text),1,4) AS fechaini,
            substr(cast(a.fechafin as text),9,2)||'/'||substr(cast(a.fechafin as text),6,2)||'/'||substr(cast(a.fechafin as text),1,4) as fechafin          
          
            FROM
            personal AS p
            INNER JOIN produccion.acabado AS a ON p.idpersonal = a.idpersonal
            INNER JOIN produccion.produccion_detalle AS prod ON prod.idproduccion_detalle = a.idproduccion_detalle
            INNER JOIN produccion.subproductos_semi AS sps ON sps.idsubproductos_semi = prod.idsubproductos_semi
            INNER JOIN produccion.productos_semi AS ps ON ps.idproductos_semi = sps.idproductos_semi
            WHERE
            a.idpersonal= :id and  extract(YEAR from a.fecha)=:p2 AND extract(MONTH from a.fecha)=:p1 ";

            $stmt1 = $this->db->prepare($acabado);
            $stmt1->bindParam(':id', $Gets['idpersonal'] , PDO::PARAM_INT);
            $stmt1->bindParam(':p1', $Gets['mes'] , PDO::PARAM_STR);
            $stmt1->bindParam(':p2', $Gets['anio'] , PDO::PARAM_STR);

            $stmt1->execute();
            $acabado=$stmt1->fetchAll();

            return array($produccion , $acabado);
    }

    function viewPag($Gets)
    {
        $sql="SELECT
            pa.motivo,
            pa.nrorecibo,
            pa.importe,
            substr(cast(pa.fechacancelacion as text),9,2)||'/'||substr(cast(pa.fechacancelacion as text),6,2)||'/'||substr(cast(pa.fechacancelacion as text),1,4) AS fechacancelacion,
            pa.horapago
            
            FROM
            produccion.pagos AS pa
            INNER JOIN personal AS pe ON pe.idpersonal = pa.idpersonal
            WHERE
            pa.idpersonal= :id and  extract(YEAR from pa.fechacancelacion)=:p2 AND extract(MONTH from pa.fechacancelacion)=:p1 ";

        $stmt1 = $this->db->prepare($sql);
        $stmt1->bindParam(':id', $Gets['idpersonal'] , PDO::PARAM_INT);
        $stmt1->bindParam(':p1', $Gets['mes'] , PDO::PARAM_STR);
        $stmt1->bindParam(':p2', $Gets['anio'] , PDO::PARAM_STR);

        $stmt1->execute();
        return $stmt1->fetchAll();
    }
    
    function getList()
    {
        $sql = "SELECT p.idpersonal, p.personal FROM public.vista_personal AS p ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idpersonal'=>$r[0],'personal'=>$r[1]);
        }
        return $data;
    }
    
    function getListAsist($id)
    {
        $sql = "SELECT ca.idpersonalasig,
        p.nombres||' '|| p.apellidos
        FROM capacitacion.capacitacion c
            JOIN capacitacion.capacitacion_asignacion ca ON ca.idcapacitacion = c.idcapacitacion
            JOIN personal p ON p.idpersonal = ca.idpersonalasig        
        WHERE ca.idcapacitacion=".$id." ORDER BY p.nombres ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idpersonal'=>$r[0],'personal'=>$r[1]);
        }
        return $data;
    }
    
    function getPersonalxArea($G)
    {
        $idc = $G['idc'];
        $idusu= $G['idusu'];
        
        if($idusu=='')
        {
            $sql = "SELECT * FROM vista_personal WHERE idconsultorio=".$idc;
        }
        else {
            $sql = "SELECT * FROM vista_personal WHERE idconsultorio=".$idc;
        }
        
       
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idpersonal'=>$r[0],'personal'=>$r[1]);
        }
        return $data;
    }
    
    
}
?>