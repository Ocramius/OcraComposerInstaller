# OcraComposerInstaller

This module is a `composer-installer` package type for composer. It handles the path where packages of type
`zendframework-module-autoloader` are installed (simply into `vendor` typically). This is to avoid manual setting of
`module_paths` in ZendFramework applications using modules.