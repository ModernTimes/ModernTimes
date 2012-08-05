<?php
// d($CharacterQuest);

echo "<p>" . $CharacterQuest->quest->call("getDesc") . "</p>";

if($CharacterQuest->quest->params['currentStep'] == 'overview') {
    echo "<BR /><div class='well' style='width: 250px; text-align: center; margin-left: 100px'>";
    $steps = array(
        "inventory" => array("Where are my things?",
                             "You found your things"),
        "skills" => array("What was I good at again?",
                          "You remembered your skills"),
    );
    foreach($steps as $step=>$stepLabel) {
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
    echo "</div>";
}


?>