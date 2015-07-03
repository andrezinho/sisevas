<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/informeme.php';

class informemeController extends Controller 
{   
    var $cols = array(
        1 => array('Name'=>'Item','NameDB'=>'i.idinforme','align'=>'center','width'=>'50'),
        2 => array('Name'=>'N° Reporte','NameDB'=>'i.codigo','width'=>'100'),
        3 => array('Name'=>'Personal','NameDB'=>'p.nombres','search'=>true,'width'=>'250'),        
        4 => array('Name'=>'Fecha Inicio','NameDB'=>'i.fehcaini','width'=>'80','align'=>'center'),
        5 => array('Name'=>'Fecha Fin','NameDB'=>'i.fehcafin','width'=>'100','align'=>'center'),
        6 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>'40')

    );

    public function index() 
    {        
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Funciones de la Unidad Operativa";
        $data['script'] = "evt_index_informeme.js";
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
        $obj = new informeme();        
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
        $data['eje'] = $this->Select(array('id'=>'idejecap','name'=>'idejecap','text_null'=>'.:: Seleccione ::.','table'=>'capacitacion.vista_ejecap'));
        $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>':: Seleccione ::','table'=>' vista_obejtivosemp'));
        $data['mediosverif'] = $this->Select(array('id'=>'idmediosverificacion','name'=>'idmediosverificacion','text_null'=>'.:: Seleccione ::.','table'=>'calidad.vista_mediosver'));
                              
        $view->setData($data);
        $view->setTemplate( '../view/informeme/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new informeme();
        $data = array();
        $view = new View();        
        $rows = $obj->edit($_GET['id']); 
        $data['obj'] = $rows;
        $data['idconsultorio'] = $this->Select(array('id'=>'idconsultorio','name'=>'idconsultorio','text_null'=>'.:: Seleccione ::.','table'=>'vista_consultorio','code'=>$rows->idconsultorio));
        $data['eje'] = $this->Select(array('id'=>'idejecap','name'=>'idejecap','text_null'=>'.:: Seleccione ::.','table'=>'capacitacion.vista_ejecap','code'=>$rows->idejecapacitacion));
        $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>':: Seleccione ::','table'=>' vista_obejtivosemp','code'=>$rows->idobejtivosemp));
        $data['mediosverif'] = $this->Select(array('id'=>'idmediosverificacion','name'=>'idmediosverificacion','text_null'=>'.:: Seleccione ::.','table'=>'calidad.vista_mediosver','code'=>$rows->idmediosverificacion));

        $data['rowsd'] = $obj->getDetails($rows->idinforme);
        $view->setData($data);
        $view->setTemplate( '../view/informeme/_form.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new informeme();
        $result = array();        
        if ($_POST['idinforme']=='') 
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
        $obj = new informeme();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));

    }
    
    public function correlativo()
    {
         $obj = new informeme();        
         $rows = $obj->GCorrelativo($_GET);
         print_r(json_encode($rows));
    }
    
    public function printer()
    {
        $obj = new informeme();
        $data = array();
        $view = new View();
        $ro = $obj->printDoc($_GET['id']);
        //$res= $obj->printPre($_GET['id']);
        $data['cab']    = $ro[0];
        //$data['objemp'] = $ro[1];
        $data['tar']   = $ro[1];
        //$data['rowsd']  = $res;
        $view->setData($data);
        $view->setTemplate( '../view/informeme/_infpdf.php' );
        //$view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();
    }
 
}

?>