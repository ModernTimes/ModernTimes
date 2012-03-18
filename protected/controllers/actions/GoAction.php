<?php

// ToDo: Change to VisitNAMEActions to have nicer URLs?
class GoAction extends CAction {

    public $regions = array(
        'world' => array(
            'name' => "World",
            'view' => 'index',
        ),
        'megacity' => array(
            'name' => "Megacity",
            'view' => 'areas/megacity',
        ),
        'commercial' => array(
            'name' => "Commercial area",
            'view' => 'areas/megacity/commercial'
        ),
        'mbbcg' => array(
            'name' => "McBain & Booze Consulting Group",
            'view' => 'areas/megacity/commercial/mbbcg',
        ),
    );
    
    /*
     * ToDo: - Check: Can character be here?
     *       - Create view files in folder areas/ and feed special params
     */
    public function run($region = "megacity") {
        // Will be used in some view files and redirect commands
        Yii::app()->session['lastTravel'] = array(
            'region'  => $region,
            'name'   => $this->regions[$region]['name'],
        );

        $this->controller->render($this->regions[$region]['view']);
    }
}