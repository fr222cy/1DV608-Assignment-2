<?php



class LoginController
{
public function __construct(LoginView $v, LoginModel $lm, LoginSession $ls)
{
    $this->v = $v;
    $this->lm = $lm;
    $this->ls = $ls;
}

public function init()
{
    $this->userPost();
    $this->userWantsToLogout();
}

//Checks if something is posted.
public function userPost()
{
    if($this->v->isPosted())
    {
        $username = $this->username();
        $password = $this->password();
        
        try
        {
            $this->lm->checkLogin($username, $password);
        
            //If no Exception is thrown, the user has successfully logged in.
            if($this->ls->loginMessage())
            {
                $this->v->statusMessage('Welcome');   
            }
            else
            {
                $this->v->statusMessage('');    
            }
        }   
        //Throw Exception if the user fails to login.
        catch(Exception $e)
        {
            $this->v->statusMessage($e -> getMessage());
        }
    }
}

//Gets the Username input.
public function username()
{
    return $this->v->getUsername();
}

//Gets the Password input.
public function password()
{
    return $this->v->getPassword();
}

//Calls userLogout that destroys the 
public function userWantsToLogout()
{
    if($this->v->logout())
    {
        $this->lm->userLogout();
    
        if(!$this->ls->loginMessage())
        {
            $this->v->statusMessage("Bye bye!");
        }
        else
        {
            $this->v->statusMessage(''); 
        }
    }
}

}







