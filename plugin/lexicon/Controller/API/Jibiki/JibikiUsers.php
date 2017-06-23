<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\LexiconBundle\Controller\API\Jibiki;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Claroline\CoreBundle\Entity\User;
use GuzzleHttp\Client;
use Claroline\LexiconBundle\Manager\DictionariesManager;


class JibikiUsers
{
	public  $base_api_uri = 'http://totoro.imag.fr/lexinnova/apiusers/';
	public  $header 	  = ['Content-Type' => 'application/json;charset=UTF-8', 'Accept' => 'application/json'];
	private $CLIENT_USER;

	public function __construct() {
		$this->CLIENT_USER = new Client([
        // Base URI is used with relative requests
        //'base_uri' => 'http://totoro.imag.fr/lexinnova/apiusers/   http://pc-mangeot.imag.fr:8999/apiusers/',
        'base_uri' => $this->base_api_uri,
        'headers'  => $this->header
        ]);
	}

	public function post_user($name, $login, $password, $email)
    {
        $userjsondata = '{"user": {
        "name": "'.$name.'",
        "login": "'.$login.'",
        "email": "'.$email.'"
        }}';
        $response = $this->CLIENT_USER->request('POST', 'users/' . $login, ['body' => $userjsondata, 'auth' => [$login, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<br/><div className='panel panel-body'>REST APIUSERS POST USER ERROR: $code $reason</div>\n";
    	}else {
        	$message = $code."<br/><span className='panel panel-body'>L'utilisateur : ".$name." a bien été enrégistré!</span><br/>";
        	return $message;
        }
    }


    public function delete_user($user, $password)
    {
        $response = $this->CLIENT_USER->request('DELETE', 'users/' . $user, ['auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();

        if ($code != 204) {
            $reason = $response->getReasonPhrase();
            echo "<p className='panel panel-body'>REST API DELETE DICT ERROR: $code $reason</p>\n";
        }else {
        	$message = $code."<span className='panel panel-body'>L'utilisateur : ".$name."a bien été supprimé!</span>";
        	return $message;
        }
    }

 	public function get_userlist($admin, $password)
    {
        $userlist = array();
        $response = $this->CLIENT_USER->request('GET', 'AdminUsers.po', [
                                                'auth' => [$admin, $password],
                                                'http_errors' => false, ]);
        $code = $response->getStatusCode();
        $body = (string) $response->getBody();
		$body = preg_replace('/&nbsp;/', '&#160;', $body);
        
        $usersxml = simplexml_load_string($body);
        $tables = $usersxml->xpath('//*[@summary]');
        $userstable = '';
        foreach ($tables as $table) {
            $hrefs = $table->xpath('.//*[@href]');
            if (count($hrefs) > 2) {
                $userstable = $table->tbody;
                foreach ($userstable->children() as $tr) {
                    $tds = $tr->children();
                    $handle = $tds[10]->asXML();
                    $handle = preg_replace('/^.*Remove=([0-9]+).*$/', '$1', $handle);
                    $user = new Utilisateur((string) $tds[0]->b->span, (string) $tds[1]->span, (string) $tds[2]->span, $handle);
                    $userlist[$user->login] = $user;
                }
            }
        }
        $reason = $response->getReasonPhrase();
        if ($code != 200) {
            echo "<p class='apierror'>REST API POST USER ERROR: $code $reason</p>\n";
        }

        return $userlist;
    }

}
