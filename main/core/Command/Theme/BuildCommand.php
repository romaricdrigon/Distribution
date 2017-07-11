<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Command\Theme;

use Claroline\CoreBundle\Manager\ThemeBuilderManager;
use Claroline\CoreBundle\Manager\ThemeManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('claroline:theme:build')
            ->setDescription('Build themes which are installed in the platform');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ThemeManager $themeManager */
        $themeManager = $this->getContainer()->get('claroline.manager.theme_manager');

        /** @var ThemeBuilderManager $builder */
        $builder = $this->getContainer()->get('claroline.manager.theme_builder');

        $output->writeln('Rebuilding themes...');

        $builder->rebuild($themeManager->all());

        $output->writeln('Done !');
    }
}
