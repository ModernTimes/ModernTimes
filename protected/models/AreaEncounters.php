<?php

Yii::import('application.models._base.BaseAreaEncounters');

/**
 * Basic HAS_MANY association model
 * Which encounters can the area trigger, and with which probability?
 * 
 * See BaseAreaEncounters for a list of attributes and related Models
 *
 * @see Area
 * @see Encounter
 * @package System.Models.Relations
 */

class AreaEncounters extends BaseAreaEncounters {

    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}