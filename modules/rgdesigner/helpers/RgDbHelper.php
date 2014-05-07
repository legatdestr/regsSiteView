<?php
/**
 * This file contains RgDbHelper abstract class.
 *
 * @author Sergey Kochetkov <legatdestr@gmail.com>
 * @copyright 2014 Elecard Med
 * @license BSD License
 */
abstract class RgDbHelper extends CComponent {

    /* dbviews list cache  */
    private static $_dbViews = array();

    /**
     * 
     * @param string $rgPrefix Prefix string for retrieving view name from the db
     * @return array Array of view_name retrieved from the database according
     * to the $rgPrefix
     */
    public static function getViewList($rgPrefix) {
        if (empty(self::$_dbViews)) {
            $driverName = Yii::app()->db->getDriverName();
            $sql = '';
            switch ($driverName) {
                case 'pgsql':
                    $sql = 'SELECT table_name from INFORMATION_SCHEMA.views '
                            . ' WHERE table_schema = ANY (current_schemas(false)) '
                            . "AND table_name like '" . $rgPrefix . "%'";

                    break;
                case 'mssql':
                    $sql = 'SELECT name as table_name FROM sys.views '
                            . "WHERE name like '" . $rgPrefix . "%'";
                    break;
                case 'mysql':
                    $sql = "SELECT table_name "
                            . "FROM information_schema.`TABLES` "
                            . "WHERE "
                            . "TABLE_TYPE LIKE 'VIEW' "
                            . "AND TABLE_SCHEMA "
                            . "LIKE 'database_name'"
                            . "AND TABLE_NAME like '" . $rgPrefix . "%'";
                    break;
                default:
                    $sql = '';
                    break;
            }
            $cmd = Yii::app()->db->createCommand($sql);
            $rows = $cmd->queryAll();
            $dbViews = array();
            foreach ($rows as $row) {
                $dbViews[] = $row['table_name'];
            }
            self::$_dbViews = $dbViews;
        }

        return self::$_dbViews;
    }

}
