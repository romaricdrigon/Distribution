<?php



namespace Claroline\LexiconBundle\Manager;

 
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



class DictionariesUsersManager extends JibikiUsers
{

	/**
     * @var user
     */
    private $username;

    /**
     * @var mail
     */
    private $mail;

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
     * @var ClaroUsers
     */
    private $ClaroUsers;

    /**
     * @var userRightsResources
     */
    private $userRightsResources;

    /**
     * @var userShareResources
     */
    public $userShareResources;

    /**
     * DictionariesUsersManager constructor.
     *
     */

    public function __construct()
    {
        $JBKUsers           = new JibikiUsers();
        $ClaroUsers         = new AuthUsersManager();
        $this->JBKUsers     = $JBKUsers;
        $this->ClaroUsers   = $ClaroUsers->generateAuth();
        getUriUser();
    }

    public function getUriUser()
    {
        $this->username    = $this->ClaroUsers['username'];
        $this->mail        = $this->ClaroUsers['mail'];
        $this->id          = $this->ClaroUsers['id'];
        $this->password    = $this->ClaroUsers['password'];
    }

    public function getAllUser()
    {
        $userslist = $this->JBKUsers->get_userlist($this->username, $this->password);

        return $userslist;
    }

    public function userExist($U)
    {
        $right = $this->JBKUsers->get_userlist;

        return False;
    }


    public function getUser()
    {
        $right = $this->checkRights($this->user);

        return False;
    }









}
