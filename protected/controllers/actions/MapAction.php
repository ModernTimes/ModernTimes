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
        
        // Will be used in some view files
        Yii::app()->session['lastPlace'] = array(
            'id'   => array("map"),
            'name' => "London",
        );

        $Character = CD();
        $Markers = Marker::model()->withRelated()->findAll();
                
        $this->controller->render("gmap", array(
            'Markers' => $Markers,
            'Character' => $Character
        ));
    }
}