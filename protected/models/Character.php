<?php

Yii::import('application.models._base.BaseCharacter');

/**
 * Provides nice getter and setter ("gainer") methods 
 * These methods raise events which allow other code thingies to hook into the 
 * respective calculations
 */

class Character extends BaseCharacter {

    /**
     * BASIC INTERACTIONS
     */
    
    /**
     * Wrapper for gainResource, which gives resources to the character 
     * (or takes them away in case of negative values)
     * gainResource raises events which makes it possible for other stuff
     * to hook into the calculations
     * @param float $amount
     * @param enum(battle, encounter, quest) $from
     * Allows said other stuff to react to gainX events only in case the
     * resources come from a certain source
     * ToDo: define other sources (trade, whatever)
     */
    public function gainCash($amount = 0, $from = '') {
        $this->gainResource('cash', $amount, $from);
    }
    public function gainFavours($amount = 0, $from = '') {
        $this->gainResource('favours', $amount, $from);
    }
    public function gainKudos($amount = 0, $from = '') {
        $this->gainResource('kudos', $amount, $from);
    }
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
     * @param type int
     */
    public function increaseCash($amount = 0) {
        $this->increaseResource('cash', $amount);
    }
    public function increaseFavours($amount = 0) {
        $this->increaseResource('favours', $amount);
    }
    public function increaseKudos($amount = 0) {
        $this->increaseResource('kudos', $amount);
    }
    private function increaseResource($resource, $amount) {
        if($amount > 0) {
            $this->{$resource} += (int) $amount;
            EUserFlash::setSuccessMessage((int) $amount . " " . ucfirst($resource), 'gainResource gain' . ucfirst($resource));
        }
    }
    
    public function getDropItemPerc() {
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusPerc' => &$bonusPerc));
        $this->onCalcDropItemBonus($event);

        return $bonusPerc;
    }
    
    /**
     * Wrapper for gainItem. Allows handling of multiple Item models
     * @param array|Item $items
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
     * @return bool, success?
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

    public function decreaseHp($amount) {
        $this->hp -= (int) $amount;
        if($this->hp <= 0) {
            // ToDo: make bad things happen
            $this->hp = 0;
        }
    }
    public function increaseHp($amount) {
        $hpBefore = $this->hp;
        $this->hp += (int) $amount;
        if ($this->hp > $this->getHpMax()) {
            $this->hp = $this->getHpMax();
        }
        EUserFlash::setSuccessMessage(($this->hp - $hpBefore), 'gainHp');
        return ($this->hp - $hpBefore);
    }
    public function decreaseEnergy($amount) {
        $this->energy -= (int) $amount;
        if($this->energy <= 0) {
            $this->energy = 0;
        }
    }
    public function increaseEnergy($amount) {
        $energyBefore = $this->energy;
        $this->energy += (int) $amount;
        if ($this->energy > $this->getEnergyMax()) {
            $this->energy = $this->getEnergyMax();
        }
        EUserFlash::setSuccessMessage(($this->energy - $energyBefore), 'gainEnergy');
        return ($this->energy - $energyBefore);
    }
    
    /**
     * same as gainResource stuff, see above
     */
    public function gainXp($amount = 0, $from = '') {
        $this->gainSubstat('xp', $amount, $from);
    }
    public function gainResoluteness($amount = 0, $from = '') {
        $this->gainSubstat('resoluteness', $amount, $from);
    }
    public function gainWillpower($amount = 0, $from = '') {
        $this->gainSubstat('willpower', $amount, $from);
    }
    public function gainCunning($amount = 0, $from = '') {
        $this->gainSubstat('cunning', $amount, $from);
    }
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

