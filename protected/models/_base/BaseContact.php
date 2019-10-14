<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string specialClass
 * - string areaOfInfluence
 * - integer levelOfInfluence
 * - string befriendable
 * - string bribable
 * - string seducible
 *
 * - CharacterContacts characterContacts
 * - ContactFavors contactFavors
 * - Monster monsters
 * <br>
 * <p>This is the model base class for the table "{{contact}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Contact".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseContact extends GxActiveRecord {

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
		return '{{contact}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Contact|Contacts', $n);
	}

	/**
	 * Returns a string or array of strings
	 * Not quite sure what this is for, though
	 * @return mixed
	 */
	public static function representingColumn() {
		return 'specialClass';
	}

	/**
	 * Returns an array with rules that specify valid Model data
	 * @return array
	 */
	public function rules() {
		return array(
			array('specialClass', 'required'),
			array('levelOfInfluence', 'numerical', 'integerOnly'=>true),
			array('specialClass', 'length', 'max'=>100),
			array('areaOfInfluence', 'length', 'max'=>11),
			array('befriendable, bribable, seducible', 'length', 'max'=>4),
			array('areaOfInfluence, levelOfInfluence, befriendable, bribable, seducible', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, specialClass, areaOfInfluence, levelOfInfluence, befriendable, bribable, seducible', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'characterContacts' => array(self::HAS_MANY, 'CharacterContacts', 'contactID'),
			'contactFavors' => array(self::HAS_MANY, 'ContactFavors', 'contactID'),
			'monsters' => array(self::HAS_MANY, 'Monster', 'contactID'),
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
			'specialClass' => Yii::t('app', 'Special Class'),
			'areaOfInfluence' => Yii::t('app', 'Area Of Influence'),
			'levelOfInfluence' => Yii::t('app', 'Level Of Influence'),
			'befriendable' => Yii::t('app', 'Befriendable'),
			'bribable' => Yii::t('app', 'Bribable'),
			'seducible' => Yii::t('app', 'Seducible'),
			'characterContacts' => null,
			'contactFavors' => null,
			'monsters' => null,
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
		$criteria->compare('specialClass', $this->specialClass, true);
		$criteria->compare('areaOfInfluence', $this->areaOfInfluence, true);
		$criteria->compare('levelOfInfluence', $this->levelOfInfluence);
		$criteria->compare('befriendable', $this->befriendable, true);
		$criteria->compare('bribable', $this->bribable, true);
		$criteria->compare('seducible', $this->seducible, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}