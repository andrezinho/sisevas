<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/funcionesuop.php';

class funcionesuopController extends Controller 
{   
    var $cols = array(
        1 => array('Name'=>'Codigo','NameDB'=>'f.idfuncionesuop','align'=>'center','width'=>40),
        2 => array('Name'=>'Unidad Operativa','NameDB'=>'c.descripcion','width'=>100,'search'=>true),
        3 => array('Name'=>'Perfil Ocup.','NameDB'=>'ca.descripcion','width'=>100,'search'=>true),
        4 => array('Name'=>'Funcion','NameDB'=>'f.descripcion','width'=>350,'search'=>true),
        5 => array('Name'=>'Estado','NameDB'=>'f.estado','align'=>'center','width'=>50),
        6 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>50)

    );

    public function index() 
    {        
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Funciones de la Unidad Operativa";
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(true,true,true,false);

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new funcionesuop();        
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
        $data['idconsultorio'] = $this->Select(array('id'=>'idconsultorio','name'=>'idconsultorio','text_null'=>'.:: Seleccione ::.','table'=>'vista_consultorio'));
        $data['idcargo'] = $this->Select(array('id'=>'idcargo','name'=>'idcargo','table'=>'vista_cargo')); 
        $data['eje'] = $this->Select(array('id'=>'idejecapacitacion','name'=>'idejecapacitacion','table'=>'capacitacion.vista_ejecap'));
        $view->setData($data);
        $view->setTemplate( '../view/funcionesuop/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new funcionesuop();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['idconsultorio'] = $this->Select(array('id'=>'idconsultorio','name'=>'idconsultorio','text_null'=>'.:: Seleccione ::.','table'=>'vista_consultorio','code'=>$obj->idconsultorio));
        $data['idcargo'] = $this->Select(array('id'=>'idcargo','name'=>'idcargo','table'=>'vista_cargo','code'=>$obj->idcargo));
        $data['eje'] = $this->Select(array('id'=>'idejecapacitacion','name'=>'idejecapacitacion','table'=>'capacitacion.vista_ejecap','code'=>$obj->idejecapacitacion));
        $view->setData($data);
        $view->setTemplate( '../view/funcionesuop/_form.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new funcionesuop();
        $result = array();        
        if ($_POST['idfuncionesuop']=='') 
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
        $obj = new funcionesuop();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    public function getFuncionesxArea()
    {
        $obj = new funcionesuop();        
        $rows = $obj->getFuncionesxArea($_GET);
        print_r(json_encode($rows));
    }

    public function getEjes()
    {
        $obj = new funcionesuop();        
        $rows = $obj->getEjes($_GET);
        print_r(json_encode($rows));
    }
 
}

?>