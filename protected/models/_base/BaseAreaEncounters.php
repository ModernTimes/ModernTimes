<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - integer areaID
 * - integer encounterID
 * - string prob
 *
 * - Encounter encounter
 * - Area area
 * - EncounterEncounters encounterEncounters
 * - EncounterEncounters encounterEncounters1
 * <br>
 * <p>This is the model base class for the table "{{area_encounters}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AreaEncounters".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseAreaEncounters extends GxActiveRecord {

    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * Returns the name of the table that this model is based on
	 * @return string
	 */
	public function tableName() {
		return '{{area_encounters}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'AreaEncounters|AreaEncounters', $n);
	}

	/**
	 * Returns a string or array of strings
	 * Not quite sure what this is for, though
	 * @return mixed
	 */
	public static function representingColumn() {
		return 'prob';
	}

	/**
	 * Returns an array with rules that specify valid Model data
	 * @return array
	 */
	public function rules() {
		return array(
			array('areaID, encounterID', 'required'),
			array('areaID, encounterID', 'numerical', 'integerOnly'=>true),
			array('prob', 'length', 'max'=>7),
			array('prob', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, areaID, encounterID, prob', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'encounter' => array(self::BELONGS_TO, 'Encounter', 'encounterID'),
			'area' => array(self::BELONGS_TO, 'Area', 'areaID'),
			'encounterEncounters' => array(self::HAS_MANY, 'EncounterEncounters', 'toEncounterID'),
			'encounterEncounters1' => array(self::HAS_MANY, 'EncounterEncounters', 'fromEncounterID'),
		);
	}

	/**
	 * Returns an array that specifies pivotModel configurations
	 * @return array
	 */
	public function pivotModels() {
		return array(
		);
	}

	/**
	 * Returns an array with attributeLabels for the Model's attributes
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'areaID' => null,
			'encounterID' => null,
			'prob' => Yii::t('app', 'Prob'),
			'encounter' => null,
			'area' => null,
			'encounterEncounters' => null,
			'encounterEncounters1' => null,
		);
	}

	/**
	 * Returns a CActiveDataProvider, fed with search criteria based
	 * on the object's attributes
	 * @return CActiveDataProvider
	 * @link http://www.yiiframework.com/doc/api/CActiveDataProvider
	 */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('areaID', $this->areaID);
		$criteria->compare('encounterID', $this->encounterID);
		$criteria->compare('prob', $this->prob, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}