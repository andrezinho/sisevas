<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/capacitacion.php';

class capacitacionController extends Controller
{
    var $cols = array(
                1 => array('Name'=>'Item','NameDB'=>'s.idcapacitacion','align'=>'center','width'=>'20'),
                2 => array('Name'=>'Codigo','NameDB'=>'codigo','width'=>'60','search'=>true),
                3 => array('Name'=>'Tema','NameDB'=>'tema','width'=>'150','search'=>true),
                4 => array('Name'=>'Fuente','NameDB'=>'f.descripcion','width'=>'120'),
                5 => array('Name'=>'Eje Cap.','NameDB'=>'e.descripcion ','width'=>'140','align'=>'left'),
                6 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>'60')
                
             );
    
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];

        $data['titulo'] = "Crear Capacitacion";
        $data['script'] = "evt_index_capacitacion.js";
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
        $obj = new capacitacion();        
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
        $data['objcap'] = $this->Select(array('id'=>'idobejtivoscap','name'=>'idobejtivoscap','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_objetivoscap'));
        $data['perfilocup'] = $this->Select(array('id'=>'idtipopersonal','name'=>'idtipopersonal','text_null'=>':: Seleccione ::','table'=>'vista_tipopersonal'));
        $data['tipoeva'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','text_null'=>':: Seleccione ::','table'=>'seguridad.vista_perfil'));
        $data['metodo'] = $this->Select(array('id'=>'idmetodoscapacitacion','name'=>'idmetodoscapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_metodoscap'));
                             
        $view->setData($data);
        $view->setTemplate( '../view/capacitacion/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new capacitacion();
        $data = array();
        $view = new View();
        $estado = $this->getEstado("capacitacion.capacitacion","idcapacitacion",$_GET['id']);
        if($estado==0)
        {
            $rows = $obj->edit($_GET['id']); 
            $data['obj'] = $rows;
            //print_r($rows);
            $data['fuente'] = $this->Select(array('id'=>'idfuentecapacitacion','name'=>'idfuentecapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_fuentecap','code'=>$rows->idfuentecapacitacion));
            $data['eje'] = $this->Select(array('id'=>'idejecapacitacion','name'=>'idejecapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_ejecap','code'=>$rows->idejecapacitacion));
            $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>':: Seleccione ::','table'=>' vista_obejtivosemp','code'=>$rows->idobejtivosemp));
            $data['objcap'] = $this->Select(array('id'=>'idobejtivoscap','name'=>'idobejtivoscap','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_objetivoscap','code'=>$rows->idobejtivoscap));
            $data['perfilocup'] = $this->Select(array('id'=>'idtipopersonal','name'=>'idtipopersonal','text_null'=>':: Seleccione ::','table'=>'vista_tipopersonal','code'=>$rows->idalcance));
            $data['tipoeva'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','text_null'=>':: Seleccione ::','table'=>'seguridad.vista_perfil','code'=>$rows->idtipoevaluacion));
            $data['metodo'] = $this->Select(array('id'=>'idmetodoscapacitacion','name'=>'idmetodoscapacitacion','text_null'=>':: Seleccione ::','table'=>'capacitacion.vista_metodoscap','code'=>$rows->idmetodoscapacitacion));
            
            $data['rowsd'] = $obj->getDetails($rows->idcapacitacion);
            $view->setData($data);
            $view->setTemplate( '../view/capacitacion/_form.php' );
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
        $obj = new capacitacion();
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
        $obj = new capacitacion();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));

    
    }

    public function end()
    {
        $obj = new capacitacion();
        $result = array();        
        $p = $obj->end($_POST['i']);
        if ($p[0]=="1") $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
   
}

?>