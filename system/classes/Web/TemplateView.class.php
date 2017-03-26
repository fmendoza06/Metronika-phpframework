<?php

require_once "Smarty.class.php";

class TemplateView {

    var $template;

    function TemplateView($template) {
        $this->template = $template;
    }
    
    function show() {

        // get a template engine object
        $obj =& TemplateView::getTemplateEngine();

        // assign the variables to the template engine
        $obj->assign(WebRequest::getParameterList());

        // set the plugins directories
        // must use Smarty > 2.6.0
        $obj->plugins_dir = array (
            Application::getBaseDirectory().Application::__getVar('plugins_dir'),
            ASAP::getAsapDirectory()."/system/plugins",
            'plugins'
            );



	/**
		Copyright 2006  Spyro Solutions
		Load directory for config language
		@author Spyro Solutions
		@date 29-sep-2004 10:33:05
		@location Cali-Colombia Application::__getVar('language_dir')
	*/
	     
        $obj->config_dir =  Application::getBaseDirectory().Application::__getVar('language_dir').'/'.Application::__getVar('language');
		
        //load the template
        $obj->template_dir = Application::getBaseDirectory().Application::__getVar('templates_dir');
        $obj->display($this->template);

    }

    function &getTemplateEngine(){

        // there is a previously created engine object ??
        $obj =& ASAP::getStaticProperty('Template', 'engine');

        // create the smarty object
        if (!isset($obj) || !is_object($obj)) {
            $obj = new Smarty();
        }
        
        return $obj;
    }

}

?>

