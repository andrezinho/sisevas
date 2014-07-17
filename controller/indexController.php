<?php

require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/index.php';
require_once '../model/sistema.php';

class IndexController extends Controller 
{    
    public function Index() 
    {
        $Index = new Index();        
        $data = array();
        $data['html'] = $Index->index();
        $view = new View();
        $view->setData( $data );
        $view->setTemplate( '../view/_index.php' );
        $view->setLayout( '../template/layout.php');
        $view->render();
    }
    
    public function Menu()
    {
        $objsistema = new Sistema();
        print_r(json_encode($objsistema->menu()));
    }
    
    //Ver todo el index desde la BD
    public function VerIndex()
    {
        $obj = new Index();
        $data = array();
        $view = new View();
        $ro = $obj->viewIndex();
        $data['mv'] = $ro[0];
        $data['obejtivosemp'] = $ro[1];
        $data['obejtivoscal'] = $ro[2];
        $data['valoresemp'] = $ro[3];
        $data['politica'] = $ro[4];
        $view->setData($data);
        $view->setTemplate( '../view/_index.php' );
        $view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();
    }
}
?>