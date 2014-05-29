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
}
?>