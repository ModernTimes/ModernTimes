<?php

class SpecialnessBehavior extends CBehavior {

    // Non-magic call function
    // routes the requests to the special method, if it exists, and to the basic method otherwise
    public function call() {
        $name = func_get_arg(0);
        $parameters = array();
        
        $numArgs = func_num_args();
        for($i = 1; $i < $numArgs; $i++) {
            $parameters[] = func_get_arg($i);
        }
    
        if($this->getSpecial()) {
            $this->initSpecialness();
            if(method_exists($this->owner->asa("special"), $name)) {
                // Yii::trace("calling " . $name . " - SPECIAL");
                return call_user_func_array(array($this->owner->asa("special"), $name), $parameters);
            }
        }
        // Yii::trace("calling " . $name . " - BASIC");
        return call_user_func_array(array($this->owner, $name), $parameters);
    }

    // ToDo: Do some checking for classname, is_child_of behavior, etc.
    public function initSpecialness() {
        if($this->getSpecial() && $this->owner->asa("special") === null) {
            $this->owner->attachbehavior('special', new $this->owner->specialClass);
        }
    }
    public function getSpecial() {
        return (!empty($this->owner->specialClass) ? true : false);
    }
}