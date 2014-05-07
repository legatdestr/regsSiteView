<?php

/**
 * This is the model class for table "rgattr".
 *
 * The followings are the available columns in table 'rgattr':
 * @property integer $id
 * @property integer $entity_id
 * @property string $dbname
 * @property integer $filtertype
 * @property string $alias
 * @property boolean $enabled
 *
 * The followings are the available model relations:
 * @property Rgentity $entity
 */
class Rgattr extends CActiveRecord {

    const RG_FILTER_TYPE_DROPDN = 1;
    const RG_FILTER_TYPE_TEXTINP = 2;
    const RG_FILTER_TYPE_NONE = 0;

    /**
     *
     * @var boolean 
     */
    public $checked = false;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return isset(Yii::app()->params['dbSchema']) ? Yii::app()->params['dbSchema'] . '.rgattr' : 'rgattr';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('entity_id, filtertype', 'numerical', 'integerOnly' => true),
            array('entity_id, dbname, alias', 'required'),
            array('dbname, alias', 'length', 'max' => 255),
            array('enabled', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, entity_id, dbname, filtertype, alias, enabled', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'entity' => array(self::BELONGS_TO, 'Rgentity', 'entity_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        Yii::t('RgdesignerModule.constructor', 'Registry constructor');
        return array(
            'id' => Yii::t('RgdesignerModule.rgattr', 'id'),
            'entity_id' => Yii::t('RgdesignerModule.rgattr', 'entity_id'),
            'dbname' => Yii::t('RgdesignerModule.rgattr', 'Name in the database'),
            'filtertype' => Yii::t('RgdesignerModule.rgattr', 'Filter type'),
            'alias' => Yii::t('RgdesignerModule.rgattr', 'Human readable name'),
            'enabled' => Yii::t('RgdesignerModule.rgattr', 'Enabled/disabled'),
            'checker' => Yii::t('RgdesignerModule.rgattr', 'Enabled/disabled'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('entity_id', $this->entity_id);
        $criteria->compare('dbname', $this->dbname, true);
        $criteria->compare('isfiltered', $this->isfiltered);
        $criteria->compare('filtertype', $this->filtertype);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rgattr the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Array( index => filter name)
     * @return array Filter types
     */
    public static function getFilterType() {
        return array(
            self::RG_FILTER_TYPE_DROPDN => Yii::t('RgdesignerModule.rgattr', 'DropDown List'),
            self::RG_FILTER_TYPE_TEXTINP => Yii::t('RgdesignerModule.rgattr', 'Text filter'),
            self::RG_FILTER_TYPE_NONE => Yii::t('RgdesignerModule.rgattr', 'Not specified'),
        );
    }

    /**
     * Set 'enabled' field to false for all entity attributes
     * @param integer $entity_id Entity Id 
     */
    public static function disableEntityAttrs($entity_id) {

        Yii::app()
                ->db
                ->createCommand('UPDATE ' . self::model()->tableName() .
                        ' SET enabled = false WHERE entity_id = :entity_id')
                ->bindParam(':entity_id', $entity_id, PDO::PARAM_INT)
                ->execute();
    }

    /**
     * Used in constructor processing form
     * @param integer $entity_id
     * @param array $attrs UNSAFETY $_POST vars
     */
    public static function updateAttrs($entity_id, $attrs, $useTransaction = true) {
        if (!is_array($attrs))
            throw new Exception('Unable to update attribute');
        if ($useTransaction)
            $transaction = Yii::app()->db->beginTransaction();

        $isMarked = false;
        foreach ($attrs as $inDbName => $aRow) {
            if (isset($aRow['checked'])) {
                $isMarked = true;
                break;
            }
        }

        if ($isMarked === false) {
            throw new Exception('Unable to save attribute. No marked attributes.');
        }

        try {
            self::disableEntityAttrs($entity_id);
            foreach ($attrs as $inDbName => $aRow) {
                if (isset($aRow['checked'])) {
                    // отмечен галочкой
                    if (isset($aRow['id']) && (intval($aRow['id']) > 0)) {

                        // выполняем update
                        $id = intval($aRow['id']);
                        $attrModel = self::model()->findByPk($id);
                        if ($attrModel === null) {
                            throw new Exception('Attribute doesn`t exist.');
                        }
                        $attrModel->attributes = $aRow;
                        $attrModel->enabled = $aRow['checked'];
                        if (!$attrModel->save()) {
                            throw new Exception('Unable to update attribute');
                        }
                    } else {
                        $attrModel = new Rgattr();
                        $attrModel->attributes = $aRow;
                        $attrModel->enabled = true;
                        $attrModel->id = null;
                        $attrModel->dbname = $inDbName;
                        $attrModel->entity_id = $entity_id;
                        if (!$attrModel->save()) {
                            throw new Exception('Unable to save attribute');
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            if ($useTransaction)
                $transaction->rollback();
            throw $ex;
        }
        if ($useTransaction) {
            $transaction->commit;
        }
        return true;
    }

    public function beforeSave() {
//        if ((parent::beforeSave()) && ($this->isNewRecord)) {
//            $this->id = Yii::app()->db->createCommand('SELECT uuid_generate_v4();')->query()->readAll()[0]['uuid_generate_v4'];
//            return true;
//        }
//        return false;
    }

}
