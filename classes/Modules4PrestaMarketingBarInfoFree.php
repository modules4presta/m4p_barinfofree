<?php
/**
 * LICENCE
 *
 * ALL RIGHTS RESERVED.
 * YOU ARE NOT ALLOWED TO COPY/EDIT/SHARE/WHATEVER.
 *
 * IN CASE OF ANY PROBLEM CONTACT AUTHOR.
 *
 *  @author    Jakub Przepióra (kontakt@nice-code.eu)
 *  @copyright nice-code.pl
 *  @license   ALL RIGHTS RESERVED
 */
class Modules4PrestaMarketingBarInfoFree
{
    const ADS_CACHE_KEY = 'm4p_barinfofree_ads_cache';
    const ADS_CACHE_TIME_KEY = 'm4p_barinfofree_ads_cache_time';
    const ADS_CACHE_LIFETIME = 86400;

    public static function getAdsFromModules4Presta()
    {
        $ads = self::fetchAds();

        foreach ($ads as &$module) {
            $module['price_formatted'] = self::formatPrice(isset($module['price']) ? (float) $module['price'] : 0);
        }
        unset($module);

        return $ads;
    }

    protected static function fetchAds()
    {
        $cached = self::getCachedAds();
        $cachedAt = (int) Configuration::get(self::ADS_CACHE_TIME_KEY);

        if ($cached !== null && $cachedAt > time() - self::ADS_CACHE_LIFETIME) {
            return $cached;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://modules4presta.io/index.php?action=getAdsForModul&fc=module&module=mfp_license_manager&controller=ajax&modulename='.urlencode('m4P_barinfofree'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 3,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 3,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $ads = ($response !== false) ? json_decode($response, true) : null;
        if (!is_array($ads)) {
            return ($cached !== null) ? $cached : array();
        }

        Configuration::updateValue(self::ADS_CACHE_KEY, json_encode($ads));
        Configuration::updateValue(self::ADS_CACHE_TIME_KEY, time());

        return $ads;
    }

    protected static function getCachedAds()
    {
        $cache = Configuration::get(self::ADS_CACHE_KEY);
        if (!$cache) {
            return null;
        }

        $ads = json_decode($cache, true);

        return is_array($ads) ? $ads : null;
    }

    protected static function formatPrice($price)
    {
        $context = Context::getContext();

        if (isset($context->currentLocale, $context->currency) && $context->currentLocale && $context->currency) {
            return $context->currentLocale->formatPrice($price, $context->currency->iso_code);
        }

        return Tools::displayPrice($price);
    }
}
