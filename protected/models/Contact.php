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
     * array with string representations of potential treatments of contacts
     * @var array
     */
    public $treatments = array("befriendable", "bribable", "seducible");
    
    /**
     * Factory-style
     * Stamps out a specific contact based on the attributes of this record
     * @uses Name::createName
     * @param string $sex enum(male|female) default null
     * @param string $name Name to apply to CharacterContact. Default null
     * @return CharacterContacts
     */
    public function getCharacterContact($sex = null, $name = null) {
        $CharacterContact = new CharacterContacts();
        $CharacterContact->contactID = $this->id;
        $CharacterContact->contact = $this;
        
        // Sex
        if(empty($sex)) {
            $sex = (mt_rand(0,1) ? "female" : "male");
        }
        $CharacterContact->sex = $sex;
        
        // Name
        if(empty($name)) {
            $name = Name::createName($sex);
        }
        $CharacterContact->name = $name;
        
        // Bribable, befriendable, etc?
        foreach($this->treatments as $treatment) {
            if($this->{$treatment} == 0) {
            } elseif ($this->{$treatment} == 1) {
                $CharacterContact->{$treatment} = 1;
            } else {
                $rand = mt_rand(0, 1000);
                if($rand <= $this->{$treatment} * 1000) {
                    $CharacterContact->{$treatment} = 1;
                }
            }
        }
        return $CharacterContact;
    }
    
    /**
     * Returns a string representation of the contact 
     * @return string
     */
    public function getTitle() {
        $ret = ucfirst($this->getLevelOfInfluenceLabel()) . $this->getAreaOfInfluenceLabel();
        // $ret = Yii::app()->tools->addIndefArticle($ret);
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