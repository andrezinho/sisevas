<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/consultas.php';

class ConsultasController extends Controller 
{   
    
    public function informe() 
    {        
        $data = array();
        $view = new View();
        $data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_informe.php' );       
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }

    public function data_informe()
    {
        //
        $obj = new Consultas();
        $data = array();
        $result = $obj->data_informe($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];
        $view = new View();
        $view->setData($data);
        if($_GET['tipo']=="pdf")
            $view->setTemplate('../view/reportes/_reporte_rep03_pdf.php');
        else
            $view->setTemplate('../view/consultas/_data_informe.php');
        $view->setLayout('../template/empty.php');
        return $view->render();
    }
    
    public function hojaruta() 
    {        
        $data = array();
        $view = new View();
        $data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_hojaruta.php' );       
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }

    public function ingresos() 
    {        
        $data = array();
        $view = new View();
        //$data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_ingresos.php' );       
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }

    public function produccion() 
    {        
        $data = array();
        $view = new View();
        //$data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_produccion.php' );       
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }

    public function stock() 
    {        
        $data = array();
        $view = new View();
        $data['almacen'] = $this->Select(array('id'=>'idalmacen','name'=>'idalmacen','text_null'=>'.: Seleccione :.','table'=>'produccion.vista_almacen'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_stockproductos.php' );       
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }

    public function ventas() 
    {        
        $data = array();
        $view = new View();
        $data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_ventas.php' );       
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
}

?>