<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/medioverificacion.php';

class medioverificacionController extends Controller 
{   
    var $cols = array(
        1 => array('Name'=>'Codigo','NameDB'=>'idmediosverificacion','align'=>'center','width'=>60),
        2 => array('Name'=>'Descripcion','NameDB'=>'descripcion','width'=>500,'search'=>true),
        6 => array('Name'=>'Estado','NameDB'=>'estado','align'=>'center','width'=>100)

     );

    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        //$data['script'] = "evt_index_verificacion.js";
        $data['titulo'] = "Medios de Verificacion";
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(true,true,false,true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }
    
    public function indexGrid() 
    {
        $obj = new medioverificacion();        
        $page = (int)$_GET['page'];
        $limit = (int)$_GET['rows']; 
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $filtro = $this->getColNameDB($this->cols,(int)$_GET['f']);        
        $query = $_GET['q'];
        if(!$sidx) $sidx = 1;
        if(!$limit) $limit = 10;
        if(!$page) $page = 1;
        echo json_encode($obj->indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$this->getColsVal($this->cols)));
    }

    public function create()
    {
        $data = array();
        $view = new View();        
        //$data['idsucursal'] = $this->Select(array('id'=>'idsucursal','name'=>'idsucursal','text_null'=>'Seleccione...','table'=>'vista_sucursal'));       
        $view->setData($data);
        $view->setTemplate( '../view/medioverificacion/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new medioverificacion();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj; 
        //$data['idsucursal'] = $this->Select(array('id'=>'idsucursal','name'=>'idsucursal','table'=>'vista_sucursal','code'=>$obj->idsucursal));   
        $view->setData($data);
        $view->setTemplate( '../view/medioverificacion/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new medioverificacion();
        $result = array();        
        if ($_POST['idmediosverificacion']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);                                
        if ($p[0]==1)                
            $result = array(1,'',$p[2]);                
        else                 
            $result = array(2,$p[1],'');
        print_r(json_encode($result));

    }

    public function delete()
    {
        $obj = new medioverificacion();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

}
?>