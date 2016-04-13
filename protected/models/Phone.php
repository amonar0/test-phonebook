<?php

class Phone extends CActiveRecord {
        public $id;
        public $number;
        public $person;

        function search() {
                $criteria = new CDbCriteria;
                $criteria->compare('id', $this->id);
                $criteria->compare('person', $this->person, true);
                $criteria->compare('number', $this->number);

                return new CActiveDataProvider(get_class($this), array(
                    'criteria' => $criteria,
                ));
        }

        function rules() {
                return array(
                    array('id', 'numerical', 'integerOnly' => true),
                    array('number, person', 'required'),
                    array('number', 'numerical', 'integerOnly' => true, 'integerPattern' => '/\d{5,15}/')
                );
        }

        function attributeLabels() {
                return array(
                    'id' => '#',
                    'number' => 'Phone №'
                );
        }

        static function model($className = __CLASS__) {
                return parent::model($className);
        }

        function tableName() {
                return 'phone';
        }

}
