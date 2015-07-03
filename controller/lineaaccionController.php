<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/lineaaccion.php';

class lineaaccionController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'idlineaaccionacitacion','align'=>'center','width'=>'20'),
                        2 => array('Name'=>'Descripcion','NameDB'=>'descripcion','search'=>true),                        
                        3 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'30','align'=>'center')
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Linea de Accion";
        
        $data['actions'] = array(true,true,true,false);

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new lineaaccion();        
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
        //$data['Area'] = $this->Select(array('id'=>'idarea','name'=>'idarea','text_null'=>'Seleccione...','table'=>'vista_area'));       
        $view->setData($data);
        $view->setTemplate( '../view/lineaaccion/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new lineaaccion();
        $data = array();
        $view = new View();
        $rows = $obj->edit($_GET['id']);
        $data['obj'] = $rows; 
        //$data['rowsd'] = $obj->getDetails($rows->idlineaaccionacitacion);
        $view->setData($data);
        $view->setTemplate( '../view/lineaaccion/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new lineaaccion();
        $result = array();        
        if ($_POST['idlineaaccion']=='') 
        
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
        $obj = new lineaaccion();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    public function get()
    {
        $obj = new lineaaccion();
        $data = array();        
        $field = "descripcion";
        if($_GET['tipo']==1) $field = "dni";
        $value = $obj->get($_GET["term"],$field);

        $result = array();
        foreach ($value as $key => $val) 
        {
              array_push($result, array(
                        "idlineaaccion"=>$val['idlineaaccion'],
                        "descripcion"=> $val['descripcion']
                    )
                );
              if ( $key > 7 ) { break; }
        }
        print_r(json_encode($result));
    }
    
    public function getTemas()
    {
        $obj = new lineaaccion();        
        $rows = $obj->getTemas($_GET);
        print_r(json_encode($rows));
    }

}

?>