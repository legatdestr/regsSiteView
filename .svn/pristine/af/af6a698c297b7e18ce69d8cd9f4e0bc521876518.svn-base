<?php
/* @var $this RgentityController */
/* @var $model Rgentity */

$this->breadcrumbs = array(
    Yii::t('RgdesignerModule.constructor', 'Registry constructor'),
);

$this->menu = array(
    array('label' => Yii::t('RgdesignerModule.constructor', 'Add registry'), 'url' => array('create')),
);

?>

<?php
// print out flash messages
if ($this->module->printFlashes)
    foreach (Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . Yii::t('RgdesignerModule.constructor', $message) . "</div>\n";
    }
?>

<h1><?php echo Yii::t('RgdesignerModule.constructor', 'Registry constructor'); ?></h1>
<div class="row">
    <div class="span-12"><?php echo Yii::t('RgdesignerModule.constructor', 'To edit a previously configured registry, select it from the list.'); ?>
        <br/><?php echo Yii::t('RgdesignerModule.constructor', 'If you want to set up a new registry, select');
echo '"' . Yii::t('RgdesignerModule.constructor', 'Add registry') . '"' ?>.
    </div>
</div>    
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'rgentity-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    //'template' => '{pager}',
    'columns' => array(
        //'id',
        array(
            'name' => 'name',
            'value' => 'Chtml::link($data->name, array("update", "id"=>$data->id))',
            'type' => 'html',
        ),
        array(
            'name' => 'dbview',
            'value' => 'Chtml::link($data->dbview, array("update", "id"=>$data->id))',
            'type' => 'html',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}{delete}',
        ),
    ),
));

?>

