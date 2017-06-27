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

 

use Claroline\CoreBundle\Manager\GroupManager;
use Claroline\CoreBundle\Manager\UserManager;
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiUsers;
use JMS\DiExtraBundle\Annotation as DI;


/**
 *  @DI\Service("claroline_lexicon.authUsers")
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

	/**
	 * @DI\InjectParams({
	 *     "container"    = @DI\Inject("service_container")
	 * })
	 */

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

	private function getLname() {
		$fname = $this->container->getLastName();
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
		$userProprieties              	  = array();
		$userProprieties['username']      = $this->getUsername();
		$userProprieties['firstName']     = $this->getFname();
		$userProprieties['LastName']      = $this->getLname();
		$userProprieties['email']         = $this->getEmail();
		$userProprieties['id']            = $this->getUserId();
		$userProprieties['password']      = $this->getPassword();
		$userProprieties['makepassword']  = $this->makePassword();
		
		return $userProprieties; 
	}



}