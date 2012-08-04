<?php

Yii::import('application.models._base.BaseCharacter');

/**
 * Provides getter, setter, and "gainer" methods.
 * Getter and "gainer" methods raise events which allow other code thingies to 
 * hook into the respective calculations.
 * 
 * See BaseCharacter for a list of attributes and related Models.
 * 
 * @todo loadX methods with getRelated() 
 * http://www.yiiframework.com/doc/api/1.1/CActiveRecord#getRelated-detail
 * @todo put loadX, hasX, gainX, and addX in one place, fill gaps, and search
 * rest of code base for calls of these methods that can be beautified
 * 
 * @uses CombatantBehavior
 * @uses CharacterModifierBehavior
 * @uses CalcCharacterStatEvent
 * @link http://www.yiiframework.com/extension/attributesbackupbehavior/
 * @package Character
 */

class Character extends BaseCharacter {

    /**
     * BASIC INTERACTIONS
     */
    
    /**
     * Wrapper for gainResource
     * @uses gainResource
     * @param float $amount
     * @param string $source enum(other|battle|encounter|quest|autosell) 
     * @return int the actual amount of cash gained
     */
    public function gainCash($amount = 0, $source = '') {
        return $this->gainResource('cash', $amount, $source);
    }
    /**
     * Wrapper for gainResource
     * @uses gainResource
     * @param float $amount
     * @param string $source enum(other|battle|encounter|quest|autosell) 
     * @return int the actual amount of favours gained
     */
    public function gainFavours($amount = 0, $source = '') {
        return $this->gainResource('favours', $amount, $source);
    }
    /**
     * Wrapper for gainResource
     * @uses gainResource
     * @param float $amount
     * @param string $source enum(other|battle|encounter|quest|autosell) 
     * @return int the actual amount of kudos gained
     */
    public function gainKudos($amount = 0, $source = '') {
        return $this->gainResource('kudos', $amount, $source);
    }
    /**
     * Gives resources to the character (or takes them away)
     * Before it actually does, it raises a GainingResource event, to which
     * other code elements can react, especially Model records with
     * CharacterModifierBehavior.
     * @uses GainStatEvent
     * @param string $resource enum(cash|favours|kudos)
     * @param float $amount
     * @param string $source enum(other|battle|encounter|quest|autosell) 
     * Allows event handlers to react to gainStuff events only in case the
     * resources come from a certain source
     * @return int the actual amount of resource gained
     */ 
    private function gainResource($resource, $amount, $source) {
        $event = new GainStatEvent($this, array(
            'amount' => $amount,
            'source'   => $source
        ));
        call_user_func(array($this, "onGain" . ucfirst($resource)), $event);

        $amount = max(0, $event->adjustStat($amount));
        
        return call_user_func(array($this, "increase" . ucfirst($resource)), $amount);
    }
    
    /**
     * Wrapper for changeResource
     * @uses changeResource
     * @param float $amount
     * @return int the actual cash increase
     */
    public function increaseCash($amount = 0) {
        return $this->changeResource('cash', $amount);
    }
    /**
     * Wrapper for changeResource
     * @uses changeResource
     * @param float $amount
     * @return int actual change in resource
     */
    public function increaseFavours($amount = 0) {
        return $this->changeResource('favours', $amount);
    }
    /**
     * Wrapper for changeResource
     * @uses changeResource
     * @param float $amount
     * @return int actual change in resource
     */
    public function increaseKudos($amount = 0) {
        return $this->changeResource('kudos', $amount);
    }
    /**
     * Wrapper for changeResource
     * @uses changeResource
     * @param float $amount
     * @return int actual change in resource
     */
    public function decreaseCash($amount = 0) {
        return $this->changeResource('cash', -$amount);
    }
    /**
     * Wrapper for changeResource
     * @uses changeResource
     * @param float $amount
     * @return int actual change in resource
     */
    public function decreaseFavours($amount = 0) {
        return $this->changeResource('favours', -$amount);
    }
    /**
     * Wrapper for changeResource
     * @uses changeResource
     * @param float $amount
     * @return int actual change in resource
     */
    public function decreaseKudos($amount = 0) {
        return $this->changeResource('kudos', -$amount);
    }
    /**
     * Changes the indicated resource by $amount (which can be negative)
     * Also generates an EUserFlash message to inform the user about this
     * fortunate turn of events.
     * This is more of a setter method and does not raise any events.
     * @param string $resource enum(cash|favours|kudos)
     * @param int $amount
     * @return int actual change in resource
     */
    private function changeResource($resource, $amount) {
        // If amount is between two numbers, use RNG to determine which one to use
        $amount = Yii::app()->tools->decideBetweenTwoNumbers($amount);
        
        $this->{$resource} += $amount;
        if($amount > 0) {
            EUserFlash::setSuccessMessage($amount . " " . ucfirst($resource), 'gainResource gain' . ucfirst($resource));
        }
        return $amount;
    }
    
