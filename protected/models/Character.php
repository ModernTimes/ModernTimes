<?php

Yii::import('application.models._base.BaseCharacter');

class Character extends BaseCharacter {

    /*
     *  BASIC INTERACTIONS
     */
    
    // from   enum   battle, encounter, quest, ...
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
            EUserFlash::setSuccessMessage("You gained " . (int) $amount . " " . ucfirst($resource), 'gainResource gain' . ucfirst($resource));
        }
    }
    
    public function getDropItemPerc() {
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusPerc' => &$bonusPerc));
        $this->onCalcDropItemBonus($event);

        return $bonusPerc;
    }
    
    public function gainItems($items) {
        if(!is_array($items) || empty($items)) { return; }
        
        foreach($items as $item) {
            $this->gainItem($item);
        }
    }
    public function gainItem($item) {
        // d($item);

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
    }

    public function decreaseHp($amount) {
        $this->hp -= (int) $amount;
        if($this->hp <= 0) {
            // ToDo: make bad things happen
            $this->hp = 0;
        }
    }
    public function increaseHp($amount) {
        $this->hp += (int) $amount;
        if ($this->hp > $this->getHpMax()) {
            $this->hp = $this->getHpMax();
        }
    }
    public function decreaseEnergy($amount) {
        $this->energy -= (int) $amount;
        if($this->energy <= 0) {
            $this->energy = 0;
        }
    }
    public function increaseEnergy($amount) {
        $this->energy += (int) $amount;
        if ($this->energy > $this->getEnergyMax()) {
            $this->energy = $this->getEnergyMax();
        }
    }
    
    // Divides the number of xp among the three substats
    public function increaseXp($xp) {
        $cA = $this->getClassAttributes();
        $this->increaseResoluteness($xp * $cA[$this->class]['resoluteness']);
        $this->increaseWillpower($xp * $cA[$this->class]['willpower']);
        $this->increaseCunning($xp * $cA[$this->class]['cunning']);
    }
    // ToDo: negative amounts (rare cases)
    public function increaseResoluteness($amount) {
        $this->increaseSubstat("resoluteness", $amount);
    }
    public function increaseWillpower($amount) {
        $this->increaseSubstat("willpower", $amount);
    }
    public function increaseCunning($amount) {
        $this->increaseSubstat("cunning", $amount);
    }
    private function increaseSubstat($stat, $amount) {
        // If amount is between two numbers, use RNG to determine which one to use
        $amount = Yii::app()->tools->decideBetweenTwoNumbers($amount);

        if($amount > 0) {
            $levelBefore = $this->getLevel();
            $statBefore = call_user_func(array($this, "get" . ucfirst($stat) . "Base"));

            $this->{$stat . "Sub"} += $amount;

            EUserFlash::setSuccessMessage("Your gained " . (int) $amount . " " . $stat, 'gainStat gainSubstat gain' . ucfirst($stat));

            if(call_user_func(array($this, "get" . ucfirst($stat) . "Base")) > $statBefore) {
                EUserFlash::setSuccessMessage("<b>Your " . $stat . " increased!</b>", 'gainStat gainNormalstat gain' . ucfirst($stat));
            }
            if($levelBefore < $this->getLevel()) {
                EUserFlash::setSuccessMessage("<b>You gained a level!</b>", 'gainStat gainLevel');
            }
        }
    }
    
    
    /*
     *  RETRIEVAL OF CHARACTER DATA
     */
    
    /* 
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

        $ret = floor(
                call_user_func(array($this, "get" . ucfirst($stat) . "Base")) *
                    (($bonusPerc + 100) / 100) +
                $bonusAbs
               );
                
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

        $ret = floor(
                (($this->getResolutenessBuffed() + 3) * (($bonusPerc + 100) / 100)
                    + $bonusAbs)
                * ($this->getClassType() == 'resoluteness' ? 1.5 : 1)
               );
                
        return $ret;
    }
    public function getEnergyMax() {
        $bonusAbs = 0;
        $bonusPerc = 0;

        $event = new CEvent(null, array('bonusAbs' => &$bonusAbs,
                                        'bonusPerc' => &$bonusPerc));
        call_user_func(array($this, "onCalcEnergy"), $event);

        $ret = floor(
                (($this->getWillpowerBuffed() + 3) * (($bonusPerc + 100) / 100)
                    + $bonusAbs)
                * ($this->getClassType() == 'willpower' ? 1.5 : 1)
               );
                
        return $ret;
    }
    
    // Calculate based on main substat
    public function getLevel() {
        $mainstatBase = $this->getMainstatBase();
        return floor(sqrt($mainstatBase - 4)+1);
        /* y = (x − 1)^2 + 4
        sqrt(y - 4) = x-1
        sqrt(y-4)+1 = x */
    }
    // Returns level progression in %
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
    

    /*
     *   OTHER STUFF
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
    
    public function setBattleFlag($battleID) {
        $this->ongoingBattleID = $battleID;
    }
    
    public function hasEffect($effect) {
        foreach($this->characterEffects as $characterEffect) {
            if($characterEffect->effect->id == $effect->id) {
                return true;
            }
        }
        return false;
    }
    public function addEffect($characterEffect) {
        // $this->characterEffects is NOT a real property, but the result of a function call!
        $charEffects = $this->characterEffects;
        $charEffects[] = $characterEffect;
        $this->characterEffects = $charEffects;
        EUserFlash::setNoticeMessage($characterEffect->effect->name, "<b>" . $characterEffect->effect->name . "</b> (for the next " . $characterEffect->turns . " encounters)", 'effect');
    }

    public function getFamiliar() {
        foreach($this->familiars as $familiar) {
            if($familiar->active == 1) {
                return $familiar;
            }
        }
        return null;
    }
    public function getEquipment() {
        foreach($this->equipments as $equipment) {
            if($equipment->active == 1) {
                return $equipment;
            }
        }
        return null;
    }
    public function getSkillset() {
        foreach($this->skillsets as $skillset) {
            if($skillset->active == 1) {
                return $skillset;
            }
        }
        return null;
    }

    /*
     *  EVENT RAISERS
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

    public function onCalcDropItemBonus($event) {
        $this->raiseEvent("onCalcDropItemBonus", $event);
    }
    
    /*
     *   BACKGROUND STUFF
     */
    
    public function getClassAttributes() {
        return array('consultant'   => array('cunning' => 0.5, 'resoluteness' => 0.3, 'willpower' => 0.2),
                     'banker'       => array('cunning' => 0.5, 'willpower' => 0.3, 'resoluteness' => 0.2),
                     'bureaucrat'   => array('resoluteness' => 0.5, 'willpower' => 0.3, 'cunning' => 0.2),
                     'mobster'      => array('resoluteness' => 0.5, 'cunning' => 0.3, 'willpower' => 0.2),
                     'celebrity'    => array('willpower' => 0.5, 'cunning' => 0.3, 'resoluteness' => 0.2),
                     'politician'   => array('willpower' => 0.5, 'resoluteness' => 0.3, 'cunning' => 0.2), 
               );
    }
    public function getClassType() {
        // Relies on mainstat getting 50% of the substat gains
        $cA = $this->getClassAttributes();
        return array_search('0.5', $cA[$this->class]);
    }
    
    public function behaviors() {
        return array(
            'withRelated'=>array('class'=>'ext.wr.WithRelatedBehavior',),
            "application.components.CombatantBehavior",
            'AttributesBackupBehavior' => 'ext.AttributesBackupBehavior',
            );
    }

    public static function model($className=__CLASS__) {
	return parent::model($className);
    }
}