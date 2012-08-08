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
     * array with string representations of statuses that a contact can be in
     * @var array
     */
    public $statuses = array("befriended", "bribed", "seduced");
    
    /**
     * Checks whether the character is treated in some way already
     * @return boolean 
     */
    public function isTreated() {
        foreach($this->statuses as $status) {
            if($this->{$status}) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Returns the status of a treated contact
     * @return boolean 
     */
    public function getStatus() {
        foreach($this->statuses as $status) {
            if($this->{$status}) {
                return $status;
            }
        }
        return "untreated";
    }
    
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
     * Returns a description of the status of this contact
     * @uses getStatus
     * @return string 
     */
    public function getStatusDesc() {
        $status = $this->getStatus();
        switch($status) {
            case "befriended":
                return "You guys are <b>friends</b>";
            case "bribed":
                return "You <b>bribed</b> " . _objective($this->sex);
            case "seduced":
                return "You <b>seduced</b> " . _objective($this->sex);
            // should never happen
            case "untreated":
                return "You don't really know " . _objective($this->sex) . " yet";
            // should never happen
            default:
                return $this->name . " is <b>" . $status . "</b>";
        }
    }
    
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
                    'contact' => array(
                        'alias' => 'characterContactsContact' . self::getScopeCounter(),
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