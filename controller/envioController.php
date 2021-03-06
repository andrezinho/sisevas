<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/envio.php';

class EnvioController extends Controller 
{   
    var $cols = array(
        1 => array('Name'=>'Item','NameDB'=>'t.idtramite','align'=>'center','width'=>40),
        2 => array('Name'=>'Tipo Documento','NameDB'=>'td.descripcion','width'=>90,'search'=>true),
        3 => array('Name'=>'Codigo','NameDB'=>'t.codigo','search'=>true,'width'=>60),
        4 => array('Name'=>'Fecha Emision','NameDB'=>'t.fechainicio','align'=>'center','width'=>50),                        
        5 => array('Name'=>'Remitente','NameDB'=>"p.nombres||' '||p.apellidos",'align'=>'left','width'=>200),
        6 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>20)
    );

    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        
        $data['titulo'] = "Envio de Documentos";
        $data['script'] = "evt_index_envio.js";
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
        $obj = new Envio();        
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
        $data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Seleccione ::','table'=>'vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/envio/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Envio();
        $data = array();
        $view = new View();        
        $rows = $obj->edit($_GET['id']);
        $data['obj'] = $rows;
        $data['personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'Seleccione...','table'=>'vista_personal','code'=>$rows->idperdestinatario));        
        $data['remitente'] = $this->Select(array('id'=>'idperremitente','name'=>'idperremitente','text_null'=>'Seleccione...','table'=>'vista_remitente','code'=>$rows->idpersonalresp));        
        $data['tipodoc'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','text_null'=>':: Seleccione ::','table'=>'vista_tipodocumento','code'=>$rows->idtipo_documento));
        $data['tipoproblema'] = $this->Select(array('id'=>'idtipo_problema','name'=>'idtipo_problema','text_null'=>'Seleccione...','table'=>'vista_tipoproblema','code'=>$rows->idtipo_problema));
        $tp= $obj->idtipo_problema;
        if ($tp == 1) {
            $data['idareai'] = $this->Select(array('id'=>'idareai','name'=>'idareai','text_null'=>'Seleccione...','table'=>'vista_consultorio','code'=>$rows->idareai));
        }else
            {
                $data['idareai'] = $this->Select(array('id'=>'idareai','name'=>'idareai','text_null'=>'Seleccione...','table'=>'vista_personal','code'=>$rows->idpersonalresp));
            }
        
        $data['rowsd'] = $obj->getDetails($rows->idtramite,$rows->idtipo_documento);
        $view->setData($data);
        $view->setTemplate( '../view/envio/_devform.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new Envio();
        $result = array();        
        if ($_POST['idtramite']=='') 
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
        $obj = new Envio();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function reporte_detallado()
    {
        $obj = new Envio();
        $data = array();
        $result = $obj->reporte_detallado($_GET);
        $data['datos'] = $result[1];
        $data['rows'] = $result[0];        
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/envio/_reporte.php');
        $view->setLayout('../template/evaluacion.php');
        return $view->render();
    }
    
    public function nuevos()
    {
        $obj = new Envio();
        print_r(json_encode($obj->nuevos()));
    }
    
    public function getDocumentos()
    {
        $obj = new Envio();
        $data = array();        
        $field = "asunto";
        if($_GET['tipo']==1) $field = "codigo";
        $value = $obj->get($_GET["term"],$field);

        $result = array();
        foreach ($value as $key => $val) 
        {
            array_push($result, array(
                      "idtramite"=>$val['idtramite'],
                      "idtpdoc"=>$val['idtipo_documento'],
                      "codigo"=>$val['codigo'],
                      "asunto"=> $val['asunto'] 
                  )
              );
            if ( $key > 7 ) { break; }
        }
        print_r(json_encode($result));
    }
    


}
?>