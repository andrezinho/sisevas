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
}
?>