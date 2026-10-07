<?php

/**
 * m4p_barinfofree
 *
 * @author    Modules4Presta <contact@modules4presta.io>
 * @copyright 2026 Nice Code sp. z o.o. (Modules4Presta)
 * @license   https://opensource.org/licenses/MIT MIT License
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class m4p_barinfofree extends Module
{
    const CONFIG_KEYS = [
        'm4p_barinfofree_bar',
        'm4p_barinfofree_bar_color',
        'm4p_barinfofree_text_color',
        'm4p_barinfofree_text_size',
        'm4p_barinfofree_switch',
    ];

    const DEFAULTS = [
        'm4p_barinfofree_bar' => '',
        'm4p_barinfofree_bar_color' => '#0d183d',
        'm4p_barinfofree_text_color' => '#ffffff',
        'm4p_barinfofree_text_size' => 14,
        'm4p_barinfofree_switch' => 0,
    ];

    public function __construct()
    {
        $this->name = 'm4p_barinfofree';
        $this->tab = 'front_office_features';
        $this->version = '2.0.0';
        $this->author = 'Modules4Presta';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7.6.0', 'max' => _PS_VERSION_];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Top info bar', [], 'Modules.M4pbarinfofree.Admin');
        $this->description = $this->trans('Shows a bar across the top of the shop with a message you set.', [], 'Modules.M4pbarinfofree.Admin');

        if (!Configuration::get('m4p_barinfofree_bar')) {
            $this->warning = $this->trans('No bar text provided', [], 'Modules.M4pbarinfofree.Admin');
        }
    }

    public function install()
    {
        foreach (self::DEFAULTS as $key => $value) {
            Configuration::updateValue($key, $value);
        }

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
                'title' => $this->trans('Settings', [], 'Modules.M4pbarinfofree.Admin'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->trans('Bar text', [], 'Modules.M4pbarinfofree.Admin'),
                    'name' => 'm4p_barinfofree_bar',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->trans('Font size', [], 'Modules.M4pbarinfofree.Admin'),
                    'name' => 'm4p_barinfofree_text_size',
                    'desc' => $this->trans('In pixels.', [], 'Modules.M4pbarinfofree.Admin'),
                ),
                array(
                    'type' => 'color',
                    'label' => $this->trans('Text colour', [], 'Modules.M4pbarinfofree.Admin'),
                    'name' => 'm4p_barinfofree_text_color',
                    'lang' => false,
                    'id' => 'text_color',
                    'data-hex' => true,
                    'desc' => $this->trans('Enter a hex code.', [], 'Modules.M4pbarinfofree.Admin'),
                ),
                array(
                    'type' => 'color',
                    'label' => $this->trans('Bar colour', [], 'Modules.M4pbarinfofree.Admin'),
                    'name' => 'm4p_barinfofree_bar_color',
                    'lang' => false,
                    'id' => 'bar_color',
                    'data-hex' => true,
                    'desc' => $this->trans('Enter a hex code.', [], 'Modules.M4pbarinfofree.Admin'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->trans('Let visitors close the bar', [], 'Modules.M4pbarinfofree.Admin'),
                    'name' => 'm4p_barinfofree_switch',
                    'desc' => $this->trans('Closing is remembered in a cookie, so list this module among your functional cookies.', [], 'Modules.M4pbarinfofree.Admin'),
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->trans('On', [], 'Modules.M4pbarinfofree.Admin')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->trans('Off', [], 'Modules.M4pbarinfofree.Admin')
                        )
                    ),
                )
            ),
            'submit' => array(
                'title' => $this->trans('Save', [], 'Modules.M4pbarinfofree.Admin'),
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
                'desc' => $this->trans('Save', [], 'Modules.M4pbarinfofree.Admin'),
                'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name . '&token=' . Tools::getAdminTokenLite('AdminModules'),
            ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->trans('Back to list', [], 'Modules.M4pbarinfofree.Admin')
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
                $errors[] = $this->trans('Bar text cannot be empty.', [], 'Modules.M4pbarinfofree.Admin');
            }
            if ($barColor !== '' && !Validate::isColor($barColor)) {
                $errors[] = $this->trans('The bar colour must be a valid hex colour.', [], 'Modules.M4pbarinfofree.Admin');
            }
            if ($textColor !== '' && !Validate::isColor($textColor)) {
                $errors[] = $this->trans('The text colour must be a valid hex colour.', [], 'Modules.M4pbarinfofree.Admin');
            }
            if ($textSize !== '' && !Validate::isUnsignedInt($textSize)) {
                $errors[] = $this->trans('The font size must be a positive number.', [], 'Modules.M4pbarinfofree.Admin');
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

        return $output . $this->displayForm();
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
