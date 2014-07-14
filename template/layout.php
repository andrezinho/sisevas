<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>SISTEMA DE EVALUACION DE DESEMPEÑO</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="expires" content="0" />
    <link type="text/css" href="css/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" />
    <link type="text/css" href="css/layout.css" rel="stylesheet" />
    <link href="css/cssmenu.css" rel="stylesheet" type="text/css" />
    <link href="css/style_forms.css" rel="stylesheet" type="text/css" />
    <link href="css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>    
    <script type="text/javascript" src="js/menus.js"></script>
    <script type="text/javascript" src="js/session.js"></script>
    <script type="text/javascript" src="js/required.js"></script>
    <script type="text/javascript" src="js/validateradiobutton.js"></script>
    <script type="text/javascript" src="js/utiles.js"></script>
    <script type="text/javascript" src="js/js-layout.js"></script>
    <script type="text/javascript" src="js/pag.js"></script>
    <script type="text/javascript" src="js/jquery.jqGrid.min.js"></script> 
    <!-- <script type="text/javascript" src="js/jquery.jqGrid.src.js"></script> -->
    <script type="text/javascript" src="js/grid.locale-es.js"></script>
    <!-- prefix free to deal with vendor prefixes -->
    <script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript" type="text/javascript"></script>    
    <script src="js/jquery.uploadify.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="css/uploadify.css"></link>
<!--
    <script type="text/javascript">        
        
        $(function () {
            $("#tabsindex").tabs({ collapsible: false });
        });

    </script>
 -->
 
 <script type="text/javascript">
 jQuery(document).ready(function($) {
 
    $('#tabsindex .tabscontent>div').not('div:first').hide();
    $('#tabsindex ul li:first,#tabsindex .tabscontent>div:first').addClass('active');
 
    $('#tabsindex ul li a').click(function(){
 
        var currentTab = $(this).parent();
        if(!currentTab.hasClass('active')){
            $('#tabsindex ul li').removeClass('active');             
 
            $('#tabsindex .tabscontent>div').slideUp('fast').removeClass('active');
 
            var currentcontent = $($(this).attr('href'));
            currentcontent.slideDown('fast', function() {
                currentTab.addClass('active');
                currentcontent.addClass('active');
            });
        }
        return false;                           
    });
});
 </script>   
<style type="text/css">
    .content *:first-child {margin-top: 0;}
    .content *:last-child {margin-bottom: 0;}
     
    /*clearfix*/
    .clearfix:before, .clearfix:after { display: table; content: ""; }
    .clearfix:after { clear: both; }
    .clearfix { zoom: 1; }
     
    /*tabs ul*/
    .tabsindex ul{
        margin: 0;padding: 0;
    }
     
    /*tabs li*/
    .tabsindex li { 
        position: relative; 
        display: inline-block; 
        margin: 1px .2em 0 0; 
        padding: 0;
        list-style: none; white-space: nowrap;
    }
     
    .tabsindex li.active a{
        position: relative;
        z-index: 10;
        margin-bottom: -1px;
        padding-bottom: 6px;
        background: #FAFAFA;
        box-shadow: 0 0 8px rgba(0, 0, 0, .2);
    }
     
    /*tabs a*/
    .tabsindex a{
        font-size: 12px;
        font-weight: bold !important;
        display: inline-block;
        margin-bottom: -5px;
        padding: 7px;
        padding-bottom: 10px;
        border: 1px solid #DFDFDF;
        border-bottom: none;
        border-radius: 5px 5px 0 0;
        background: #F3F3F3;
    }
     
    /*content*/
    .tabsindex .tabscontent {
        position: relative;
        display: block;
        float: left; 
        border: 1px solid #DFDFDF;
        border-radius: 5px;
        background: #F3F3F3;
        box-shadow: 0 0 10px rgba(0, 0, 0, .2);
    }
    .tabsindex .tabscontent .active{
        position: relative;
        z-index: 200;
        display: inline-block;
        border-radius: 5px;
        background: #FAFAFA;
    }
     
    /*first tab with border-radius 0*/
    .tabsindex .tabscontent:first-child,
    .tabsindex .tabscontent .active:first-child {
        border-top-left-radius: 0;
    }
     
    .tabsindex .content{
        padding: 20px;        
        min-height: 300px;
    }
    
    .tabsindex .content p{
        font-size: 15px;
    }
</style>

</head>

<body>
    <?php 
        //print_r($_SESSION); 
    ?>
    <header id="site_head">
        <div class="header_cont">
            <h1><a href="#">Romero</a></h1> 
            <nav class="head_nav"></nav>
        </div>
    </header>
    <div id="body">
        <div id="banner"></div>        
        <div id="left">
            <h6 class="ui-widget-header ui-state-hover">BIENVENIDO  </h6>
            <br />
            <p>USER</p>
            <div id="barra-session">
                <span class="item-top"><?php echo strtoupper($_SESSION['name']); ?></span>                
            </div><br />
            <p>SEDE</p>
            <div id="barra-session">
                <span class="item-top"><?php echo strtoupper($_SESSION['sucursal']); ?></span>                
            </div>
            <p>CONSULTORIO</p>
            <div id="barra-session">                      
                <span class="item-top"><?php echo strtoupper($_SESSION['area']); ?></span>
            </div>
            <p>PERIODO</p>
            <div id="barra-session">                      
                <span class="item-top"><?php echo strtoupper($_SESSION['periodo']); ?> (<?php echo strtoupper($_SESSION['periodo_estado']); ?>) </span>
            </div>
            <!-- 
            <p>MENSAJES</p>
            <div id="barra-session">                           
                <a href="#" class="box-item-notification notification-encomienda" title="Encomiendas Pendientes">
                    <span class="indicator-notification"></span>
                </a>
            
                <div id="notifications" class="ui-corner-all" style="">
                    <a href="#" id="icon-notifications" class="box-item-notification notification-encomienda">
                        <span id="count-notifications" class="ui-corner-all" style="display: none"></span>
                    </a>                
                 </div> 
                        
            </div>
            --> 
            <div id="barra-session">
                <br />             
                <a href="index.php?controller=user&action=logout" class="logout">CERRAR SESION</a>                
            </div>

        </div>        
        <div id="content">
            <?php echo $content; ?>
        </div>
        <div  class="spacer"></div>
        <div id="foot" class="ui-corner-bottom">
            SISTEMA DE EVALUACION DE DESEMPEÑO
            <br/>2013
        </div>
        <div  class="spacer"></div>        
    </div>
    <div id="dialog-session" title="Su sesión ha expirado." style="display:none">
        <div class="ui-state-error" style="padding: 0 .7em; border: 0">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
            <strong>Por favor vuelva a iniciar sesión.</strong></p>
        </div>
    </div>
    <div id="dialog"></div>
</body>
</html>