<?php

class m140415_101346_create_attr_tables extends CDbMigration {

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp() {
        // creating rgentity table
        $this->createTable('rgentity', array(
            'id' => 'pk',
            'dbview' => 'string NOT NULL',
            'name' => 'string NOT NULL UNIQUE',
        ));
        
        // creating rgattr table
        $this->createTable('rgattr', array(
            'id' => 'pk',
            'entity_id' => 'integer NOT NULL',
            'dbname' => 'string NOT NULL',
            'filtertype' => 'integer DEFAULT 0',
            'alias' => 'string',
            'enabled' => 'boolean DEFAULT false',
        ));
        // creating index on the entity_id column
        $this->createIndex('idx_rgattr_ent_id', 'rgattr', 'entity_id');
        // FK creating
        $this->addForeignKey(
                'fk_rgattr', 'rgattr', 'entity_id', 'rgentity', 'id', 'CASCADE', 'CASCADE');
       
    }

    public function safeDown() {
        $this->dropTable('rgattr');
        $this->dropTable('rgentity');        
    }

}
