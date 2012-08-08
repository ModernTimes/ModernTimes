<?php
// d($CharacterQuest);

echo "<p>" . $CharacterQuest->quest->call("getDesc") . "</p>";

if($CharacterQuest->quest->params['currentStep'] == 'overview') {
    echo "<BR /><div class='well' style='width: 250px; text-align: center; margin-left: 100px'>";
    $steps = array(
        "inventory" => array("Where are my things?",
                             "You found your things"),
        "skills" => array("What was I good at again?",
                          "You remembered a certain talent of yours"),
        "battleskills" => array("How do I protect myself?",
                                "You remembered your fighting style"),
    );
    foreach($steps as $step=>$stepLabel) {
        // Show battleskills step only if skills has already been completed
        if($step != "battleskills" || 
                $CharacterQuest->quest->params['skills']) {
            
            if(!$CharacterQuest->quest->params[$step]) {
                echo CHtml::link(
                        $stepLabel[0],
                        "./questTutorialStartStep?step=" . $step,
                        array(
                            'class' => 'btn btn-primary',
                            'style' => 'margin: 5px 0 5px 0'
                    ));
            } else {
                echo CHtml::button(
                        $stepLabel[1],
                        array(
                            'class' => 'btn btn-primary disabled',
                            'style' => 'margin: 5px 0 5px 0'
                    ));            
            }
        }
    }
    echo "</div>";
    
}

// Step battleskills requires fighting a monster ...
if($CharacterQuest->quest->params['currentStep'] == 'battleskills') {
    echo "<a href='./questTutorialFight' class='nounderline'>
          <div class='btn-group' style='margin: 40px 10px 10px 100px'>
            <button class='btn btn-large'><i class='icon-time'></i>&nbsp;</button>
            <button class='btn btn-large btn-danger'>Open the door</button>
          </div></a>";
}

?>