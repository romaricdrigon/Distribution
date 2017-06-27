<?php



namespace Claroline\LexiconBundle\Manager;



/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


 
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\GroupManager;
use Claroline\CoreBundle\Manager\UserManager;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiUsers;
use Claroline\CoreBundle\Event\DisplayToolEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Claroline\LexiconBundle\Manager\AuthUsersManager;




/**
 *  @DI\Service("claroline_lexicon.manager.users")
 */
class DictionariesUsersManager extends JibikiUsers
{

	/**
     * @var user
     */
    private $username;

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
    private $userResources;

     /**
     * @var JBKUsers
     */
    private $JBKUsers;

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
     *     "userClaro"    = @DI\Inject("claroline_lexicon.authUsers")
     * })
     */

    public function __construct($userClaro)
    {
        $this->JBKUsers     = new JibikiUsers();
        $this->ClaroUser    = $userClaro->generateAuth();
        $this->getUriUser();
    } 

    public function getUriUser()
    {
        $this->username    = $this->ClaroUser['username'];
        $this->email       = $this->ClaroUser['email'];
        $this->id          = $this->ClaroUser['id'];
        $this->password    = $this->ClaroUser['password'];
        $this->name        = $this->ClaroUser['firstName'].' '.$this->ClaroUser['LastName'];
    }

    public function getCurrentUser()
    {
        $currentuser        = new \stdClass();
        $currentuser->id    = $this->ClaroUser['id'];
        $currentuser->name  = $this->ClaroUser['firstName'].' '.$this->ClaroUser['LastName'];
        $currentuser->email = $this->ClaroUser['email'];
        //print_r(json_encode((array) $currentuser, True));
        return json_encode((array) $currentuser, True);
    } 


    public function getAllJBKUsers()  
    {
        $userlogins    = array();
        $usernames     = array();
        $userslist     = array();
        $userslistjson = json_decode($this->JBKUsers->get_userlist(),true);
       	foreach ($userslistjson['user-list']['user'] as $user){
       		foreach ($user as $nam=>$log){
       			if ($nam == 'login') {
       				array_push($userlogins, $log);
       			}else{
       				array_push($usernames, $log);
       			}
       		}
       	}
        
        return array($usernames, $userlogins);
    }


    public function usernameExist($U)
    {
        $usernames  = $this->getAllJBKUsers()[0];
        foreach($usernames as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }


    public function userloginExist($U)
    {
        $userlogins   = $this->getAllJBKUsers()[1];
        foreach($userlogins as $user) {
        	if($user == $U) {
        		return True;
        	}
        }
    }


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
    }


    public function createUser()
    {
        if ($this->JBKUsers->post_user($this->name, $this->username, $this->password, $this->email)){
            echo "<span class='alert alert-success'> Votre compte utilisateur : '".$this->username."'  a bien été crée sur la plateforme Jibiki &#9786; </span>";
        }
        else{
            echo "<span class='alert alert-danger'> Votre compte utilisateur : '".$this->username."'  n'a pas pu être crée sur la plateforme Jibiki. 
            Veuillez vérifier la disponibilité de votre login ou réessayer plutard &#9785; </span>";
        }
    }








}
