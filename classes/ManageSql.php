<?php

require_once __DIR__.'/../mfp_topinfobar.php';

class ManageSql {

    public $sqlQueries = [];

    public array $DB_tables = ["mfp_topinfobar"];

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
            if (Db::getInstance()->execute("DROP TABLE IF EXISTS `".mfp_topinfobar::getPrefixDb().$table."`;") === false) {
                return false;
            }
        }
        return true;
    }
}