<?php


namespace MFP;


class ModulesForPrestaMarketing
{
    public static function checkServerRequirements()
    {
        $ionCubeLoaderEnabled = extension_loaded('ionCube Loader');
        $phpVersion = phpversion();
        $prestashopVersion = _PS_VERSION_;

        if ($ionCubeLoaderEnabled && version_compare($phpVersion, '7.0.0', '>=') && version_compare($prestashopVersion, '1.7.0.0', '>=')) {
            return 'Server meets the requirements';
        } else {
            $message = 'Server does not meet the requirements: ';
            $requirements = [];

            if (!$ionCubeLoaderEnabled) {
                $requirements[] = 'IonCube Loader is not installed';
            }

            if (version_compare($phpVersion, '7.3.0', '<')) {
                $requirements[] = 'PHP version is lower than 7.0.0';
            }

            if (version_compare($prestashopVersion, '1.7.0.0', '<')) {
                $requirements[] = 'PrestaShop version is lower than 1.7.0.0';
            }

            return $message . implode(', ', $requirements);
        }
    }
}