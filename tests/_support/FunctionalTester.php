<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

   /**
    * Define custom actions here
    */

   //login for rock and roll
   public function login()
   {
        $this->amOnPage('/'); 
        $this->maximizeWindow();
        if($this->isUsernameVisible()){
            $this->fillField(['name' => 'LoginForm[email]'], "salman@maavan.com");
            $this->fillField(['name' => 'LoginForm[password]'], "1234567890");
            if($this->isLoginSubmitButtonVisible()){
                $this->click('.login-btn');
                $this->assertTrue($this->isMainPageVisible());
            }else{
                $this->assertFalse(true);    
            }            
        }else{
            $this->assertFalse(true);    
        } 

   }

   public function mainPage()
   {
   		if($this->isUrlCorrect()){

	        $this->maximizeWindow();
	        return true;
    	}
   }

   /*
    *
    * verifies correct study
    * Enter testing Post code
    *
    */
    public function isOnCorrectStudy()
    {
        if($this->mainPage()){
            if($this->studyCenter()){
                if($this->isZipCodeFieldVisible()){
                    $this->fillField(['name' => 'Name'], "82001");
                    $grabPostCode = $this->grabValueFrom(['name' => 'Name']);              
                    if($grabPostCode == "82001"){
                        $this->click('#submit_zipcode');
                        return $this->loaderVisibleInvisible();
                    }
                }   
            } 
            $I->assertFalse(true);          
        }
        $I->assertFalse(true);
    }

   public function studyCenter()
    {
        if($this->isStudyCenterButtonVisible()){
            $this->click('.menu ul li:nth-child(4)');
            return true;
        }
        $this->assertFalse(true);
        
    }

    public function isMainPageVisible()
    {
        return $this->visible('.download-btn.back-btn');
    }

    public function isLoginSubmitButtonVisible()
    {
        return $this->visible('.login-username');
    }

    public function isUsernameVisible()
    {

        return $this->visible('#loginform-email');
    }

    public function loaderVisibleInvisible()
    {
        if($this->isloaderVisible()){
            return $this->isloaderInVisible();
        }
        return false;
    }

    public function isZipCodeFieldVisible()
    {
        return $this->visible('#name');
    }

    //For Breastcancer study 
    public function isCheckboxVisible()
    {
        return $this->visible('#chk-policy');
    }

    public function isloaderVisible()
    {
        return $this->visible('.spinner');
    }

    public function isloaderInVisible()
    {
        return $this->invisible('.spinner');
    }


    public function isStudyCenterButtonVisible()
    {
        return $this->visible('//a[contains(text(), "Find a Study Center")]');
    }

   ///////////////////////////////////////              Waits For Loading or Visiblity Invisibilty           /////////////////////////////////////////////////

    /*
     * Wait For Element Visible
     * required time (Default:30s)
     */
    public function visible($selector, $time = 30)
    {
        try {
            $this->waitForElementVisible($selector, $time);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
     * Wait For Element Visible
     * required time (Default:30s)
     */
    public function isUrlCorrect()
    {
        try {
            $this->amOnPage($this->amOnPage('/'));
            return true;
        } catch (Exception $e) {
        	$this->amOnPage('#center');
            return true;
        }
    }

    /*
     *
     * For using Jquery
     * Wait for scope to change
     * Sometimes takes 2 to 3 minutes to change
     *
     */
    public function waitForScopeToBeChanged($selector, $time = 60)
    {
        $waitForScope = $this->visible($selector, $time);
        if (!$waitForScope) {
            $this->waitForScopeToBeChanged($selector, $time);
        }
        return true;
    }

    /*
     * Wait For Element Invisible
     * required time (Default:30s)
     */
    public function invisible($selector, $time = 30)
    {
        try {
            $this->waitForElementNotVisible($selector, $time);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function extractAdditionalFromSelector($selector)
    {
        $name = str_replace(
            '$',
            "",
            $this->getInputText('' . $selector . '')
        );
        return $name;
    }

    function multiexplode ($delimiters,$data) {
        $makeReady = str_replace($delimiters, $delimiters[0], $data);
        $return    = explode($delimiters[0], $makeReady);
        return  $return;
    }

}
