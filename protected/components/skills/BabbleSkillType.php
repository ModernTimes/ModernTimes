<?php

class BabbleSkillType extends CBehavior {

    public function getBabbleBullshit() {
        $messages = array(
            "Confirmed, our team consists of young, ambitious and motivated professionals in a result-driven organization, which encourages initiative, combined with responsibility and personal development.",
            "Our biggest challenge is cultivating fully operational performances at a much shorter duration and more limited scope.",
            "We realize that generating quick-win marketing efforts help you cope with an ultra-dynamic marketplace.",
            "Our ongoing efforts to productize turnkey thoughtware are leading potential customers to your web page.",
        );
        
        return $messages[mt_rand(0, count($messages)-1)];
    }
}