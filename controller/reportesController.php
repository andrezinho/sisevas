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
        /*$obj = new reportes();
        $data = array();
        $result = $obj->data_rep07($_GET);
        //$data['datos'] = $result[1];
        //$data['rows'] = $result[0];
        //$view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep07_pdf.php');
        else
            $view->setTemplate('../view/reportes/_reporte_rep07.php');
        //$view->setLayout('../template/empty.php');
        //return $view->render();
        echo $view->renderPartial();*/
        
        $obj = new reportes();
        $data = array();
        $view = new View();
        $data['rowsd'] = $obj->data_rep07($_GET);
        //$data['idalmacen']= $_GET['idalm'];
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_reporte_rep07.php' );
        echo $view->renderPartial();
    }
}
?>