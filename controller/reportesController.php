<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/reportes.php';
class reportesController extends Controller 
{
    public function rep01() 
    {
        //Reporte
        $data = array();
        $view = new View();
        $data['periodo'] = $this->Select(array('name'=>'idperiodo','id'=>'idperiodo','table'=>'evaluacion.vperiodo'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep01.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function rep02() 
    {
        //Reporte
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep02.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function data_rep02()
    {
        //
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep02($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep02_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep02.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }

    public function rep03() 
    {
        //Reporte
        $data = array();
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep03.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function data_rep03()
    {
        //
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep05($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep03_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep03.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function rep05() 
    {
        $data = array();
        $view = new View();
        //$data['tipoalc'] = $this->Select(array('id'=>'idtipoalcance','name'=>'idtipoalcance','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_tipoalcance','code'=>$rows->idtipoalcance));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep05.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_rep05()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep05($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep05_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep05.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function rep06() 
    {
        $data = array();
        $view = new View();
        $data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep06.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_rep06()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep06($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep06_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep06.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function rep07() 
    {
        $data = array();
        $view = new View();
        //$data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep07.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_rep07()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep07($_GET);        
        $data['rows'] = $result[0];
        $data['tp'] = $result[1];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep07_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep07.php');
        $view->setLayout('../template/empty.php');
        return $view->render();        
    }
    
    public function rep08() 
    {
        $data = array();
        $view = new View();
        //$data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep08.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_rep08()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep08($_GET);        
        $data['rows'] = $result[0];
        $data['tp'] = $result[1];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep08_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep08.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function rep09() 
    {
        $data = array();
        $view = new View();
        //$data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep09.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_rep09()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep09($_GET);        
        $data['rows'] = $result[0];
        $data['tt'] = $result[1];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep09_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep09.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function rep10() 
    {
        $data = array();
        $view = new View();
        //$data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_rep10.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_rep10()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep10($_GET);        
        $data['rows'] = $result[0];
        $data['tt'] = $result[1];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep10_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep10.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function vacaciones() 
    {
        $data = array();
        $view = new View();
        //$data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_vacaciones.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_vacaciones()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rep10($_GET);        
        $data['rows'] = $result[0];
        $data['tt'] = $result[1];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep10_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_vacaciones.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function rankingeva() 
    {
        $data = array();
        $view = new View();
        $data['periodo'] = $this->Select(array('name'=>'idperiodo','id'=>'idperiodo','table'=>'evaluacion.vperiodo'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_ranking.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
        
    }
    
    public function data_rankingeva()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_rankingeva($_GET);        
        $data['rows'] = $result[0];
        $data['tt'] = $result[1];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_rpt_ranking_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_vacaciones.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function parametros() 
    {
        $data = array();
        $view = new View();
        //$data['competencias'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Todos ::','table'=>'vista_tipodocumento'));
        $data['competencias1'] = $this->Select(array('id'=>'idcompetencia1','name'=>'idcompetencia1','table'=>'evaluacion.competencias'));
        $data['competencias2'] = $this->Select(array('id'=>'idcompetencia2','name'=>'idcompetencia2','table'=>'evaluacion.competencias'));
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_parametros.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    
    public function data_parametros()
    {
        $obj = new reportes();
        $data = array();
        $result = $obj->data_parametros($_GET);        
        $data['rows'] = $result[0];
        $data['dat0'] = $result[1];
        $data['dat1'] = $result[2];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_rpt_parametros_pdf.php');
        else
            $view->setTemplate('../view/reportes/_rpt_parametros.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
}
?>