<?php
include_once("Main.php");

class Index extends Main {    
    public function index()
    {
        return array('body'=>'<p>CUERPO DE LA PAGINA :) </p>');
    }
    /*
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
        $mv= $stmt->fetchAll();
                
        $objemp="SELECT
            obejtivosemp.descripcion,
            obejtivosemp.estado,
            obejtivosemp.img
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
        
        return array($mv, $obejtivosemp, $obejtivoscal, $valoresemp, $politica, $objetempimg);
    }
    */

}


?>