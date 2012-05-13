<?php

namespace OcraComposerInstaller\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class Installer extends LibraryInstaller
{
    /**
     * Module installer, like this module
     */
    const TYPE_MODULE_AUTOLOADER = 'zendframework-module-autoloader';

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        return ($this->vendorDir ? $this->vendorDir . '/' : '')
            . substr($package->getPrettyName(), strpos($package->getPrettyName(), '/') + 1);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return static::TYPE_MODULE_AUTOLOADER === $packageType;
    }
}
