<?php
/**
 * Deletes an inactive character and all related data
 * 
 * @package Actions.Character management
 */

class DeleteCharacterAction extends CAction {

    /**
     * See above
     * @param int $characterID ID of the Character to be deleted
     */
    public function run($characterID) {
        // positive integer
        $validSyntax = (!empty($characterID)
                        // are all characters digits? rules out decimal numbers
                        && ctype_digit($characterID)
                        && $characterID > 0);
        if(!$validSyntax) {
            EUserFlash::setErrorMessage("Something went wrong. Shit happens.");
        } else {
            $Character = Character::model()->find(
                'userID=:userID AND id=:characterID',
                array(':userID' => Yii::app()->user->id,
                      ':characterID' => $characterID)
            );
            
            if(!is_a($Character, "Character")) {
                EUserFlash::setErrorMessage("Got 'ya! That character isn't yours.");
            } else {
                if($Character->active) {
                    EUserFlash::setErrorMessage("You can only delete inactive characters.");
                } else {
                    $transaction = Yii::app()->tools->getTransaction();
                    try {
                        $numberOfCharacterBattleskillsDeleted = CharacterBattleskills::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterEffectsDeleted = CharacterEffects::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterEncountersDeleted = CharacterEncounters::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterEquipmentsDeleted = CharacterEquipments::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterFamiliarsDeleted = CharacterFamiliars::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterItemsDeleted = CharacterItems::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterQuestsDeleted = CharacterQuests::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterRecipesDeleted = CharacterRecipes::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterSkillsDeleted = CharacterSkills::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        $numberOfCharacterSkillsetsDeleted = CharacterSkillsets::model()->deleteAll(
                            'characterID=:characterID',
                            array(':characterID' => $Character->id)
                        );
                        
                        $Character->delete();

                        $transaction->commit();
                        EUserFlash::setMessage("R.I.P. - " . $Character->name . ", a former " . $Character->getTitle() . ".");
                    } catch(Exception $e) {
                        $transaction->rollback();
                        d($e);
                        EUserFlash::setErrorMessage("We really would have liked to 
                            kill your character, but some weird database shit 
                            happened. We promise to look into it, even if it's boring.
                            Promised.");
                    }
                }
            }
        }

        $this->controller->redirect(array('manageCharacters'));
    }
}