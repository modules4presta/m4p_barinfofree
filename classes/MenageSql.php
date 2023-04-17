<?php

namespace MFP;

class MenageSql {


    public function doQueriesArray($sql)
    {

        foreach ($sql as $query) {
            if (Db::getInstance()->execute($query) === false) {
                return false;
            }
        }
        return true;
    }

    public function __destruct()
    {
        $top_info_bar = new mfp_topinfobar();
        $tables = $top_info_bar->getDatabaseTables();

        foreach ($tables as $table) {
            if (Db::getInstance()->execute("DROP TABLE `'._DB_PREFIX_.$table'`;") === false) {
                return false;
            }
        }
        return true;
    }
}