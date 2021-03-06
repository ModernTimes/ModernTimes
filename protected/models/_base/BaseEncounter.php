<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string name
 * - string specialClass
 * - integer onetime
 * - string msg
 * - integer costsTurn
 * - integer gainCash
 * - integer gainXp
 * - integer gainResoluteness
 * - integer gainWillpower
 * - integer gainCunning
 * - integer effectID
 * - integer effectDuration
 * - integer questID
 * - string questSetState
 *
 * - AreaEncounters areaEncounters
 * - CharacterEncounters characterEncounters
 * - Effect effect
 * - EncounterEncounters encounterEncounters
 * - EncounterEncounters encounterEncounters1
 * - EncounterItems encounterItems
 * <br>
 * <p>This is the model base class for the table "{{encounter}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Encounter".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseEncounter extends GxActiveRecord {

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
		return '{{encounter}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Encounter|Encounters', $n);
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
			array('name, specialClass, msg', 'required'),
			array('onetime, costsTurn, gainCash, gainXp, gainResoluteness, gainWillpower, gainCunning, effectID, effectDuration, questID', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('specialClass', 'length', 'max'=>50),
			array('questSetState', 'length', 'max'=>11),
			array('onetime, costsTurn, gainCash, gainXp, gainResoluteness, gainWillpower, gainCunning, effectID, effectDuration, questID, questSetState', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, specialClass, onetime, msg, costsTurn, gainCash, gainXp, gainResoluteness, gainWillpower, gainCunning, effectID, effectDuration, questID, questSetState', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'areaEncounters' => array(self::HAS_MANY, 'AreaEncounters', 'encounterID'),
			'characterEncounters' => array(self::HAS_MANY, 'CharacterEncounters', 'encounterID'),
			'effect' => array(self::BELONGS_TO, 'Effect', 'effectID'),
			'encounterEncounters' => array(self::HAS_MANY, 'EncounterEncounters', 'encounterID'),
			'encounterEncounters1' => array(self::HAS_MANY, 'EncounterEncounters', 'toEncounterID'),
			'encounterItems' => array(self::HAS_MANY, 'EncounterItems', 'encounterID'),
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
			'specialClass' => Yii::t('app', 'Special Class'),
			'onetime' => Yii::t('app', 'Onetime'),
			'msg' => Yii::t('app', 'Msg'),
			'costsTurn' => Yii::t('app', 'Costs Turn'),
			'gainCash' => Yii::t('app', 'Gain Cash'),
			'gainXp' => Yii::t('app', 'Gain Xp'),
			'gainResoluteness' => Yii::t('app', 'Gain Resoluteness'),
			'gainWillpower' => Yii::t('app', 'Gain Willpower'),
			'gainCunning' => Yii::t('app', 'Gain Cunning'),
			'effectID' => null,
			'effectDuration' => Yii::t('app', 'Effect Duration'),
			'questID' => Yii::t('app', 'Quest'),
			'questSetState' => Yii::t('app', 'Quest Set State'),
			'areaEncounters' => null,
			'characterEncounters' => null,
			'effect' => null,
			'encounterEncounters' => null,
			'encounterEncounters1' => null,
			'encounterItems' => null,
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
		$criteria->compare('specialClass', $this->specialClass, true);
		$criteria->compare('onetime', $this->onetime);
		$criteria->compare('msg', $this->msg, true);
		$criteria->compare('costsTurn', $this->costsTurn);
		$criteria->compare('gainCash', $this->gainCash);
		$criteria->compare('gainXp', $this->gainXp);
		$criteria->compare('gainResoluteness', $this->gainResoluteness);
		$criteria->compare('gainWillpower', $this->gainWillpower);
		$criteria->compare('gainCunning', $this->gainCunning);
		$criteria->compare('effectID', $this->effectID);
		$criteria->compare('effectDuration', $this->effectDuration);
		$criteria->compare('questID', $this->questID);
		$criteria->compare('questSetState', $this->questSetState, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}