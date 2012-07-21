<?php

Yii::import('application.models._base.BaseCharacter');

/**
 * Provides nice getter, setter, and "gainer" methods 
 * Getter and "gainer" methods raise events which allow other code thingies to 
 * hook into the respective calculations
 * 
 * See BaseCharacter for a list of attributes and related Models
 * 
 * @see CombatantBehavior
 * @see CharacterModifierBehavior
 * @link http://www.yiiframework.com/extension/attributesbackupbehavior/
 * @package Character
 */

class Character extends BaseCharacter {

    /**
     * BASIC INTERACTIONS
     */
    
    /**
     * Wrapper for gainResource
     * @see gainResource
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainCash($amount = 0, $from = '') {
        $this->gainResource('cash', $amount, $from);
    }
    /**
     * Wrapper for gainResource
     * @see gainResource
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainFavours($amount = 0, $from = '') {
        $this->gainResource('favours', $amount, $from);
    }
    /**
     * Wrapper for gainResource
     * @see gainResource
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainKudos($amount = 0, $from = '') {
        $this->gainResource('kudos', $amount, $from);
    }
    /**
     * Gives resources to the character (or take them away)
     * Before it actually does, it raises a gainingResource event, to which
     * other code elements can react, especially Model records with
     * CharacterModifierBehavior.
     * @todo define other sources (trade, whatever)
     * @param string $resource enum(cash|favours|kudos)
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     * Allows event handlers to react to gainStuff events only in case the
     * resources come from a certain source
     */ 
    private function gainResource($resource, $amount, $from) {
        $bonusAbs = 0;
        $bonusPerc = 1;
        
        // Note that amount is read-only
        $event = new CModelEvent($this, array('bonusAbs'  => &$bonusAbs,
                                              'bonusPerc' => &$bonusPerc,
                                              'amount' => $amount,
                                              'from'   => $from));
        call_user_func(array($this, "onGaining" . ucfirst($resource)), $event);
        
        $amount = floor(
                    $amount * (($bonusPerc + 100) / 100) +
                    $bonusAbs
                  );
        
        call_user_func(array($this, "increase" . ucfirst($resource)), $amount);
    }
    
    /**
     * Wrapper for increaseResource
     * @see increaseResource
     * @param float $amount
     */
    public function increaseCash($amount = 0) {
        $this->increaseResource('cash', $amount);
    }
    /**
     * Wrapper for increaseResource
     * @see increaseResource
     * @param float $amount
     */
    public function increaseFavours($amount = 0) {
        $this->increaseResource('favours', $amount);
    }
    /**
     * Wrapper for increaseResource
     * @see increaseResource
     * @param float $amount
     */
    public function increaseKudos($amount = 0) {
        $this->increaseResource('kudos', $amount);
    }
    /**
     * Increases the indicated resource by $amount (which can be negative)
     * Also generates an EUserFlash message to inform the user about this
     * fortunate turn of events.
     * This is more of a setter method and does not raise any events.
     * @param string $resource enum(cash|favours|kudos)
     * @param type int
     */
    private function increaseResource($resource, $amount) {
        if($amount > 0) {
            $this->{$resource} += (int) $amount;
            EUserFlash::setSuccessMessage((int) $amount . " " . ucfirst($resource), 'gainResource gain' . ucfirst($resource));
        }
    }
    
    /**
     * Returns the cumulative bonus to item drop chances by raising a
     * CalcDropItemBonus event, which is then modified by everything that
     * affects this stat, especially Model records with
     * CharacterModifierBehavior.
     * @return float bonus in percentage points
     */ 
    public function getDropItemPerc() {
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusPerc' => &$bonusPerc));
        $this->onCalcDropItemBonus($event);

        return $bonusPerc;
    }
    
    /**
     * Wrapper for gainItem. Allows handling of multiple Items.
     * @see gainItem
     * @param array $items several Items
     */
    public function gainItems($items) {
        if(!is_array($items) || empty($items)) { return; }
        
        foreach($items as $item) {
            $this->gainItem($item);
        }
    }
    /**
     * Adds an item to the character's inventory
     * @param Item $item 
     * @return bool success?
     */
    public function gainItem($item) {
        // d($item);

        if(!is_a($item, "Item")) {
            // ToDo: nice exception
            return false;
        }
       
        $this->loadItems();

        $added = false;
        foreach($this->characterItems as $characterItem) {
            if($characterItem->item->id == $item->id) {
                $characterItem->n ++;
                $characterItem->save();
                $added = true;
            }
        }
        if(!$added) {
            $CharacterItem = new CharacterItems;
            $CharacterItem->characterID = $this->id;
            $CharacterItem->itemID = $item->id;
            $CharacterItem->n = 1;
            $CharacterItem->save();
            $characterItems = $this->characterItems;
            $characterItems[] = $CharacterItem;
        }
        
        EUserFlash::setSuccessMessage("You got <b>" . $item->name . "</b>", 'gainItem id:' . $item->id);
        return true;
    }

