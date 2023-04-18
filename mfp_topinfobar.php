<?php

require_once __DIR__.'/classes/ModulesForPrestaMarketing.php';
require_once __DIR__.'/classes/ModulesForPrestaConnector.php';
require_once __DIR__.'/classes/ManageSql.php';


if (!defined('_PS_VERSION_')) {
    exit;
}

class mfp_topinfobar extends Module
{


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
    public static function getPrefixDb() {

        return _DB_PREFIX_;
    }

    public function install()
    {

        if (!parent::install()) {
            return false;
        }
        if(!$this->registerHook('displayHeader')) return false;

        (new ManageSql())->installQuaries();


        return true;
    }

    public function uninstall()
    {
        // Deletes module tables
        (new ManageSql())->uninstallQueries();
        return parent::uninstall();
    }

    public function getDatabaseTables(){
        return $this->DB_tables;
    }

    public function getContent()
    {
        $output = '';
        $mfpMarketing = new ModulesForPrestaMarketing();
        $output .= $mfpMarketing->checkServerRequirements();
        return $output ;
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