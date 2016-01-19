<?php
use Behat\Behat\Exception\BehaviorException;
class Biometry extends OpenEyesPage
{
    protected $path = "OphInBiometry/Default/create?patient_id={patientId}";
    protected $elements = array(
        'saveBiometry' => array(
            'xpath' => "//*[@id='et_save']"
        ),
        'noLensError' => array(
            'xpath'=> "//*[@class='errorlink']//*[contains(text(),'No lens selected')]"
        ),
        'lensTypeRight'=> array(
            'xpath'=> "//*[@id='Element_OphInBiometry_Selection_lens_id_right']"
        ),
        'lensTypeDefaultRight'=> array(
            'xpath'=> "//*[@id='Element_OphInBiometry_Selection_lens_id_right']//*[contains(text(),'Please select')]"
        ),
        'lensTypeDefaultLeft'=> array(
            'xpath'=> "//*[@id='Element_OphInBiometry_Selection_lens_id_left']//*[contains(text(),'Please select')]"
        ),
        'userSummaryFooter'=> array(
            'xpath'=> "//*[@class='info']//*[contains(text(),'IOLMaster')]"
        ),
        'eventEditTab'=> array(
            'xpath'=> "//*[@class='inline-list tabs event-actions']//*[contains(text(),'Edit')]"
        ),
        'readonlyFields'=> array(
            'xpath'=> "//*[@class='row field-row']//*[@class='readonly-box']"
        ),
        'createdByIOLMasterDesc'=> array(
            'xpath'=> "//*[@class='row field-row']//*[contains(text(),'Created by IOL Master input')]"
        ),
        'biometryReport'=> array(
            'xpath'=> "//*[@class='highlight booking']"
        ),
        'biometryContinue'=> array(
            'xpath'=> "//*[@class='event-header']//*[contains(text(),'Continue')]"
        ),
        'eventHeader'=> array(
            'xpath'=> "//*[@class='event-header']"
        ),
        'eventContent'=> array(
            'xpath'=> "//*[@class='event-content']"
        )
    );
    public function saveBiometry()
    {
        $this->getElement('saveBiometry')->click();
    }

    public function noLensErrorConfirm(){
        if($this->find ( 'xpath', $this->getElement ( 'noLensError' )->getXpath () ))
        {
            throw new BehaviorException ( "WARNING!!! ERROR SHOWN! LENS TYPE IS MANDATORY" );
        }
        else
        {
        print
        "*****
        ****
        TEST PASSED!! Lens type is not mandatory
        ******
        ******";
        }
    }

    public function noLensByDefaultConfirm(){
        //$this->getElement('lensTypeRight')->click();
        if($this->getElement('lensTypeDefaultRight')->isSelected()&&$this->getElement('lensTypeDefaultLeft')->isSelected()){
            print "No Lens Type is selected by default!! TEST PASSED!";
        }

        else{
            print "WARNING!!! LENS TYPE SELECTED BY DEFAULT! TEST FAILED!!";
            throw new BehaviorException ( "WARNING!!! LENS TYPE SELECTED BY DEFAULT! TEST FAILED!!");
        }
    }

    public function verifyEventIsAuto(){
       $this->waitForElementDisplayNone('userSummaryFooter');
        if($this->getElement('userSummaryFooter')->isVisible()){
            $this->getElement('eventEditTab')->click();
            $this->waitForElementDisplayBlock('readonlyFields');
            if($this->getElement('readonlyFields')->isVisible()||$this->getElement('createdByIOLMasterDesc')->isVisible()){
                print "Event Created from IOL Master";
            }
        }
        else{
            print "Event not created from IOL Master!!";
        }
    }

    public function selectAutoBiometryEvent(){
        $this->waitForElementDisplayNone('biometryReport');
        $this->getElement('biometryReport')->click();
        $this->getElement('biometryContinue')->click();
    }

    public function selectAutoBiometryEventByDateTime($dateTime){
        $this->waitForElementDisplayNone('biometryReport');
        $this->elements['biometryReportByDateTime'] = array(
            'xpath' => "//*[@class='element-fields']//*[contains(text(),'$dateTime')]"
        );
        $this->getElement('biometryReportByDateTime')->click();
        $this->getElement('biometryContinue')->click();
    }

    public function selectTabOnEventSummaryPage($eventTab){
        $this->waitForElementDisplayNone('eventHeader');
        $this->elements['eventHeaderTab'] = array(
            'xpath' => "//*[@class='event-header']//*[contains(text(),'$eventTab')]"
        );
        $this->getElement('eventHeaderTab')->click();
    }

    public function lookDataInBiometryPage($value,$eyeSide,$tabType){
        $this->waitForElementDisplayNone('eventContent');
        if($tabType=='Edit') {
            $this->elements['eyeSideData'] = array(
                'xpath' => "//*[@id='$eyeSide-eye-lens']//*[contains(text(),'$value')]"
            );
        }
        elseif($tabType=='View'){
            $this->elements['eyeSideData'] = array(
                'xpath' => "//*[@class='element-eye $eyeSide-eye column']//*[contains(text(),'$value')]"
            );
        }
        else{
            throw new BehaviorException ( "WARNING!!! INVALID EYE SELECTION PROVIDED! TEST FAILED!!");
        }

        if($this->getElement('eyeSideData')->isVisible()){
            print "Value Displayed Correctly!";
        }
        else{
            throw new BehaviorException ( "WARNING!!! INVALID VALUE DISPLAYED! TEST FAILED!!");
        }
    }

    public function lookForEventSummaryInfoAlert($infoAlert){
        $this->waitForElementDisplayNone('eventContent');
        $this->elements['eventPageInfoAlert'] = array(
            'xpath' => "//*[@class='row']//*[contains(text(),'$infoAlert')]"
        );
        if($this->getElement('eventPageInfoAlert')->isVisible()){
            print "Alert Displayed Correctly!";
        }
        else{
            throw new BehaviorException ( "WARNING!!! INVALID ALERT DISPLAYED! TEST FAILED!!");
        }
    }

    public function checkLensDropDown($lensType,$eyeSide){
        $this->waitForElementDisplayNone('eventContent');
        $this->elements['eyeTypeLensDropDown'] = array(
            'xpath' => "//*[@id='Element_OphInBiometry_Selection_lens_id_$eyeSide']"
        );
        $this->getElement('eyeTypeLensDropDown')->click();
        $this->elements['eyeTypeLensDropDownValue'] = array(
            'xpath' => "//*[contains(text(),'$lensType')]"
        );
        if($this->getElement('eyeTypeLensDropDownValue')->isVisible()){
            print "Lens Displayed correctly!";
        }
        else{
            throw new BehaviorException ( "WARNING!!! LENS NOT DISPLAYED! TEST FAILED!!");
        }
    }

    public function checkFormulaDropDown($formula,$eyeSide){
        $this->waitForElementDisplayNone('eventContent');
        $this->elements['eyeTypeFormulaDropDown'] = array(
            'xpath' => "//*[@id='Element_OphInBiometry_Selection_formula_id_$eyeSide']"
        );
        $this->getElement('eyeTypeFormulaDropDown')->click();
        $this->elements['eyeTypeFormulaDropDownValue'] = array(
            'xpath' => "//*[contains(text(),'$formula')]"
        );
        if($this->getElement('eyeTypeFormulaDropDownValue')->isVisible()){
            print "Formula Displayed correctly!";
        }
        else{
            throw new BehaviorException ( "WARNING!!! FORMULA NOT DISPLAYED! TEST FAILED!!");
        }
    }

}
