<?php


/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.  
 */ 
 

namespace Claroline\LexiconBundle\Manager;  

 
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiUsers;
use JMS\DiExtraBundle\Annotation as DI;
use Claroline\LexiconBundle\Manager\AuthUsersManager;

  

/**
 *  @DI\Service("claroline_lexicon.manager.users")
 */
class DictionariesUsersManager
{

	/**
     * @var user
     */
    public $username;

    /**
     * @var name
     */
    private $name;

    /**
     * @var email
     */
    private $email;

    /**
     * @var id
     */
    private $id;

    /**
     * @var password
     */
    private $password;

    /**
     * @var userResources
     */
    public $userResources;

     /**
     * @var JBKUsers
     */
    public $JBKUsers;

    /**
     * @var ClaroUser
     */ 
    private $ClaroUser;
 
    /**
     * @var userRightsResources
     */
    private $userRightsResources;

    /**
     * @var userShareResources
     */
    public $userShareResources; 
 

    /**
     * Dictionaries users Manager constructor.
     * 
     * @DI\InjectParams({
     *     "userClaro"    = @DI\Inject("claroline_lexicon.authusers")
     * })
     */
    public function __construct($userClaro)
    {
        $this->ClaroUser  = $userClaro->generateAuth();
    } 


    /**
     * Get current login user from claroline
     * 
     * @return $userproperties (to global variables)
     */ 
    public function getUriUser()
    {

        $this->username    = $this->ClaroUser['username'];
        $this->email       = $this->ClaroUser['email'];
        $this->id          = $this->ClaroUser['id'];
        $this->password    = $this->ClaroUser['password'];
        $this->name        = $this->ClaroUser['firstName'].' '.$this->ClaroUser['LastName'];
    }


    /**
     * Get properties of current login user from claroline
     * 
     * @return $userproperties (json format)
     */
    public function getCurrentUser()
    {
        $currentuser        = new \stdClass();
        $currentuser->id    = $this->ClaroUser['id'];
        $currentuser->name  = $this->ClaroUser['firstName'].' '.$this->ClaroUser['LastName'];
        $currentuser->email = $this->ClaroUser['email'];
        return json_encode((array) $currentuser, True);
    } 


    /**
     * Get all JIBIKI Users from throught its API
     * 
     * @return array($usernames, $login) 
     */
    public function getAllJBKUsers()  
    {
        $this->JBKUsers = new JibikiUsers(); 
        $userlogins     = array();
        $usernames      = array();
        $userslist      = array();
        $userslistjson  = json_decode($this->JBKUsers->get_userlist(),true);
       	foreach ($userslistjson['user-list']['user'] as $user){
       		foreach ($user as $name=>$login){
       			if ($name == 'login') {
       				array_push($userlogins, $login);
       			}else{
       				array_push($usernames, $login);
       			}
       		}
       	}
        
        return array($usernames, $userlogins);
    }

    /**
     * Check if the current claroline username exist in JIBIKI platform
     * 
     * @return Boolean (True or False) 
     */
    public function usernameExist($U)
    {
        $usernames  = $this->getAllJBKUsers()[0];
        foreach($usernames as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }

    /**
     * Check if the current claroline login exist in JIBIKI platform
     * 
     * @return Boolean (True or False) 
     */
    public function userloginExist($U)
    {
        $userlogins   = $this->getAllJBKUsers()[1];
        foreach($userlogins as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }

    /*
    public function userDictionries($U)
    {
        $logins     = $this->getAllJBKUsers()[1];
        foreach($userlogins as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }


    public function getUser()
    {
        $right = $this->checkRights($this->user);

        return False;
    }*/

    
    /**
     * Check if the current claroline user exist in JIBIKI platform.
     * If not, we create a new user in JIBIKI with the same Claroline login.
     * 
     * @return message (success or non-success) 
     */
    public function createUser()
    {
        $this->JBKUsers   = new JibikiUsers();
        if ($this->JBKUsers->post_user($this->name, $this->username, $this->password, $this->email)){
            echo "<span class='alert alert-success'> Votre compte utilisateur : '".$this->username."'  a bien été crée sur la plateforme Jibiki &#9786; </span>";
        }
        else{
            echo "<span class='alert alert-danger'> Votre compte utilisateur : '".$this->username."'  n'a pas pu être crée sur la plateforme Jibiki. 
            Veuillez vérifier la disponibilité de votre login ou réessayer plutard &#9785; </span>";
        }
    }








}
