<?php

/**
 * @var $model CModel 
 */
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'rggrid' . $model->rgSiteView['id'],
    'dataProvider' => $model->search(),
    //'filter' => $model,
    'columns' => Chtml::listData($model->getVisibleAttrs(), 'dbname', 'dbname'),
    'beforeAjaxUpdate' => 'function(id,options){'
    . 'options.data =  $("#rgFilterForm' . $model->rgSiteView['id'] . '").serialize();'
    . '}',
));
