<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/misionvision.php';

class misionvisionController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'idmisionvision','align'=>'center','width'=>'20'),
                        2 => array('Name'=>'Mision','NameDB'=>'mision','search'=>true),
                        3 => array('Name'=>'Vision','NameDB'=>'Vision','search'=>true),
                        4 => array('Name'=>'Estado','NameDB'=>'estado','width'=>'30','align'=>'center')
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
		$data['titulo'] = "Mison y Vision";
		
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
        $obj = new misionvision();        
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
        $view->setTemplate( '../view/misionvision/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new misionvision();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $view->setData($data);
        $view->setTemplate( '../view/misionvision/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new misionvision();
        $result = array();        
        if ($_POST['idmisionvision']=='') 
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
        $obj = new misionvision();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    public function loadfile()
    {
        
        if (!empty($_FILES)) 
        {
            $tempFile = $_FILES['Filedata']['tmp_name'];                          // 1
            $fileparts = pathinfo($_FILES['Filedata']['name']);
            $ext = $fileparts['extension'];

            //$targetPath = 'doc/';  
            $targetPath = 'images/index/';  
            $filetypes = array("pdf","doc","png","jpeg","jpg");
            $flag = false;
            foreach($filetypes as $typ)
            {
                if($typ==strtolower($ext))
                {
                        $flag = true;
                }
            }    
            if($flag)
            {
                $targetFile =  str_replace('//','/',$targetPath).str_replace(' ','_',$_FILES['Filedata']['name']);
                $name = str_replace(' ','_',$_FILES['Filedata']['name']);
                if( move_uploaded_file($tempFile,$targetFile))
                {	
                    echo "1###".$name;
                    chmod($targetFile, 0777);
                }
                else
                {
                    echo "0###Error";
                }
            }
            else 
            {
                echo "0###Extension no apcetada ".$typ;
            }    

        }
        else {
            echo "KO";
        }
    }
    
    public function loadfile_v()
    {
        
        if (!empty($_FILES)) 
        {
            $tempFile = $_FILES['Filedata']['tmp_name'];                          // 1
            $fileparts = pathinfo($_FILES['Filedata']['name']);
            $ext = $fileparts['extension'];

            //$targetPath = 'doc/';  
            $targetPath = 'images/index/';  
            $filetypes = array("pdf","doc","png","jpeg","jpg");
            $flag = false;
            foreach($filetypes as $typ)
            {
                if($typ==strtolower($ext))
                {
                        $flag = true;
                }
            }    
            if($flag)
            {
                $targetFile =  str_replace('//','/',$targetPath).str_replace(' ','_',$_FILES['Filedata']['name']);
                $name = str_replace(' ','_',$_FILES['Filedata']['name']);
                if( move_uploaded_file($tempFile,$targetFile))
                {	
                    echo "1###".$name;
                    chmod($targetFile, 0777);
                }
                else
                {
                    echo "0###Error";
                }
            }
            else 
            {
                echo "0###Extension no apcetada ".$typ;
            }    

        }
        else {
            echo "KO";
        }
    }
   
}

?>