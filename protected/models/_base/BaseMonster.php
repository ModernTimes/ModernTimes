<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string title
 * - string specialClass
 * - string sex
 * - integer contactID
 * - string contactProb
 * - integer hpMax
 * - integer attack
 * - integer defense
 * - string xp
 * - string msgEncounter
 *
 * - AreaMonsters areaMonsters
 * - Contact contact
 * - MonsterBattleskills monsterBattleskills
 * - MonsterItems monsterItems
 * <br>
 * <p>This is the model base class for the table "{{monster}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Monster".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseMonster extends GxActiveRecord {

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
		return '{{monster}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Monster|Monsters', $n);
	}

	/**
	 * Returns a string or array of strings
	 * Not quite sure what this is for, though
	 * @return mixed
	 */
	public static function representingColumn() {
		return 'title';
	}

	/**
	 * Returns an array with rules that specify valid Model data
	 * @return array
	 */
	public function rules() {
		return array(
			array('title, specialClass, hpMax, attack, defense, msgEncounter', 'required'),
			array('contactID, hpMax, attack, defense', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('specialClass', 'length', 'max'=>50),
			array('sex, xp', 'length', 'max'=>6),
			array('contactProb', 'length', 'max'=>4),
			array('sex, contactID, contactProb, xp', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, title, specialClass, sex, contactID, contactProb, hpMax, attack, defense, xp, msgEncounter', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'areaMonsters' => array(self::HAS_MANY, 'AreaMonsters', 'monsterID'),
			'contact' => array(self::BELONGS_TO, 'Contact', 'contactID'),
			'monsterBattleskills' => array(self::HAS_MANY, 'MonsterBattleskills', 'monsterID'),
			'monsterItems' => array(self::HAS_MANY, 'MonsterItems', 'monsterID'),
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
			'title' => Yii::t('app', 'Title'),
			'specialClass' => Yii::t('app', 'Special Class'),
			'sex' => Yii::t('app', 'Sex'),
			'contactID' => null,
			'contactProb' => Yii::t('app', 'Contact Prob'),
			'hpMax' => Yii::t('app', 'Hp Max'),
			'attack' => Yii::t('app', 'Attack'),
			'defense' => Yii::t('app', 'Defense'),
			'xp' => Yii::t('app', 'Xp'),
			'msgEncounter' => Yii::t('app', 'Msg Encounter'),
			'areaMonsters' => null,
			'contact' => null,
			'monsterBattleskills' => null,
			'monsterItems' => null,
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
		$criteria->compare('title', $this->title, true);
		$criteria->compare('specialClass', $this->specialClass, true);
		$criteria->compare('sex', $this->sex, true);
		$criteria->compare('contactID', $this->contactID);
		$criteria->compare('contactProb', $this->contactProb, true);
		$criteria->compare('hpMax', $this->hpMax);
		$criteria->compare('attack', $this->attack);
		$criteria->compare('defense', $this->defense);
		$criteria->compare('xp', $this->xp, true);
		$criteria->compare('msgEncounter', $this->msgEncounter, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}