<?php 
$hasSkills = false;
foreach($this->character->characterSkills as $characterSkill) {
    if($characterSkill->skill->skillType == "active" &&
            $characterSkill->available) {
        $hasSkills = true;
        break;
    }
}

if($hasSkills) { ?>

<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        Use a skill
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">

        <?php foreach($this->character->characterSkills as $characterSkill) {
            if($characterSkill->skill->skillType == "active" &&
                    $characterSkill->available) {

                /**
                 * Only generate standard popup content if Skill does not 
                 * generate its own popup
                 */
                $popup = $characterSkill->skill->call('getPopup');
                if(empty($popup)) {
                    $popup = "<p>" . $characterSkill->skill->desc . "</p>";
                }

                echo "<li>" . 
                        CHtml::link(
                            $characterSkill->skill->name . " " . "<span class='btn-mini'><i class='icon-star'></i> " . $characterSkill->skill->costEnergy . "</span>", 
                            "./useSkill?skillID=" . $characterSkill->skill->id, 
                            array(
                                'data-title'=>$characterSkill->skill->name, 
                                'data-content'=>$popup,
                                'rel'=>'popover'
                            )) . 
                     "</li>";
            }
        } ?>
    </ul>
</li>

<?php } ?>