    /**
     * Returns the cumulative bonus to item drop chances by raising a
     * CalcDropItemBonus event, which is then modified by everything that
     * affects this stat, especially Model records with
     * CharacterModifierBehavior.
     * @uses CollectBonusEvent
     * @return float bonus in percentage points
     */ 
    public function getDropItemPerc() {
        $event = new CollectBonusEvent($this);
        $this->onCalcDropItemBonus($event);
        return $event->getBonusPerc();
    }
    
    /**
     * Wrapper for gainItem. Allows handling of multiple Items.
     * @uses gainItem
     * @param array $items several Items
     * @param string $source enum(other|battle|encounter|quest|unequip) 
     */
    public function gainItems($items, $source = "other") {
        if(!is_array($items) || empty($items)) { return; }
        
        foreach($items as $item) {
            $this->gainItem($item, 1, $source);
        }
    }
    /**
     * Adds an item to the character's inventory
     * @uses GainItemEvent
     * @uses onGainItem
     * @param Item $Item 
     * @param int $n how many Items of the indicated kind?
     * @param string $source enum(other|battle|encounter|quest|unequip) 
     * @return bool success?
     */
    public function gainItem($Item, $n = 1, $source = "other") {
        if(!is_a($Item, "Item")) {
            // @todo nice exception
            return false;
        }
       
        $this->loadItems();

        $CharacterItem = $this->getCharacterItem($Item);
        $CharacterItem->n += $n;
        $CharacterItem->save();

        if($source != "unequip") {
            $event = new GainItemEvent($this, $Item, $n);
            $this->onGainItem($event);
            EUserFlash::setSuccessMessage("You got " . $n . " <b>" . $Item->name . "</b>", 'gainItem id:' . $Item->id);
        }
        return true;
    }

    /**
     * Wrapper for changeHp
     * @uses changeHp
     * @param int $amount
     * @return int how the hp actually changed
     */
    public function decreaseHp($amount) {
        return $this->changeHp(-$amount);
    }
    /**
     * Wrapper for changeHp
     * @uses changeHp
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
        if($hpDifference > 0) {
            EUserFlash::setSuccessMessage($hpDifference, 'gainHp');
        }
        return $hpDifference;
    }
    
    /**
     * Wrapper for changeEnergy
     * @uses changeEnergy
     * @param int $amount 
     * @return int how the energy actually changed
     */
    public function decreaseEnergy($amount) {
        return $this->changeEnergy(-$amount);
    }
    /**
     * Wrapper for changeEnergy
     * @uses changeEnergy
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
     * @uses gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     * @return int actual xp gain
     */
    public function gainXp($amount = 0, $from = '') {
        return $this->gainSubstat('xp', $amount, $from);
    }
    /**
     * Wrapper for gainSubstat
     * @uses gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     * @return int actual substat gain
     */
    public function gainResoluteness($amount = 0, $from = '') {
        return $this->gainSubstat('resoluteness', $amount, $from);
    }
    /**
     * Wrapper for gainSubstat
     * @uses gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     * @return int actual substat gain
     */
    public function gainWillpower($amount = 0, $from = '') {
        return $this->gainSubstat('willpower', $amount, $from);
    }
    /**
     * Wrapper for gainSubstat
     * @uses gainSubstat
     * @param float $amount
     * @param string $from enum(battle|encounter|quest|autosell) 
     * @return int actual substat gain
     */
    public function gainCunning($amount = 0, $from = '') {
        return $this->gainSubstat('cunning', $amount, $from);
    }
    /**
     * Gives substats to the character (or take them away)
     * Before it actually does, it raises a GainingStatEvent, to which
     * other code elements can react, especially Model records with
     * CharacterModifierBehavior.
     * @uses GainStatEvent
     * @param string $substat enum(xp|robustness|cunning|willpower)
     * @param float $amount
     * @param string $source enum(other|battle|encounter|quest|autosell) 
     * Allows event handlers to react to gainingStuff events only in case the
     * substat come from a certain source
     * @return int actual substat gain
     */ 
    private function gainSubstat($substat, $amount, $source) {
        $event = new GainStatEvent($this, array(
            'amount' => $amount,
            'source'   => $source
        ));
        call_user_func(array($this, "onGain" . ucfirst($substat)), $event);
        
        $amount = max(0, $event->adjustStat($amount));
        
        return call_user_func(array($this, "increase" . ucfirst($substat)), $amount);
    }

