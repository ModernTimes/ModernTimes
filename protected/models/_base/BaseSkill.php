<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string name
 * - string skillType
 * - string specialClass
 * - integer charactermodifierID
 * - integer costEnergy
 * - integer healing
 * - integer createEffectID
 * - integer effectTurns
 * - string effectMsgIncreasedDuration
 * - string desc
 * - string msgResolved
 *
 * - CharacterSkills characterSkills
 * - Effect createEffect
 * - Charactermodifier charactermodifier
 * <br>
 * <p>This is the model base class for the table "{{skill}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Skill".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseSkill extends GxActiveRecord {

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
		return '{{skill}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Skill|Skills', $n);
	}

	/**
	 * Returns a string or array of strings
	 * Not quite sure what this is for, though
	 * @return mixed
	 */
	public static function representingColumn() {
		return 'name';
	}

	/**
	 * Returns an array with rules that specify valid Model data
	 * @return array
	 */
	public function rules() {
		return array(
			array('name, specialClass, effectMsgIncreasedDuration, desc, msgResolved', 'required'),
			array('charactermodifierID, costEnergy, healing, createEffectID, effectTurns', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('skillType', 'length', 'max'=>7),
			array('specialClass', 'length', 'max'=>50),
			array('skillType, charactermodifierID, costEnergy, healing, createEffectID, effectTurns', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, skillType, specialClass, charactermodifierID, costEnergy, healing, createEffectID, effectTurns, effectMsgIncreasedDuration, desc, msgResolved', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'characterSkills' => array(self::HAS_MANY, 'CharacterSkills', 'skillID'),
			'createEffect' => array(self::BELONGS_TO, 'Effect', 'createEffectID'),
			'charactermodifier' => array(self::BELONGS_TO, 'Charactermodifier', 'charactermodifierID'),
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
			'name' => Yii::t('app', 'Name'),
			'skillType' => Yii::t('app', 'Skill Type'),
			'specialClass' => Yii::t('app', 'Special Class'),
			'charactermodifierID' => null,
			'costEnergy' => Yii::t('app', 'Cost Energy'),
			'healing' => Yii::t('app', 'Healing'),
			'createEffectID' => null,
			'effectTurns' => Yii::t('app', 'Effect Turns'),
			'effectMsgIncreasedDuration' => Yii::t('app', 'Effect Msg Increased Duration'),
			'desc' => Yii::t('app', 'Desc'),
			'msgResolved' => Yii::t('app', 'Msg Resolved'),
			'characterSkills' => null,
			'createEffect' => null,
			'charactermodifier' => null,
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
		$criteria->compare('name', $this->name, true);
		$criteria->compare('skillType', $this->skillType, true);
		$criteria->compare('specialClass', $this->specialClass, true);
		$criteria->compare('charactermodifierID', $this->charactermodifierID);
		$criteria->compare('costEnergy', $this->costEnergy);
		$criteria->compare('healing', $this->healing);
		$criteria->compare('createEffectID', $this->createEffectID);
		$criteria->compare('effectTurns', $this->effectTurns);
		$criteria->compare('effectMsgIncreasedDuration', $this->effectMsgIncreasedDuration, true);
		$criteria->compare('desc', $this->desc, true);
		$criteria->compare('msgResolved', $this->msgResolved, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}