<?php

/**
 * Provides global utility functions and wrappers to access the Character model 
 * and related character data. In particular, it defines the global function 
 * CD() (for CharacterData), which returns the Character model with a number of 
 * related models. 
 * 
 * CharacterData is initialized by GameController before any 
 * game action is executed. It redirects to the character creation action if it 
 * does not find an active character. On initialization, it attaches equipments,
 * skills, familiars, and other related models to the Character model, so that 
 * the CharacterModifierBehavior of these related models can interact with the 
 * Character model's calculations of basic character stats, like getMaxHp, 
 * getRobustness, getLevel, etc.
 * 
 * @uses Character
 * @link http://www.yiiframework.com/doc/api/1.1/CApplicationComponent
 * @package Character
 */

class CharacterData extends CApplicationComponent {
    /**
     * @var Character Model record
     */
    private $_model = null;
    
    /**
     * Called by Yii preloader
     * Used to initialize alias for Yii::app()->cd->_()
     * @return void
     */
    public function init() {
        if (!function_exists('CD')) {
            function CD() {
                return Yii::app()->cd->_();
                // $argv = func_get_args();
                // call_user_func_array(array("CharacterData", '_'), $argv);
            }
        }
    }
    
    /**
     * Called by GameController before any game actions are started
     * @todo Only read the complete character record from the DB,
     *       if some 'changed' parameter was set in the meantime
     * @return void
     */
    public function initialize () {
        if(is_a(Yii::app()->session['CD'], "Character")) {
            // If: changed-paramter was set in DB
            if(true) {
                Yii::log("Character info was changed since last action. Well, it probably hasn't, but let's pretend.");
                $this->load();
            } else {
                Yii::log("Character info has not been changed since last action. Use session info.");
                $this->_model = Yii::app()->session['CD'];
            }
        } else {
            Yii::log("No Character session data found");
            $this->load();
        }
    }
    
    /**
     * - Loads the Character model and related models
     * - Attaches related models like passive skills, familiars, etc. to the 
     * Character model
     * - Redirects to character creation action in case it doesn't find an 
     * active character for the current user
     * @todo Find a way to add the "available = 1" conditions again, without
     *       causing any errors. Update: so far, so good. Continue monitoring.
     * @todo put the static model() call into the Character model
     * @todo put the attach stuff things intot he Character model
     * That way, we can load and initialize other characters, too
     * @return void
     */
    public function load() {
        $this->_model = Character::model()->with(array(
            /**
             * Care: Current Yii version does not yet automatically alias 
             * recurring table names in with-calls. So we have to do it
             * ourselves.
             */
            'characterEquipments'=>array(
                'with' => array(
                    'weapon0' => array('with' => array(
                        'requirement' => array('alias' => 'weaponRequirement'),
                        'charactermodifier' => array('alias' => 'weaponCharactermodifier'))),
                    'offhand0' => array('with' => array(
                        'requirement' => array('alias' => 'offhandRequirement'),
                        'charactermodifier' => array('alias' => 'offhandCharactermodifier'))),
                    'accessoryA0' => array('with' => array(
                        'requirement' => array('alias' => 'accessoryARequirement'),
                        'charactermodifier' => array('alias' => 'accessoryACharactermodifier'))),
                    'accessoryB0' => array('with' => array(
                        'requirement' => array('alias' => 'accessoryBRequirement'),
                        'charactermodifier' => array('alias' => 'accessoryBCharactermodifier'))),
                    'accessoryC0' => array('with' => array(
                        'requirement' => array('alias' => 'accessoryCRequirement'),
                        'charactermodifier' => array('alias' => 'accessoryCCharactermodifier'))),
                ),
                'condition'=>"`characterEquipments`.`active`=1"
            ),
            'characterFamiliars'=>array(
                // 'condition'=>"`characterFamiliars`.`active`=1"
            ),
            /**
             * Actually, it's alright to lazy load this one. It's only relevant
             * in battles 
             */
            /**
            'characterSkillsets'=>array(
                'condition'=>"`characterSkillsets`.`active`=1"
            ),
            */
            'characterSkills' => array(
                'with' => array(
                    'skill' => array(
                        'with' => array(
                            // 'createEffect0',
                            'charactermodifier' => array('alias' => 'skillCharactermodifier'),
                        )
                    )
                ), 
                // 'condition' => "available = 1"
            ),
            'characterEffects'=> array(
                'with' => array(
                    'effect' => array(
                        'with' => array(
                            'charactermodifier' => array('alias' => 'effectCharactermodifier'),
                        )
                    )
                )
            ),
            'characterQuests' => array(
                'with' => array(
                    'quest'
                )
            ),
            'characterEncounters' => array(
                'with' => array(
                    'encounter'
                )
            )
        ))->find('t.userID=:userID AND t.active=1', 
                 array(':userID'=>Yii::app()->user->id));

        // d($this->_model);
        
        // If no active character can be found: redirect
        // @todo Change to character/create
        if(!is_a($this->_model, "Character")) {
            Yii::app()->controller->redirect(array('site/index'));
            // Yii::app()->controller->redirect(array('character/create'));
        }
        
        // Let Equipment Model attach all Item event handlers to the Character class
        $equipment = $this->_model->getEquipment();
        if($equipment !== null) {
            $equipment->attachToCharacter($this->_model);
        }
        
        // Attach effects's event handlers
        foreach($this->_model->characterEffects as $characterEffect) {
            $characterEffect->effect->call("attachToCharacter", $this->_model);
        }
        // Attach passive skill's charactermodifier's event handlers
        foreach($this->_model->characterSkills as $characterSkill) {
            $characterSkill->skill->call("attachToCharacter", $this->_model);
        }
        /**
         * Initialize quests, i.e. hook into Character's events, set a link
         * to a CharacterQuests record, and load params based on that record
         * Only if $characterQuest is not done for yet!
         */
        foreach($this->_model->characterQuests as $characterQuest) {
            if($characterQuest->state != "completed" &&
                    $characterQuest->state != "failed")
                
            $characterQuest->quest->call("initialize", $this->_model, $characterQuest);
        }
        
        PQPLogRoute::logMemory($this, "Completely loaded character data model");
        
        $this->saveSession();
    }
    
    /**
     * Tells the Character record to load related CharacterItem records
     * @todo Add further search criteria
     * @return void
     */
    public function loadItems() {
        $this->_model->loadItems();
    }

    /**
     * Returns the Character model
     * @return Character
     */
    public function _() {
        return $this->_model;
    }
    
    /**
     * Is called by GameController after game actions
     * Saves the Character model in case it has changed since it was loaded
     * @return void
     */
    public function save() {
        if($this->_model->attributesChanged()) {
            $this->_model->update();
            // $this->_model->save();
            $this->saveSession();
            Yii::trace("CharacterData: Character model saved");
        } else {
            Yii::trace("CharacterData: Character model not saved, since it has not been modified");
        }
    }
    
    /**
     * Does not do anything useful right now, since the character data is read 
     * in full from the database before any game action is executed. In 
     * deployment, the character data should only be read from the database if 
     * it has changed. If not, the data in the session can be used instead.
     * @return void
     */
    public function saveSession() {
        Yii::app()->session['CD'] = $this->_model;
    }
}