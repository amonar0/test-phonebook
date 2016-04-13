<?php

class m160413_184303_create_phone_table extends CDbMigration
{
	public function safeUp()
	{
                $this->createTable('phone', array(
                        'id' => 'pk',
                        'number' => 'BIGINT NOT NULL',
                        'person' => 'VARCHAR(128) NOT NULL',
                ));
                
                $this->populate();
	}
        
        private function populate() {
                $phones = array();
                for ($i = 1; $i <= 35; $i++) {
                        $digits = $i < 10 ? "0{$i}" : "$i";
                        $phones[] = array('number' => "790000000{$digits}", 'person' => "Человек {$i}");
                }
                $this->insertMultiple('phone', $phones);
        }

	public function down()
	{
		$this->dropTable('phone');
	}
}