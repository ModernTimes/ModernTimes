<?php

/**
 * This is the model base class for the table "{{encounter_items}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "EncounterItems".
 *
 * Columns in table "{{encounter_items}}" available as properties of the model,
 * followed by relations of table "{{encounter_items}}" available as properties of the model.
 *
 * @property integer $id
 * @property integer $encounterID
 * @property integer $itemID
 * @property double $prob
 *
 * @property Encounter $encounter
 * @property Item $item
 */
abstract class BaseEncounterItems extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{encounter_items}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'EncounterItems|EncounterItems', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('encounterID, itemID, prob', 'required'),
			array('encounterID, itemID', 'numerical', 'integerOnly'=>true),
			array('prob', 'numerical'),
			array('id, encounterID, itemID, prob', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'encounter' => array(self::BELONGS_TO, 'Encounter', 'encounterID'),
			'item' => array(self::BELONGS_TO, 'Item', 'itemID'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'encounterID' => null,
			'itemID' => null,
			'prob' => Yii::t('app', 'Prob'),
			'encounter' => null,
			'item' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('encounterID', $this->encounterID);
		$criteria->compare('itemID', $this->itemID);
		$criteria->compare('prob', $this->prob);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}