<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string name
 * - string actionType
 * - string battlePhase
 * - string subType
 * - string specialClass
 * - integer costEnergy
 * - integer dealsDamage
 * - string damageAttackFactor
 * - integer damageFixedAmount
 * - string damageType
 * - integer healing
 * - integer createBattleeffectID
 * - integer battleeffectTurns
 * - string effectMsgIncreasedDuration
 * - string desc
 * - string msgResolved
 *
 * - Battleeffect createBattleeffect
 * - CharacterBattleskills characterBattleskills
 * - CharacterSkillsets characterSkillsets
 * - CharacterSkillsets characterSkillsets1
 * - CharacterSkillsets characterSkillsets2
 * - CharacterSkillsets characterSkillsets3
 * - CharacterSkillsets characterSkillsets4
 * - CharacterSkillsets characterSkillsets5
 * - CharacterSkillsets characterSkillsets6
 * - CharacterSkillsets characterSkillsets7
 * - CharacterSkillsets characterSkillsets8
 * - CharacterSkillsets characterSkillsets9
 * - MonsterBattleskills monsterBattleskills
 * <br>
 * <p>This is the model base class for the table "{{battleskill}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Battleskill".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseBattleskill extends GxActiveRecord {

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
		return '{{battleskill}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Battleskill|Battleskills', $n);
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
			array('name, subType, specialClass, effectMsgIncreasedDuration, desc, msgResolved', 'required'),
			array('costEnergy, dealsDamage, damageFixedAmount, healing, createBattleeffectID, battleeffectTurns', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('actionType, damageType', 'length', 'max'=>8),
			array('battlePhase', 'length', 'max'=>7),
			array('subType', 'length', 'max'=>20),
			array('specialClass', 'length', 'max'=>50),
			array('damageAttackFactor', 'length', 'max'=>5),
			array('actionType, battlePhase, costEnergy, dealsDamage, damageAttackFactor, damageFixedAmount, damageType, healing, createBattleeffectID, battleeffectTurns', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, actionType, battlePhase, subType, specialClass, costEnergy, dealsDamage, damageAttackFactor, damageFixedAmount, damageType, healing, createBattleeffectID, battleeffectTurns, effectMsgIncreasedDuration, desc, msgResolved', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'createBattleeffect' => array(self::BELONGS_TO, 'Battleeffect', 'createBattleeffectID'),
			'characterBattleskills' => array(self::HAS_MANY, 'CharacterBattleskills', 'battleskillID'),
			'characterSkillsets' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos10ID'),
			'characterSkillsets1' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos9ID'),
			'characterSkillsets2' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos1ID'),
			'characterSkillsets3' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos2ID'),
			'characterSkillsets4' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos3ID'),
			'characterSkillsets5' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos4ID'),
			'characterSkillsets6' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos5ID'),
			'characterSkillsets7' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos6ID'),
			'characterSkillsets8' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos7ID'),
			'characterSkillsets9' => array(self::HAS_MANY, 'CharacterSkillsets', 'pos8ID'),
			'monsterBattleskills' => array(self::HAS_MANY, 'MonsterBattleskills', 'battleskillID'),
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
			'actionType' => Yii::t('app', 'Action Type'),
			'battlePhase' => Yii::t('app', 'Battle Phase'),
			'subType' => Yii::t('app', 'Sub Type'),
			'specialClass' => Yii::t('app', 'Special Class'),
			'costEnergy' => Yii::t('app', 'Cost Energy'),
			'dealsDamage' => Yii::t('app', 'Deals Damage'),
			'damageAttackFactor' => Yii::t('app', 'Damage Attack Factor'),
			'damageFixedAmount' => Yii::t('app', 'Damage Fixed Amount'),
			'damageType' => Yii::t('app', 'Damage Type'),
			'healing' => Yii::t('app', 'Healing'),
			'createBattleeffectID' => null,
			'battleeffectTurns' => Yii::t('app', 'Battleeffect Turns'),
			'effectMsgIncreasedDuration' => Yii::t('app', 'Effect Msg Increased Duration'),
			'desc' => Yii::t('app', 'Desc'),
			'msgResolved' => Yii::t('app', 'Msg Resolved'),
			'createBattleeffect' => null,
			'characterBattleskills' => null,
			'characterSkillsets' => null,
			'characterSkillsets1' => null,
			'characterSkillsets2' => null,
			'characterSkillsets3' => null,
			'characterSkillsets4' => null,
			'characterSkillsets5' => null,
			'characterSkillsets6' => null,
			'characterSkillsets7' => null,
			'characterSkillsets8' => null,
			'characterSkillsets9' => null,
			'monsterBattleskills' => null,
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
		$criteria->compare('actionType', $this->actionType, true);
		$criteria->compare('battlePhase', $this->battlePhase, true);
		$criteria->compare('subType', $this->subType, true);
		$criteria->compare('specialClass', $this->specialClass, true);
		$criteria->compare('costEnergy', $this->costEnergy);
		$criteria->compare('dealsDamage', $this->dealsDamage);
		$criteria->compare('damageAttackFactor', $this->damageAttackFactor, true);
		$criteria->compare('damageFixedAmount', $this->damageFixedAmount);
		$criteria->compare('damageType', $this->damageType, true);
		$criteria->compare('healing', $this->healing);
		$criteria->compare('createBattleeffectID', $this->createBattleeffectID);
		$criteria->compare('battleeffectTurns', $this->battleeffectTurns);
		$criteria->compare('effectMsgIncreasedDuration', $this->effectMsgIncreasedDuration, true);
		$criteria->compare('desc', $this->desc, true);
		$criteria->compare('msgResolved', $this->msgResolved, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}