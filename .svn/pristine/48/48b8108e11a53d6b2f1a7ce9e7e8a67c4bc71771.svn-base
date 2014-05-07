<?php

class RgentityController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public function init() {
        $this->layout = $this->module->layout;
    }

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform actions
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete'),
                'users' => array('*'),
            ),
        );
    }

    /*     * *********************************************************************** */

    protected function showAttributes($viewData, $endApp = true) {
        $this->render('_showAttributes', array(
            'viewData' => $viewData,
        ));
        if ($endApp)
            Yii::app()->end();
    }

    protected function saveAttributes($viewData, $endApp = true) {
        //return false on success or Rgentity - $entityModel on success
        $useTransaction = $viewData['useTransaction'];
        $saved = Rgentity::saveEntityWithAttrs($viewData['entityModel'], $viewData['receivedAttrs'], $useTransaction, $viewData['attrErrors']);
        if ($saved) {
            // $this->redirect($this->createUrl('index'));
            $this->redirect(array('update', 'id' => $saved->id));
        } else {
            //$viewData['attrProvider'] = RgAttrsHelper::getRgViewAttrs($viewData['entityModel']->dbview);
            $this->render('_showAttributes', array(
                'viewData' => $viewData
            ));
            if ($endApp)
                Yii::app()->end();
        }
    }

    protected function showDefault($viewData, $endApp = true) {
        $this->render('_showDefault', array(
            'viewData' => $viewData,
                )
        );
        if ($endApp)
            Yii::app()->end();
    }

    /*     * *********************************************************************** */

    /**
     * Initialize user query environment
     * @return array
     */
    protected function initialize($entity_id = false) {
        // get dbPrefix from global module settings
        $dbPrefix = $this->module->dbPrefix;
        // contains models and other data
        $viewData = array();
        $viewData['dbPrefix'] = $dbPrefix;
        // Get list of avalaible database views
        $viewData['dbViews'] = RgDbHelper::getViewList($dbPrefix);

        $entityModel = ($entity_id) ? Rgentity::model()->findByPk($entity_id) : new Rgentity();
        $entityModel = (empty($entityModel)) ? new Rgentity() : $entityModel;

        $viewData['entityModel'] = $entityModel;

        $viewData['attrModel'] = new Rgattr();

        $viewData['dbViewName'] = (isset($_POST['Rgentity']['dbview'])) ?
                filter_var($_POST['Rgentity']['dbview'], FILTER_SANITIZE_STRING) : false;
        if (!$viewData['dbViewName'])
            $viewData['dbViewName'] = (empty($entityModel->dbview)) ? false : $entityModel->dbview;

        // RgViewAttrs
        // if update
        if ($entityModel->id) {
            $viewData['attrProvider'] = ($viewData['dbViewName']) ? RgAttrsHelper::combineRgViewAttrs($entityModel->id, $viewData['dbViewName']) :
                    new CArrayDataProvider(array());
        } else {
            $viewData['attrProvider'] = ($viewData['dbViewName']) ? RgAttrsHelper::getRgViewAttrs($viewData['dbViewName']) :
                    new CArrayDataProvider(array());
        }

        $viewData['attrErrors'] = array();

        $viewData['entityModel']->attributes = (isset($_POST['Rgentity'])) ? $_POST['Rgentity'] : null;

        // received attrs from user input. unsafed!!
        $viewData['receivedAttrs'] = ( (isset($_POST['Rgattr']) ? is_array($_POST['Rgattr']) : false) ) ?
                $_POST['Rgattr'] : false;

        $viewData['useTransaction'] = $this->module->useTransaction;

        $submit = isset($_POST['action_id']);

        $action = ($submit ? filter_var($_POST['action_id'], FILTER_SANITIZE_STRING) : 'showDefault' );

        $viewData['action'] = $action;

        return $viewData;
    }

    /**
     * Processing create entity action
     */
    public function actionCreate() {
        $data = $this->initialize();
        $action = $data['action'];
        if (method_exists($this, $action)) {
            $this->$action($data);
        } else {
            $this->showDefault($data);
        }
    }

    /**
     * Processing update action
     * @param Integer $id entity_id
     */
    public function actionUpdate($id) {

        $data = $this->initialize($id);
        $action = $data['action'];
        if ($action === 'showDefault') {
            $this->showAttributes($data);
        }
        if (method_exists($this, $action)) {
            $this->$action($data);
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Delete attribute by ID
     * @param integer $id Attriute ID
     */
    public function actionDeleteAttribute($id) {
        Rgattr::model()->findByPk($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Rgentity('search');
        $model->unsetAttributes();  // clear any default values
        // используется для поиска
        if (isset($_GET['Rgentity'])) {
            $model->attributes = $_GET['Rgentity'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Rgentity('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rgentity']))
            $model->attributes = $_GET['Rgentity'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rgentity the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Rgentity::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rgentity $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rgentity-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
