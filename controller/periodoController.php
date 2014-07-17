
<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/periodo.php';

class periodoController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'idperiodo','align'=>'center','width'=>'20'),
                        2 => array('Name'=>'Descripcion','NameDB'=>'descripcion','search'=>true),
                        3 => array('Name'=>'Fecha Apertura','NameDB'=>'fecha_apertura','search'=>false,'width'=>'60','align'=>'center'),
                        4 => array('Name'=>'Fecha Cierre','NameDB'=>'fecha_cierre','search'=>false,'width'=>'60','align'=>'center'),
                        5 => array('Name'=>'Año','NameDB'=>'anio','search'=>true,'width'=>'40','align'=>'center'),
                        6 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'70','align'=>'center','color'=>'#FFFFFF')
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['actions'] = array(true,true,false,false);

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new periodo();        
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
        $data['more_options'] = $this->more_options('periodo');        
        $view->setData($data);
        $view->setTemplate( '../view/periodo/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new periodo();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $data['more_options'] = $this->more_options('periodo');
        $view->setData($data);
        $view->setTemplate( '../view/periodo/_form.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new periodo();
        $result = array();        
        if ($_POST['idperiodo']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);                                
        if ($p[0])                
            $result = array(1,'');                
        else                 
            $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    //Cierre de periodo
    public function close()
    {        
        $obj = new periodo();        
        $data = array();
        $view = new View();
        $obj = $obj->edit_();
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/periodo/_close.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }

    public function closeok()
    {
        $obj = new periodo();
        $result = array();        
        $p = $obj->closeok();
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
}
?>