    /**
     * Divides xp gains among the three substats, depending on the Character
     * class
     * @uses increaseResoluteness
     * @uses increaseWillpower
     * @uses increaseCunning
     * @param float $xp 
     * @return int actual xp gain
     */
    public function increaseXp($xp) {
        $actualXpGain = 0;
        $cA = $this->getClassAttributes();
        $actualXpGain += $this->increaseResoluteness($xp * $cA[$this->class]['resoluteness'], false);
        $actualXpGain += $this->increaseWillpower($xp * $cA[$this->class]['willpower'], false);
        $actualXpGain += $this->increaseCunning($xp * $cA[$this->class]['cunning'], false);
        if($actualXpGain > 0) {
            EUserFlash::setSuccessMessage($actualXpGain . " experience points", 'gainStat gainXP');
        }
        return $actualXpGain;
    }
    
    /**
     * Wrapper for increaseSubstat
     * @uses increaseSubstat
     * @param float $amount
     * @param bool $generateMsg
     * @return int actual substat gains
     */
    public function increaseResoluteness($amount, $generateMsg = true) {
        return $this->increaseSubstat("resoluteness", $amount, $generateMsg);
    }
    /**
     * Wrapper for increaseSubstat
     * @uses increaseSubstat
     * @param float $amount
     * @param bool $generateMsg
     * @return int actual substat gains
     */
    public function increaseWillpower($amount, $generateMsg = true) {
        return $this->increaseSubstat("willpower", $amount, $generateMsg);
    }
    /**
     * Wrapper for increaseSubstat
     * @uses increaseSubstat
     * @param float $amount
     * @param bool $generateMsg
     * @return int actual substat gains
     */
    public function increaseCunning($amount, $generateMsg = true) {
        return $this->increaseSubstat("cunning", $amount, $generateMsg);
    }
    
    /**
     * Increases the indicated substat by $amount
     * @todo handle negative $amount
     * If $generateMsg: also generates an EUserFlash message to inform the user 
     * about this fortunate turn of events.
     * This is more of a setter method and does not raise any events.
     * @uses Tools->decideBetweenTwoNumbers
     * @param string $stat enum(resoluteness|cunning|willpower)
     * @param bool $generateMsg
     * @return int actual substat gains
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
        return $amount;
    }
    
    
    /**
     * RETRIEVAL OF CHARACTER DATA
     */
    
    /**
     * Wrapper for getStatBuffed
     * @uses getStatBuffed
     * @return int
     */
    public function getResolutenessBuffed() {
        return $this->getStatBuffed("resoluteness");
    }
    /**
     * Wrapper for getStatBuffed
     * @uses getStatBuffed
     * @return int
     */
    public function getWillpowerBuffed() {
        return $this->getStatBuffed("willpower");
    }
    /**
     * Wrapper for getStatBuffed
     * @uses getStatBuffed
     * @return int
     */
    public function getCunningBuffed() {
        return $this->getStatBuffed("cunning");
    }

