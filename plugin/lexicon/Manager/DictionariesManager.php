<?php


namespace Claroline\LexiconBundle\Manager;




use Claroline\CoreBundle\Entity\User;
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiUsers;
use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiResources;
use Claroline\CoreBundle\Event\DisplayToolEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\TwigBundle\TwigEngine;


class DictionariesManager
{
    /**
     * @var user
     */
    public $user;

    /**
     * @var userResources
     */
    public $userResources;

    /**
     * @var userRightsResources
     */
    private $userRightsResources;

    /**
     * @var JBKresources
     */
    private $JBKresources;

    /**
     * @var userShareResources
     */
    private $userShareResources;

    /**
     * DictionariesManager constructor.
     *
     */
    public function __construct()
    {
        $user               = new User();
        $JBKresources       = new JibikiResources();
        $this->user         = $user;
        $this->JBKresources = $JBKresources;
    }

    /**
     * Checks if a user is allowed to pass a quiz or not.
     *
     */
    
    public function getAllUserResources()
    {
        $right = $this->checkRights($this->user);

        return False;
    }

    public function getUserResources()
    {
        $right = $this->checkRights($this->user);

        return False;
    }

    public function getShareUserResources()
    {
        $right = $this->checkRights($this->user);

        return False;
    }
    /**
     * Checks if a user can submit answers to a paper or use hints.
     *
     */
    public function checkRights($user)
    {
        return False;
    }

    /**
     * Starts or continues an exercise paper.
     *
     */
    public function startOrContinue()
    {
       //$data_content = '{}';
      //$Users = new JBKUsers();
      $resources = new JibikiResources();
      $dicos = $resources->get_all_dictionaries('levis', 'levis');
      $dico = $resources->get_dictionary('Lexinnova');
      foreach ($dicos as $dict) {
          echo 'Nom : ',var_dump($dict), ' <br/><br/><br/>';
      }
      //$user = $Users->post_user('Henritest', 'henri', 'hen', 'henri@email.fr');
      //echo $user;
      //$data_content = "{'".$user."'}";
        return False;
    }

   
}


