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


use Claroline\LexiconBundle\Controller\API\Jibiki\JibikiResources;
use Claroline\CoreBundle\Event\DisplayToolEvent;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Claroline\LexiconBundle\Manager\DictionariesUsersManager as DUM;


/**
 *  @DI\Service("claroline_lexicon.manager.dictionaries")
 */

class DictionariesManager
{
   
    /**
     * @var users
     */
    public $users;

    /**
     * @var userClaro
     */
    public $userClaro;

    /**
     * @var userManager
     */
    public $userManager;

    /**
     * @var JBKusers
     */
    public $JBKusers;

    /**
     * @var ClaroUser
     */
    private $ClaroUser;

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
     * @var questionManager
     */
    private $questionManager;


    /**
     * DictionariesManager constructor.
     * 
     * @DI\InjectParams({
     *     "userClaro"    = @DI\Inject("claroline_lexicon.authUsers"),
     *     "userManager"  = @DI\Inject("claroline_lexicon.manager.users"),
     *     "questionManager"  = @DI\Inject("ujm_exo.manager.question")
     * })
     */
    public function __construct($userClaro, $userManager, $questionManager)
    {
        $this->lexicon_manager   = $userClaro;
        $JBKresources            = new JibikiResources();
        $this->JBKresources      = $JBKresources;
        $this->userClaro         = $userClaro;
        $this->userManager       = $userManager;
        $this->JBKusers          = $this->userManager->getAllJBKUsers();
        $this->ClaroUser         = $userClaro->generateAuth();
        $this->questionManager   = $questionManager;
    }

    /**
     * Checks if a user is allowed to pass a quiz or not.
     *
     */
    public function getAllUserResources()
    {
        $userslogin     = $this->JBKusers[1];
        $clarousername  = $this->ClaroUser['username'];
        $claropass      = $this->ClaroUser['password'];
        if ($this->userManager->userloginExist($clarousername)) {
            $dico = $this->JBKresources->get_all_dictionaries($clarousername, $claropass);
            $Resources = $this->serializeResources($dico); 
            return $Resources;
        }  
        else{ 
            $message = "<span class='alert alert-danger'> Vous n'avez pas un compte utilisateur sur la plateforme Jibiki. 
            Nous allons vous créer un rapidement ! </span>";
            $this->userManager->createUser();
        }
         
    }


    public function serializeResources($resources)
    { 
        $resourcesjsondata = new \stdClass();
        $diconame          = array();
        $dicocontent       = array();
        foreach ($resources as $titledico => $dico) {
            array_push($diconame, $titledico);
            $jsondico = $this->encodeToJson($dico);
            array_push($dicocontent, $jsondico);
        }
        $resourcesjsondata->totalResults         = count($diconame);
        $resourcesjsondata->questions            = array_map(function($n){return $n;}, $dicocontent);
        $resourcesjsondata->pagination           = new \stdClass();
        $resourcesjsondata->pagination->current  =  0;
        $resourcesjsondata->pagination->pageSize = -1;
        $resourcesjsondata->sortBy               = new \stdClass(); 
        //print_r(json_encode((array) $resourcesjsondata, True));
        return json_encode((array) $resourcesjsondata, True);
    }

    public function encodeToJson($dico)
    {
        $resourcejsondata                = new \stdClass();
        $resourcejsondata->id            = $dico->name;
        $resourcejsondata->type          = $dico->name;
        $resourcejsondata->title         = "";
        $resourcejsondata->category      = $dico->category;
        $resourcejsondata->content       = $dico->fullname;
        $resourcejsondata->meta          = new \stdClass();
        $resourcejsondata->created       = "2017-05-30T12:10:15";
        $resourcejsondata->updated       = "2017-05-30T17:10:15";
        $resourcejsondata->model         = false;
        $resourcejsondata->usedBy        = array(); 
        $resourcejsondata->sharedWith    = array();
        $resourcejsondata->description   = $dico->comments;
        $resourcejsondata->hints         = array();
        $resourcejsondata->meta->authors = array();
        array_push($resourcejsondata->meta->authors, $this->author($dico));
        array_push($resourcejsondata->sharedWith, $this->shareWith($dico));
        return $resourcejsondata;
    }

    public function author($dico)
    {
        $author        = new \stdClass();
        $author->id    = (string) $this->ClaroUser['id'];
        $author->name  = $dico->authors;
        $author->email = $dico->owner.'@yahoo.fr';
        return $author;
    }

    public function shareWith($dico)
    {
        $share              = new \stdClass();
        $share->adminRights = false;
        $share->user        = new \stdClass();
        $share->user->id    = (string) $this->ClaroUser['id'];
        $share->user->name  = $dico->authors;
        $share->user->email = $dico->owner.'@yahoo.fr';
        return $share;
    }

    public function getUserResources()
    {
        $right = $this->checkRights($this->JBKusers);

        return False;
    }

    public function getShareUserResources()
    {
        $right = $this->checkRights($this->user);

        return False;
    }

    public function getPrivateUserResources()
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


