<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\LexiconBundle\Controller\openResources;


use Claroline\CoreBundle\Entity\Group;
use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Entity\Workspace\Workspace;
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\GroupManager;
use Claroline\CoreBundle\Manager\MailManager;
use Claroline\CoreBundle\Manager\UserManager;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Claroline\CoreBundle\Pager\PagerFactory;
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


class DesktopLexiconController extends Controller
{

    /**
     * @EXT\Route(
     *     "/tool",
     *     name="claro_desktop_lexicon_home",
     *     options={"expose"=true}
     *
     * )
     * @EXT\Method("GET")
     * @EXT\Template("ClarolineLexiconBundle:Pages:home.html.twig")
     */
    public function indexHome()
    {
        $data_content = '{
          "name": "claroline-distribution",
          "version": "1.0.0",
          "description": "Claroline distribution frontend dependencies",
          "dependencies": {
            "classnames": "^2.2.5",
            "checklist-model": "^0.10.0",
            "core-js": "^2.4.1",
            "crypto-js": "^3.1.9-1",
            "d3": "^4.4.0",
            "dragula": "^3.7.1",
            "immutability-helper": "^2.0.0",
            "invariant": "^2.2.1",
            "lodash": "^4.16.1",
            "modernizr": "^3.3.1",
            "moment": "^2.15.1",
            "react": "^15.4.0",
            "react-bootstrap": "^0.30.3",
            "react-color": "^2.11.1",
            "react-datepicker": "^0.29.0",
            "react-dnd": "^2.1.4",
            "react-dnd-touch-backend": "^0.3.6",
            "react-dom": "^15.4.0",
            "react-redux": "^4.4.5",
            "redux": "^3.5.2",
            "redux-thunk": "^2.1.0",
            "reselect": "^2.5.3",
            "svg4everybody": "^2.1.2",
            "tinycolor2": "^1.4.1",
            "uuid": "^3.0.1",
            "whatwg-fetch": "^2.0.1"
          },
          "files": [
            "package.json"
          ]
        }' ;
        return $this->render('ClarolineLexiconBundle:Pages:home.html.twig', array('data' => $data_content));
    }

    /**
     * @EXT\Route(
     *     "/{typeResource}/{idResource}",
     *     name="lexicon_consult",
     *     requirements={
     *        "idResource" : "\d+\w+",
     *        "typeResource" : "dictionary|glossary"
     *      }
     * )
     * @EXT\Method("GET")
     * Displays the message form with the "to" field filled with users of a group.
     */
    public function consultResource($typeResource, $idResource)
    {
       return $this->render('ClarolineLexiconBundle:Pages:content-resource.html.twig');
    }

}
