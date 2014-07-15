<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/valoresemp.php';

class valoresempController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'idvaloresemp','align'=>'center','width'=>'40'),
                        2 => array('Name'=>'Valor','NameDB'=>'valor','width'=>'100','search'=>true),
                        3 => array('Name'=>'Descripcion','NameDB'=>'descripcion','align'=>'left'),                       
                        4 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'50','align'=>'center')
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Valores de la Empresa";
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
        $obj = new valoresemp();        
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
        $view->setData($data);
        $view->setTemplate( '../view/valoresemp/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new valoresemp();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        
        $data['obj'] = $obj;        
        $view->setData($data);
        $view->setTemplate( '../view/valoresemp/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new valoresemp();
        $result = array();        
        if ($_POST['idvaloresemp']=='') 
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
        $obj = new valoresemp();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    //imprmir reporte
    public function reporte_detallado()
    {
        $obj = new valoresemp();
        $data = array();
        $result = $obj->reporte_detallado($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];        
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/valoresemp/_reporte.php');
        $view->setLayout('../template/evaluacion.php');
        return $view->render();
    }
   
}

?>