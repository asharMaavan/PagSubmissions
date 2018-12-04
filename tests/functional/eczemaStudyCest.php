<?php 

class eczemaStudyCest
{
    public function _before(FunctionalTester $I)
    {
    }

     /*
	*
	* Checks correct study
	* Submit PostCode
	* Submit Information
	* Confirm Success message
	*
    */
    public function pagStudiesTest(FunctionalTester $I)
    {
        $I->isOnCorrectStudy();
        $this->selectSiteAndFillForm($I);
        $this->questionnaireLastQuestions($I);	
        $this->fillFormSubmission($I);
        $this->submissionConfirmation($I);
    } 

    /*
	*
	* Select My Study
	* Fill information Form and submit
	*
    */
    private function selectSiteAndFillForm(FunctionalTester $I)
    {
    	if($this->isNextButtonVisible($I)){
    		    		
    		$I->click('.next-prev-btn a');

    		$this->clickNextButton($I);
    		
    		if($this->isQuestionnaireVisible($I)){
    			if($this->questionnaireSubmission($I)){
    				return true;
    			}
    			$I->assertFalse(true);

    		}elseif($this->isInfoFormVisible($I)){
    			return $this->fillFormSubmission($I);
    		}else{
    			$I->assertFalse(true);
    		}
    	}
    	$I->assertFalse(true);
    }

    /**
    *
    * Submit all questions
    *
    */
    private function questionnaireSubmission(FunctionalTester $I)
    {

    	if($this->isQuestionnaireVisible($I)){
			//Select google as first ans
    		$I->customClick('.inputGroup #GOOGLE');
    		$I->wait(2);
    		$I->click('.next-btn');
    		$this->loaderVisibleInvisible($I);
    		//Accept the age
    		$this->selectAndNextWithXpath($I);

    		if($this->isHeightWeightVisible($I)){   
				// set height and weight
				return $this->heightAndWeightSubmission($I);				
    		}else{    		 			
    			$I->assertFalse(true);
    		}
    	}else{
    		$I->assertFalse(true);
    	}
    }

    private function heightAndWeightSubmission(FunctionalTester $I)
    {
    	
		$I->fillField(['name' => 'feet'], "6");
		$I->fillField(['name' => 'inch'], "1");
		$I->fillField(['name' => 'pnd'], "180");
		$I->click('.next-btn');
		$this->loaderVisibleInvisible($I);
    	
    	return $this->isPercentQuestionVisible($I);
    }

    private function questionnaireLastQuestions(FunctionalTester $I)
    {    
    	if($this->isPercentQuestionVisible($I)){ 
    		$this->selectAndNextWithXpath($I);
    		//Last question    		
			if($this->isLastQuestionVisible($I)){
				$this->selectAndNextWithXpath($I);    			
				if($this->isInfoFormVisible($I)){					
					$I->assertTrue(true);
				}				
				return false; 
			}  
			return false;	  		
    	}
    	return false;
    }

    private function fillFormSubmission(FunctionalTester $I)
    {
    	//Fill information form
        if($this->isInfoFormVisible($I) || $this->isNextButtonInVisible($I)){
			$I->fillField(['name' => 'fname'], "Automated");
			$I->fillField(['name' => 'lname'], "Name");			
			$I->fillField(['name' => 'email'], "qa.maavan@gmail.com");
			if($this->isConfirmEmailVisible($I)){
				$I->fillField(['name' => 'confirm_email'], "qa.maavan@gmail.com");
			}
			$I->fillField(['name' => 'phone'], "+923248895525");            
			$I->click('#send-btn');	
			$I->assertTrue($this->isSubmitButtonInvisible($I));		
			
		}

    }

    /*
	*
	* Confirms information has been submitted
	*
    */
    private function submissionConfirmation(FunctionalTester $I)
    {
    	
    	if($this->isSubmissionSuccess($I) || $this->isSubmissionSuccessful($I)){
    		$I->assertTrue(true);		
    	}else{
    		$I->assertFalse(true);
    	}
    }  

    private function clickNextButton(FunctionalTester $I)
    {
    	//click again on Next Button for questionaire
		if($this->isNextButtonVisible($I)){
			$I->click('.next-prev-btn a');
			$this->isNextButtonInVisible($I);	
		}
    } 

    private function selectAndNextWithXpath(FunctionalTester $I)
    {
    	if($this->isYesButtonWithXpathVisible($I)){
    		$I->click('//label[contains(text(), "YES")]');
			$I->wait(2);
			$I->click('.next-btn');				
    	}
    	return $this->loaderVisibleInvisible($I);;		
    }

    private function clickYesAndNext(FunctionalTester $I)
    {
    	if($this->isYesButtonVisible($I)){
    		$I->click('.inputGroup #YES');
			$I->wait(2);
    		$I->click('.next-btn a');	
    		return $this->loaderVisibleInvisible($I);
    	}    	
    	$I->assertFalse(true);
    }

    private function isConfirmEmailVisible(FunctionalTester $I)
    {
    	return $I->visible('#confirm_email');
    }

    private function isYesButtonVisible(FunctionalTester $I)
    {
    	return $I->visible('.inputGroup #YES');
    }

    private function isYesButtonWithXpathVisible(FunctionalTester $I)
    {
    	return $I->visible('//label[contains(text(), "YES")]');
    }

    private function isLastQuestionVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Does your eczema seem irritated?")]');
    }

    private function isSecondQuestionVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Are you between 18 and 75 years old?")]');
    }

    private function loaderVisibleInvisible(FunctionalTester $I)
    {
    	if($this->isLoaderVisible($I)){
    		return $this->isLoaderInVisible($I);
    	}
    	return false;
    }

    private function isPercentQuestionVisible(FunctionalTester $I)
    {
    	return $I->visible('//div[contains(text(), "Do you believe that you have eczema on about 10% or more of your body?")]');
    }

    private function isHeightWeightVisible(FunctionalTester $I)
    {
    	return $I->visible('//div[contains(text(), "What is your height and weight?")]');
    }

    private function isLoaderVisible(FunctionalTester $I)
    {
    	return $I->visible('.loader');
    }

    private function isLoaderInVisible(FunctionalTester $I)
    {
    	return $I->invisible('.loader');	
    }


    private function isStudyCheckboxVisible(FunctionalTester $I)
    {
    	return $I->visible('.radiobtn');
    }

    private function isQuestionnaireVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Where did you see the advertisement for the RADIANT study?")]');
    }

    private function isSubmissionSuccess(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Thank you for your submission. You will receive a follow up email from us shortly.")]');
    }

    //For Presence Study
    private function isSubmissionSuccessful(FunctionalTester $I)
    {
        return $I->visible('//*[contains(text(), "Thank you for successfully submitting your information.")]');
    }

    private function isSubmitButtonInvisible(FunctionalTester $I)
    {
    	return $I->invisible('#send-btn');
    }

    private function isInfoFormVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Please provide your contact information")]');
    }

    private function isNextButtonVisible(FunctionalTester $I)
    {
    	return $I->visible('.next-prev-btn',20);
    }

    private function isNextButtonInVisible(FunctionalTester $I)
    {
        return $I->invisible('.next-prev-btn',15);
    }

}
