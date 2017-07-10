<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
  
namespace Claroline\LexiconBundle;


use Claroline\CoreBundle\Library\DistributionPluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;
use Claroline\MessageBundle\Installation\AdditionalInstaller;

class ClarolineLexiconBundle extends DistributionPluginBundle

{
    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();

        return $config->addRoutingResource(__DIR__.'/Resources/config/routing.yml', null, 'lexicon');
    }

    public function hasMigrations()
	{
	    return false;
	}
}