    /**
     * Wrapper for changeHp
     * @see changeHp
     * @param int $amount
     * @return int how the hp actually changed
     */
    public function decreaseHp($amount) {
        return $this->changeHp(-$amount);
    }
    /**
     * Wrapper for changeHp
     * @see changeHp
     * @param int $amount 
     * @return int how the hp actually changed
     */
    public function increaseHp($amount) {
        return $this->changeHp($amount);
    }
    
    /** 
     * Changes $this->hp by $amount
     * Generates a EUserFlash message to inform the user about healing
     * @todo raise event in case the Character hits 0 hp
     * @param int $amount 
     * @return int how the hp actually changed
     */
    public function changeHp($amount) {
        $amount = (int) $amount;
        $hpBefore = $this->hp;
        
        $this->hp += $amount;

        if ($this->hp > $this->getHpMax()) {
            $this->hp = $this->getHpMax();
        }
        if($this->hp < 0) {
            $this->hp = 0;
        }
        
        $hpDifference = ($this->hp - $hpBefore);
        if(hpDifference > 0) {
            EUserFlash::setSuccessMessage($hpDifference, 'gainHp');
        }
        return $hpDifference;
    }
    
    /**
     * Wrapper for changeEnergy
     * @see changeEnergy
     * @param int $amount 
     * @return int how the energy actually changed
     */
    public function decreaseEnergy($amount) {
        return $this->changeEnergy(-$amount);
    }
    /**
     * Wrapper for changeEnergy
     * @see changeEnergy
     * @param int $amount 
     * @return int how the energy actually changed
     */
    public function increaseEnergy($amount) {
        return $this->changeEnergy($amount);
    }
    
    /** 
     * Changes $this->energy by $amount
     * Generates a EUserFlash message to inform the user about energy boosts
     * @param int $amount 
     * @return int how the energy actually changed
     */
    public function changeEnergy($amount) {
        $amount = (int) $amount;
        $energyBefore = $this->energy;

        $this->energy += $amount;
        
        if ($this->energy > $this->getEnergyMax()) {
            $this->energy = $this->getEnergyMax();
        }
        if($this->energy <= 0) {
            $this->energy = 0;
        }
        
        $energyDifference = $this->energy - $energyBefore;
        if($energyDifference > 0) {
            EUserFlash::setSuccessMessage($energyDifference, 'gainEnergy');
        }
        return $energyDifference;
    }
    
    /**
     * Wrapper for gainSubstat
     * @see gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainXp($amount = 0, $from = '') {
        $this->gainSubstat('xp', $amount, $from);
    }
    /**
     * Wrapper for gainSubstat
     * @see gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainResoluteness($amount = 0, $from = '') {
        $this->gainSubstat('resoluteness', $amount, $from);
    }
    /**
     * Wrapper for gainSubstat
     * @see gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainWillpower($amount = 0, $from = '') {
        $this->gainSubstat('willpower', $amount, $from);
    }
    /**
     * Wrapper for gainSubstat
     * @see gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     */
    public function gainCunning($amount = 0, $from = '') {
        $this->gainSubstat('cunning', $amount, $from);
    }
    /**
     * Gives substats to the character (or take them away)
     * Before it actually does, it raises a gainingSubstat event, to which
     * other code elements can react, especially Model records with
     * CharacterModifierBehavior.
     * @todo define other sources (trade, whatever)
     * @param string $substat enum(xp|robustness|cunning|willpower)
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     * Allows event handlers to react to gainingStuff events only in case the
     * substat come from a certain source
     */ 
    private function gainSubstat($substat, $amount, $from) {
        $bonusAbs = 0;
        $bonusPerc = 1;
        
        // Note that amount is read-only
        $event = new CModelEvent($this, array('bonusAbs'  => &$bonusAbs,
                                              'bonusPerc' => &$bonusPerc,
                                              'amount' => $amount,
                                              'from'   => $from));
        call_user_func(array($this, "onGaining" . ucfirst($substat)), $event);
        
        $amount = floor(
                    $amount * (($bonusPerc + 100) / 100) +
                    $bonusAbs
                  );
        
        call_user_func(array($this, "increase" . ucfirst($substat)), $amount);
    }

