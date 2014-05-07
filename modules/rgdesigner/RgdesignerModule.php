<?php

/**
 * This file contains RgdesignerModule class.
 *
 * @author Sergey Kochetkov <legatdestr@gmail.com>
 * @copyright 2014 Elecard Med
 * @license BSD License
 */
class RgdesignerModule extends CWebModule {

    /**
     * @var string database view name prefix. Default is 'reg_'
     * can be changed in the module settings in the application configuration file
     */
    public $dbPrefix = 'reg_';
    public $dbSchema;

    /**
     * Send or not user messages
     * @var boolean 
     * can be changed in the module settings in the application configuration file
     */
    public $sendFlashes = true;

    /**
     * Print out or not flash messages in own template
     * @var boolean 
     * can be changed in the module settings in the application configuration file
     */
    public $printFlashes = true;

    /**
     * Wrap saving in single transaction
     * @var boolean 
     */
    public $useTransaction = true;

    public function init() {
        
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components

        // I didn't find normal method for importing these classes using Yii.
        // $this->setImport() doesn't work correctly if this module is a submodule
        $DS = DIRECTORY_SEPARATOR;
        $inclPath = __DIR__ . $DS;
        
        require $inclPath . 'models' . $DS . 'Rgattr.php';
        require $inclPath . 'models' . $DS . 'Rgentity.php';
        require $inclPath . 'helpers' . $DS . 'RgAttrsHelper.php';
        require $inclPath . 'helpers' . $DS . 'RgDbHelper.php';
        
    }

    /**
     * This method is called before any module controller action is performed
     * @param CController $controller the controller
     * @param CAction $action the action
     * @return boolean
     */
    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }

}
