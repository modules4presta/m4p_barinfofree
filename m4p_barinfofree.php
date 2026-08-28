<?php
/**
 * Top info bar FREE
 *
 *  @author    Jakub Przepióra (kontakt@nice-code.eu)
 *  @copyright nice-code.pl
 *  @license   ALL RIGHTS RESERVED
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
require_once dirname(__FILE__) . '/classes/Modules4PrestaMarketingBarInfoFree.php';

class m4p_barinfofree extends Module
{
    const CONFIG_KEYS = [
        'm4p_barinfofree_bar',
        'm4p_barinfofree_bar_color',
        'm4p_barinfofree_text_color',
        'm4p_barinfofree_text_size',
        'm4p_barinfofree_switch',
        'm4p_barinfofree_ads_cache',
        'm4p_barinfofree_ads_cache_time',
    ];

    public function __construct()
    {
        $this->name = 'm4p_barinfofree';
        $this->tab = 'front_office_features';
        $this->version = '1.2.0';
        $this->author = 'Modules4Presta.io';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => '8.1.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Top info bar FREE');
        $this->description = $this->l('Module add top bar with information ').' &nbsp;<a href="https://modules4presta.io/index.php?action=redirectToModule&fc=module&module=mfp_license_manager&controller=ajax&modulename=m4p_barinfopro" target="_blank">'.$this->l('Get PRO').'</a>';

        if (!Configuration::get('m4p_barinfofree_bar')) {
            $this->warning = $this->l('No bar text provided');
        }
    }

    public function install()
    {
        return parent::install()
            && $this->registerHook('displayHeader')
            && $this->registerHook('actionFrontControllerSetMedia');
    }

    public function uninstall()
    {
        foreach (self::CONFIG_KEYS as $key) {
            Configuration::deleteByName($key);
        }

        return parent::uninstall();
    }

    public function displayForm()
    {
        $fields_form[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Setting'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Write a text to top bar'),
                    'name' => 'm4p_barinfofree_bar',
                    'required' => true,
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
                    'label' => $this->l('Allow visitors to close the top bar'),
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
                'm4p_barinfofree_bar' => Tools::getValue('m4p_barinfofree_bar', Configuration::get('m4p_barinfofree_bar')),
                'm4p_barinfofree_bar_color' => Tools::getValue('m4p_barinfofree_bar_color', Configuration::get('m4p_barinfofree_bar_color')),
                'm4p_barinfofree_text_color' => Tools::getValue('m4p_barinfofree_text_color', Configuration::get('m4p_barinfofree_text_color')),
                'm4p_barinfofree_text_size' => Tools::getValue('m4p_barinfofree_text_size', Configuration::get('m4p_barinfofree_text_size')),
                'm4p_barinfofree_switch' => Tools::getValue('m4p_barinfofree_switch', Configuration::get('m4p_barinfofree_switch')),
            ),
            'languages' => $this->context->controller->getLanguages(),
        );

        return $helper->generateForm($fields_form);
    }

    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            $bar = trim((string) Tools::getValue('m4p_barinfofree_bar', ''));
            $barColor = (string) Tools::getValue('m4p_barinfofree_bar_color', '');
            $textColor = (string) Tools::getValue('m4p_barinfofree_text_color', '');
            $textSize = (string) Tools::getValue('m4p_barinfofree_text_size', '');
            $switch = (int) Tools::getValue('m4p_barinfofree_switch', 0);

            $errors = [];
            if ($bar === '') {
                $errors[] = $this->l('Bar text cannot be empty.');
            }
            if ($barColor !== '' && !Validate::isColor($barColor)) {
                $errors[] = $this->l('Bar color must be a valid hex color.');
            }
            if ($textColor !== '' && !Validate::isColor($textColor)) {
                $errors[] = $this->l('Text color must be a valid hex color.');
            }
            if ($textSize !== '' && !Validate::isUnsignedInt($textSize)) {
                $errors[] = $this->l('Font size must be a positive number.');
            }

            if ($errors) {
                foreach ($errors as $error) {
                    $output .= $this->displayError($error);
                }
            } else {
                Configuration::updateValue('m4p_barinfofree_bar', $bar);
                Configuration::updateValue('m4p_barinfofree_text_color', $textColor);
                Configuration::updateValue('m4p_barinfofree_text_size', $textSize === '' ? '' : (int) $textSize);
                Configuration::updateValue('m4p_barinfofree_bar_color', $barColor);
                Configuration::updateValue('m4p_barinfofree_switch', $switch);

                Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules') . '&configure=' . $this->name . '&conf=6');
            }
        }

        $this->context->smarty->assign(array(
            'modules_ads' => Modules4PrestaMarketingBarInfoFree::getAdsFromModules4Presta()
        ));
        $ads = $this->context->smarty->fetch(_PS_MODULE_DIR_.$this->name.'/views/templates/admin/m4p_ads.tpl');

        return $output . $this->displayForm() . $ads;
    }

    protected function isBarVisible()
    {
        if (isset($_COOKIE['m4p_barinfofree']) && $_COOKIE['m4p_barinfofree'] == '1') {
            return false;
        }

        return (bool) Configuration::get('m4p_barinfofree_bar');
    }

    public function hookActionFrontControllerSetMedia()
    {
        if (!$this->isBarVisible()) {
            return;
        }

        $this->context->controller->registerStylesheet(
            'module-m4p-barinfofree',
            'modules/' . $this->name . '/views/css/main.css',
            ['media' => 'all', 'priority' => 150]
        );
        $this->context->controller->registerJavascript(
            'module-m4p-barinfofree',
            'modules/' . $this->name . '/views/js/main.js',
            ['position' => 'bottom', 'priority' => 150]
        );
    }

    public function hookDisplayHeader()
    {
        if (!$this->isBarVisible()) {
            return '';
        }

        $this->context->smarty->assign(array(
            'topbarinformation' => Configuration::get('m4p_barinfofree_bar'),
            'm4p_barinfofree_text_size' => (int) Configuration::get('m4p_barinfofree_text_size'),
            'm4p_barinfofree_bar_color' => Configuration::get('m4p_barinfofree_bar_color'),
            'm4p_barinfofree_text_color' => Configuration::get('m4p_barinfofree_text_color'),
            'm4p_barinfofree_switch' => (bool) Configuration::get('m4p_barinfofree_switch'),
        ));

        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->name . '/views/templates/front/topbar.tpl');
    }
}
