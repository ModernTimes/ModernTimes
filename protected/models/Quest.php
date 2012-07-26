<?php

Yii::import('application.models._base.BaseQuest');
Yii::import('application.components.quests.*');

/**
 * Provides some basic methods for handling quests.
 * Has to be "overridden" by SpecialnessBehavior classes to do anything useful.
 *
 * Adds a couple of standard event listeners to events triggered by Character.
 * If you add more event handlers, don't forget to add a line to
 * detachFromCharacter().
 * 
 * See BaseQuest for a list of attributes and related Models
 * 
 * @uses SpecialnessBehavior
 * @uses CharacterQuests
 * package System.Models 
 */

class Quest extends BaseQuest {
    
    /**
     * Link to a CharacterQuest record, which can be used to
     * change the state of a quest for a Character
     * @var CharacterQuest 
     */
    public $CharacterQuest;
    
    /**
     * Additional params to manage the Quest
     * @var array
     */
    public $params = array();
    
    /**
     * Initializes the quest, i.e. hooks into Character's events, sets a link
     * to a CharacterQuests record, and loads its params based on that record
     * @param Character $Character
     * @param CharacterQuests $CharacterQuest 
     */
    public function initialize($Character, $CharacterQuest) {
        $this->call('attachToCharacter', $Character);
        $this->CharacterQuest = $CharacterQuest;
        $this->loadParams();
    }
    
    /**
     * Basic version; "override" if necessary
     * Returns a string representation of the status of this Quest
     * (from the Character's point of view)
     * @uses getDescStatus
     * @return string
     */
    public function getDesc() {
        return "" . $this->desc . "<BR />" . $this->call('getDescStatus') . "";
    }
    /**
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * Returns a string representation of what is going on right now with
     * regard to this Quest (from the Character's point of view)
     * 
     * @return string empty
     */
    public function getDescStatus() { return ""; }
    
    /**
     * Sets the current state of the quest
     * @todo raise events
     * @uses CharacterQuests
     * @param string $state enum(available|ongoing|completed|rejected|failed)
     * @param bool $update default true
     */
    public function setState($state, $update = true) {
        switch($state) {
            case "available":
            case "ongoing":
            case "completed":
            case "rejected":
            case "failed":
                $this->CharacterQuest->state = $state;
                if($update) {
                    $this->CharacterQuest->update();
                }
                break;
            default:
                break;
        }
    }
    
    /**
     * Saves the serialized param attribute to CharacterQuest record
     * @uses CharacterQuests
     * @param bool $update default true
     */
    public function saveParams($update = true) {
        $this->CharacterQuest->params = serialize($this->params);
        if($update) {
            $this->CharacterQuest->update();
        }
    }
    
    /**
     * Sets $this->params according to $this->CharacterQuest->params 
     * @uses CharacterQuests
     */
    public function loadParams() {
        $this->params = unserialize($this->CharacterQuest->params);
    }
    
    
    /**
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * Attach this class's event handlers to the Character's events
     * 
     * @param Character $Character
     */
    public function attachToCharacter($Character) { }

    /**
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * Detach this class's event handlers from the Character's events
     * 
     * @param Character $Character
     */
    public function detachFromCharacter($Character) { }    

    /**
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * @todo get rid of this particular handler; it's not quest-like
     * @param CEvent $event with BonusCollectorBehavior
     */
    public function reactToOnCalcHp($event) { }    
    
    
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @return array
     */
    public function behaviors() {
        return array("application.components.SpecialnessBehavior");
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