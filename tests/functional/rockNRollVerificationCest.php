<?php 

class rockNRollVerificationCest
{
    public function _before(FunctionalTester $I)
    {
    }

    /**
    *
    * Verifies all studies and their submissions
    *
    */
    public function rockNRollVerificationTest(FunctionalTester $I)
    {
    	$I->login();    	
    	$this->checkAndVerifyAlopeciaStudy($I);
    	$this->checkAndVerifyPresenceStudy($I);
    	$this->checkAndVerifyEczemaStudy($I);
    	$this->checkAndVerifyBreastCancerStudy($I);
    	$this->checkAndVerifyOasisStudy($I);
    	$this->checkAndVerifyRadiantStudy($I);
    	$this->checkAndVerifyDialogtecTestLine($I);
    }

    private function selectStudyPage(FunctionalTester $I)
    {
    	//switch to studies page
    	if($this->isStudiesPageInVisible($I)){
    		
    		$I->click('//a[contains(text(), "Studies")]');
    	}

    	$I->assertTrue($this->isStudyNamesVisible($I));
    }

    //Alopecia Study
    private function checkAndVerifyAlopeciaStudy(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);    	
    	if($this->isAlopeciaStudyVisible($I)){
    		$I->click('//*[contains(text(), "JAHO Alopecia Study")]');
    		if($this->isAlopeciaSitesVisible($I)){
    			$I->click('//*[contains(text(), "ALOPECIA AREATA STUDY TESTING")]');
    			$this->checkForSubmission($I);	
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}

    }

    //Presence Study
    private function checkAndVerifyPresenceStudy(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);
    	if($this->isPresenceStudyVisible($I)){
    		$I->click('//*[contains(text(), "HBEH Parkinsons Study")]');    		
    		if($this->isPresenceSitesVisible($I)){
    			$I->click('//*[contains(text(), "The Presence Study Test")]');
    			$this->checkForSubmission($I);
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}
    }

    //Eczema Study
    private function checkAndVerifyEczemaStudy(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);
    	if($this->isEczemaStudyVisible($I)){
    		$I->click('//*[contains(text(), "JAIW Eczema Study")]');    		
    		if($this->isEczemaSitesVisible($I)){
    			$I->click('//*[contains(text(), "MY SKIN TEST")]');
    			$this->checkForSubmission($I);
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}
    }

    //Breast Cancer Study
    private function checkAndVerifyBreastCancerStudy(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);
    	if($this->isCancerStudyVisible($I)){
    		$I->click('//*[contains(text(), "JPCF Breast Cancer Study")]');    		
    		if($this->isCancerSitesVisible($I)){
    			$I->click('//*[contains(text(), "Breast Cancer Study test")]');
    			$this->checkForSubmission($I);
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}
    }

    //Oasis Study
    private function checkAndVerifyOasisStudy(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);
    	if($this->isOasisStudyVisible($I)){
    		$I->click('//*[contains(text(), "AMAJ Psoriasis Study")]');    		
    		if($this->isOasisSitesVisible($I)){
    			$I->click('//*[contains(text(), "PSORIASIS(OASIS) Test")]');
    			$this->checkForSubmission($I);
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}
    }

    //Radiant Study
    private function checkAndVerifyRadiantStudy(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);
    	if($this->isRadiantStudyVisible($I)){
    		$I->click('//*[contains(text(), "RADIANT Study")]');    		
    		if($this->isRadiantSitesVisible($I)){
    			$I->click('//*[contains(text(), "RADIANT Study For ECZEMA Site test")]');
    			$this->checkForSubmission($I);
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}
    }

    //DIALOGTEC TEST LINE
    private function checkAndVerifyDialogtecTestLine(FunctionalTester $I)
    {
    	$this->selectStudyPage($I);
    	if($this->isDialogtecTestLineVisible($I)){
    		$I->click('//*[contains(text(), "DIALOGTEC TEST LINE")]');
    		if($this->isDialoguetechSitesVisible($I)){
    			$I->click('//*[contains(text(), "Dialoguetech Testing")]');
    			if($this->isDateVisible($I)){    				
    				$todayDate = date('m/d/Y h:i:s', time());
    				$todayTime = $I->multiexplode(array(' ',':'), $todayDate);    				
    				$newTime = $todayTime[1];
    				$dateLength = $this->submissionCount($I);
    				if($dateLength == 0){  
    					if($newTime <= 12){
    						$I->assertTrue(true); 
    					}else{    						
    						$I->assertFalse(True);	
    					}	
    				}elseif($dateLength == 1){
    					//there is one entry
    					$I->assertTrue(true); 
    				}else{
    					$I->assertFalse(True);
    				}
    			}else{
	    			$I->assertTrue(false);
	    		}	
    		}else{
	    		$I->assertTrue(false);
	    	}

    	}else{
    		$I->assertTrue(false);
    	}

    }

