<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string name
 * - string specialClass
 * - integer requirementID
 * - integer requirementBefriended
 * - integer requirementBribed
 * - integer requirementSeduced
 * - integer badConscience
 *
 * - ContactFavors contactFavors
 * - Requirement requirement
 * <br>
 * <p>This is the model base class for the table "{{favor}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Favor".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseFavor extends GxActiveRecord {

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
		return '{{favor}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Favor|Favors', $n);
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
			array('name, specialClass', 'required'),
			array('requirementID, requirementBefriended, requirementBribed, requirementSeduced, badConscience', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('specialClass', 'length', 'max'=>100),
			array('requirementID, requirementBefriended, requirementBribed, requirementSeduced, badConscience', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, specialClass, requirementID, requirementBefriended, requirementBribed, requirementSeduced, badConscience', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'contactFavors' => array(self::HAS_MANY, 'ContactFavors', 'favorID'),
			'requirement' => array(self::BELONGS_TO, 'Requirement', 'requirementID'),
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
			'requirementID' => null,
			'requirementBefriended' => Yii::t('app', 'Requirement Befriended'),
			'requirementBribed' => Yii::t('app', 'Requirement Bribed'),
			'requirementSeduced' => Yii::t('app', 'Requirement Seduced'),
			'badConscience' => Yii::t('app', 'Bad Conscience'),
			'contactFavors' => null,
			'requirement' => null,
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
		$criteria->compare('requirementID', $this->requirementID);
		$criteria->compare('requirementBefriended', $this->requirementBefriended);
		$criteria->compare('requirementBribed', $this->requirementBribed);
		$criteria->compare('requirementSeduced', $this->requirementSeduced);
		$criteria->compare('badConscience', $this->badConscience);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}