<?php

/**
 * - Starts game actions based on user input
 * - Defines filters that are checked before specific game actions are started
 * - Takes care of initializing CharacterData
 * - Cleans up after game actions are done
 * 
 * @uses CharacterData
 * @package Actions 
 */

class GameController extends Controller {

    /**
     * Defines the standard layout file to render view files in
     * Can be changed by Action classes
     * @var string
     */
    public $layout='//layouts/g_sidebar_standard';

    /**
     * The standard action for the game controller.
     * Redirect to last place (in session), or to map if no last place is
     * defined
     */
    public function actionIndex() {
        $this->redirect(Yii::app()->tools->getLastPlaceRoute());
    }

    /**
     * Returns an array that maps action ids with Action classes
     * @return array
     */
    public function actions() {
        return array(
            'map'              => 'application.controllers.actions.MapAction',
            
            'quests'           => 'application.controllers.actions.quests.QuestsAction',
            'acceptQuest'      => 'application.controllers.actions.quests.AcceptQuestAction',
            'rejectQuest'      => 'application.controllers.actions.quests.RejectQuestAction',
            
            'useSkill'         => 'application.controllers.actions.UseSkillAction',

            'mischief'         => 'application.controllers.actions.MischiefAction',
            'battleMonster'    => 'application.controllers.actions.battle.BattleMonsterAction',
            'battleAction'     => 'application.controllers.actions.battle.BattleActionAction',
            'encounter'        => 'application.controllers.actions.EncounterAction',
            
            'inventory'        => 'application.controllers.actions.inventory.InventoryAction',
            'autosell'         => 'application.controllers.actions.inventory.AutosellAction',
            'equip'            => 'application.controllers.actions.inventory.EquipAction',
            'unequip'          => 'application.controllers.actions.inventory.UnequipAction',
            'useItem'          => 'application.controllers.actions.inventory.UseItemAction',
            'combineItems'     => 'application.controllers.actions.inventory.CombineItemsAction',
            
            'contacts'         => 'application.controllers.actions.contacts.ContactsAction',
            'contact'          => 'application.controllers.actions.contacts.ContactAction',
            'exploitContact'   => 'application.controllers.actions.contacts.ExploitContactAction',
            'befriendContact'  => 'application.controllers.actions.contacts.BefriendContactAction',
            
            'home'             => 'application.controllers.actions.home.HomeAction',
            'rest'             => 'application.controllers.actions.home.RestAction',
            
            'shop'             => 'application.controllers.actions.shop.ShopAction',
            'buyItem'          => 'application.controllers.actions.shop.BuyItemAction',

            'consultantHQ'         => 'application.controllers.actions.consultant.ConsultantHQAction',
            
            /**
             * Quest specific stuff 
             */
            'questTutorialStartStep'    => 'application.controllers.actions.quests.tutorial.QuestTutorialStartStepAction',
            'questTutorialFight'    => 'application.controllers.actions.quests.tutorial.QuestTutorialFightAction',
            
            /**
             * To test new features without having to mess around with actual
             * game functions
             */
            'test'             => 'application.controllers.actions.TestAction'
        );
    }
    
    /**
     * So short that it's still in GameController. Will get its own file soon. 
     */
    public function actionCharacter() {
        $this->render('character', array("character" => CD()));
    }
    
    /**
     * Allows to fight a monster without going through an encounter.
     * Should only be used during development
     * @todo get rid of this in deployment
     * @param int $monsterID ID of the monster to fight (for testing purposes!)
     */
    public function actionBattleMonsterDirectly($monsterID) {
        $battleMonsterAction = new BattleMonsterAction($this, "battleMonster");
        $battleMonsterAction->monsterID = $monsterID;
        $this->runAction($battleMonsterAction);
    }
    
    
    /**
     * Returns a list of filters that are applied before a game action
     * is executed. See filterXXX functions for more details.
     * @link http://www.yiiframework.com/doc/api/CFilterChain
     * @return array
     */
    public function filters() {
        return array(
            'isRegistered', 
            // has active character
            'initCharacterDataComponent', 
            'noOngoingBattle',
            'noOngoingEncounter',
            'hasTurns + mischief, battleMonster, rest',
            'hasHp + mischief',
            // 'debugInfo'
            );
    }
    
