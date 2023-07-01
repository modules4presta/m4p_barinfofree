<?php


if (!defined('_PS_VERSION_')) {
    exit;
}
require_once dirname(__FILE__) . '/classes/Modules4PrestaMarketingBarInfoFree.php';
class m4p_barinfofree extends Module
{
    public $content = '';
    public function __construct()
    {
        $this->name = 'm4p_barinfofree';
        $this->tab = 'front_office_features';
        $this->version = '1.1.5';
        $this->author = 'Modules4Presta.io';
        $this->need_instance = 0;
        $this->_path = _PS_MODULE_DIR_.$this->name;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Top info bar FREE');
        $this->description = $this->l('Module add top bar with information ').'<a href="https://modules4presta.io/index.php?action=redirectToModule&fc=module&module=mfp_license_manager&controller=ajax&modulename=m4p_barinfopro">'.$this->l('Get PRO').'</a>';


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

        $this->installQuaries();


        return true;
    }

    public function uninstall()
    {


        if (!parent::uninstall()) {
            return false;
        }
        return true;

    }

    public function displayForm(){
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Setting'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Write a text to top bar'),
                    'name' => 'm4p_barinfofree_bar',


                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Font size'),
                    'name' => 'm4p_barinfofree_text_size',
                    'desc' => $this->l('Enter size in pixels'),
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Set Color text'),
                    'name' => 'm4p_barinfofree_text_color',
                    'lang' => false,
                    'id' => 'text_color',
                    'data-hex' => true,

                    'desc' => $this->l('Enter hex code.'),
                ),
                array(
                    'type' => 'color',
                    'label' => $this->l('Set Color bar'),
                    'name' => 'm4p_barinfofree_bar_color',
                    'lang' => false,
                    'id' => 'bar_color',
                    'data-hex' => true,

                    'desc' => $this->l('Enter hex code.'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('You can turn on/off top bar'),
                    'name' => 'm4p_barinfofree_switch',
                    'desc' => $this->l('This option uses cookies. Therefore, you should add this module to the functional cookie files.'),
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('On')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Off')
                        )
                    ),
                )

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
                'm4p_barinfofree_bar' => Configuration::get('m4p_barinfofree_bar'),
                'm4p_barinfofree_bar_color' => Configuration::get('m4p_barinfofree_bar_color'),
                'm4p_barinfofree_text_color' => Configuration::get('m4p_barinfofree_text_color'),
                'm4p_barinfofree_text_size' => Configuration::get('m4p_barinfofree_text_size'),
                'm4p_barinfofree_switch' => Configuration::get('m4p_barinfofree_switch'),


            ),
            'languages' => $this->context->controller->getLanguages(),
        );

        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {

            $m4p_barinfofree_bar = Tools::getValue('m4p_barinfofree_bar');
            $m4p_barinfofree_bar_color = Tools::getValue('m4p_barinfofree_bar_color');
            $m4p_barinfofree_text_color = Tools::getValue('m4p_barinfofree_text_color');
            $m4p_barinfofree_text_size = Tools::getValue('m4p_barinfofree_text_size');
            $m4p_barinfofree_switch = Tools::getValue('m4p_barinfofree_switch');



            if (!isset( $m4p_barinfofree_bar )) {
                $output .= $this->displayError($this->l('You have empty fields.'));
            } else {

                Configuration::updateValue('m4p_barinfofree_bar', $m4p_barinfofree_bar);
                Configuration::updateValue('m4p_barinfofree_text_color', $m4p_barinfofree_text_color);
                Configuration::updateValue('m4p_barinfofree_text_size', $m4p_barinfofree_text_size);
                Configuration::updateValue('m4p_barinfofree_bar_color', $m4p_barinfofree_bar_color);
                Configuration::updateValue('m4p_barinfofree_switch', $m4p_barinfofree_switch);


                $output .= $this->displayConfirmation($this->l('Successful save'));
            }
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');

        }
        $this->context->smarty->assign(array(
            'modules_ads' => Modules4PrestaMarketingBarInfoFree::getAdsFromModules4Presta()
        ));
        $this->content .= $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->name.'/views/templates/admin/m4p_ads.tpl');

        $this->context->smarty->assign(array(
            'content' => $this->content,
            'modules_ads' => Modules4PrestaMarketingBarInfoFree::getAdsFromModules4Presta()
        ));
        $output .= $this->displayForm().$this->content;
        return $output ;
    }

    public function hookDisplayHeader()
    {
        if (isset($_COOKIE['m4p_barinfofree']) && $_COOKIE['m4p_barinfofree'] == '1') return;
        $this->context->controller->addJS($this->_path . 'views/js/main.js');
        $this->context->controller->addCSS($this->_path . 'views/css/main.css');


        $this->context->smarty->assign(array(
            'topbarinformation' => Configuration::get("m4p_barinfofree_bar"),
            'm4p_barinfofree_text_size' => Configuration::get("m4p_barinfofree_text_size"),
            'm4p_barinfofree_bar_color' => Configuration::get("m4p_barinfofree_bar_color"),
            'm4p_barinfofree_text_color' => Configuration::get("m4p_barinfofree_text_color"),
            'm4p_barinfofree_switch' => Configuration::get("m4p_barinfofree_switch"),

        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'm4p_barinfofree/views/templates/front/topbar.tpl');
    }
    public $sqlQueries = [];

    public array $DB_tables = ["m4p_barinfofree"];

    public function installQuaries()
    {
        $this->sqlQueries[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.$this->DB_tables[0].'` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `inforamation_conent` VARCHAR(255) NOT NULL,
				  `status` int(1) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';

        foreach ($this->sqlQueries as $query) {
            if (Db::getInstance()->execute($query) === false) {
                return false;
            }
        }
        return true;
    }

    public function uninstallQueries()
    {


        foreach ($this->DB_tables as $table) {
            Db::getInstance()->execute("DROP TABLE IF EXISTS `'._DB_PREFIX_.$this->DB_tables[0].'`;");

        }
        return true;
    }
}