<?php
/**
 * Pretty boring right now, as it just renders the standard gmap view.
 * Might become more interesting in the future, when there are
 * regions besides London to explore.
 * Might also be used to save more specific viewpoints in the standard gmap.
 * 
 * @package Actions
 */

class MapAction extends CAction {

    /**
     * For later use. Moskow or New York anyobdy?
     * @var array
     */
    public $regions = array( );
    
    /**
     * Renders the gmap.php view file 
     */
    public function run() {
        // Will be used in some view files and redirect commands
        Yii::app()->session['lastMapPosition'] = array();

        $Character = CD();
        $Markers = Marker::model()->with(array(
            'requirement'
        ))->findAll();
                
        $this->controller->render("gmap", array(
            'Markers' => $Markers,
            'Character' => $Character
        ));
        // d($Markers);
    }
}