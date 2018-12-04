<?php 

class pagStudiesCest
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
        $this->isOnCorrectStudy($I);
        $this->selectSiteAndFillForm($I);
        $this->submissionConfirmation($I);
    }

    /*
	*
	* verifies correct study
	* Enter testing Post code
	*
    */
    private function isOnCorrectStudy(FunctionalTester $I)
    {
    	if($I->mainPage()){
    		if($this->studyCenter($I)){
    			if($this->isZipCodeFieldVisible($I)){
	    			$I->fillField(['name' => 'Name'], "82001");
	    			$grabPostCode = $I->grabValueFrom(['name' => 'Name']);    			
	    			if($grabPostCode == "82001"){
	    				$I->click('#submit_zipcode');
	    				return $this->loaderVisibleInvisible($I);
	    			}

				}	
    		} 
    		$I->assertFalse(true);   		
    	}
    	$I->assertFalse(true);
    }

    private function studyCenter(FunctionalTester $I)
    {
    	if($this->isStudyCenterButtonVisible($I)){
			$I->click('.menu ul li:nth-child(4)');
			return true;
    	}
    	$I->assertFalse(true);
    	
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
    		//select my study
    		$I->click('.radiobtn');	
    		$I->wait(2);
    		$I->click('.next-prev-btn a');
    		
    		//Fill information form
            if($this->isInfoFormVisible($I) || $this->isNextButtonInVisible($I)){
    			$I->fillField(['name' => 'fname'], "Automated");
    			$I->fillField(['name' => 'lname'], "Name");
    			$I->fillField(['name' => 'email'], "qa.maavan@gmail.com");
    			$I->fillField(['name' => 'phone'], "+923248895525");
                if($this->isCheckboxVisible($I)){
                    $I->click('#chk-policy');
                }
    			$I->click('#send-btn');
    			return $this->isSubmitButtonInvisible($I);
    		}
    		$I->assertFalse(true);
    	}
    	$I->assertFalse(true);
    }

    /*
	*
	* Confirms information has been submitted
	*
    */
    private function submissionConfirmation(FunctionalTester $I)
    {
    	if($this->isSubmissionSuccess($I) || $this->isSubmissionSuccessful($I)){
    		return true;
    	}else{
    		$I->assertFalse(true);
    	}
    }

    private function loaderVisibleInvisible(FunctionalTester $I)
    {
        if($this->isloaderVisible($I)){
            return $this->isloaderInVisible($I);
        }
        return false;
    }

    //For Breastcancer study 
    private function isCheckboxVisible(FunctionalTester $I)
    {
        return $I->visible('#chk-policy');
    }

    private function isloaderVisible(FunctionalTester $I)
    {
        return $I->visible('.spinner');
    }

    private function isloaderInVisible(FunctionalTester $I)
    {
        return $I->invisible('.spinner');
    }

    private function isStudyCenterButtonVisible(FunctionalTester $I)
    {
    	return $I->visible('//a[contains(text(), "Find a Study Center")]');
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
    	return $I->visible('#fname',15);
    }

    private function isNextButtonVisible(FunctionalTester $I)
    {
    	return $I->visible('.next-prev-btn',20);
    }

    private function isNextButtonInVisible(FunctionalTester $I)
    {
        return $I->invisible('.next-prev-btn',15);
    }

    private function isZipCodeFieldVisible(FunctionalTester $I)
    {
    	return $I->visible('#name');
    }

}
