<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/tareas.php';

class tareasController extends Controller 
{   
    var $cols = array(
        1 => array('Name'=>'Cod.','NameDB'=>'idtareas','width'=>25,'align'=>'center'),
        2 => array('Name'=>'Personal','NameDB'=>"p.nombres||' '||p.apellidos",'width'=>80,'search'=>true),
        3 => array('Name'=>'Tarea','NameBD'=>'t.tarea','width'=>120,'search'=>true),
        4 => array('Name'=>'Fecha Reg.','NameBD'=>'t.fechareg','width'=>30,'search'=>true,'align'=>'center'),
        5 => array('Name'=>'Importancia','NameDB'=>'t.estado','width'=>30,'align'=>'center')
    );

    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Tareas para Informe Memoria";
        
        $data['actions'] = array(true,true,false,true);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }
    
    public function indexGrid() 
    {
        $obj = new tareas();        
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
        $data['ejes'] = $this->Select(array('name'=>'idejecapacitacion','id'=>'idejecapacitacion','text_null'=>'.:: Seleccione ::.','table'=>'capacitacion.vista_ejecap'));
        $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>'.:: Seleccione ::.','table'=>' vista_obejtivosemp'));
        $data['mediosverif'] = $this->Select(array('id'=>'idmediosverificacion','name'=>'idmediosverificacion','text_null'=>'.:: Seleccione ::.','table'=>'calidad.vista_mediosver'));
        $data['importancia'] = $this->Select(array('id'=>'idimportancia','name'=>'idimportancia','text_null'=>'.:: Seleccione ::.','table'=>'vista_importancia'));
        $view->setData($data);
        $view->setTemplate( '../view/tareas/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new tareas();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $IdPerReg= $_SESSION['idusuario'];
        $verId = $this->getVerificar("calidad.tareas","idtareas",$_GET['id']);
        if($verId== $IdPerReg)
        {
            
            $data['obj'] = $obj;
            $data['ejes'] = $this->Select(array('name'=>'idejecapacitacion','id'=>'idejecapacitacion','table'=>'capacitacion.vista_ejecap','code'=>$obj->idejecapacitacion));
            $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>'.:: Seleccione ::.','table'=>' vista_obejtivosemp','code'=>$obj->idobejtivosemp));
            $data['mediosverif'] = $this->Select(array('id'=>'idmediosverificacion','name'=>'idmediosverificacion','text_null'=>'.:: Seleccione ::.','table'=>'calidad.vista_mediosver','code'=>$obj->idmediosverificacion));
            $data['importancia'] = $this->Select(array('id'=>'idimportancia','name'=>'idimportancia','text_null'=>'.:: Seleccione ::.','table'=>'vista_importancia','code'=>$obj->idimportancia));
            $view->setData($data);
            $view->setTemplate( '../view/tareas/_form.php' );
            echo $view->renderPartial();
        }
        else
            {
            ?>
            <script type="text/javascript"> 
                alert('Usted no esta autorizado para Actualizarlo');
                reload();
            </script>
            <?php
               
            }
        
    }
    
    public function view() 
    {
        $obj = new tareas();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['ejes'] = $this->Select(array('name'=>'idejecapacitacion','id'=>'idejecapacitacion','table'=>'capacitacion.vista_ejecap','code'=>$obj->idejecapacitacion));
        $data['objemp'] = $this->Select(array('id'=>'idobejtivosemp','name'=>'idobejtivosemp','text_null'=>'.:: Seleccione ::.','table'=>' vista_obejtivosemp','code'=>$obj->idobejtivosemp));
        $data['mediosverif'] = $this->Select(array('id'=>'idmediosverificacion','name'=>'idmediosverificacion','text_null'=>'.:: Seleccione ::.','table'=>'calidad.vista_mediosver','code'=>$obj->idmediosverificacion));
        $data['importancia'] = $this->Select(array('id'=>'idimportancia','name'=>'idimportancia','text_null'=>'.:: Seleccione ::.','table'=>'vista_importancia','code'=>$obj->idimportancia));
        $view->setData($data);
        $view->setTemplate( '../view/tareas/_form.php' );
        echo $view->renderPartial();
    }
    
    public function getVerificar($tabla,$campo,$id)
    {
        $obj = new tareas();
        $estado = $obj->getVer($tabla,$campo,$id);
        return $estado;
    }
    
    public function save()
    {
        $obj = new tareas();
        $result = array();        
        if ($_POST['idtareas']=='') 
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
        $obj = new tareas();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function getTareas()
    {
        $obj = new tareas();
        $rows = $obj->getTareas($_GET);
        print_r(json_encode($rows));
    }
}
?>