    /**
     * Divides xp gains among the three substats, depending on the Character
     * class
     * @see increaseResoluteness
     * @see increaseWillpower
     * @see increaseCunning
     * @param float $xp 
     */
    public function increaseXp($xp) {
        if($xp > 0) {
            EUserFlash::setSuccessMessage((int) $xp . " experience points", 'gainStat gainXP');
        }
        
        $cA = $this->getClassAttributes();
        $this->increaseResoluteness($xp * $cA[$this->class]['resoluteness'], false);
        $this->increaseWillpower($xp * $cA[$this->class]['willpower'], false);
        $this->increaseCunning($xp * $cA[$this->class]['cunning'], false);
    }
    
    /**
     * Wrapper for increaseSubstat
     * @see increaseSubstat
     * @param float $amount
     * @param bool $generateMsg
     */
    public function increaseResoluteness($amount, $generateMsg = true) {
        $this->increaseSubstat("resoluteness", $amount, $generateMsg);
    }
    /**
     * Wrapper for increaseSubstat
     * @see increaseSubstat
     * @param float $amount
     * @param bool $generateMsg
     */
    public function increaseWillpower($amount, $generateMsg = true) {
        $this->increaseSubstat("willpower", $amount, $generateMsg);
    }
    /**
     * Wrapper for increaseSubstat
     * @see increaseSubstat
     * @param float $amount
     * @param bool $generateMsg
     */
    public function increaseCunning($amount, $generateMsg = true) {
        $this->increaseSubstat("cunning", $amount, $generateMsg);
    }
    
    /**
     * Increases the indicated substat by $amount
     * @todo handle negative $amount
     * If $generateMsg: also generates an EUserFlash message to inform the user 
     * about this fortunate turn of events.
     * This is more of a setter method and does not raise any events.
     * @see Tools->decideBetweenTwoNumbers
     * @param string $stat enum(resoluteness|cunning|willpower)
     * @param bool $generateMsg
     */
    private function increaseSubstat($stat, $amount, $generateMsg = true) {
        // If amount is between two numbers, use RNG to determine which one to use
        $amount = Yii::app()->tools->decideBetweenTwoNumbers($amount);

        if($amount > 0) {
            $levelBefore = $this->getLevel();
            $statBefore = call_user_func(array($this, "get" . ucfirst($stat) . "Base"));

            $this->{$stat . "Sub"} += $amount;

            if($generateMsg) {
                EUserFlash::setSuccessMessage("Your gained " . (int) $amount . " " . $stat, 'gainStat gainSubstat gain' . ucfirst($stat));
            }

            if(call_user_func(array($this, "get" . ucfirst($stat) . "Base")) > $statBefore) {
                EUserFlash::setSuccessMessage("<b>Your " . $stat . " increased!</b>", 'gainStat gainNormalstat gain' . ucfirst($stat));
            }
            if($levelBefore < $this->getLevel()) {
                EUserFlash::setSuccessMessage("<b>You gained a level!</b>", 'gainStat gainLevel');
            }
        }
    }
    
    
    /**
     * RETRIEVAL OF CHARACTER DATA
     */
    
    /**
     * Wrapper for getStatBuffed
     * @see getStatBuffed
     * @return int
     */
    public function getResolutenessBuffed() {
        return $this->getStatBuffed("resoluteness");
    }
    /**
     * Wrapper for getStatBuffed
     * @see getStatBuffed
     * @return int
     */
    public function getWillpowerBuffed() {
        return $this->getStatBuffed("willpower");
    }
    /**
     * Wrapper for getStatBuffed
     * @see getStatBuffed
     * @return int
     */
    public function getCunningBuffed() {
        return $this->getStatBuffed("cunning");
    }

    /**
     * Returns the Character's buffed $stat (resoluteness, cunning, willpower)
     * In order to determine bonuses to the stat, it raises a 
     * CalcCharacterStat event, to which other code elements can react, 
     * especially Model records with CharacterModifierBehavior.
     * @uses CalcCharacterStatEvent
     * @uses adjustStat
     * @param string $stat enum(robustness|cunning|willpower)
     * @return int
     */ 
    private function getStatBuffed($stat) {
        $event = new CalcCharacterStatEvent($this);
        call_user_func(array($this, "onCalc" . ucfirst($stat)), $event);
        
        $base = call_user_func(array($this, "get" . ucfirst($stat) . "Base"));
        return $this->adjustStat($base, $event);
    }
    
