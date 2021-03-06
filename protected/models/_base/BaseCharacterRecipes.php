<?php

/**
 * Properties and related Models:
 *
 * - integer id
 * - integer characterID
 * - integer recipeID
 * - integer n
 *
 * - Recipe recipe
 * - Character character
 * <br>
 * <p>This is the model base class for the table "{{character_recipes}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "CharacterRecipes".</p>
 * <p>Beware: decimals and floats can show up as strings in the attribute list</p>
 *
 * @package System.Models.Base
 */
abstract class BaseCharacterRecipes extends GxActiveRecord {

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
		return '{{character_recipes}}';
	}

	/**
	 * Returns a label for this Model (singular or plural) based on $n
	 * @param int $n default 1
	 * @return string
	 */
	public static function label($n = 1) {
		return Yii::t('app', 'CharacterRecipes|CharacterRecipes', $n);
	}

	/**
	 * Returns a string or array of strings
	 * Not quite sure what this is for, though
	 * @return mixed
	 */
	public static function representingColumn() {
		return 'id';
	}

	/**
	 * Returns an array with rules that specify valid Model data
	 * @return array
	 */
	public function rules() {
		return array(
			array('characterID, recipeID', 'required'),
			array('characterID, recipeID, n', 'numerical', 'integerOnly'=>true),
			array('n', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, characterID, recipeID, n', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Returns an array of the form 
	 * "relationAttributeName" => array(BELONGS_TO|HAS_MANY, foreign Model, foreign attribute (key))
	 * @return array
	 */
	public function relations() {
		return array(
			'recipe' => array(self::BELONGS_TO, 'Recipe', 'recipeID'),
			'character' => array(self::BELONGS_TO, 'Character', 'characterID'),
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
			'characterID' => null,
			'recipeID' => null,
			'n' => Yii::t('app', 'N'),
			'recipe' => null,
			'character' => null,
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
		$criteria->compare('characterID', $this->characterID);
		$criteria->compare('recipeID', $this->recipeID);
		$criteria->compare('n', $this->n);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}