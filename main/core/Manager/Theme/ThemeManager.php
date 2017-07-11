<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Manager\Theme;

use Claroline\CoreBundle\Entity\Theme\Theme;
use Claroline\CoreBundle\Library\Configuration\PlatformConfigurationHandler;
use Claroline\CoreBundle\Persistence\ObjectManager;
use Claroline\CoreBundle\Validator\Exception\InvalidDataException;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @DI\Service("claroline.manager.theme_manager")
 */
class ThemeManager
{
    /**
     * @var array
     * @deprecated
     */
    private static $stockThemes = [
        'Claroline',
        'Claroline Black',
        'Claroline Mint',
        'Claroline Ruby',
    ];

    /** @var ObjectManager */
    private $om;
    /** @var PlatformConfigurationHandler */
    private $config;
    /** @var string */
    private $themeDir;

    /**
     * ThemeManager constructor.
     *
     * @DI\InjectParams({
     *     "om"         = @DI\Inject("claroline.persistence.object_manager"),
     *     "config"     = @DI\Inject("claroline.config.platform_config_handler"),
     *     "kernelDir"  = @DI\Inject("%kernel.root_dir%")
     * })
     *
     * @param ObjectManager                $om
     * @param PlatformConfigurationHandler $config
     * @param string                       $kernelDir
     */
    public function __construct(
        ObjectManager $om,
        PlatformConfigurationHandler $config,
        $kernelDir
    ) {
        $this->om = $om;
        $this->config = $config;
        $this->themeDir = $kernelDir.'/../web/themes';
    }

    /**
     * Lists all themes installed in the current platform.
     *
     * @return array
     */
    public function all()
    {
        return $this->om
            ->getRepository('ClarolineCoreBundle:Theme\Theme')
            ->findBy([], ['name' => 'ASC']);
    }

    /**
     * Creates a new theme.
     *
     * @param array $data
     *
     * @return Theme
     */
    public function create(array $data)
    {
        return $this->update(new Theme(), $data);
    }

    /**
     * Updates an existing theme.
     *
     * @param Theme $theme
     * @param array $data
     *
     * @return Theme
     *
     * @throws InvalidDataException
     */
    public function update(Theme $theme, array $data)
    {
        $errors = $this->validate($data);
        if (count($errors) > 0) {
            throw new InvalidDataException('Theme is not valid', $errors);
        }

        return $theme;
    }

    /**
     * Validates theme data.
     *
     * @param array $data
     *
     * @return array
     */
    public function validate(array $data)
    {
        $errors = [];

        return $errors;
    }

    /**
     * Returns the names of all the registered themes.
     *
     * @return string[]
     */
    public function listThemeNames()
    {
        $themes = $this->all();
        $themeNames = [];

        /** @var Theme $theme */
        foreach ($themes as $theme) {
            $themeNames[$theme->getNormalizedName()] = $theme->getName();
        }

        return $themeNames;
    }

    /**
     * Returns the app theme directory.
     *
     * @return string
     */
    public function getThemeDir()
    {
        return $this->themeDir;
    }

    /**
     * Returns whether the theme directory is writable.
     *
     * @return bool
     */
    public function isThemeDirWritable()
    {
        return is_writable($this->themeDir);
    }

    /**
     * Deletes a theme, including its css directory.
     *
     * @param Theme $theme
     *
     * @throws \Exception if the theme is not a custom theme
     */
    public function delete(Theme $theme)
    {
        if (!empty($theme->getPlugin())) {
            throw new \Exception("Stock and plugins theme '{$theme->getName()}' cannot be deleted");
        }

        $this->om->remove($theme);
        $this->om->flush();

        // todo : to remove and delete src-files instead
        $fs = new Filesystem();
        $fs->remove("{$this->themeDir}/{$theme->getNormalizedName()}");
    }

    /**
     * Returns the current
     * platform theme.
     *
     * @return Theme
     */
    public function getCurrentTheme()
    {
        $name = ucwords(str_replace('-', ' ', $this->config->getParameter('theme')));

        return $this->om
            ->getRepository('ClarolineCoreBundle:Theme\Theme')
            ->findOneBy([
                'name' => $name,
            ]);
    }

    /**
     * Creates a custom theme based on a css file.
     *
     * @param string $name
     * @param File   $file
     * @param bool   $extendDefault
     *
     * @deprecated
     */
    public function createCustomTheme($name, File $file, $extendDefault = false)
    {
        $theme = new Theme();
        $theme->setName($name);
        $theme->setExtendingDefault($extendDefault);
        $themeDir = "{$this->themeDir}/{$theme->getNormalizedName()}";

        $fs = new Filesystem();
        $fs->mkdir($themeDir);

        $file->move($themeDir, 'bootstrap.css');

        $this->om->persist($theme);
        $this->om->flush();
    }

    public function getThemeByNormalizedName($normalizedName)
    {
        $name = ucwords(str_replace('-', ' ', $normalizedName));

        return $this->om
            ->getRepository('ClarolineCoreBundle:Theme\Theme')
            ->findOneBy([
                'name' => $name,
            ]);
    }

    /**
     * @return array
     *
     * @deprecated
     */
    public static function listStockThemesName()
    {
        return self::$stockThemes;
    }
}
