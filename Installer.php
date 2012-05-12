<?php

namespace OcraComposerInstaller\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;

class TemplateInstaller extends LibraryInstaller
{
    /**
     * Module installer, like this module
     */
    const TYPE_MODULE_INSTALLER = 'zendframework-module-installer';

    /**
     * Standard ZendFramework module
     */
    const TYPE_MODULE = 'zendframework-module';

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        if ($package->getType() === 'zendframework-module-installer') {
            return ($this->vendorDir ? $this->vendorDir . '/' : '')
                . substr(__NAMESPACE__, 0, strpos(__NAMESPACE__, '\\'));
        }

        return parent::getInstallPath($package);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return static::TYPE_MODULE === $packageType || static::TYPE_MODULE_INSTALLER === $packageType;
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        var_dump('installing ' . $package->getName());
        parent::install($repo, $package);
        if ($package->getType() === static::TYPE_MODULE) {
            // @todo custom installation steps (add itself to `application.config.php`?)
        }
    }
}
