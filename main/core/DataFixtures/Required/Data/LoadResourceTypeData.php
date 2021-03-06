<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\DataFixtures\Required\Data;

use Claroline\CoreBundle\DataFixtures\Required\RequiredFixture;
use Claroline\CoreBundle\Entity\Activity\ActivityRuleAction;
use Claroline\CoreBundle\Persistence\ObjectManager;

/**
 * Resource types data fixture.
 */
class LoadResourceTypeData implements RequiredFixture
{
    /**
     * All these resource types have the 'document' meta type.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $badgeAwardAction = new ActivityRuleAction();
        $badgeAwardAction->setAction('badge-awarding');
        $manager->persist($badgeAwardAction);
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 2;
    }
}
