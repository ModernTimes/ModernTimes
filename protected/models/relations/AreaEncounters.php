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
     * Returns the declaration of named scopes. A named scope represents a query
     * criteria that can be chained together with other named scopes and applied
     * to a query.
     * @link http://www.yiiframework.com/doc/api/1.1/CActiveRecord#scopes-detail
     * @return array the scope definition. The array keys are scope names
     */
    public function scopes() {
        return array(
            'withRelated' => array(
                'with' => array(
                    'encounter' => array(
                        'alias' => 'areaEncountersEncounter' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                ),
            ),
        );
    }
    
    /**
     * Factory method to get Model objects
     * @link http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }
}