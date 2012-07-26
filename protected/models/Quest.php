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
 * package System.Models 
 */

class Quest extends BaseQuest {
    
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