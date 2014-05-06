Install database tables using sql/migrations/ or SQL code from sql/PostgreSQL.sql file

Add  'ext.regsSiteView.components.*' string to your config import section
Add the following lines to your config file:
    'modules' => array(
        'rgdesigner' => array(
            'class' => 'ext.regsSiteView.modules.rgdesigner.RgdesignerModule',
            'dbPrefix' => 'reg_', // database view prefix to search dbView
            'printFlashes' => true, // print flash messages or not
            'sendFlashes' => true, // send flash messages or not
        ),
    ),

You can use the Rg widget like this:
<?php 
$this->widget('ext.regsSiteView.widgets.RgSiteView', array(
    'entity_id' => $entityModel->id,
));
?>
Where $entityModel - descendant of the RgBaseModel. Id - rgentity table id.

Use modules/rgdesigner/assets/showAttributes.js to add your javascript.
Use modules/rgdesigner/assets/showAttributes.css to add your css.

Enjoy!