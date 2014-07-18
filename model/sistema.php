<?php
/*session_start();*/
include_once("Main.php");
class Sistema extends Main
{
    function menu()
    {
        $stmt = $this->db->prepare("SELECT * from seguridad.view_menupadres where idperfil = :p1");
        $stmt->bindValue(':p1', $_SESSION['id_perfil'] , PDO::PARAM_INT);
        $stmt->execute();
        $items = $stmt->fetchAll();
        $cont = 0; 
        $cont2 = 0;
        foreach ($items as $valor)
        {
            $stmt = $this->db->prepare("SELECT * from seguridad.view_menuhijos where idpadre=".$valor['idmodulo']." and idperfil=:p1");
            $stmt->bindValue(':p1', $_SESSION['id_perfil'] , PDO::PARAM_INT);
            $stmt->execute();
            $hijos = $stmt->fetchAll();
            $url = "";
            if(trim($valor['url'])=="") { $url = "#"; }
            else {
                    $url = $valor['url'];
                    if($valor['controlador']!="")
                    {
                        if($valor['accion']=="")
                        {
                            $url .= "?controller=".$valor['controlador'];
                        }
                        else 
                        {
                            $url .= "?controller=".$valor['controlador']."&action=".$valor['accion'];
                        }
                    }
                 }            
            $menu[$cont] = array(
                                'texto' => $valor['descripcion'],
                                'url' => $url,
                                'enlaces' => array()
                );
            $cont2 = 0;
            foreach($hijos as $h)
            {
                $urlm = "";
                if(trim($h['url'])=="") {$urlm = "#";}
                else {
                        $urlm = $h['url'];
                        if($h['controlador']!="")
                        {
                            if($h['accion']=="")
                            {
                                $urlm .= "?controller=".$h['controlador'];
                            }
                            else 
                            {
                                $urlm .= "?controller=".$h['controlador']."&action=".$h['accion'];
                            }
                        }
                     }
              $menu[$cont]['enlaces'][$cont2] = array('idmodulo'=>$h['idmodulo'],'texto' => $h['descripcion'],'url' => $urlm);
              $cont2 ++;
            }
            $cont ++;
        }
        return $menu;
    }    

     function viewIndex()
    {        
        $mv="SELECT
            misionvision.mision,
            misionvision.vision,
            misionvision.img_m,
            misionvision.img_v
            FROM
            public.misionvision";

        $stmt = $this->db->prepare($mv);            
        $stmt->execute();
        $mv= $stmt->fetch();
        
        
        $objemp="SELECT
            obejtivosemp.idobejtivosemp,
            obejtivosemp.descripcion,
            obejtivosemp.estado
            FROM
            public.obejtivosemp
            WHERE
            obejtivosemp.estado=1 ";

        $stmt1 = $this->db->prepare($objemp);
        $stmt1->execute();
        $obejtivosemp=$stmt1->fetchAll();
        
        $objcal="SELECT
            obejtivoscalidad.idobejtivoscalidad,
            obejtivoscalidad.descripcion,
            obejtivoscalidad.estado
            FROM
            public.obejtivoscalidad
            WHERE
            obejtivoscalidad.estado= 1 ";

        $stmt2 = $this->db->prepare($objcal);
        $stmt2->execute();
        $obejtivoscal=$stmt2->fetchAll();
        
        $valemp="SELECT
            valoresemp.idvaloresemp,
            valoresemp.valor,
            valoresemp.descripcion,
            valoresemp.estado
            FROM
            public.valoresemp
            WHERE
            valoresemp.estado= 1 ";

        $stmt3 = $this->db->prepare($valemp);
        $stmt3->execute();
        $valoresemp=$stmt3->fetchAll();
        
        $polcal="SELECT
            idpolitica_calidad,
            descripcion,
            img,
            estado
            FROM
            public.politica_calidad
            WHERE
            estado= 1 ";

        $stmt4 = $this->db->prepare($polcal);
        $stmt4->execute();
        $politica=$stmt4->fetchAll();
        
        return array($mv, $obejtivosemp, $obejtivoscal, $valoresemp, $politica);
    }
}

/*$obj = new Sistema();
print_r($obj->menu());*/
?>