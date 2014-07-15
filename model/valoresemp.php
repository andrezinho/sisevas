<?php
include_once("Main.php");
class valoresemp extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            idvaloresemp,
            valor,           
            descripcion,
            case estado when 1 then 'ACTIVO' else 'INCANTIVO' end
            
            FROM
            valoresemp ";
            
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM valoresemp WHERE idvaloresemp = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO valoresemp (valor, descripcion, estado) 
                        VALUES(:p1,:p2,:p3)");
                        
        $stmt->bindParam(':p1', $_P['valor'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE valoresemp set 
                            valor = :p1, 
                            descripcion = :p2,
                            estado = :p3
                            
                    WHERE idvaloresemp = :idvaloresemp");
        $stmt->bindParam(':p1', $_P['valor'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        
        $stmt->bindParam(':idvaloresemp', $_P['idvaloresemp'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM valoresemp WHERE idvaloresemp = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    //Reporte
    function ViewResultado($_G)
    {
        $idpersonal =$_G['idper'];
        $fechai = $this->fdate($_G['fechai'], 'EN');
        $fechaf = $this->fdate($_G['fechaf'], 'EN');
        
        if($idpersonal==0)
        {   
            $sql="SELECT
                s.descripcion,
                pr.serie,
                pr.numero,
                c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS nomcliente,
                substr(cast(pr.fecha as text),9,2)||'/'||substr(cast(pr.fecha as text),6,2)||'/'||substr(cast(pr.fecha as text),1,4) AS fecha,
                p.nombres || ' ' || p.apellidos AS vendedor,
                case 
                    when pr.estado=0 then 'REGISTRADO' 
                    when pr.estado=1 then 'ANULADO'
                    else 'PASO A SOLICITUD' 
                end AS estado
            FROM
                facturacion.proforma AS pr
                INNER JOIN cliente AS c ON c.idcliente = pr.idcliente
                INNER JOIN sucursales AS s ON s.idsucursal = pr.idsucursal
                INNER JOIN personal AS p ON p.idpersonal = pr.idvendedor
            WHERE
                pr.fecha BETWEEN CAST(:p1 AS DATE) AND CAST(:p2 AS DATE)
            ORDER BY pr.idcliente ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p1', $fechai , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $fechaf, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll();
        }
        
    }

    function reporte_detallado($g)
    {
        $periodo = (!isset($_SESSION['periodo'])) ? 'PERIODO 2014-I' : $_SESSION['periodo'];
        $idperiodo = (!isset($_SESSION['idperiodo'])) ? '1' : $_SESSION['idperiodo'];
        $sql = "SELECT p.idarea,p.nombres,p.apellidos,c.descripcion as consultorio 
                FROM personal as p inner join consultorio as c on 
                    c.idconsultorio = p.idarea
                WHERE p.idpersonal = :id ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();

        $idconsultorio = $r->idarea;
        $personal = $r->nombres.' '.$r->apellidos;
        $consultorio = $r->consultorio;

        $datos = array($personal, $consultorio, $periodo);

        $sql = "SELECT descripcion
                from valoresemp 
                where idpersonal = :id
                order by idvaloresemp ";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':id',$g['idp'],PDO::PARAM_INT);
        $stmt->execute();
        $data = array();
        
        foreach ($stmt->fetchAll() as $row) 
        {
            $data[] = array('descripcion'=>$row[0]);            
        }
       
        return array($data,$datos);
    }
}
?>