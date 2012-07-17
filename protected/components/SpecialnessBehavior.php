<?php

/**
 * Makes it possible to define special behavior for specific entries for
 * certain models, like special monsters, items, areas, etc.
 * 
 * Important: If a model can have specially defined behaviors, do ot call that 
 * model's function directly. Use the $model->call('functionName', params) 
 * syntax instead. SpecialnessBehavior will then redirect the call to either 
 * the standard model's function or to the special function of a class defined 
 * by the attribute specialClass in the model entry.
 */

class SpecialnessBehavior extends CBehavior {

    /**
     * Non-magic call function
     * Redirects requests to the special method, if it exists, and to the basic
     * method of the owner class otherwise
     * @param string 1st, name of the function to be called
     * @params mixed 2nd+, whatever params you want to use
     * @return mixed, whatever the called function returns
     */
    public function call() {
        $name = func_get_arg(0);
        $parameters = array();
        
        // ToDo: more elegant!?!
        $numArgs = func_num_args();
        for($i = 1; $i < $numArgs; $i++) {
            $parameters[] = func_get_arg($i);
        }
    
        /**
         * if specialnessBehavior method exists, call that
         * if not, or if something goes wrong, fall through to basic method
         */
        if($this->isSpecial()) {
            $this->initSpecialness();
            if(method_exists($this->owner->asa("special"), $name)) {
                /* 
                Yii::trace("calling " . get_class($this->owner) . "." . $name
                    . (isset($this->owner->name) 
                        ? " (" . $this->owner->name . ") " : "") 
                    . " - SPECIAL");
                 */
                return call_user_func_array(array($this->owner->asa("special"), $name), $parameters);
            }
        }
        /* 
         Yii::trace("calling " . get_class($this->owner) . "." . $name
            . (isset($this->owner->name) 
                ? " (" . $this->owner->name . ") " : "") 
            . " - BASIC");
         */
        return call_user_func_array(array($this->owner, $name), $parameters);
    }

    // ToDo: Do some checking for classname, is_child_of behavior, etc.
    public function initSpecialness() {
        if($this->isSpecial() && $this->owner->asa("special") === null) {
            $this->owner->attachbehavior('special', new $this->owner->specialClass);

            Yii::trace("attached special behavior class " . $this->owner->specialClass . " to " . get_class($this->owner) . (isset($this->owner->name) 
                    ? " (" . $this->owner->name . ") " : ""));
        }
    }
    public function isSpecial() {
        return (!empty($this->owner->specialClass) ? true : false);
    }
}