    // Divides the number of xp among the three substats
    public function increaseXp($xp) {
        if($xp > 0) {
            EUserFlash::setSuccessMessage((int) $xp . " experience points", 'gainStat gainXP');
        }
        
        $cA = $this->getClassAttributes();
        $this->increaseResoluteness($xp * $cA[$this->class]['resoluteness'], false);
        $this->increaseWillpower($xp * $cA[$this->class]['willpower'], false);
        $this->increaseCunning($xp * $cA[$this->class]['cunning'], false);
    }
    // ToDo: negative amounts (rare cases)
    public function increaseResoluteness($amount, $generateMsg = true) {
        $this->increaseSubstat("resoluteness", $amount, $generateMsg);
    }
    public function increaseWillpower($amount, $generateMsg = true) {
        $this->increaseSubstat("willpower", $amount, $generateMsg);
    }
    public function increaseCunning($amount, $generateMsg = true) {
        $this->increaseSubstat("cunning", $amount, $generateMsg);
    }
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
     * Buffed: Base * BonusPerc(entage based) + BonusAbs(olute)
     * CEvents don't need a sender object
     */
    public function getResolutenessBuffed() {
        return $this->getStatBuffed("resoluteness");
    }
    public function getWillpowerBuffed() {
        return $this->getStatBuffed("willpower");
    }
    public function getCunningBuffed() {
        return $this->getStatBuffed("cunning");
    }
    private function getStatBuffed($stat) {
        $bonusAbs = 0;
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusAbs' => &$bonusAbs,
                                        'bonusPerc' => &$bonusPerc));
        call_user_func(array($this, "onCalc" . ucfirst($stat)), $event);

        $ret = call_user_func(array($this, "get" . ucfirst($stat) . "Base")) *
                    (($bonusPerc + 100) / 100) +
               $bonusAbs;
        //floor
        // make sure that stats don't fall below 0 (e.g. by having bonusPerc = -120)
        $ret = max(floor($ret), 0);
                
        return $ret;
    }
    
    public function getResolutenessBase() {
        return floor(sqrt($this->resolutenessSub));
    }
    public function getWillpowerBase() {
        return floor(sqrt($this->willpowerSub));
    }
    public function getCunningBase() {
        return floor(sqrt($this->cunningSub));
    }
    
    public function getResolutenessProgress() {
        return sqrt($this->resolutenessSub);
    }
    public function getWillpowerProgress() {
        return sqrt($this->willpowerSub);
    }
    public function getCunningProgress() {
        return sqrt($this->cunningSub);
    }

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
     * Calculate based on main substat
     * y = (x − 1)^2 + 4
     *   = sqrt(y - 4) = x-1
     *   = sqrt(y-4)+1 = x
     * @return int
     */
    public function getLevel() {
        $mainstatBase = $this->getMainstatBase();
        return floor(sqrt(max(4,$mainstatBase) - 4)+1);
    }
    /**
     * Returns level progression in %
     * @return int
     */
    public function getLevelProgress() {
        $mainstatBase = $this->getMainstatBase();
        return sqrt($mainstatBase - 4) + 1 - $this->getLevel();
    }
    
    public function getMainstatBase() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Base"));
    }
    public function getMainstatBuffed() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Buffed"));
    }
    public function getMainstatSub() {
        return call_user_func(array($this, "get" . ucfirst($this->getClassType()) . "Sub"));
    }

    public function getNormalAttack() {
        return $this->getResolutenessBuffed();
    }
    public function getSpecialAttack() {
        return $this->getWillpowerBuffed();
    }
    public function getDefense() {
        return $this->getCunningBuffed();
    }
    

    /**
     * OTHER STUFF
     */

    // Load relations that are not taken care of by CD
    public function loadItems() {
        if(empty($this->characterItems)) {
            d("EMPTY characterItems");
            $characterItems = CharacterItems::model()->with(array('item'))->findAll('t.characterID=:characterID', 
                 array(':characterID'=>$this->id));
            d($characterItems);
            $this->characterItems = $characterItems;
        }
    }
    
    // ToDo: make this way more dynamic
    public function createFirstRoundCombatMessage() {
        return $this->name . " gets into a proper fighting position.";
    }
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
    public function getEffect($effect) {
        foreach($this->characterEffects as $characterEffect) {
            if($characterEffect->effect->id == $effect->id) {
                return $characterEffect;
            }
        }
        return false;
    }

    /**
     * Returns the active entity of a given related model
     * @return mixed
     */
    public function getFamiliar() {
        foreach($this->characterFamiliars as $familiar) {
            if($familiar->active == 1) {
                return $familiar;
            }
        }
        return null;
    }
    public function getEquipment() {
        foreach($this->characterEquipments as $equipment) {
            if($equipment->active == 1) {
                return $equipment;
            }
        }
        return null;
    }
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

    public function onCalcHp($event) {
        $this->raiseEvent("onCalcHp", $event);
    }
    public function onCalcEnergy($event) {
        $this->raiseEvent("onCalcEnergy", $event);
    }
    public function onCalcResoluteness($event) {
        $this->raiseEvent("onCalcResoluteness", $event);
    }
    public function onCalcWillpower($event) {
        $this->raiseEvent("onCalcWillpower", $event);
    }
    public function onCalcCunning($event) {
        $this->raiseEvent("onCalcCunning", $event);
    }

    public function onGainingCash($event) {
        $this->raiseEvent("onGainingCash", $event);
    }
    public function onGainingFavours($event) {
        $this->raiseEvent("onGainingFavours", $event);
    }
    public function onGainingKudos($event) {
        $this->raiseEvent("onGainingKudos", $event);
    }
    public function onGainingXp($event) {
        $this->raiseEvent("onGainingXp", $event);
    }
    public function onGainingResoluteness($event) {
        $this->raiseEvent("onGainingResoluteness", $event);
    }
    public function onGainingWillpower($event) {
        $this->raiseEvent("onGainingWillpower", $event);
    }
    public function onGainingCunning($event) {
        $this->raiseEvent("onGainingCunning", $event);
    }

    public function onCalcDropItemBonus($event) {
        $this->raiseEvent("onCalcDropItemBonus", $event);
    }
    
    /*
     *   BACKGROUND STUFF
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
     * Relies on mainstat getting 50% of the substat gains
     * @return enum(resoluteness, cunning, willpower)
     */
    public function getClassType() {
        $cA = $this->getClassAttributes();
        return array_search('0.5', $cA[$this->class]);
    }
    
    public function behaviors() {
        return array(
            // 'withRelated'=>array('class'=>'ext.wr.WithRelatedBehavior',),
            "application.components.CombatantBehavior",
            'AttributesBackupBehavior' => 'ext.AttributesBackupBehavior',
        );
    }

    public static function model($className=__CLASS__) {
	return parent::model($className);
    }
}