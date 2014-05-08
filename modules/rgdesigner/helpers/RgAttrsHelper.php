<?php

/**
 * This file contains RgAttrsHelper class.
 *
 * @author Sergey Kochetkov <legatdestr@gmail.com>
 * @copyright 2014 Elecard Med
 * @license BSD License
 */
abstract class RgAttrsHelper extends CComponent {

    /**
     * Retrieves the list of the attributes established by the user
     * and saved in rgattr table
     * @param integer $entity_id Identificator of siteview
     * @return \CSqlDataProvider 
     */
    public static function getRgAttrs($entity_id) {

        $sql = 'SELECT * FROM ' . Rgattr::model()->tableName() . ' WHERE entity_id = :entity_id';

        $dataProvider = new CSqlDataProvider($sql, array(
            'pagination' => false,
            'params' => array(
                ':entity_id' => $entity_id,
            ),
            'sort' => array(
                'attributes' => array('dbname')
            ),
        ));
        return $dataProvider;
    }

    /**
     * Retrieves the names of database view fields
     * @param string $dbViewName Name of the Database View
     * @return array of columnNames
     */
    public static function getViewAttrsNames($dbViewName) {
        $schemaName = isset(Yii::app()->params['dbSchema']) ? Yii::app()->params['dbSchema'] . '.' : '';
        $table = Yii::app()->db->schema->getTable($schemaName . $dbViewName);
        $columnNames = array();
        if ($table !== null) {
            $columnNames = $table->getColumnNames();
        }
        return $columnNames;
    }

    /**
     * Used in update form
     * @param integer $entity_id Entity Identificator from RgEntity db table
     * @param string $dbViewName name of the real database view
     * @return \CArrayDataProvider
     */
    public static function combineRgViewAttrs($entity_id, $dbViewName = false) {
        if (!$dbViewName) {
            $dbViewName = Yii::app()->db->createCommand(
                                    'SELECT dbview '
                                    . ' FROM ' . Rgentity::model()->tableName()
                                    . ' WHERE id = :entity_id ORDER BY dbview')
                            ->bindParam(':entity_id', $entity_id, PDO::PARAM_INT)->queryScalar();
        }
        // gettting attributes established by user
        $rgAttrs = self::getRgAttrs($entity_id)->getData();
        // gettting database view attributesNames
        $dbViewAttrs = self::getViewAttrsNames($dbViewName);

        // retreive default values from database
        $templateAttr = (new Rgattr())->attributes;
        $templateAttr['entity_id'] = $entity_id;
        // result
        $res = array();

        if ($dbViewName) {
            foreach ($dbViewAttrs as $attr) {
                $inArray = false;
                foreach ($rgAttrs as $attrRow) {
                    $inArray = $inArray || ($attr === $attrRow['dbname']);
                    if ($inArray)
                        break;
                }
                if (!$inArray) {
                    $newRow = $templateAttr;
                    $newRow['dbname'] = $attr;
                    $res[] = $newRow;
                }
            }
        }
        $resAttrs = array_merge($rgAttrs, $res);
        return new CArrayDataProvider($resAttrs, array(
            'pagination' => false,
        ));
    }

    /**
     * Used in create form
     * Retreive dbview attribute names and set them as Rgttr models
     * @param string $dbViewName
     * @return \CArrayDataProvider
     */
    public static function getRgViewAttrs($dbViewName) {
        // get dbView attr names array
        $dbViewAttrs = self::getViewAttrsNames($dbViewName);
        // retreive default values from database
        $templateAttr = Rgattr::model()->attributes;

        // result
        $res = array();

        foreach ($dbViewAttrs as $attr) {
            $newRow = $templateAttr;
            $newRow['dbname'] = $attr;
            $res[] = $newRow;
        } // foreach
        return new CArrayDataProvider($res, array(
            'pagination' => false,
        ));
    }

}
