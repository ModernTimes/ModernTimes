<?php

Yii::import('application.models._base.BaseContactFavors');

/**
 * Basic HAS_MANY association model
 * Which favors can a contact grant?
 * 
 * See BaseContactFavors for a list of attributes and related Models
 * 
 * @see Contact
 * @see Favor
 * @package System.Models.Relations
 */

class ContactFavors extends BaseContactFavors {
    
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
                    'favor' => array(
                        'alias' => 'contactFavorsFavor' . self::getScopeCounter(),
                        'scopes' => 'withRelated'
                    ),
                )
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