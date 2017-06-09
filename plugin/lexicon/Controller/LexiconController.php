<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\LexiconBundle\Controller;

use Claroline\CoreBundle\Entity\Group;
use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Entity\Workspace\Workspace;
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\GroupManager;
use Claroline\CoreBundle\Manager\MailManager;
use Claroline\CoreBundle\Manager\UserManager;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Claroline\CoreBundle\Pager\PagerFactory;
use Claroline\MessageBundle\Entity\Message;
use Claroline\MessageBundle\Form\MessageType;
use Claroline\MessageBundle\Manager\MessageManager;
use JMS\DiExtraBundle\Annotation as DI;
use JMS\SecurityExtraBundle\Annotation as SEC;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class LexiconController extends Controller
{

    /**
     * @EXT\Route(
     *     "/lexicon",
     *     name="lexicon_index_start",
     *     options={"expose"=false}
     * )
     *
     * Displays the message form with the "to" field filled with user.
     */
    public function indexStartAction()
    {
        return $this->render(
          'ClarolineLexiconBundle:Lexicon:Pages:lexicon.html.twig',
          array('dico' => 'Cool, c"est mon premier lexique !!!!!')
        );
    }

    /**
     * @EXT\Route(
     *     "/lexicon/create",
     *     name="lexicon_create_lexicon"
     * )
     *
     * Displays the message form with the "to" field filled with users of a group.
     */
    public function createLexiconAction()
    {
       return $this->render('ClarolineLexiconBundle:Lexicon:Pages:layout.html.twig');
    }

}
