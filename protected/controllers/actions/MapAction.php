<?php
/**
 * Pretty boring right now, as it just renders the standard gmap view.
 * Might become more interesting in the future, when there are
 * regions besides London to explore.
 * Might also be used to save more specific viewpoints in the standard gmap.
 */

class MapAction extends CAction {

    // For later use. Moskow or New York anyobdy?
    public $regions = array( );
    
    public function run() {
        // Will be used in some view files and redirect commands
        Yii::app()->session['lastMapPosition'] = array();

        $this->controller->render("gmap");
    }
}