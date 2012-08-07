<?php

Yii::import('application.models._base.BaseCharacterContacts');

/**
 * Basic HAS_MANY association model
 * Which contacts does the character have?
 * 
 * See BaseCharacterContacts for a list of attributes and related Models
 * 
 * @see Character
 * @see Contact
 * @package Character.Relations
 */

class CharacterContacts extends BaseCharacterContacts {
    
    /**
     * array with string representations of potential treatments of contacts
     * @var array
     */
    public $treatments = array("befriendable", "bribable", "seducible");
    
    /**
     * Returns an array with string identifiers of possible treatments
     * @return array
     */
    public function getPossibleTreatments() {
        $possibleTreatments = array();
        foreach($this->treatments as $treatment) {
            if($this->{$treatment}) {
                $possibleTreatments[] = $treatment;
            }
        }
        return $possibleTreatments;
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