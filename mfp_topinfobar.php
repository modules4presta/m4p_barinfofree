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
        $this->author = 'Modules for Presta';
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
                    'name' => 'mfp_top_information_bar',


                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Font size'),
                    'name' => 'mfp_text_size',
                    'desc' => $this->l('Enter size in pixels'),
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Set Color text'),
                    'name' => 'mfp_text_color',
                    'lang' => false,
                    'id' => 'text_color',
                    'data-hex' => true,

                    'desc' => $this->l('Enter hex code.'),
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Set Color bar'),
                    'name' => 'mfp_bar_color',
                    'lang' => false,
                    'id' => 'bar_color',
                    'data-hex' => true,

                    'desc' => $this->l('Enter hex code.'),
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
                'mfp_top_information_bar' => Configuration::get('mfp_top_information_bar'),
                'mfp_bar_color' => Configuration::get('mfp_bar_color'),
                'mfp_text_color' => Configuration::get('mfp_text_color'),
                'mfp_text_size' => Configuration::get('mfp_text_size'),


            ),
            'languages' => $this->context->controller->getLanguages(),
        );
        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {

            $mfp_top_information_bar = Tools::getValue('mfp_top_information_bar');
            $mfp_bar_color = Tools::getValue('mfp_bar_color');
            $mfp_text_color = Tools::getValue('mfp_text_color');
            $mfp_text_size = Tools::getValue('mfp_text_size');



            if (!isset( $mfp_top_information_bar )) {
                $output .= $this->displayError($this->l('You have empty fields.'));
            } else {

                Configuration::updateValue('mfp_top_information_bar', $mfp_top_information_bar);
                Configuration::updateValue('mfp_text_color', $mfp_text_color);
                Configuration::updateValue('mfp_text_size', $mfp_text_size);
                Configuration::updateValue('mfp_bar_color', $mfp_bar_color);


                $output .= $this->displayConfirmation($this->l('Successful save'));
            }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');

        }
        $output .= $this->displayForm();
        $output .= (new ModulesForPrestaMarketing())->getRequaiermentsTemplate();
        return $output ;
    }

    public function hookDisplayHeader()
    {

        $this->context->controller->addJS($this->_path . 'views/js/main.js');
        $this->context->controller->addCSS($this->_path . 'views/css/main.css');


        $this->context->smarty->assign(array(
            'topbarinformation' => Configuration::get("mfp_top_information_bar"),
            'mfp_text_size' => Configuration::get("mfp_text_size"),
            'mfp_bar_color' => Configuration::get("mfp_bar_color"),
            'mfp_text_color' => Configuration::get("mfp_text_color"),

        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'mfp_topinfobar/views/templates/front/topbar.tpl');
    }

}