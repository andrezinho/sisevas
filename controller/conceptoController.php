<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/concepto.php';

class ConceptoController extends Controller
{
    var $cols = array(
        1 => array('Name'=>'Codigo','NameDB'=>'idconcepto','align'=>'center','width'=>'20'),
        2 => array('Name'=>'Descripcion','NameDB'=>'descripcion','search'=>true),
        3 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'30','align'=>'center','color'=>'#FFFFFF')
     );
    
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];

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
        $obj = new Concepto();        
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
        $view->setTemplate( '../view/Concepto/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new Concepto();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/Concepto/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new Concepto();
        $result = array();        
        if ($_POST['idconcepto']=='') 
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
        $obj = new Concepto();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    public function get()
    {
        $obj = new Concepto();
        $data = array();        
        $field = "nombres";
        if($_GET['tipo']==1) $field = "descripcion";
        $value = $obj->get($_GET["term"],$field);

        $result = array();
        foreach ($value as $key => $val) 
        {
            array_push($result, array(
                      "idconcepto"=>$val['idconcepto'],
                      "descripcion"=>$val['descripcion']

                  )
            );
            if ( $key > 7 ) { break; }
        }
        print_r(json_encode($result));
    }
    
    public function getList()
    {
        $obj = new Concepto();
        $idconcepto = (int)$_GET['id'];
        $rows = $obj->getList($idconcepto);
        print_r(json_encode($rows));
    }
   
}

?>