    /**
     * Start logging memory usage of the render process
     * @param string $view
     * @return boolean always true
     */
    protected function beforeRender($view) {
        PQPLogRoute::logMemory("memory used before render");
        return true;
    }
    
    /**
     * Start logging memory usage of the action handling process
     * @param CAction $action action id
     * @return boolean always true
     */
    public function beforeAction($action) {
        PQPLogRoute::logMemory("memory used before game action");
        Yii::beginProfile("game action: " . $action->id);
        return true;
    }
    
    /**
     * - Add the GoodForNothing Effect if Character has no hp left
     * - Cap hp and energy at maxHp and maxEnergy respectively
     * - Save the Character record in case it has changed during the action
     * @param CAction $action
     * @return boolean always true
     */
    public function afterAction($action) {
        $character = CD();

        // Add GoodForNothing effect if character has 0 hp
        if($character->hp <= 0) {
            // Add GFN (ID 1) for 3 turns, unless it's already there
            Yii::app()->tools->addEffect($character, 1, 3, array('addTurns' => false));
        }
        
        $character->hp = min($character->hp, $character->getHpMax());
        $character->energy = min($character->energy, $character->getEnergyMax());

        // d($character);
        // Save Character AR in case it changed
        // (whether or not AR has changed is checked by AR behavior automatically)
        Yii::app()->cd->save();

        Yii::endProfile("game action: " . $action->id);
        
        return true;
    }
    
    /**
     * Checks if the user is registered
     * @param CFilterChain $c 
     */
    public function filterIsRegistered($c) {
        // if(Yii::app()->user->checkAccess('registered')) {
        if(!Yii::app()->user->isGuest) {
            $c->run();
        } else {
            Yii::app()->request->redirect(Yii::app()->user->returnUrl);
        }
    }
    
    /**
     * Initializes CharacterData. If there is no active Character record,
     * CharacterData will redirect to character/create action automatically
     * @uses CharacterData
     * @param CFilterChain $c 
     */
    public function filterInitCharacterDataComponent($c) {
        Yii::app()->cd->initialize();
        $c->run();
    }
    
    /**
     * Makes sure that the user does not cheat their way out of an
     * ongoing battle
     * @uses CharacterData
     * @param CFilterChain $c 
     */
    public function filterNoOngoingBattle($c) {
        if(CD()->ongoingBattleID !== null && 
           Yii::app()->controller->action->id != "battleAction") {

            $this->redirect(array('battleAction'));
            return;
        }
        $c->run();
    }

    /**
     * Makes sure that the user does not cheat their way out of an
     * ongoing Encounter path
     * @uses CharacterData
     * @param CFilterChain $c 
     */
    public function filterNoOngoingEncounter($c) {
        if(CD()->ongoingEncounterID !== null && 
           Yii::app()->controller->action->id != "encounter") {

            $this->redirect(array('encounter'));
            return;
        }
        $c->run();
    }    
    
    /**
     * Checks if the Character has turns left to do the action.
     * Only applies to certain actions.
     * @param CFilterChain $c 
     */
    public function filterHasTurns($c) {
        if(CD()->turns == 0) {
            EUserFlash::setErrorMessage("You can't do any more mischief right now.", 'validate');
            $this->redirect(array('index'));
            return;
        }
        $c->run();
    }
    
    /**
     * Checks if the Character has hp left.
     * Only applies to certain actions.
     * @param CFilterChain $c 
     */
    public function filterHasHp($c) {
        if(CD()->hp <= 0) {
            EUserFlash::setErrorMessage("You are too exhausted to do any mischief right now.", 'validate');
            $this->redirect(array('index'));
            return;
        }
        $c->run();
    }
    
    /**
     * Adds data about the active session to the log
     * @param CFilterChain $c 
     */
    public function filterDebugInfo($c) {
        Yii::trace("Session: " . var_export(Yii::app()->session, true));
        $c->run();
    }

}