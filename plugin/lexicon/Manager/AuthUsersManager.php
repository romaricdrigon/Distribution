<?php



namespace Claroline\LexiconBundle\Manager;

 

use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\GroupManager;
use Claroline\CoreBundle\Manager\UserManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiUsers;
use Claroline\CoreBundle\Event\DisplayToolEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 *  @DI\Service("claroline_lexicon.manager.lexicon")
 */
class AuthUsersManager
{

	/**
     * @var login
     */
    public $login;

    /**
     * @var password
     */
    private $password;

    /**
     * @var container
     */
    private $container;

    /**
     * @var even
     */
    private $even;



	public function __construct($container) {
		$this->container = $container->get('security.token_storage')->getToken()->getUser();
	}


	private function getUserId() {
		$userid = $this->container->getId();
		return $userid;
	}

	private function getUsername() {
		$username = $this->container->getUsername();
		return $username;
	}

	private function getEmail() {
		$mail = $this->container->getMail();
		return $mail;
	}

	private function getFname() {
		$fname = $this->container->getFirstName();
		return $fname;
	}

	private function getPassword() {
		$password = $this->container->getPassword();
		return $password;
	}

	private function makePassword(){
		$user     = $this->getUsername();
		$password = md5($user);
		return $password;
	}

	public function generateAuth() {
		var_dump($this->container->getUsername());
		$userProprieties              	  = $this->container->getEditableProperties();
		$userProprieties['username']      = $this->getUsername();
		$userProprieties['firstName']     = $this->getFname();
		$userProprieties['email']         = $this->getEmail();
		$userProprieties['id']            = $this->getUserId();
		$userProprieties['password']      = $this->getPassword();
		$userProprieties['makepassword']  = $this->makePassword();
		
		return $userProprieties; 
	}



}