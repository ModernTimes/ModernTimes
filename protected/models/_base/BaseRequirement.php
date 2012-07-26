<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string class
 * - integer mainstat
 * - integer resoluteness
 * - integer willpower
 * - integer cunning
 *
 * - Area areas
 * - AreaEncounters areaEncounters
 * - AreaMonsters areaMonsters
 * - Item items
 * <br>
 * <p>This is the model base class for the table "{{requirement}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Requirement".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseRequirement extends GxActiveRecord {

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
		return '{{requirement}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Requirement|Requirements', $n);
	}

	/**
	 * Returns a string or array of strings
	 * Not quite sure what this is for, though
	 * @return mixed
	 */
	public static function representingColumn() {
		return 'class';
	}

	/**
	 * Returns an array with rules that specify valid Model data
	 * @return array
	 */
	public function rules() {
		return array(
			array('mainstat, resoluteness, willpower, cunning', 'numerical', 'integerOnly'=>true),
			array('class', 'length', 'max'=>12),
			array('class, mainstat, resoluteness, willpower, cunning', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, class, mainstat, resoluteness, willpower, cunning', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'areas' => array(self::HAS_MANY, 'Area', 'requirementID'),
			'areaEncounters' => array(self::HAS_MANY, 'AreaEncounters', 'requirementID'),
			'areaMonsters' => array(self::HAS_MANY, 'AreaMonsters', 'requirementID'),
			'items' => array(self::HAS_MANY, 'Item', 'requirementID'),
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
			'class' => Yii::t('app', 'Class'),
			'mainstat' => Yii::t('app', 'Mainstat'),
			'resoluteness' => Yii::t('app', 'Resoluteness'),
			'willpower' => Yii::t('app', 'Willpower'),
			'cunning' => Yii::t('app', 'Cunning'),
			'areas' => null,
			'areaEncounters' => null,
			'areaMonsters' => null,
			'items' => null,
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
		$criteria->compare('class', $this->class, true);
		$criteria->compare('mainstat', $this->mainstat);
		$criteria->compare('resoluteness', $this->resoluteness);
		$criteria->compare('willpower', $this->willpower);
		$criteria->compare('cunning', $this->cunning);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}