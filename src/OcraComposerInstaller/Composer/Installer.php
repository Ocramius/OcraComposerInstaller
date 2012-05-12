<?php

namespace OcraComposerInstaller\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;
use Composer\Repository\InstalledRepositoryInterface;
use UnexpectedValueException;

class Installer extends LibraryInstaller
{
    /**
     * Module installer, like this module
     */
    const TYPE_MODULE_AUTOLOADER = 'zendframework-module-autoloader';

    /**
     * Standard ZendFramework module
     */
    const TYPE_MODULE = 'zendframework-module';

    /**
     * Name of the file to which module paths will be flushed
     */
    const MODULE_PATHS_FILE = 'module_paths.php';

    /**
     * {@inheritDoc}
     */
    public function getInstallPath(PackageInterface $package)
    {
        if ($package->getType() === static::TYPE_MODULE_AUTOLOADER) {
            return ($this->vendorDir ? $this->vendorDir . '/' : '')
                . substr($package->getPrettyName(), strpos($package->getPrettyName(), '/') + 1);
        }

        return parent::getInstallPath($package);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return static::TYPE_MODULE === $packageType || static::TYPE_MODULE_AUTOLOADER === $packageType;
    }

    /**
     * {@inheritDoc}
     */
    public function install(InstalledRepositoryInterface $repo, PackageInterface $package)
    {
        parent::install($repo, $package);

        $this->writeModuleMapFile($package);
    }

    /**
     * {@inheritDoc}
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        parent::update($repo, $initial, $target);

        $this->writeModuleMapFile($target);
    }

    /**
     * Stores a php array containing a list of paths to installed ZendFramework modules
     */
    protected function writeModuleMapFile(PackageInterface $package)
    {
        $this->initializeVendorDir();
        $modulePathsFile = ($this->vendorDir ? $this->vendorDir . '/' : '') . static::MODULE_PATHS_FILE;
        $modulePaths = @include $modulePathsFile;

        if (!is_array($modulePaths)) {
            $modulePaths = array();
        }

        $prettyName = substr($package->getPrettyName(), strpos($package->getPrettyName(), '/') + 1);
        $installPath = $this->getInstallPath($package);
        $modulePaths[$prettyName] = $installPath;

        foreach ($modulePaths as $key => $path) {
            if (!realpath($path)) {
                unset($modulePaths[$key]);
            }
        }

        $phpOutput = "<?php" . PHP_EOL . 'return ' . var_export($modulePaths, true) . ';';

        if (!@file_put_contents($modulePathsFile, $phpOutput)) {
            throw new UnexpectedValueException('Could not write contents to file "' . $modulePathsFile . '"');
        }
    }
}
