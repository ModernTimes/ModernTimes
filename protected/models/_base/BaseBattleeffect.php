<?php

/**
 * This is the model base class for the table "{{battleeffect}}".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Battleeffect".
 *
 * Columns in table "{{battleeffect}}" available as properties of the model,
 * followed by relations of table "{{battleeffect}}" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $specialClass
 * @property integer $blocks
 * @property string $blockActionTypes
 * @property string $blockActionNormalSpecial
 * @property string $blockChance
 * @property integer $blockTurns
 * @property integer $blockNumberOfBlocks
 * @property string $desc
 *
 * @property Skill[] $skills
 */
abstract class BaseBattleeffect extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{battleeffect}}';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Battleeffect|Battleeffects', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, specialClass, desc', 'required'),
			array('blocks, blockTurns, blockNumberOfBlocks', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>75),
			array('specialClass', 'length', 'max'=>50),
			array('blockActionTypes', 'length', 'max'=>10),
			array('blockActionNormalSpecial', 'length', 'max'=>7),
			array('blockChance', 'length', 'max'=>5),
			array('blocks, blockActionTypes, blockActionNormalSpecial, blockChance, blockTurns, blockNumberOfBlocks', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, specialClass, blocks, blockActionTypes, blockActionNormalSpecial, blockChance, blockTurns, blockNumberOfBlocks, desc', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'skills' => array(self::HAS_MANY, 'Skill', 'createEffect'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'specialClass' => Yii::t('app', 'Special Class'),
			'blocks' => Yii::t('app', 'Blocks'),
			'blockActionTypes' => Yii::t('app', 'Block Action Types'),
			'blockActionNormalSpecial' => Yii::t('app', 'Block Action Normal Special'),
			'blockChance' => Yii::t('app', 'Block Chance'),
			'blockTurns' => Yii::t('app', 'Block Turns'),
			'blockNumberOfBlocks' => Yii::t('app', 'Block Number Of Blocks'),
			'desc' => Yii::t('app', 'Desc'),
			'skills' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('specialClass', $this->specialClass, true);
		$criteria->compare('blocks', $this->blocks);
		$criteria->compare('blockActionTypes', $this->blockActionTypes, true);
		$criteria->compare('blockActionNormalSpecial', $this->blockActionNormalSpecial, true);
		$criteria->compare('blockChance', $this->blockChance, true);
		$criteria->compare('blockTurns', $this->blockTurns);
		$criteria->compare('blockNumberOfBlocks', $this->blockNumberOfBlocks);
		$criteria->compare('desc', $this->desc, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}