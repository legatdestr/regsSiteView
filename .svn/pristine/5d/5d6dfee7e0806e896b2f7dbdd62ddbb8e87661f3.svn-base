<div class="form">
    <?php
    $entityModel = $viewData['entityModel'];
    $dbViews = $viewData['dbViews'];
    $attrErrors = $viewData['attrErrors'];
    $attrErrors = empty($attrErrors)? null: $attrErrors;
    
    $formViews = $this->beginWidget('CActiveForm', array(
        'id' => 'showDefault',
        'action' => empty($entityModel->id) ? 'create' : 'update',
    ));
    ?>    
    <?php
    echo $formViews->errorSummary($entityModel);

    if (isset($attrErrors)):
        ?>
        <div class="errorSummary">
            <ul>
                <?php
                foreach ($attrErrors as $value) {
                    echo '<li>' . Yii::t('RgdesignerModule.constructor', $value) . '</li>';
                }
                ?>
            </ul></div>
<?php endif; ?>
    <div class="row">
        <div class="rgformViewsList">
            <?php echo $formViews->labelEx($entityModel, 'dbview'); ?>
            <?php
            $viewsValues = array_values($dbViews);
            echo $formViews->dropDownList(
                    $entityModel, 'dbview', array_combine($viewsValues, $viewsValues), // array('value' => 'value')
                    array('style' => 'width:50%; min-width:100px;')
            );
            ?>
<?php echo $formViews->error($entityModel, 'dbview'); ?>
        </div>
        <div class="buttons rgformViewsSubmit">
<?php echo CHtml::submitButton(Yii::t('RgdesignerModule.constructor', 'Select')); ?>
        </div>

    </div>

    <?php echo Chtml::hiddenField('action_id', 'showAttributes'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
