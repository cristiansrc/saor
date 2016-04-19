<?php 
class app_controller extends Controller {
    protected $template = 'app';
    protected $script = array();
    protected $css = array();
   
    
    function __construct() {
           
        define('_TEMPLATE_SCRIPTS', _APPLICACION_URL . 'template/app/');
        define('_TEMPLATE_SCRIPTS_ROOT' , _ROOT_APP . '/template/' . $this->template . '/include/' );
        
        //js
        array_push($this->script, 'js/jquery-1.10.2.min.js');
        array_push($this->script, 'js/jquery-migrate-1.2.1.min.js');
        array_push($this->script, 'js/jquery-ui.js');
        array_push($this->script, 'vendors/bootstrap/js/bootstrap.min.js');
        array_push($this->script, 'vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js');
        array_push($this->script, 'js/html5shiv.js');
        array_push($this->script, 'js/respond.min.js');
        array_push($this->script, 'vendors/metisMenu/jquery.metisMenu.js');
        array_push($this->script, 'vendors/slimScroll/jquery.slimscroll.js');
        array_push($this->script, 'vendors/jquery-cookie/jquery.cookie.js');
        array_push($this->script, 'vendors/iCheck/icheck.min.js');
        array_push($this->script, 'vendors/iCheck/custom.min.js');
        array_push($this->script, 'vendors/jquery-notific8/jquery.notific8.min.js');
        array_push($this->script, 'vendors/jquery-highcharts/highcharts.js');
        array_push($this->script, 'js/jquery.menu.js');
        array_push($this->script, 'vendors/jquery-pace/pace.min.js');
        array_push($this->script, 'vendors/holder/holder.js');
        array_push($this->script, 'vendors/responsive-tabs/responsive-tabs.js');
        array_push($this->script, 'vendors/jquery-news-ticker/jquery.newsTicker.min.js');
        array_push($this->script, 'vendors/moment/moment.js');
        array_push($this->script, 'vendors/bootstrap-datepicker/js/bootstrap-datepicker.js');
        array_push($this->script, 'vendors/bootstrap-daterangepicker/daterangepicker.js');
        array_push($this->script, 'vendors/lightbox/js/lightbox.min.js');
        array_push($this->script, 'js/ui-portlets.js');
        array_push($this->script, 'js/main.js');
        
        //css
        array_push($this->css, 'vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
        array_push($this->css, 'vendors/font-awesome/css/font-awesome.min.css');
        array_push($this->css, 'vendors/bootstrap/css/bootstrap.min.css');
        array_push($this->css, 'vendors/animate.css/animate.css');
        array_push($this->css, 'vendors/jquery-pace/pace.css');
        array_push($this->css, 'vendors/iCheck/skins/all.css');
        array_push($this->css, 'vendors/jquery-notific8/jquery.notific8.min.css');
        array_push($this->css, 'vendors/bootstrap-daterangepicker/daterangepicker-bs3.css');
        array_push($this->css, array('href' => 'css/themes/style1/orange-blue.css', 'class' => 'default-style'));
        array_push($this->css, array('href' => 'css/themes/style1/orange-blue.css', 'id' => 'theme-change', 'class' => 'style-change color-change'));
        array_push($this->css, 'css/style-responsive.css');
        array_push($this->css, 'vendors/lightbox/css/lightbox.css');
        array_push($this->css, 'vendors/pageloader/pageloader.css');

    }
    
    protected function scriptsTable() {
        
        //js
        array_push($this->script, 'vendors/DataTables/media/js/jquery.dataTables.js');
        array_push($this->script, 'vendors/DataTables/media/js/dataTables.bootstrap.js');
        array_push($this->script, 'vendors/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js');

        //css
        array_push($this->css, 'vendors/DataTables/media/css/jquery.dataTables.css');
        array_push($this->css, 'vendors/DataTables/extensions/TableTools/css/dataTables.tableTools.min.css');
        array_push($this->css, 'vendors/DataTables/media/css/dataTables.bootstrap.css');
    }

    //Carga formularios y alertas modal
    protected function scriptsValidateForms(){
        array_push($this->script, 'vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
        array_push($this->script, 'vendors/bootstrap-clockface/js/clockface.js');
        array_push($this->script, 'vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.js');
        array_push($this->script, 'vendors/bootstrap-switch/js/bootstrap-switch.min.js');
        array_push($this->script, 'vendors/jquery-maskedinput/jquery-maskedinput.js');
        array_push($this->script, 'vendors/jquery-validate/jquery.validate.min.js');
        array_push($this->script, 'js/form-validation.js');
        array_push($this->script, 'js/form-components.js');
    }
    
    protected function includeHead() {
        $this->includeTemplate('head');
    }
    
   protected function includeSidebar($titulo = '', $breadcrumb = array()) {
        $menu_helper    = new HelperDb('menu');
        $menus          = $menu_helper->selectObj(
                                false, 
                                ' and menu_tipo.id_tipo_persona = ' . $_SESSION['id_tipo_persona'], 
                                'inner join menu_tipo on menu.id_menu = menu_tipo.id_menu', 'menu.*'
                        );
        
        $vars['menus']      = $menus;
        $vars['breadcrumb'] = $breadcrumb;
        $vars['titulo']     = $titulo;
        $this->includeTemplate('sidebar', $vars);
    }
    
    protected function includeFooter() {
        $this->includeTemplate('footer');
    }
    
    protected function includeViewController($name, $vars = array(),$titulo = '', $breadcrumb = array()) {
        $this->includeHead();
        $this->includeSidebar($titulo, $breadcrumb);
        $this->includeView($name, $vars);
        $this->includeFooter();
    }
    
    public function sessionStart() {
        if(isset($_SESSION['id_persona']) === false){
            $controller_login = $this->instanceController("login");
            $controller_login->login();
            die();
        }else{
            $helper_menu = new HelperDb('menu');
            $menu = $helper_menu->selectObj(
                                            false, 
                                            " and menu_tipo.id_tipo_persona = " . $_SESSION["id_tipo_persona"] . " and url_menu = '" . _CURRENT_CONTROLLER_CLASS . "' ", 
                                            " inner join menu_tipo on menu.id_menu = menu_tipo.id_menu",
                                            " menu_tipo.id_tipo_persona "
                                        );
            
            if(count($menu) === 0){
                redirectInter();
            }
        }
    }
}
?>