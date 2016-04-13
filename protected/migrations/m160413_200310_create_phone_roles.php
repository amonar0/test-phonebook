<?php

class m160413_200310_create_phone_roles extends CDbMigration {

        public function safeUp() {
                $this->createAuthTables();
                $this->createPhoneRoles();
        }
        
        private function createAuthTables() {
                $this->execute("drop table if exists AuthItem;
drop table if exists AuthItemChild;
drop table if exists AuthAssignment;

create table AuthItem
(
   name varchar(64) not null,
   type integer not null,
   description text,
   bizrule text,
   data text,
   primary key (name)
);

create table AuthItemChild
(
   parent varchar(64) not null,
   child varchar(64) not null,
   primary key (parent,child),
   foreign key (parent) references AuthItem (name) on delete cascade on update cascade,
   foreign key (child) references AuthItem (name) on delete cascade on update cascade
);

create table AuthAssignment
(
   itemname varchar(64) not null,
   userid varchar(64) not null,
   bizrule text,
   data text,
   primary key (itemname,userid),
   foreign key (itemname) references AuthItem (name) on delete cascade on update cascade
); ");
        }
        
        private function createPhoneRoles() {
                $auth = Yii::app()->authManager;

                $browsingRole = $auth->createRole('browsingPhone', 'просмотр телефонных записей');
                $auth->createOperation('viewPhone', 'просмотр телефона(-ов)');
                $browsingRole->addChild('viewPhone');

                $bizRule = 'return Yii::app()->user->name === "admin";';
                $ctrlRole = $auth->createRole('controlPhone', 'управление телефонными записями', $bizRule);
                $auth->createOperation('createPhone', 'создание телефонной записи');
                $ctrlRole->addChild('createPhone');

                $auth->createOperation('readPhone', 'просмотр телефонной записи');
                $ctrlRole->addChild('readPhone');

                $auth->createOperation('updatePhone', 'редактирование телефонной записи');
                $ctrlRole->addChild('updatePhone');

                $auth->createOperation('deletePhone', 'удаление телефонной записи');
                $ctrlRole->addChild('deletePhone');
        }

        public function down() {
                $this->dropTable('AuthItemChild');
                $this->dropTable('AuthAssignment');
                $this->dropTable('AuthItem');
        }

}
