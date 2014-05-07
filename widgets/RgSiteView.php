<?php

/**
 * This file contains RgSiteView widget class.
 *
 * @author Sergey Kochetkov <legatdestr@gmail.com>
 * @copyright 2014 Elecard Med
 * @license BSD License
 */
class RgSiteView extends CWidget {

    public $entity_id;
    
    public function init() {
        // this method will be invoked in CBaseController::beginWidget ()
    }

    public function run() {
        // this method will be invoked in CBaseController::endWidget()
        
        $model = RgModelCreator::getInstance($this->entity_id, 'search');
        if (empty($model)) {
            echo '<div class="flash-error">'
            . Yii::t('RgSiteView.filter', 'No information in the database')
            . '</div>';
            return;
        } 
        $model->unsetAttributes();
        $modelClassName = get_class($model);
        if (isset($_REQUEST[$modelClassName])) {
            $model->attributes = $_REQUEST[$modelClassName];
        }
        $this->render('_filterForm', array(
            'model' => $model,
            'filters' => $model->getAttrFilters(),
        ));
        $this->render('grid', array(
            'model' => $model,
        ));
    }

}
