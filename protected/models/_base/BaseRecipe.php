<?php

/**
 * This is the model base class for the table "{{recipe}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Recipe".
 *
 * Columns in table "{{recipe}}" available as properties of the model,
 * followed by relations of table "{{recipe}}" available as properties of the model.
 *
 * @property integer $id
 * @property integer $item1ID
 * @property integer $item2ID
 * @property integer $itemResultID
 * @property integer $costCash
 * @property integer $costFavours
 * @property integer $costKudos
 * @property integer $costsTurn
 *
 * @property Item $itemResult
 * @property Item $item1
 * @property Item $item2
 */
abstract class BaseRecipe extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{recipe}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Recipe|Recipes', $n);
	}

	public static function representingColumn() {
		return 'id';
	}

	public function rules() {
		return array(
			array('item1ID, item2ID, itemResultID', 'required'),
			array('item1ID, item2ID, itemResultID, costCash, costFavours, costKudos, costsTurn', 'numerical', 'integerOnly'=>true),
			array('costCash, costFavours, costKudos, costsTurn', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, item1ID, item2ID, itemResultID, costCash, costFavours, costKudos, costsTurn', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'itemResult' => array(self::BELONGS_TO, 'Item', 'itemResultID'),
			'item1' => array(self::BELONGS_TO, 'Item', 'item1ID'),
			'item2' => array(self::BELONGS_TO, 'Item', 'item2ID'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'item1ID' => null,
			'item2ID' => null,
			'itemResultID' => null,
			'costCash' => Yii::t('app', 'Cost Cash'),
			'costFavours' => Yii::t('app', 'Cost Favours'),
			'costKudos' => Yii::t('app', 'Cost Kudos'),
			'costsTurn' => Yii::t('app', 'Costs Turn'),
			'itemResult' => null,
			'item1' => null,
			'item2' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('item1ID', $this->item1ID);
		$criteria->compare('item2ID', $this->item2ID);
		$criteria->compare('itemResultID', $this->itemResultID);
		$criteria->compare('costCash', $this->costCash);
		$criteria->compare('costFavours', $this->costFavours);
		$criteria->compare('costKudos', $this->costKudos);
		$criteria->compare('costsTurn', $this->costsTurn);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}