    private function checkForSubmission(FunctionalTester $I)
    {
    	if($this->isDateVisible($I)){    				
			$todayDate = date("Y-m-d", time());
			$dateLength = $this->submissionCount($I);
			if($dateLength == 1){
				$subjectName = $I->getInputText('#user_gridview_container div:nth-child(3) div:nth-child(2) div:nth-child(3)');
				if(stripos($subjectName,'Automated') !== false ){
				 	$I->assertTrue(true); 
				}
			}elseif($dateLength == 2){
				$entryFound = false;	
				for($sub = 2; $sub <= 3; $sub ++){    					
					$submissionSubjectName = $I->getInputText('#user_gridview_container div:nth-child(3) div:nth-child('.$sub.') div:nth-child(3)');
					if(stripos($submissionSubjectName,'Automated') !== false){
						$entryFound = true;	
					}
				}
				if($entryFound){
					$I->assertTrue(true); 	
				}
			}else{
				$I->assertFalse(True);
			}

		}else{
			$I->assertTrue(false);
		}	
    }

    private function submissionCount(FunctionalTester $I)
    {
    	$count = 0;
    	$todayDate = date("Y-m-d", time());
    	for($sub = 2; $sub <= 3; $sub ++){
			$submissionDate = $I->getInputText('#user_gridview_container div:nth-child(3) div:nth-child('.$sub.') div:nth-child(1)');			
			$refinedDate = $I->multiexplode(array(" ", ":"), $submissionDate);
			$refinedDate = $refinedDate[0];
			if($todayDate == $refinedDate){
				$count ++;
			}
		}
		return $count;
    }

    		//////////////////////////// 	Wait For Visible and In visible 	///////////////

			////////////////// 		Radiant Study 		///////////////////

    private function isRadiantStudyVisible(FunctionalTester $I)
    {
    	$I->scrollTo('//*[contains(text(), "RADIANT Study")]',20,400);  
    	return $I->visible('//*[contains(text(), "RADIANT Study")]');
    }

    private function isRadiantSitesVisible(FunctionalTester $I)
    {    	
    	return $I->visible('//*[contains(text(), "RADIANT Study For ECZEMA Site test")]');
    }

			////////////////// 		Oasis Cancer Study 		///////////////////

    private function isOasisStudyVisible(FunctionalTester $I)
    {
    	//$I->scrollTo('//*[contains(text(), "OASIS Psoriasis Study")]',20,400);  
    	return $I->visible('//*[contains(text(), "AMAJ Psoriasis Study")]');
    }

    private function isOasisSitesVisible(FunctionalTester $I)
    {   
        $I->scrollTo('//*[contains(text(), "PSORIASIS(OASIS) Test")]',20,400);   	
    	return $I->visible('//*[contains(text(), "PSORIASIS(OASIS) Test")]');
    }

			////////////////// 		Breast Cancer Study 		///////////////////

    private function isCancerStudyVisible(FunctionalTester $I)
    {
    	$I->scrollTo('div.container.margin_b70px div.studies-contents div:nth-child(14)',20,400);  
    	return $I->visible('//*[contains(text(), "JPCF Breast Cancer Study")]');
    }

    private function isCancerSitesVisible(FunctionalTester $I)
    {    	
    	return $I->visible('//*[contains(text(), "Breast Cancer Study test")]');
    }

    		////////////////// 		Eczema Study 		///////////////////

    private function isEczemaStudyVisible(FunctionalTester $I)
    {
    	$I->scrollTo('//*[contains(text(), "JAIW Eczema Study")]',20,400);      	
    	return $I->visible('//*[contains(text(), "JAIW Eczema Study")]');
    }

    private function isEczemaSitesVisible(FunctionalTester $I)
    {
    	$I->scrollTo('//*[contains(text(), "MY SKIN TEST")]',20,400);  	
    	return $I->visible('//*[contains(text(), "MY SKIN TEST")]');
    }

    		////////////////// 		Dialogtec Test		///////////////////

    private function isDialogtecTestLineVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "DIALOGTEC TEST LINE")]');
    }
    
    private function isDialoguetechSitesVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Dialoguetech Testing")]');
    }

    		////////////////// 		Presence Study 		///////////////////

    private function isPresenceStudyVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "HBEH Parkinsons Study")]');
    }
    
    private function isPresenceSitesVisible(FunctionalTester $I)
    {  
    	$I->scrollTo('div.container.margin_b70px div.studies-contents div:nth-child(35)',20,400);  	
    	return $I->visible('//*[contains(text(), "The Presence Study Test")]');
    }

			////////////////// 		Alopecia Study 		///////////////////

	private function isAlopeciaSitesVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "ALOPECIA AREATA STUDY TESTING")]');
    }

    private function isAlopeciaStudyVisible(FunctionalTester $I)
    {
    	$I->scrollTo('//*[contains(text(), "JAHO Alopecia Study")]',20,400);  
    	return $I->visible('//*[contains(text(), "JAHO Alopecia Study")]');
    }

    private function isDownloadButtonVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Download")][1]');
    }

    private function isDateVisible(FunctionalTester $I)
    {
    	return $I->visible('//div[contains(text(), "Date")]');
    }
    
    private function isStudyNamesVisible(FunctionalTester $I)
    {
    	return $I->visible('//*[contains(text(), "Name")]');
    }

    private function isStudiesPageInVisible(FunctionalTester $I)
    {
    	return $I->invisible('//span[contains(text(), "Studies")]');
    }
}
