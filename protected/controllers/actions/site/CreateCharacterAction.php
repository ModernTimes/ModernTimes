<?php

/**
 * Handles the creation of a new character
 * 
 * @uses CreateCharacterForm
 * @package Site
 */

class CreateCharacterAction extends CAction {

    /**
     * How many characters is a user allowed to have?
     * @const int 
     */
    const maxNumberOfCharacters = 5;
    
    
    /**
     * @todo check for number of characters
     */
    public function run() {
        $form = new CreateCharacterForm;
        if(isset($_POST['CreateCharacterForm'])) {
            $form->attributes = $_POST['CreateCharacterForm'];
            if($form->validate()) {

                
                
                $transaction = Yii::app()->tools->getTransaction();
                try {

                    // Set all other active Characters active = 0
                    $numberOfDeactivatedCharacters = Character::model()->updateAll(
                        array("active" => 0),
                        'userID=:userID AND active=1',
                        array(':userID'=>Yii::app()->user->id)
                    );

                    $Character = new Character();
                    $Character->userID = Yii::app()->user->id;
                    $Character->active = 1;
                    $Character->name = $form->name;
                    $Character->sex = $form->sex;
                    $Character->class = 'consultant';
                    $Character->turns = 200;
                    $Character->resolutenessSub = 16;
                    $Character->cunningSub = 16;
                    $Character->willpowerSub = 16;
                    $Character->hp = 7;
                    $Character->energy = 7;
                    $Character->cash = 100;
                    $Character->save();
                    
                    $CharacterEquipment = new CharacterEquipments();
                    $CharacterEquipment->characterID = $Character->id;
                    $CharacterEquipment->active = 1;
                    $CharacterEquipment->save();
                    
                    $GluttonyQuest = new CharacterQuests();
                    $GluttonyQuest->characterID = $Character->id;
                    $GluttonyQuest->questID = 2;
                    $GluttonyQuest->state = 'ongoing';
                    $GluttonyQuest->visible = 0;
                    $GluttonyQuest->save();
                    
                    $GreedQuest = new CharacterQuests();
                    $GreedQuest->characterID = $Character->id;
                    $GreedQuest->questID = 3;
                    $GreedQuest->state = 'ongoing';
                    $GreedQuest->visible = 0;
                    $GreedQuest->save();
                    
                    $ProcrastinateSkill = new CharacterSkills();
                    $ProcrastinateSkill->characterID = $Character->id;
                    $ProcrastinateSkill->skillID = 1;
                    $ProcrastinateSkill->available = 1;
                    $ProcrastinateSkill->permed = 0;
                    $ProcrastinateSkill->save();
                    
                    $BabbleSkill = new CharacterSkills();
                    $BabbleSkill->characterID = $Character->id;
                    $BabbleSkill->skillID = 2;
                    $BabbleSkill->available = 1;
                    $BabbleSkill->permed = 0;
                    $BabbleSkill->save();
                    
                    $CharacterSkillset = new CharacterSkillsets();
                    $CharacterSkillset->characterID = $Character->id;
                    $CharacterSkillset->active = 1;
                    $CharacterSkillset->pos1 = 1;
                    $CharacterSkillset->pos2 = 2;
                    $CharacterSkillset->save();

                    $transaction->commit();
                    
                    EUserFlash::setMessage("Character creation successful. Welcome to Modern Times!");
                    $this->controller->redirect("../game/index");

                } catch(Exception $e) {
                    d($e);
                    $transaction->rollback();
                    EUserFlash::setErrorMessage("We really would have liked to create your character, but some weird database shit happened. We're looking into it, even though it's not fun. Promised.");
                    $this->controller->refresh();
                }                
                
            }
        }
        $this->controller->render('createCharacter', array('model' => $form));
    }    
}

?>
