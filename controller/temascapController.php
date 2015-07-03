<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/temascap.php';

class temascapController extends Controller 
{   
    var $cols = array(
        1 => array('Name'=>'Codigo','NameDB'=>'a.idtemas','width'=>20,'align'=>'center'),
        2 => array('Name'=>'Linea de Accion','NameDB'=>'c.descripcion','width'=>80,'search'=>true),
        3 => array('Name'=>'Descripcion','NameBD'=>'a.descripcion','width'=>80,'search'=>true),
        4 => array('Name'=>'Estado','NameDB'=>'a.estado','width'=>25,'align'=>'center')
    );

    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Temas para Capacitaciones";
        
        $data['actions'] = array(true,true,false,false);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }
    
    public function indexGrid() 
    {
        $obj = new temascap();        
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
        $data['lineas'] = $this->Select(array('name'=>'idlineaaccion','id'=>'idlineaaccion','table'=>'capacitacion.vista_lineaaccion'));
        $view->setData($data);
        $view->setTemplate( '../view/temascap/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new temascap();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['lineas'] = $this->Select(array('name'=>'idlineaaccion','id'=>'idlineaaccion','table'=>'capacitacion.vista_lineaaccion','code'=>$obj->idlineaaccion));
        $view->setData($data);
        $view->setTemplate( '../view/temascap/_form.php' );
        echo $view->renderPartial();
    }
    
    public function save()
    {
        $obj = new temascap();
        $result = array();        
        if ($_POST['idtemas']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);                                
        if ($p[0])                
            $result = array(1,'');                
        else                 
            $result = array(2,$p[1]);
        print_r(json_encode($result));

    }
    
    public function delete()
    {
        $obj = new temascap();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function getAspectos()
    {
        $obj = new temascap();
        $options = $obj->getAspectos($_GET['idc']);
        print_r(json_encode($options));
    }
}
?>