    /**
     * Returns the base value (unbuffed) of the Character's resoluteness
     * @return int
     */
    public function getResolutenessBase() {
        return floor(sqrt($this->resolutenessSub));
    }
    /**
     * Returns the base value (unbuffed) of the Character's willpower
     * @return int
     */
    public function getWillpowerBase() {
        return floor(sqrt($this->willpowerSub));
    }
    /**
     * Returns the base value (unbuffed) of the Character's cunning
     * @return int
     */
    public function getCunningBase() {
        return floor(sqrt($this->cunningSub));
    }
    
    /**
     * Returns the Character's buffed maximum hp value
     * Buffed = Base * BonusPerc(entage based) + BonusAbs(olute)
     * In order to determine BonusPerc and BonusAbs, it raises a CalcHp
     * event, to which other code elements can react, especially Model records 
     * with CharacterModifierBehavior.
     * @return int
     */ 
    public function getHpMax() {
        $bonusAbs = 0;
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusAbs' => &$bonusAbs,
                                        'bonusPerc' => &$bonusPerc));
        call_user_func(array($this, "onCalcHp"), $event);

        $ret = (($this->getResolutenessBuffed() + 3) * (($bonusPerc + 100) / 100)
                    + $bonusAbs)
               * ($this->getClassType() == 'resoluteness' ? 1.5 : 1);
        $ret = max(floor($ret), 0);
                
        return $ret;
    }
    /**
     * Returns the Character's buffed maximum energy value
     * Buffed = Base * BonusPerc(entage based) + BonusAbs(olute)
     * In order to determine BonusPerc and BonusAbs, it raises a CalcHp
     * event, to which other code elements can react, especially Model records 
     * with CharacterModifierBehavior.
     * @return int
     */ 
    public function getEnergyMax() {
        $bonusAbs = 0;
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusAbs' => &$bonusAbs,
                                        'bonusPerc' => &$bonusPerc));
        call_user_func(array($this, "onCalcEnergy"), $event);

        $ret = (($this->getWillpowerBuffed() + 3) * (($bonusPerc + 100) / 100)
                    + $bonusAbs)
               * ($this->getClassType() == 'willpower' ? 1.5 : 1);
        $ret = max(floor($ret), 0);
                
        return $ret;
    }
    
    /**
     * Calculates the level (x) of the Character based on mainstat (y)
     * y = (x−1)^2 + 4
     * => y-4 = (x-1)^2
     * => sqrt(y-4)   = x-1
     * => sqrt(y-4)+1 = x
     * @return int
     */
    public function getLevel() {
        $mainstatBase = $this->getMainstatBase();
        return floor(
                sqrt(max(4,$mainstatBase) - 4)
               ) + 1;
    }
    /**
     * Returns level progression in % (0.25 for 25%)
     * @return float
     */
    public function getLevelProgress() {
        $mainstatBase = $this->getMainstatBase();
        $level = $this->getLevel();
        
        $statCurrentToNextLevel = pow($level, 2) - pow($level - 1, 2);
        $statThisLevel = $mainstatBase - pow($level - 1, 2) - 4;
        return $statThisLevel / $statCurrentToNextLevel;
    }
    
    /**
     * Wrapper for getResolutenessBase, getCunningBase, or getWillpowerBase,
     * depending on the Character's class's main stat
     * @see getResolutenessBase
     * @see getCunningBase
     * @see getWillpowerBase
     * @return int
     */
    public function getMainstatBase() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Base"));
    }
    /**
     * Wrapper for getResolutenessBuffed, getCunningBuffed, or 
     * getWillpowerBuffed, depending on the Character's class's main stat
     * @see getResolutenessBuffed
     * @see getCunningBuffed
     * @see getWillpowerBuffed
     * @return int
     */
    public function getMainstatBuffed() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Buffed"));
    }
    /**
     * Wrapper for getResolutenessSub, getCunningSub, or getWillpowerSub,
     * depending on the Character's class's main stat
     * @see getResolutenessSub
     * @see getCunningSub
     * @see getWillpowerSub
     * @return int
     */
    public function getMainstatSub() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Sub"));
    }

    /**
     * Returns the attack value of the Character (for normal attacks)
     * = resoluteness buffed
     * @uses getResolutenessBuffed
     * @return int
     */
    public function getNormalAttack() {
        return $this->getResolutenessBuffed();
    }
    /**
     * Returns the special attack value of the Character (for special attacks)
     * = willpower buffed
     * @uses getWillpowerBuffed
     * @return int
     */
    public function getSpecialAttack() {
        return $this->getWillpowerBuffed();
    }
    /**
     * Returns the defense value of the Character (against normal attacks)
     * = cunning buffed
     * @uses getCunningBuffed
     * @return int
     */
    public function getDefense() {
        return $this->getCunningBuffed();
    }
    
    /**
     * Adjusts the stat as specified by the CalcCharacterStatEvent.
     * Buffed = Base * ((BonusPerc+100)/100) + BonusAbs
     * It also cleans up the result according to the options specified in $opt
     * 
     * @uses CalcCharacterStatEvent
     * @uses Tools::decideBetweenTwoNumbers
     * 
     * @param float $base
     * @param CalcCharacterStatEvent $event
     * @param array $opt 
     * - string resultType enum(int|floor), default int
     * - string lastOperation enum(floor|round|ceil|random), default floor
     * - floor min minimum value, default 0
     * @return mixed int or float 
     */
    private function adjustStat($base, $event, $opt = array()) {
        $opt = array_merge(
            // The default options
            array(
                'resultType' => 'int',
                'lastOperation' => 'floor',
                'min' => 0
            ),
            // The specified options
            $opt
        );        

        $ret = $base * (($event->getBonusPerc() + 100) / 100) +
               $event->getBonusAbs();
        
        if($opt['resultType'] == "int") {
            switch($opt['lastOperation']) {
                case "floor":
                    $ret = floor($ret);
                    break;
                case "round":
                    $ret = round($ret);
                    break;
                case "ceil":
                    $ret = ceil($ret);
                    break;
                case "random":
                    $ret = Yii::app()->tools->decideBetweenTwoNumbers($ret);
                    break;
                default:
                    break;
            }
        }
        
        if(isset($opt['min'])) {
            $ret = max($ret, $opt['min']);
        }
                
        return $ret;
    }
    

    /**
     * OTHER STUFF
     */

    /**
     * Lazy loading of inventory items associated with the Character 
     */
    public function loadItems() {
        if(empty($this->characterItems)) {
            // d("EMPTY characterItems");
            $characterItems = CharacterItems::model()->with(array('item'))->findAll(
                't.characterID=:characterID', 
                array(':characterID'=>$this->id));
            // d($characterItems);
            $this->characterItems = $characterItems;
        }
    }
    
    /**
     * Generates a "get into position" combat message
     * @todo If this is going to be used, make it more dynamic
     * @return string
     */
    public function createFirstRoundCombatMessage() {
        return $this->name . " gets into a proper fighting position.";
    }
    /**
     * Returns a string that represents the title of the Character
     * @uses getLevel
     * @return string
     */
    public function getTitle() {
        return "Level " . $this->getLevel() . " " . ucfirst($this->class);
    }
    
    /**
     * Checks if the character has a certain Effect attached to them
     * @param Effect $effect
     * @return boolean 
     */
    public function hasEffect($effect) {
        foreach($this->characterEffects as $characterEffect) {
            if($characterEffect->effect->id == $effect->id) {
                return true;
            }
        }
        return false;
    }
    /**
     * Adds a CharacterEffects record to the Character record
     * @see CharacterEffects
     * @param CharacterEffects $characterEffect 
     */
    public function addEffect($characterEffect) {
        /**
         * Remember: $this->characterEffects is NOT a real property, but the 
         * result of a function call!
         */
        $charEffects = $this->characterEffects;
        $charEffects[] = $characterEffect;
        $this->characterEffects = $charEffects;
        $characterEffect->effect->attachToCharacter($this);
        EUserFlash::setNoticeMessage($characterEffect->effect->name, "<b>" . $characterEffect->effect->name . "</b> (for the next " . $characterEffect->turns . " encounters)", 'effect');
    }
    
    /**
     * Returns an Effect record of the indicated type if such an Effect is
     * attached to the Character. (false if there is no such Effect attached
     * to the Character)
     * @param Effect $effect
     * @return mixed Effect if Effect of the indicated type is found, false
     * otherwise
     */
    public function getEffect($effect) {
        foreach($this->characterEffects as $characterEffect) {
            if($characterEffect->effect->id == $effect->id) {
                return $characterEffect;
            }
        }
        return false;
    }

    /**
     * Returns the active CharacterFamiliars record
     * @see CharacterFamiliars
     * @return mixed CharacterFamiliar or null
     */
    public function getFamiliar() {
        foreach($this->characterFamiliars as $familiar) {
            if($familiar->active == 1) {
                return $familiar;
            }
        }
        return null;
    }
    /**
     * Returns the active CharacterEquipments record
     * @see CharacterEquipments
     * @return mixed CharacterEquipments or null
     */
    public function getEquipment() {
        foreach($this->characterEquipments as $equipment) {
            if($equipment->active == 1) {
                return $equipment;
            }
        }
        return null;
    }
    /**
     * Returns the active CharacterSkillsets record
     * @see CharacterSkillsets
     * @return mixed CharacterSkillsets or null
     */
    public function getSkillset() {
        foreach($this->characterSkillsets as $skillset) {
            if($skillset->active == 1) {
                return $skillset;
            }
        }
        return null;
    }

    /**
     * EVENT RAISERS
     */

    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onCalcHp($event) {
        $this->raiseEvent("onCalcHp", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onCalcEnergy($event) {
        $this->raiseEvent("onCalcEnergy", $event);
    }
    /**
     * Event raiser
     * @param CalcCharacterStatEvent $event 
     */
    public function onCalcResoluteness($event) {
        $this->raiseEvent("onCalcResoluteness", $event);
    }
    /**
     * Event raiser
     * @param CalcCharacterStatEvent $event 
     */
    public function onCalcWillpower($event) {
        $this->raiseEvent("onCalcWillpower", $event);
    }
    /**
     * Event raiser
     * @param CalcCharacterStatEvent $event 
     */
    public function onCalcCunning($event) {
        $this->raiseEvent("onCalcCunning", $event);
    }

    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingCash($event) {
        $this->raiseEvent("onGainingCash", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingFavours($event) {
        $this->raiseEvent("onGainingFavours", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingKudos($event) {
        $this->raiseEvent("onGainingKudos", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingXp($event) {
        $this->raiseEvent("onGainingXp", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingResoluteness($event) {
        $this->raiseEvent("onGainingResoluteness", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingWillpower($event) {
        $this->raiseEvent("onGainingWillpower", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainingCunning($event) {
        $this->raiseEvent("onGainingCunning", $event);
    }

    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onCalcDropItemBonus($event) {
        $this->raiseEvent("onCalcDropItemBonus", $event);
    }
    
    /**
     * BACKGROUND STUFF
     */
    
    /**
     * Returns an array indicating the relative importance of character stats
     * for all the Character classes
     * @return array
     */
    public function getClassAttributes() {
        return array(
            'consultant'   => array('cunning' => 0.5, 'resoluteness' => 0.3, 'willpower' => 0.2),
            'banker'       => array('cunning' => 0.5, 'willpower' => 0.3, 'resoluteness' => 0.2),
            'bureaucrat'   => array('resoluteness' => 0.5, 'willpower' => 0.3, 'cunning' => 0.2),
            'mobster'      => array('resoluteness' => 0.5, 'cunning' => 0.3, 'willpower' => 0.2),
            'celebrity'    => array('willpower' => 0.5, 'cunning' => 0.3, 'resoluteness' => 0.2),
            'politician'   => array('willpower' => 0.5, 'resoluteness' => 0.3, 'cunning' => 0.2), 
        );
    }
    
    /**
     * Returns the name of the Character's class's mainstat
     * Relies on mainstat getting 50% of the substat gains
     * @uses getClassAttribute
     * @return string enum(resoluteness|cunning|willpower)
     */
    public function getClassType() {
        $cA = $this->getClassAttributes();
        return array_search('0.5', $cA[$this->class]);
    }
    
    /**
     * Returns a list of CBehaviors to be attached to this Model
     * @link http://www.yiiframework.com/doc/api/CBehavior
     * @see CombatantBehavior
     * @link http://www.yiiframework.com/extension/attributesbackupbehavior/
     * @return array
     */
    public function behaviors() {
        return array(
            // 'withRelated'=>array('class'=>'ext.wr.WithRelatedBehavior',),
            "application.components.CombatantBehavior",
            'AttributesBackupBehavior' => 'ext.AttributesBackupBehavior',
        );
    }

    /**
     * Factory method to get Model objects
     * @see http://www.yiiframework.com/doc/api/CModel
     * @param string $className
     * @return CModel
     */
    public static function model($className=__CLASS__) {
	return parent::model($className);
    }
}