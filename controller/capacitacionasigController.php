<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/capacitacionasig.php';

class capacitacionasigController extends Controller
{
    var $cols = array(
                1 => array('Name'=>'Item','NameDB'=>'s.idcapacitacion','align'=>'center','width'=>'25'),
                2 => array('Name'=>'Tema','NameDB'=>'tema','search'=>true,'width'=>'160'),                
                3 => array('Name'=>'Fuente','NameDB'=>'expositor','width'=>'150'),
                4 => array('Name'=>'Expositor','NameDB'=>'c.expositor','width'=>'150'),
                5 => array('Name'=>'Fecha Cap.','NameDB'=>'e.descripcion ','width'=>'60','align'=>'center'),
                6 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>'70'),
                7 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>'40')
             );
    
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Asignacion de Capacitacion";
        $data['script'] = "evt_index_capacitacionasig.js";
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
        $obj = new capacitacionasig();        
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
        $obj = new capacitacionasig();
        $data = array();
        $view = new View();
        $estado = $this->getEstado("capacitacion.capacitacion","idcapacitacion",$_GET['id']);
        if($estado!= 2)
        {

            $rows = $obj->edit($_GET['id']);         
            $data['obj'] = $rows;
            //print_r($rows);
            $data['fuente'] = $this->Select(array('id'=>'idfuentecapacitacion','name'=>'idfuentecapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_fuentecap','code'=>$rows->idfuentecapacitacion));
            $data['eje'] = $this->Select(array('id'=>'idejecapacitacion','name'=>'idejecapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_ejecap','code'=>$rows->idejecapacitacion));
            $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>':: Seleccione ::','table'=>' vista_obejtivosemp'));
            $data['objcap'] = $this->Select(array('id'=>'idobejtivoscap','name'=>'idobejtivoscap','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_objetivoscap','code'=>$rows->idobejtivoscap));
            $data['tipoeva'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','text_null'=>':: Seleccione ::','table'=>'seguridad.vista_perfil','code'=>$rows->idtipoevaluacion));
            $data['tipoalc'] = $this->Select(array('id'=>'idtipoalcance','name'=>'idtipoalcance','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_tipoalcance','code'=>$rows->idtipoalcance));
            $data['metodo'] = $this->Select(array('id'=>'idmetodoscapacitacion','name'=>'idmetodoscapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_metodoscap','code'=>$rows->idmetodoscapacitacion));
            $data['personal'] = $this->Select(array('id'=>'idpersonalasig','name'=>'idpersonalasig','text_null'=>'Seleccione...','table'=>'vista_personal')); 
            
            $data['rowsd'] = $obj->getDetails($rows->idcapacitacion);
            $data['rowsA'] = $obj->getDetailsAsig($rows->idcapacitacion);
            $view->setData($data);
            $view->setTemplate( '../view/capacitacionasig/_form.php' );
            echo $view->renderPartial();
        }
            else
            {
                $view = new View();
                $data['msg'] = "<b>Esta Capacitacion ya no es ediable. Bien ya fue asignada o Finalizada</b><br/><br/>";
                $view->setData($data);
                $view->setTemplate( '../view/_error_app.php' );
                echo $view->renderPartial();
            }
    }

    public function save()
    {
        $obj = new capacitacionasig();
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

    //Imprimir 
    public function printer()
    {
        $obj = new capacitacionasig();
        $data = array();
        $view = new View();
        $ro = $obj->printDoc($_GET['id']);
        $data['cab'] = $ro[0];
        $data['objemp'] = $ro[1];
        $data['asig'] = $ro[2];
        $view->setData($data);
        $view->setTemplate( '../view/capacitacionasig/_cappdf.php' );
        $view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();
    }
   
   
}

?>