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
        $this->_path = _PS_MODULE_DIR_.$this->name;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Top info bar');
        $this->description = $this->l('Module add top bar with information');

//        $this->confirmUninstall = $this->confirmUninstall();

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
    public function confirmUninstall()
    {
        $this->context->smarty->assign(array(
            'module_display_name' => $this->displayName
        ));
//        echo $this->_path.'/views/templates/admin';
        return  $this->display(__FILE__, 'views/templates/admin/uninstall_popup.tpl');
    }
    public function uninstall()
    {
        // Deletes module tables



        $this->context->smarty->assign(array(
            'module_name' => $this->name,
            'module_display_name' => $this->displayName,
        ));

        $output = $this->display(__FILE__, 'uninstall_popup.tpl');
        $this->context->controller->addJqueryPlugin('fancybox');
        $this->context->controller->addCSS($this->_path.'views/css/uninstall_popup.css');
        $this->context->smarty->assign('module_display_name', $this->displayName);
        $this->context->controller->confirmUninstall($this->l('Are you sure you want to uninstall this module?'), $output);

        echo $output;

        (new ManageSql())->uninstallQueries();
        if (!parent::uninstall()) {
            return false;
        }
        return true;

    }

    public function displayForm(){
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Setting top information bar'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Write a text to top bar'),
                    'name' => 'topbar_content',


                ),

            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );
        $helper = new HelperForm();

        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        $helper->title = $this->displayName;
        $helper->show_toolbar = true;
        $helper->toolbar_scroll = true;
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = array(
            'save' => array(
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );
        $helper->tpl_vars = array(
            'fields_value' => array(
                'topbar_content' => Configuration::get('topbar_content'),


            ),
            'languages' => $this->context->controller->getLanguages(),
        );
        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';
        $output .= $this->displayForm();
        if (Tools::isSubmit('submit' . $this->name)) {

            $topbarinformation = Tools::getValue('topbarinformation');



            if (!isset( $topbarinformation)) {
                $output .= $this->displayError($this->l('You have empty fields.'));
            } else {

                $resultUpdate = Configuration::updateValue('topbarinformation', $topbarinformation);


                $output .= $this->displayConfirmation($this->l('Successful save'));
            }
        }
        $output .= (new ModulesForPrestaMarketing())->getRequaiermentsTemplate();
        return $output ;
    }

    public function hookDisplayHeader()
    {

        $this->context->controller->addJS($this->_path . 'views/js/main.js');
        $this->context->controller->addCSS($this->_path . 'views/css/main.css');


        $this->context->smarty->assign(array(
            'topbarinformation' => Configuration::get("topbarinformation"),

        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'mfp_topinfobar/views/templates/front/topbar.tpl');
    }

}