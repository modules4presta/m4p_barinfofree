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

function upgrade_module_1_2_0($module)
{
    Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'm4p_barinfofree`');

    return $module->registerHook('actionFrontControllerSetMedia');
}
