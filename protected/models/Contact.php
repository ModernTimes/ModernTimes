<?php

Yii::import('application.models._base.BaseContact');
Yii::import('application.components.contacts.*');

/**
 * Holds information about contact types.
 * 
 * Can be "overridden" by specialnessBehavior classes
 * 
 * See BaseContact for a list of attributes and related Models.
 * 
 * @uses SpecialnessBehavior
 * @package System.Models
 */

class Contact extends BaseContact {
    
    /**
     * Returns a string representation of the contact 
     * @return string
     */
    public function getTitle() {
        $ret = $this->getLevelOfInfluenceLabel() . $this->getAreaOfInfluenceLabel();
        $vowels = array('a', 'e', 'i', 'o', 'u');
        $ret = (in_array(substr($ret, 0, 1), $vowels) ? "An " : "A ") . $ret;
        return $ret;
    }
    
    /**
     * Returns a string representation of the contact's level of influence
     * @return string 
     */
    public function getLevelOfInfluenceLabel() {
        switch($this->levelOfInfluence) {
            case 1:
                return "small-time ";
            case 2:
                return "influential ";
            default:
                return "";
        }
    }
    
    /**
     * Returns a string representation of the contact's area of influence 
     */
    public function getAreaOfInfluenceLabel() {
        switch($this->areaOfInfluence) {
            case "populace":
                return "member of the populace";
            case "finance":
                return "player in the financial sector";
            case "realEconomy":
                return "player in the real economy";
            case "police":
                return "member of the police force";
            case "underworld":
                return "member of the underworld";
            case "society":
                return "socialite";
            case "press":
                return "member of the press";
            case "bureaucracy":
                return "bureaucrat";
            // Should never happen
            default:
                return "person";
        }
    }
    
    /**
     * Returns an empty string, indicating that the default view files should
     * be used to generate the content for the popup of this record.
     * "Override" by SpecialnessBehavior classes if you want non-standard
     * popup content
     * @param mixed $CharacterContent CharacterContacts or null
     * @return string
     */
    public function getPopup($CharacterContent = null) {
        return "";
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior",
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