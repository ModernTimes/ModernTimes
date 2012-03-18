<?php

/**
 * This is the model base class for the table "{{character}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Character".
 *
 * Columns in table "{{character}}" available as properties of the model,
 * followed by relations of table "{{character}}" available as properties of the model.
 *
 * @property integer $id
 * @property integer $userID
 * @property integer $active
 * @property string $name
 * @property string $sex
 * @property string $class
 * @property integer $ongoingBattleID
 * @property integer $actions
 * @property integer $badConscience
 * @property integer $networkStrainedness
 * @property string $resolutenessSub
 * @property string $willpowerSub
 * @property string $cunningSub
 * @property integer $hp
 * @property integer $energy
 * @property integer $cash
 * @property integer $favours
 * @property integer $kudos
 *
 * @property User $user
 * @property CharacterEffects[] $characterEffects
 * @property CharacterItems[] $characterItems
 * @property CharacterSkills[] $characterSkills
 * @property Equipment[] $equipments
 * @property Familiar[] $familiars
 * @property Skillset[] $skillsets
 */
abstract class BaseCharacter extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{character}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Character|Characters', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('userID, active, name, class, ongoingBattleID, actions, badConscience, networkStrainedness, resolutenessSub, willpowerSub, cunningSub, hp, cash, favours, kudos', 'required'),
			array('userID, active, ongoingBattleID, actions, badConscience, networkStrainedness, hp, energy, cash, favours, kudos', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('sex', 'length', 'max'=>6),
			array('class', 'length', 'max'=>10),
			array('resolutenessSub, willpowerSub, cunningSub', 'length', 'max'=>8),
			array('sex, energy', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, userID, active, name, sex, class, ongoingBattleID, actions, badConscience, networkStrainedness, resolutenessSub, willpowerSub, cunningSub, hp, energy, cash, favours, kudos', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userID'),
			'characterEffects' => array(self::HAS_MANY, 'CharacterEffects', 'characterID'),
			'characterItems' => array(self::HAS_MANY, 'CharacterItems', 'characterID'),
			'characterSkills' => array(self::HAS_MANY, 'CharacterSkills', 'characterID'),
			'equipments' => array(self::HAS_MANY, 'Equipment', 'characterID'),
			'familiars' => array(self::HAS_MANY, 'Familiar', 'characterID'),
			'skillsets' => array(self::HAS_MANY, 'Skillset', 'characterID'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'userID' => null,
			'active' => Yii::t('app', 'Active'),
			'name' => Yii::t('app', 'Name'),
			'sex' => Yii::t('app', 'Sex'),
			'class' => Yii::t('app', 'Class'),
			'ongoingBattleID' => Yii::t('app', 'Ongoing Battle'),
			'actions' => Yii::t('app', 'Actions'),
			'badConscience' => Yii::t('app', 'Bad Conscience'),
			'networkStrainedness' => Yii::t('app', 'Network Strainedness'),
			'resolutenessSub' => Yii::t('app', 'Resoluteness Sub'),
			'willpowerSub' => Yii::t('app', 'Willpower Sub'),
			'cunningSub' => Yii::t('app', 'Cunning Sub'),
			'hp' => Yii::t('app', 'Hp'),
			'energy' => Yii::t('app', 'Energy'),
			'cash' => Yii::t('app', 'Cash'),
			'favours' => Yii::t('app', 'Favours'),
			'kudos' => Yii::t('app', 'Kudos'),
			'user' => null,
			'characterEffects' => null,
			'characterItems' => null,
			'characterSkills' => null,
			'equipments' => null,
			'familiars' => null,
			'skillsets' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('userID', $this->userID);
		$criteria->compare('active', $this->active);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('sex', $this->sex, true);
		$criteria->compare('class', $this->class, true);
		$criteria->compare('ongoingBattleID', $this->ongoingBattleID);
		$criteria->compare('actions', $this->actions);
		$criteria->compare('badConscience', $this->badConscience);
		$criteria->compare('networkStrainedness', $this->networkStrainedness);
		$criteria->compare('resolutenessSub', $this->resolutenessSub, true);
		$criteria->compare('willpowerSub', $this->willpowerSub, true);
		$criteria->compare('cunningSub', $this->cunningSub, true);
		$criteria->compare('hp', $this->hp);
		$criteria->compare('energy', $this->energy);
		$criteria->compare('cash', $this->cash);
		$criteria->compare('favours', $this->favours);
		$criteria->compare('kudos', $this->kudos);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}