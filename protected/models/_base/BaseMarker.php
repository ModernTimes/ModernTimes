<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - string name
 * - string specialClass
 * - integer requirementID
 * - string type
 * - string lat
 * - string lng
 * - string povHeading
 * - string povPitch
 * - integer povZoom
 * - string actionID
 * - string actionName
 * - integer actionTurn
 * - string actionParams
 * - string desc
 *
 * - Requirement requirement
 * <br>
 * <p>This is the model base class for the table "{{marker}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Marker".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseMarker extends GxActiveRecord {

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
		return '{{marker}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'Marker|Markers', $n);
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
			array('name, specialClass, lat, lng, povHeading, povPitch, actionID, actionName, actionParams, desc', 'required'),
			array('requirementID, povZoom, actionTurn', 'numerical', 'integerOnly'=>true),
			array('name, specialClass', 'length', 'max'=>100),
			array('type', 'length', 'max'=>8),
			array('lat, lng', 'length', 'max'=>9),
			array('povHeading', 'length', 'max'=>5),
			array('povPitch', 'length', 'max'=>4),
			array('actionID', 'length', 'max'=>25),
			array('actionName', 'length', 'max'=>50),
			array('requirementID, type, povZoom, actionTurn', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, specialClass, requirementID, type, lat, lng, povHeading, povPitch, povZoom, actionID, actionName, actionTurn, actionParams, desc', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
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
			'type' => Yii::t('app', 'Type'),
			'lat' => Yii::t('app', 'Lat'),
			'lng' => Yii::t('app', 'Lng'),
			'povHeading' => Yii::t('app', 'Pov Heading'),
			'povPitch' => Yii::t('app', 'Pov Pitch'),
			'povZoom' => Yii::t('app', 'Pov Zoom'),
			'actionID' => Yii::t('app', 'Action'),
			'actionName' => Yii::t('app', 'Action Name'),
			'actionTurn' => Yii::t('app', 'Action Turn'),
			'actionParams' => Yii::t('app', 'Action Params'),
			'desc' => Yii::t('app', 'Desc'),
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
		$criteria->compare('type', $this->type, true);
		$criteria->compare('lat', $this->lat, true);
		$criteria->compare('lng', $this->lng, true);
		$criteria->compare('povHeading', $this->povHeading, true);
		$criteria->compare('povPitch', $this->povPitch, true);
		$criteria->compare('povZoom', $this->povZoom);
		$criteria->compare('actionID', $this->actionID, true);
		$criteria->compare('actionName', $this->actionName, true);
		$criteria->compare('actionTurn', $this->actionTurn);
		$criteria->compare('actionParams', $this->actionParams, true);
		$criteria->compare('desc', $this->desc, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}