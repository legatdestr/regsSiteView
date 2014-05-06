<?php

// PostgreSQL only
class m140416_062355_insert_demo_data extends CDbMigration {

    // Use safeUp/safeDown to do migration with transaction
    public function safeUp() {
        $this->insert('rgentity', array(
            'dbview' => 'reg_viewjoined',
            'name' => 'Имя реестра'
        ));

        $lastId = $this->dbConnection->getLastInsertID('rgentity_id_seq');             

        $this->insert('rgattr', array(
            'entity_id' => $lastId,
            'dbname' => 'name',
            'filtertype' => '0',
            'alias' => 'Имя атрибута',
            'enabled' => 'true',
        ));

        $this->insert('rgattr', array(
            'entity_id' => $lastId,
            'dbname' => 'producer_id',
            'filtertype' => '0',
            'alias' => 'Ид продюсера',
            'enabled' => 'true',
        ));

        $this->insert('rgentity', array(
            'dbview' => 'reg_speciality',
            'name' => 'Имя реестра специальностей большое длинное название неизвестно сколько символов.'
        ));
        
        $lastId = $this->dbConnection->getLastInsertID('rgentity_id_seq');        
        
        $this->insert('rgattr', array(
            'entity_id' => $lastId,
            'dbname' => 'id',
            'filtertype' => '0',
            'alias' => 'Имя атрибута',
            'enabled' => 'true',
        ));

        $this->insert('rgattr', array(
            'entity_id' => $lastId,
            'dbname' => 'name',
            'filtertype' => '0',
            'alias' => 'какое-тоимя',
            'enabled' => 'true',
        ));
    }

    public function safeDown() {
        $this->execute('DELETE FROM rgentity');
    }

}
