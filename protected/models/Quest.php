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
 * @package System.Models 
 */

class Quest extends BaseQuest {
    
    /**
     * Link to the Character record which this Quest belongs to
     * @var Character
     */
    public $Character;

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
     * Initializes the quest:
     * - Sets links to a Character and the CharacterQuests record
     * - If ongoing: Hooks into Character's events and
     *               Loads its params (or initializes them)
     * - Hooks its own reactToOnX to its onX
     * Is only called if CharacterQuest->state is not completed or failed
     * @uses loadParams
     * @uses setInitialParams
     * @uses onChangeState
     * @uses reactToOnChangeState
     * @uses callReactToOnChangeState
     * @param Character $Character
     * @param CharacterQuests $CharacterQuest 
     */
    public function initialize($Character, $CharacterQuest) {
        $this->Character = $Character;
        $this->CharacterQuest = $CharacterQuest;
        
        if($CharacterQuest->state == "ongoing") {
            $this->call('attachToCharacter', $Character);

            $this->loadParams();
            if(empty($this->params)) {
                $this->call('setInitialParams');
            }
        }
        
        $this->onChangeState = array($this, 'callReactToOnChangeState');
        $this->onUnavailable = array($this, 'callReactToOnUnavailable');
        $this->onAvailable = array($this, 'callReactToOnAvailable');
        $this->onOngoing = array($this, 'callReactToOnOngoing');
        $this->onCompleted = array($this, 'callReactToOnCompleted');
        $this->onRejected = array($this, 'callReactToOnRejected');
        $this->onFailed = array($this, 'callReactToOnFailed');
        $this->onSucceeded = array($this, 'callReactToOnSucceeded');
    }
    
    /**
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * Sets the initial parameters for the quest, e.g. counters, flags, etc.
     */
    public function setInitialParams() { }
    
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
     * - Sets the current state of the quest
     * - Updates $this->CharacterQuest if indicated
     * - Raises an onChangeState event
     * @uses CharacterQuests
     * @uses QuestChangeStateEvent
     * @uses onChangeStat
     * @param string $state enum(unavailable|available|ongoing|completed|rejected|failed)
     * @param bool $update default true
     */
    public function setState($state, $update = true) {
        $allowedStates = array("unavailable", "available", "rejected", 
                               "ongoing", "failed", "succeeded", "completed");
        if(in_array($state, $allowedStates) && 
                $state != $this->CharacterQuest->state) {
            
            $this->CharacterQuest->state = $state;
            if($update) {
                $this->CharacterQuest->update();
            }

            $event = new QuestChangeStateEvent(
                    $this, 
                    $this->CharacterQuest->state,
                    $state);
            $this->onChangeState($event);
        }
    }
    
    /**
     * Saves the serialized param attribute to CharacterQuest record
     * @uses CharacterQuests
     * @param bool $update default true
     */
    public function saveParams($update = true) {
        if(!empty($this->params)) {
            $this->CharacterQuest->questState = serialize($this->params);
        } else {
            $this->CharacterQuest->questState = null;
        }
        if($update) {
            $this->CharacterQuest->update();
        }
    }
    