    /**
     * Returns the Character's buffed $stat (resoluteness, cunning, willpower)
     * In order to determine bonuses to the stat, it raises a 
     * CalcStat event, to which other code elements can react, 
     * especially Model records with CharacterModifierBehavior.
     * @uses CollectBonusEvent
     * @param string $stat enum(robustness|cunning|willpower)
     * @return int
     */ 
    private function getStatBuffed($stat) {
        $event = new CollectBonusEvent($this);
        call_user_func(array($this, "onCalc" . ucfirst($stat)), $event);
        
        $base = call_user_func(array($this, "get" . ucfirst($stat) . "Base"));
        $buffed = floor($event->adjustStat($base));
        
        return max(0, $buffed);
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
     * In order to determine hp bonuses, it raises a CalcHp
     * event, to which other code elements can react, especially Model records 
     * with CharacterModifierBehavior.
     * @uses CollectBonusEvent
     * @uses adjustStat
     * @return int
     */ 
    public function getHpMax() {
        $event = new CollectBonusEvent($this);
        call_user_func(array($this, "onCalcHp"), $event);

        $base = $this->getResolutenessBuffed() + 3;
        $buffed = max(1, $event->adjustStat($base));

        if($this->getClassType() == 'resoluteness') {
            $buffed = floor($buffed * 1.2);
        }
        return $buffed;
    }
    /**
     * Returns the Character's buffed maximum energy value
     * In order to determine energy bonuses, it raises a CalcEnergy
     * event, to which other code elements can react, especially Model records 
     * with CharacterModifierBehavior.
     * @uses CollectBonusEvent
     * @return int
     */ 
    public function getEnergyMax() {
        $event = new CollectBonusEvent($this);
        call_user_func(array($this, "onCalcEnergy"), $event);

        $base = $this->getWillpowerBuffed() + 3;
        $buffed = max(1, $event->adjustStat($base));

        if($this->getClassType() == 'willpower') {
            $buffed = floor($buffed * 1.3);
        }
        return $buffed;
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
     * @uses getResolutenessBase
     * @uses getCunningBase
     * @uses getWillpowerBase
     * @return int
     */
    public function getMainstatBase() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Base"));
    }
    /**
     * Wrapper for getResolutenessBuffed, getCunningBuffed, or 
     * getWillpowerBuffed, depending on the Character's class's main stat
     * @uses getResolutenessBuffed
     * @uses getCunningBuffed
     * @uses getWillpowerBuffed
     * @return int
     */
    public function getMainstatBuffed() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Buffed"));
    }
    /**
     * Wrapper for getResolutenessSub, getCunningSub, or getWillpowerSub,
     * depending on the Character's class's main stat
     * @uses getResolutenessSub
     * @uses getCunningSub
     * @uses getWillpowerSub
     * @return int
     */
    public function getMainstatSub() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Sub"));
    }

    /**
     * BATTLE STUFF 
     */
    
    /**
     * Returns how much damage the Character actually suffered
     * @uses onBeforeTakeDamage
     * @uses onAfterTakenDamage
     * @uses CombatantTakeDamageEvent
     * @uses CombatnatTakenDamageEvent
     * @param int $damage, how much damage the Character is to take
     * @param string $damageType enum(normal|vices)
     * @return int 
     */
    public function takeDamage($damage, $damageType) {
        // $debugArray["damageInitially"] = $damage;
        
        // TakeDamageEvent, collect bonuses
        $event = new CombatantTakeDamageEvent($this, $damage, $damageType);
        $this->onBeforeTakeDamage($event);
        $damageAdjusted = $event->adjustStat($damage);
        // $debugArray["damageAfterTakeDamageEvent"] = $damageAdjusted;
        
        // Reduce damage based on absolute damage reduction value
        $event = new CollectBonusEvent($this);
        $this->onCalcResistanceAbs($event);
        $damageAdjusted -= $event->getBonusAbs();
        // $debugArray["damageAfterResistanceAbs"] = $damageAdjusted;
        
        if($damageAdjusted > 0) {
            // Reduce damage based on resistance level
            $resistanceLevel = $this->getResistanceLevel($damageType);
            $damageAdjusted *= $this->getResistanceModifier($resistanceLevel);
            // $debugArray["damageAfterResistanceLevels"] = $damageAdjusted;
            
            // Beautify result
            $damageAdjusted = Yii::app()->tools->decideBetweenTwoNumbers(max($damageAdjusted, 0));
            // $debugArray['damageAfterBeautification'] = $damageAdjusted;

            // Actually take damage
            $this->decreaseHp($damageAdjusted);
        } else {
            $damageAdjusted = 0;
        }
        
        // takeN damage event, notification only
        $event = new CombatantTakenDamageEvent($this, $damageAdjusted, $damageType);
        $this->onAfterTakenDamage($event);
        
        // d($debugArray);
        return $damageAdjusted;
    }
    
    /**
     * Returns the resistance level against a given damage Type
     * Resistance is percentage based and has diminishing returns based on
     * resistance levels
     * @uses CollectBonusEvent
     * @param string $damageType enum(normal|vices)
     * @return int
     */
    public function getResistanceLevel($damageType = "normal") {
        $event = new CollectBonusEvent($this);
        call_user_func(array($this, "onCalcResistanceLevel" . ucfirst($damageType)), $event);
        return $event->getBonusAbs();
    }
    
    /**
     * Returns the damage modifier based on a resistance level against the
     * damage type
     * @todo load precalculated modifiers?
     * @param int $resistanceLevel 
     * @return float
     */
    public function getResistanceModifier($resistanceLevel) {
        return (0.1 + 0.9 * pow(10/11, $resistanceLevel));
    }
    
    /**
     * Returns the attack value depending on the relevant stat
     * @param string $stat enum(resoluteness|willpower)
     * @return int
     */
    public function getAttack($stat = "resoluteness") {
        switch($stat) {
            case "resoluteness":
                return $this->getResolutenessBuffed();
                break;
            case "willpower":
                return $this->getWillpowerBuffed();
                break;
            default:
                return 0;
                break;
        }
    }
    
    /**
     * Returns the defense value (= cunning)
     * @return int
     */
    public function getDefense() {
        return $this->getCunningBuffed();
    }
    
    /**
     * OTHER STUFF
     */

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
     * Lazy loading of CharacterItems records
     */
    public function loadItems() {
        if(!$this->hasRelated("characterItems")) {
            $characterItems = CharacterItems::model()->with(array(
                'item' => array(
                    'with' => array(
                        'requirement',
                        // 'useEffect', 
                        'charactermodifier'
                    )
                )
            ))->findAll(
                't.characterID=:characterID', 
                array(':characterID'=>$this->id));
            $this->characterItems = $characterItems;
        }
    }
    /**
     * Returns the CharacterItems record that belongs to a given item
     * Creates a new record with n = 0 if no CharacterItems record is found
     * @param mixed $item Item or int (ID of a Quest record)
     * @return CharacterItems
     */
    public function getCharacterItem($item) {
        $this->loadItems();
        if(is_numeric($item)) {
            $itemID = $item;
        } else {
            $itemID = $item->id;
        }
        foreach($this->characterItems as $characterItem) {
            if($characterItem->itemID == $itemID) {
                return $characterItem;
            }
        }
        
        /**
         * If no CharacterItems record exists for the given item,
         * create a new one with n = 0
         */
        $characterItem = new CharacterItems();
        $characterItem->characterID = $this->id;
        $characterItem->itemID = $itemID;
        $characterItem->n = 0;
        return $characterItem;
    }
    
    /**
     * Checks if the character has a given item
     * @uses getCharacterItem
     * @param mixed $item Item or int (ID of an Item record)
     * @return boolean 
     */
    public function hasItem($item) {
        $characterItem = $this->getCharacterItem($item);
        return ($characterItem->n > 0);
    }
    
    /**
     * Lazy loading of CharacterRecipes records
     */
    public function loadRecipes() {
        if(!$this->hasRelated("characterRecipes")) {
            $characterRecipes = CharacterRecipes::model()->with(array(
                'recipe' => array(
                    'with' => array(
                        'item1' => array(
                            'with' => array(
                                'charactermodifier' => array('alias' => 'item1charactermodifier'),
                                'requirement' => array('alias' => 'item1requirement')
                            )
                        ), 
                        'item2' => array(
                            'with' => array(
                                'charactermodifier' => array('alias' => 'item2charactermodifier'),
                                'requirement' => array('alias' => 'item2requirement')
                            )
                        ), 
                        'itemResult' => array(
                            'with' => array(
                                'charactermodifier' => array('alias' => 'itemResultcharactermodifier'),
                                'requirement' => array('alias' => 'itemResultrequirement')
                            )
                        ), 
                    )
                )
            ))->findAll(
                't.characterID=:characterID', 
                array(':characterID'=>$this->id));
            $this->characterRecipes = $characterRecipes;
        }
    }
    /**
     * Returns the CharacterRecipes record that belongs to a given recipe.
     * @param mixed $recipe Recipe or int (ID of a Recipe record)
     * @return CharacterRecipes
     */
    public function getCharacterRecipe($recipe) {
        $this->loadRecipes();
        if(is_numeric($recipe)) {
            $recipeID = $recipe;
        } else {
            $recipeID = $recipe->id;
        }
        foreach($this->characterRecipes as $characterRecipe) {
            if($characterRecipe->recipeID == $recipeID) {
                return $characterRecipe;
            }
        }
        
        /**
         * If no CharacterItems record exists for the given item,
         * create a new one with n = 0
         */
        $characterRecipe = new CharacterRecipes();
        $characterRecipe->characterID = $this->id;
        $characterRecipe->recipeID = $recipeID;
        $characterRecipe->n = 0;
        return $characterRecipe;
    }
    /**
     * Checks if the character has found a given recipe
     * @uses getCharacterRecipe
     * @param mixed $recipe Recipe or int (ID of a Recipe record)
     * @return boolean 
     */
    public function hasRecipe($recipe) {
        $characterRecipe = $this->getCharacterRecipe($recipe);
        return ($characterRecipe->n > 0);
    }

    /**
     * Lazy loading of CharacterSkillsets records
     */
    public function loadSkillsets() {
        if(!$this->hasRelated("characterSkillsets")) {
            $characterSkillsets = CharacterSkillsets::model()->with(array(
                'pos1', 'pos2', 'pos3', 'pos4', 'pos5', 'pos6',
                'pos7', 'pos8', 'pos9', 'pos10',
            ))->findAll(
                't.characterID=:characterID', 
                array(':characterID'=>$this->id));
            $this->characterSkillsets = $characterSkillsets;
        }
    }    
    
    /**
     * Lazy loading of CharacterQuests records
     */
    public function loadQuests() {
        if(!$this->hasRelated("characterQuests")) {
            $characterQuests = CharacterQuests::model()->withRelated()->findAll(
                't.characterID=:characterID', 
                array(':characterID'=>$this->id));
            $this->characterQuests = $characterQuests;
        }
    }
    
    /**
     * Returns the CharacterQuests record that belongs to a given quest
     * Creates a new record with state = unavailable if no
     * CharacterQuests record is found
     * @param mixed $quest Quest or int (ID of a Quest record)
     * @return CharacterQuests 
     */
    public function getCharacterQuest($quest) {
        $this->loadQuests();
        if(is_numeric($quest)) {
            $questID = $quest;
        } else {
            $questID = $quest->id;
        }
        foreach($this->characterQuests as $characterQuest) {
            if($characterQuest->questID == $questID) {
                return $characterQuest;
            }
        }
        
        /**
         * If no CharacterQuests record exists for the given quest,
         * create a new one with state = "unavailable";
         */
        $characterQuest = new CharacterQuests();
        $characterQuest->characterID = $this->id;
        $characterQuest->questID = $questID;
        $characterQuest->state = "unavailable";
        return $characterQuest;
    }
    
    /**
     * Checks if the character has completed a certain Quest
     * @uses getCharacterQuest
     * @param mixed $quest Quest or int (ID of a Quest record)
     * @return boolean 
     */
    public function hasQuestCompleted($quest) {
        $characterQuest = $this->getCharacterQuest($quest);
        return ($characterQuest->state == "completed");
    }

    /**
     * Returns a CharacterEffects record for a given $effect
     * (if no such effect is in place for the character, a new CharacterEffects
     * record will be created with turns = 0)
     * @param mixed $effect Effect or int
     * @return CharacterEffects
     */
    public function getCharacterEffect($effect) {
        if(is_numeric($effect)) {
            $effectID = $effect;
        } else {
            $effectID = $effect->id;
        }
        foreach($this->characterEffects as $characterEffect) {
            if($characterEffect->effectID == $effectID) {
                return $characterEffect;
            }
        }

        /**
         * If no CharacterEffects record exists for the given effect,
         * create a new one with turns = 0
         */
        $characterEffect = new CharacterEffects();
        $characterEffect->characterID = $this->id;
        $characterEffect->effectID = $effectID;
        $characterEffect->turns = 0;
        return $characterEffect;
    }

    /**
     * Checks if the character has a certain Effect attached to them
     * @uses getCharacterEffect
     * @param mixed $effect Effect or int (ID of an effect record)
     * @return boolean 
     */
    public function hasEffect($effect) {
        $characterEffect = $this->getCharacterEffect($effect);
        return ($characterEffect->turns > 0);
    }
    
    /**
     * Adds a CharacterEffects record to the Character record
     * @uses onAddEffect
     * @uses GainEffectEvent
     * @todo Flash message only if the Character record represents the current
     * user's character
     * @uses CharacterEffects
     * @param CharacterEffects $characterEffect 
     */
    public function addCharacterEffect($characterEffect) {
        /**
         * Remember: $this->characterEffects is NOT a real property, but the 
         * result of a function call!
         */
        $charEffects = $this->characterEffects;
        $charEffects[] = $characterEffect;
        $this->characterEffects = $charEffects;
        $characterEffect->effect->attachToCharacter($this);
        
        $event = new GainEffectEvent($this, $characterEffect);
        $this->onGainEffect($event);
        
        EUserFlash::setNoticeMessage($characterEffect->effect->name, "<b>" . $characterEffect->effect->name . "</b> (for the next " . $characterEffect->turns . " encounters)", 'effect');
    }

    /**
     * Returns a CharacterSkills record
     * (If the character does not know the skill, a new record will be created
     * with available = 0)
     * @param mixed $skill Skill or int
     * @return CharacterSkills
     */
    public function getCharacterSkill($skill) {
        if(is_numeric($skill)) {
            $skillID = $skill;
        } else {
            $skillID = $skill->id;
        }
        foreach($this->characterSkills as $characterSkill) {
            if($characterSkill->skillID == $skillID) {
                return $characterSkill;
            }
        }
        
        /**
         * If no CharacterSkills record exists,
         * create a new one with available = 0
         */
        $characterSkill = new CharacterSkills();
        $characterSkill->characterID = $this->id;
        $characterSkill->skillID = $skillID;
        $characterSkill->available = 0;
        return $characterSkill;
    }

    /**
     * Checks if the character knows a certain skill
     * @uses getCharacterSkill
     * @param mixed $skill Skill or int (ID of a Skill record)
     * @return boolean 
     */
    public function hasSkill($skill) {
        $characterSkill= $this->getCharacterSkill($skill);
        return ($characterSkill->available);
    }
    
    /**
     * Returns the active CharacterFamiliars record
     * @see CharacterFamiliars
     * @return mixed CharacterFamiliars or null
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
     * Since some equipment data is laoded in CharacterData, we need
     * to be able to find out if the full data has been loaded or not
     * @var bool
     */
    private $hasRelatedEquipmentsFull = false;
    /**
     * Lazy loading of CharacterEquipments records
     */
    public function loadEquipments() {
        if(!$this->hasRelatedEquipmentsFull) {
            $characterEquipments = CharacterEquipments::model()->withRelated()->findAll(
                't.characterID=:characterID', 
                array(':characterID'=>$this->id));
            $this->characterEquipments = $characterEquipments;
            $this->hasRelatedEquipmentsFull = true;
        }
    }    
    
    /**
     * Returns the active CharacterEquipments record
     * @see CharacterEquipments
     * @return mixed CharacterEquipments or null
     */
    public function getEquipment() {
        $this->loadEquipments();
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
     * @param CollectBonusEvent $event 
     */
    public function onCalcHp($event) {
        $this->raiseEvent("onCalcHp", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcEnergy($event) {
        $this->raiseEvent("onCalcEnergy", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResoluteness($event) {
        $this->raiseEvent("onCalcResoluteness", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcWillpower($event) {
        $this->raiseEvent("onCalcWillpower", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcCunning($event) {
        $this->raiseEvent("onCalcCunning", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceAbs($event) {
        $this->raiseEvent("onCalcResistanceAbs", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelNormal($event) {
        $this->raiseEvent("onCalcResistanceLevelNormal", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelEnvy($event) {
        $this->raiseEvent("onCalcResistanceLevelEnvy", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelGreed($event) {
        $this->raiseEvent("onCalcResistanceLevelGreed", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelGluttony($event) {
        $this->raiseEvent("onCalcResistanceLevelGluttony", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelLust($event) {
        $this->raiseEvent("onCalcResistanceLevelLust", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelPride($event) {
        $this->raiseEvent("onCalcResistanceLevelPride", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelSloth($event) {
        $this->raiseEvent("onCalcResistanceLevelSloth", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event 
     */
    public function onCalcResistanceLevelWrath($event) {
        $this->raiseEvent("onCalcResistanceLevelWrath", $event);
    }

    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcCritChance($event) {
        $this->raiseEvent("onCalcCritChance", $event);
    }

    /**
     * Wrapper for onCalcBonusDamageX methods
     * @param CollectBonusEvent $event
     * @param string $damageType enum (normal|vices) default normal
     */
    public function onCalcBonusDamage($event, $damageType = "normal") {
        call_user_func(array($this, "onCalcBonusDamage" . ucfirst($damageType)), $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageNormal($event) {
        $this->raiseEvent("onCalcBonusDamageNormal", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageEnvy($event) {
        $this->raiseEvent("onCalcBonusDamageEnvy", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageGreed($event) {
        $this->raiseEvent("onCalcBonusDamageGreed", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageGluttony($event) {
        $this->raiseEvent("onCalcBonusDamageGluttony", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageLust($event) {
        $this->raiseEvent("onCalcBonusDamageLust", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamagePride($event) {
        $this->raiseEvent("onCalcBonusDamagePride", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageSloth($event) {
        $this->raiseEvent("onCalcBonusDamageSloth", $event);
    }
    /**
     * Event raiser
     * @param CollectBonusEvent $event
     */
    public function onCalcBonusDamageWrath($event) {
        $this->raiseEvent("onCalcBonusDamageWrath", $event);
    }
    
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainCash($event) {
        $this->raiseEvent("onGainCash", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainFavours($event) {
        $this->raiseEvent("onGainFavours", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainKudos($event) {
        $this->raiseEvent("onGainKudos", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainXp($event) {
        $this->raiseEvent("onGainXp", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainResoluteness($event) {
        $this->raiseEvent("onGainResoluteness", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainWillpower($event) {
        $this->raiseEvent("onGainWillpower", $event);
    }
    /**
     * Event raiser
     * @param CEvent $event 
     */
    public function onGainCunning($event) {
        $this->raiseEvent("onGainCunning", $event);
    }

    /**
     * Event raiser
     * @param GainEffectEvent $event 
     */
    public function onGainEffect($event) {
        $this->raiseEvent("onGainEffect", $event);
    }

    /**
     * Event raiser
     * @param GainItemEvent $event 
     */
    public function onGainItem($event) {
        $this->raiseEvent("onGainItem", $event);
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
     * @todo make static
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
     * @link http://www.yiiframework.com/extension/attributesbackupbehavior/
     * @return array
     */
    public function behaviors() {
        return array(
            "application.components.CombatantBehavior",
            'AttributesBackupBehavior' => 'ext.AttributesBackupBehavior',
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