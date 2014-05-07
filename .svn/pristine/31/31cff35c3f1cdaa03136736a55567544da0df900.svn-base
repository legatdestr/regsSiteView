<?php
/**
 * This file contains RgModelCreator abstract class implementing dynamic model
 * creating feature.
 *
 * @author Sergey Kochetkov <legatdestr@gmail.com>
 * @copyright 2014 Elecard Med
 * @license BSD License
 *
 * Needed the strings to be switched on in the configuration file: 
 * 'ext.regsSiteView.components.*' 
 * in config import section
 */

abstract class RgModelCreator extends CComponent {

    /**
     * 
     * @param string $name name of a class for creation
     * @return string contains class definition
     */
    protected static function get_class_template($name) {
        return "class $name extends RgBaseModel { }";
    }

    /**
     * 
     * @param string $name Database view name
     * @param string $scenario Default is null, which means 'insert'
     * @return RgBaseModel $model object 
     * @throws CDbException
     */
    protected static function getObjectByModelName($name, $scenario = null) {
        if (!isset($name)) {
            throw new CDbException(Yii::t('yii', 'Classname {class} is empty "{name}".', array('{class}' => get_class($this), '{name}' => $name)));
        }
        $class_template = self::get_class_template($name);
        if (!class_exists($name, false))
            eval($class_template);
        return new $name($scenario);
    }

    private static $_cache = array();
    private static $_last_cache_index;

    /**
     * Executes db query on the rgentity table 
     * @param integer $entity_id row ID of rgsiteview table
     * @param string $scenario scenario name. Default is null.
     * @return RgBaseModel Extends CActiveRecord
     * @return boolean false if siteView was not found
     */
    public static function getInstance($entity_id = null, $scenario = null) {
        $model = NULL;
        if (empty($entity_id)) {
            if (!empty(self::$_last_cache_index)) {
                $model = self::$_cache[self::$_last_cache_index];
            }
        } else {
            $db = Yii::app()->db;
            $sql = 'SELECT * FROM ' . Rgentity::model()->tableName() .  ' WHERE id = :id';
            $cmd = $db->createCommand($sql);
            $cmd->bindParam(':id', $entity_id, PDO::PARAM_INT);
            $fetchAssociative = true;
            $row = $cmd->queryRow($fetchAssociative);
            $viewName = $row['dbview'];
            if ($viewName) {
                $model = self::getObjectByModelName($viewName, $scenario);
                $model->rgSiteView = $row;
            }
            self::$_last_cache_index = $entity_id;
            self::$_cache[$entity_id] = $model;
        }
        return $model;
    }

}
