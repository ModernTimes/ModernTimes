<?php

/**
 * Makes it possible to define special behavior for specific entries for
 * certain models, like special monsters, items, areas, etc.
 * 
 * Important: If a model can have specially defined behaviors, do not call that 
 * model's function directly. Use the $model->call('functionName', params) 
 * syntax instead. SpecialnessBehavior will then redirect the call to either 
 * the standard model's function or to the special function of a class defined 
 * by the attribute specialClass in the model entry.
 * 
 * @package System
 */

class SpecialnessBehavior extends CBehavior {

    /**
     * Non-magic call function
     * Redirects requests to the special method, if it exists, or to the basic
     * method of the owner class otherwise
     * param string 1st parameter name of the function to be called
     * params mixed 2nd+ parameter whatever params the desired function needs
     * @return mixed
     */
    public function call() {
        $name = func_get_arg(0);
        $parameters = array();
        
        // @todo do this more elegantly!?
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

    /**
     * Initializes the class that defines the special behavior and attaches
     * it to $this->owner.
     * @todo Do some checking for classname, is_child_of CBehavior, etc.
     * @link http://www.yiiframework.com/doc/api/CBehavior
     */
    public function initSpecialness() {
        if($this->isSpecial() && $this->owner->asa("special") === null) {
            $this->owner->attachbehavior('special', new $this->owner->specialClass);
            /**
            Yii::trace("attached special behavior class " . $this->owner->specialClass . 
                    " to " . get_class($this->owner) . 
                    (isset($this->owner->name) ? " (" . $this->owner->name . ") " : ""));
            */
        }
    }
    
    /**
     * Checks if $this->owner is special,
     * i.e. if it has a specialClass attribute defined
     * @return bool
     */
    public function isSpecial() {
        return (!empty($this->owner->specialClass) ? true : false);
    }
}