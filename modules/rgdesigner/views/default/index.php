<?php
/* @var $this DefaultController */

$this->breadcrumbs = array(
    mb_convert_case($this->module->id, MB_CASE_TITLE)
);
?>

<p><?php echo Yii::t('RgdesignerModule.constructor', 'Welcome to'); ?> Rgdesigner!</p>
<a href="<?php echo $this->createUrl('rgentity/index'); ?>"><?php echo Yii::t('RgdesignerModule.constructor', 'Constructor'); ?></a>
