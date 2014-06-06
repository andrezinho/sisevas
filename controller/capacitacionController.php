<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/capacitacion.php';

class capacitacionController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'s.idcapacitacion','align'=>'center','width'=>'20'),
                        2 => array('Name'=>'Descripcion','NameDB'=>'s.descripcion','search'=>true),
                        3 => array('Name'=>'Estado','NameDB'=>'s.estado','width'=>'30','align'=>'center','color'=>'#FFFFFF')
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
        $obj = new Rutas();        
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
        $data['fuente'] = $this->Select(array('id'=>'idfuentecapacitacion','name'=>'idfuentecapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_fuentecap'));
        $data['eje'] = $this->Select(array('id'=>'idejecapacitacion','name'=>'idejecapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_ejecap'));
        $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>':: Seleccione ::','table'=>' vista_obejtivosemp'));
        $data['objcap'] = $this->Select(array('id'=>'idobejtivoscap','name'=>'idobejtivoscap','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_objetivosca'));
                               
        $view->setData($data);
        $view->setTemplate( '../view/capacitacion/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new Rutas();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $data['more_options'] = $this->more_options('area');
        $view->setData($data);
        $view->setTemplate( '../view/capacitacion/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new Rutas();
        $result = array();        
        if ($_POST['idcapacitacion']=='') 
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
        $obj = new Rutas();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
   
}

?>