<?php
/**
 * Loads all Marker records and renders the gmap.php view file
 * 
 * @package Actions
 */

class MapAction extends CAction {

    /**
     * For later use. Moskow or New York anyobdy?
     * var array
     */
    // public $regions = array( );
    
    /**
     * Renders the gmap.php view file 
     */
    public function run() {
        // Will be used in some view files and redirect commands
        // Yii::app()->session['lastMapPosition'] = array();

        $Character = CD();
        $Markers = Marker::model()->with(array(
            'requirement'
        ))->findAll();
                
        $this->controller->render("gmap", array(
            'Markers' => $Markers,
            'Character' => $Character
        ));
    }
}