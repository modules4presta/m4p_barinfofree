<?php

include "./classes/MenageSql.php";

if (!defined('_PS_VERSION_')) {
    exit;
}

class mfp_topinfobar extends Module
{

    public $sqlQueries = [];

    public $DB_tables = ["mfp_topinfobar"];
    public function __construct()
    {
        $this->name = 'mfp_topinfobar';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Nice Code';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Top info bar');
        $this->description = $this->l('Module add top bar with information');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('SELECT ADD')) {
            $this->warning = $this->l('No name provided');
        }
    }


    public function install()
    {

        if (!parent::install()) {
            return false;
        }
        if(!$this->registerHook('displayHeader')) return false;


        $this->sqlQueries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'mfp_topinfobar` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,				  
				  `inforamation_conent` VARCHAR(255) NOT NULL,
				  `status` int(1) NOT NULL,			  
				  PRIMARY KEY (`id`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

        $menagerSQL = new MenageSql($this->sqlQueries);

        if($menagerSQL === false) return false;

        return true;
    }

    public function uninstall()
    {
        // Deletes module tables
        Db::getInstance()->execute("DROP TABLE `'._DB_PREFIX_.'mfpswitchinvoicebill`;");
        return parent::uninstall();
    }

    public function getDatabaseTables(){
        return $this->DB_tables;
    }

    public function hookDisplayHeader()
    {
        $link = new Link;
        $parameters_map = array("action" => "setinvoice");
        $ajax_get_map = $link->getModuleLink('mfp_switch_invoice', 'ajax', $parameters_map);
        Media::addJsDef(array(
            'ajax_get_map' => $ajax_get_map
        ));
        $this->context->controller->addJS($this->_path . 'views/js/main.js');
    }

}