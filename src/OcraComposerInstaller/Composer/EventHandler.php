<?php

namespace OcraComposerInstaller\Composer;

use Composer\Script\Event;
use Composer\Package\PackageInterface;
use Composer\Repository\CompositeRepository;

class EventHandler
{
    /**
     * @var PackageInterface[]
     */
    protected static $updatedModules = array();

    /**
     * @var PackageInterface[]
     */
    protected static $installedModules = array();

    /**
     * @param \Composer\Script\Event $event
     */
    public function postPackageInstall(Event $event)
    {
        die(__METHOD__);
        var_dump(array(__METHOD__ => $event));
    }

    /**
     * @param \Composer\Script\Event $event
     */
    public function postPackageUpdate(Event $event)
    {
        die(__METHOD__);
        var_dump(array(__METHOD__ => $event));
    }

    /**
     * @param \Composer\Script\Event $event
     */
    public function postPackageUninstall(Event $event)
    {
        die(__METHOD__);
        var_dump(array(__METHOD__ => $event));
    }

    /**
     * @param \Composer\Script\Event $event
     */
    public static function postUpdate(Event $event)
    {
        die(__METHOD__);
        /* @var $event \Composer\Composer */
        $composer = $event->getComposer();
        /* @var $rm \Composer\Repository\RepositoryManager */
        $rm = $composer->getRepositoryManager();
        $repo = new CompositeRepository(array($rm->getLocalDevRepository(), $rm->getLocalRepository()));
        $packages = $repo->getPackages();

        $zfPackages = array_filter($packages, function ($package) {
            return 'zendframework-module' === $package->getType();
        });

        var_dump(array(__METHOD__ => $zfPackages));
    }

    /**
     * @param \Composer\Script\Event $event
     */
    public static function postInstall(Event $event)
    {
        die(__METHOD__);
        /* @var $event \Composer\Composer */
        $composer = $event->getComposer();
        /* @var $rm \Composer\Repository\RepositoryManager */
        $rm = $composer->getRepositoryManager();
        $repo = new CompositeRepository(array($rm->getLocalDevRepository(), $rm->getLocalRepository()));
        $packages = $repo->getPackages();

        $zfPackages = array_filter($packages, function ($package) {
            return 'zendframework-module' === $package->getType();
        });

        var_dump(array(__METHOD__ => $zfPackages));
    }
}