    /**
     * Sets $this->params according to $this->CharacterQuest->questState 
     * @uses CharacterQuests
     */
    public function loadParams() {
        if(empty($this->params)) {
            $this->params = unserialize($this->CharacterQuest->questState);
        }
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
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onChangeState($event) {
        $this->raiseEvent("onChangeState", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onUnavailable($event) {
        $this->raiseEvent("onUnavailable", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onAvailable($event) {
        $this->raiseEvent("onAvailable", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onRejected($event) {
        $this->raiseEvent("onRejected", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onOngoing($event) {
        $this->raiseEvent("onOngoing", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onFailed($event) {
        $this->raiseEvent("onFailed", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onSucceeded($event) {
        $this->raiseEvent("onSucceeded", $event);
    }
    /**
     * Event raiser
     * @param QuestChangeStateEvent $event 
     */
    public function onCompleted($event) {
        $this->raiseEvent("onCompleted", $event);
    }
    
    /**
     * Event handler
     * Raises a more specific event depending on the new state
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnChangeState($event) { 
        switch($event->stateAfter) {
            case "unavailable":
                $this->onUnavailable($event);
                break;
            case "available":
                $this->onAvailable($event);
                break;
            case "rejected":
                $this->onRejected($event);
                break;
            case "ongoing":
                $this->onOngoing($event);
                break;
            case "failed":
                $this->onFailed($event);
                break;
            case "succeeded":
                $this->onSucceeded($event);
                break;
            case "completed":
                $this->onCompleted($event);
                break;
        }
    }
    /**
     * Wrapper for reactToOnChangeState which makes it possible to use
     * $this->call('reactToOnChangeState') as a callback in initialize
     * @uses reactToOnChangeState
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnChangeState($event) {
        $this->call('reactToOnChangeState', $event);
    }
    
    /**
     * Event handler
     * Standard reaction: set visible = 0
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnUnavailable($event) { 
        if($this->CharacterQuest->visible = 1) {
            $this->CharacterQuest->visible = 0;
            $this->CharacterQuest->update();
        }
    }
    /**
     * Wrapper for reactToOnUnavailable which makes it possible to use
     * $this->call('reactToOnUnavailable') as a callback in initialize
     * @uses reactToOnUnavailable
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnUnavailable($event) {
        $this->call('reactToOnUnavailable', $event);
    }

    /**
     * Event handler
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnAvailable($event) { }
    /**
     * Wrapper for reactToOnAvailable which makes it possible to use
     * $this->call('reactToOnAvailable') as a callback in initialize
     * @uses reactToOnAvailable
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnAvailable($event) {
        $this->call('reactToOnAvailable', $event);
    }
    
    /**
     * Event handler
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnRejected($event) { }
    /**
     * Wrapper for reactToOnRejected which makes it possible to use
     * $this->call('reactToOnRejected') as a callback in initialize
     * @uses reactToOnRejected
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnRejected($event) {
        $this->call('reactToOnRejected', $event);
    }

    /**
     * Event handler
     * Standard reaction: set visible = 1
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnOngoing($event) { 
        if($this->CharacterQuest->visible = 0) {
            $this->CharacterQuest->visible = 1;
            $this->CharacterQuest->update();
        }
    }
    /**
     * Wrapper for reactToOnOngoing which makes it possible to use
     * $this->call('reactToOnOngoing') as a callback in initialize
     * @uses reactToOnOngoing
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnOngoing($event) {
        $this->call('reactToOnOngoing', $event);
    }
    
    /**
     * Event handler
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnFailed($event) { }
    /**
     * Wrapper for reactToOnFailed which makes it possible to use
     * $this->call('reactToOnFailed') as a callback in initialize
     * @uses reactToOnFailed
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnFailed($event) {
        $this->call('reactToOnFailed', $event);
    }

    /**
     * Event handler
     * Quasi-abstract; "override" by SpecialnessBehavior classes.
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnSucceeded($event) { }
    /**
     * Wrapper for reactToOnSucceeded which makes it possible to use
     * $this->call('reactToOnSucceeded') as a callback in initialize
     * @uses reactToOnSucceeded
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnSucceeded($event) {
        $this->call('reactToOnSucceeded', $event);
    }

    /**
     * Event handler
     * Resets $this->params, sets visible = 1, and saves $this->CharacterQuest
     * @param QuestChangeStateEvent $event 
     */
    public function reactToOnCompleted($event) { 
        $this->CharacterQuest->visible = 1;
        $this->owner->params = array();
        $this->saveParams();
    }
    /**
     * Wrapper for reactToOnCompleted which makes it possible to use
     * $this->call('reactToOnCompleted') as a callback in initialize
     * @uses reactToOnCompleted
     * @param QuestChangeStateEvent $event 
     */
    public function callReactToOnCompleted($event) {
        $this->call('reactToOnCompleted', $event);
    }
    
    
    
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