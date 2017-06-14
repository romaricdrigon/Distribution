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
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Claroline\CoreBundle\Entity\User;
use GuzzleHttp\Client;
use Claroline\LexiconBundle\Controller\API\Jibiki\ContentResource;




class JBKResources
{
    public  $base_api_uri = 'http://totoro.imag.fr/lexinnova/api';
	public  $header 	  = ['Content-Type' => 'application/xml;charset=UTF-8', 'Accept' => 'application/xml'];
	private $CLIENT_RESOURCES;

	public function __construct() {
		$this->CLIENT_RESOURCES = new Client([
        // Base URI is used with relative requests
        //'base_uri' => 'http://totoro.imag.fr/lexinnova/apiusers/',
        'base_uri' => $this->base_api_uri,
        'headers'  => $this->header
        ]);
	}

    public function get_volume($dictname, $lang)
    {
        $volume = '';
        $response = $this->CLIENT_RESOURCES->request('GET', $dictname.'/'.$lang, ['http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='apierror'>REST API GET VOLUME ERROR: $code $reason</p>\n";
        } else {
            $volumexml = simplexml_load_string($response->getBody());
            $volume = ContentResource::fromXML($volumexml);
        }

        return $volume;
    }


	public function get_dictionary($dictname)
    {
        $dict = '';
        $response = $this->CLIENT_RESOURCES->request('GET', $dictname, ['http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='panel panel-body'>REST API GET DICT ERROR: $code $reason</p>\n";
        } else {
        	$dicfile = $response->getBody();
            //$dictab = array($dicfile->{'last-modification-date'}, $dicfile->{'source'}, $dicfile->{'name'});
            $dictxml = simplexml_load_string($dicfile);
            $dict = ContentResource::fromXML($dictxml);
            foreach ($dict->src as $volumelang) {
                $volume = $this->get_volume($dict->name, $volumelang);
                $dict->volumes[$volumelang] = $volume;
        	}
        }

        return $dict;
    }

    public function get_all_dictionaries()
    {
        $dict = '';
        $dictxml = '';
        $response = $this->CLIENT_RESOURCES->request('GET','');
        $code = $response->getStatusCode();
        if ($code != 200) {
            $reason = $response->getReasonPhrase();
            echo "<p class='panel panel-body'>REST API GET DICT ERROR : $code $reason</p>\n";
        } else {
            $dicfile = $response->getBody();
            $dictxml = simplexml_load_string($dicfile);
            //$dict = ContentResource::fromXML($dictxml);
        }

        return $dictxml;
    }

    public function post_volume($dictname, $src, $voldata, $user, $password)
    {
        $response = $this->CLIENT_RESOURCES->request('POST', $dictname.'/'.$src, ['body' => $voldata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='apierror'>REST API POST VOLUME ERROR : $code $reason</p>\n";
            echo $response->getBody();
        }

        return $code;
    }

    public function put_volume($dictname, $src, $voldata, $user, $password)
    {
        $volume = '';
        $response = $this->CLIENT_RESOURCES->request('PUT', $dictname.'/'.$src, ['body' => $voldata, 'auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 201) {
            $reason = $response->getReasonPhrase();
            echo "<p class='apierror'>REST API PUT VOLUME ERROR : $code $reason</p>\n";
        } else {
            $volumexml = simplexml_load_string($response->getBody());
            $volume = ContentResource::fromXML($volumexml);
        }

        return $volume;
    }

    public function delete_volume($dictname, $src, $voldata, $user, $password)
    {
        $response = $this->CLIENT_RESOURCES->request('DELETE', $dictname.'/'.$src, ['auth' => [$user, $password], 'http_errors' => false]);
        $code = $response->getStatusCode();
        if ($code != 204) {
            $reason = $response->getReasonPhrase();
            echo "<p class='apierror'>REST API DELETE VOLUME ERROR : $code $reason</p>\n";
        }

        return $code;
    }
}

