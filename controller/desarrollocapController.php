<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/desarrollocap.php';

class desarrollocapController extends Controller
{
    var $cols = array(
                1 => array('Name'=>'Item','NameDB'=>'s.idcapacitacion','align'=>'center','width'=>'25'),
                2 => array('Name'=>'Tema','NameDB'=>'tema','search'=>true,'width'=>'180'), 
                3 => array('Name'=>'Expositor','NameDB'=>'c.expositor','width'=>'150'),
                4 => array('Name'=>'Fecha Cap.','NameDB'=>'e.descripcion ','width'=>'60','align'=>'center'),
                5 => array('Name'=>'Est.','NameDB'=>'','align'=>'center','width'=>'50'),
                6 => array('Name'=>'Imp. Cap.','NameDB'=>'','align'=>'center','width'=>'50'),
                7 => array('Name'=>'Imp. Act.','NameDB'=>'','align'=>'center','width'=>'50')
             );
    
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];

        $data['titulo'] = "Desarrollo de la Capacitacion";
        $data['script'] = "evt_index_desarrollocap.js";
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(false,true,false,false);

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new desarrollocap();        
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

    public function edit() {
        $obj = new desarrollocap();
        $data = array();
        $view = new View();
        $estado = $this->getEstado("capacitacion.capacitacion","idcapacitacion",$_GET['id']);
        //if($estado==0)
        //{
            $rows = $obj->edit($_GET['id']); 
            $data['obj'] = $rows;
            $rowsAsist = $this->getAsistentes(array('id'=>$rows->idcapacitacion));
            $data['personalasis'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>':: Seleccione ::','table'=>$rowsAsist));
            $data['tipoeva'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','text_null'=>':: Seleccione ::','table'=>'seguridad.vista_perfil','code'=>$rows->idtipoevaluacion));
            
            $data['rowsac'] = $obj->getAcuerdos($rows->idcapacitacion);
            $view->setData($data);
            $view->setTemplate( '../view/desarrollocap/_form.php' );
            echo $view->renderPartial();
        //}
            //else
            //{
                //$view = new View();
                //$data['msg'] = "<b>Esta Capacitacion ya no es ediable. Bien ya fue asignada o Finalizada</b><br/><br/>";
                //$view->setData($data);
                //$view->setTemplate( '../view/_error_app.php' );
                //echo $view->renderPartial();
            //}
        
        
    }

    public function save()
    {
        $obj = new desarrollocap();
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
        $obj = new desarrollocap();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));

    
    }

    public function end()
    {
        $obj = new desarrollocap();
        $result = array();        
        $p = $obj->end($_POST['i']);
        if ($p[0]=="1") $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    public function VerNroActa()
    {
        $obj = new desarrollocap();        
        $rows = $obj->VerNroActaSql($_GET['idcap']);                               
        print_r(json_encode($rows));
    }
    
    public function printeract()
    {
        $obj = new desarrollocap();
        $data = array();
        $view = new View();
        $ro = $obj->printDoc($_GET['id']);
        //$res= $obj->printPre($_GET['id']);
        $data['cab']    = $ro[0];
        $data['acuerdo']= $ro[1];
        $data['asig']   = $ro[2];
        //$data['rowsd']  = $res;
        $view->setData($data);
        $view->setTemplate( '../view/desarrollocap/_actapdf.php' );
        //$view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();
    }
}

?>