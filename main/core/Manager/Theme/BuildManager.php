<?php

namespace Claroline\CoreBundle\Manager\Theme;

use Claroline\CoreBundle\Entity\Theme\Theme;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @DI\Service("claroline.manager.theme_builder")
 */
class BuildManager
{
    const INSTALLED_THEME_PATH = 'Resources/themes';

    const CUSTOM_THEME_PATH    = 'themes';

    /** @var KernelInterface */
    private $kernel;

    /** @var string */
    private $filesDir;

    /**
     * BuildManager constructor.
     *
     * @DI\InjectParams({
     *     "kernel"   = @DI\Inject("kernel"),
     *     "filesDir" = @DI\Inject("%claroline.param.files_directory%")
     * })
     *
     * @param KernelInterface $kernel
     * @param string          $filesDir
     */
    public function __construct(KernelInterface $kernel, $filesDir)
    {
        $this->kernel = $kernel;
        $this->filesDir = $filesDir;
    }

    public function rebuild(array $themes)
    {
        foreach ($themes as $theme) {
            $this->rebuildTheme($theme);
        }
    }

    private function rebuildTheme(Theme $theme)
    {
        $themeSrc = '';

        // retrieve source files of the theme
        $plugin = $theme->getPlugin();
        if (!empty($plugin)) {
            // installed themes are located inside symfony bundles
            $bundleName = $plugin->getVendorName().$plugin->getShortName();

            // load bundle instance from kernel if it's enabled
            try {
                $bundle = $this->kernel->getBundle($bundleName);
                $themeSrc = join(DIRECTORY_SEPARATOR, [$bundle->getPath(), static::INSTALLED_THEME_PATH]);
            } catch (\InvalidArgumentException $e) {
                // the bundle is not enabled, just do nothing
            }
        } else {
            // custom themes are in the files directory of the platform
            $themeSrc = join(DIRECTORY_SEPARATOR, [$this->filesDir, static::CUSTOM_THEME_PATH]);
        }

        if (!empty($themeSrc)) {
            $this->compileTheme(
                $themeSrc.DIRECTORY_SEPARATOR.$theme->getNormalizedName()
            );
        }
    }

    private function compileTheme($themeSrc)
    {

    }
}
