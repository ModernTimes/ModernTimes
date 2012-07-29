<?php

/**
 * CreateCharacterForm class.
 * @package Site.Forms
 */
class CreateCharacterForm extends CFormModel {

    public $name;
    public $sex;
    // public $verifyCode;

    /**
     * Declares the validation rules.
     * @return array
     */
    public function rules() {
        return array(
            // name and sex are required
            array('name', 'required',
                'message' => "Sorry, having a name is mandatory."),
            array('sex', 'required',
                'message' => "Good luck running around without a sex!"),
            // sex has to be either male or female
            array('sex','in','range'=>array('male','female'),'allowEmpty'=>false, 
                'message' => "Oh, c'mon. It can't be THAT hard to decide your sex."),
            // verifyCode needs to be entered correctly
            // array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
        );
    }

    /**
     * Declares customized attribute labels.
     * @return array
     */
    public function attributeLabels() {
        return array(
            // 'verifyCode'=>'Verification Code',
        );
    }
}