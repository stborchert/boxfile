# boxfile

This is a tool for applying Boxfile specifics to your project. A _Boxfile_ is a configuration file for a [Freistilbox site](https://freistil.zendesk.com/hc/en-us/articles/201084675-The-Boxfile).

## Installation

The tool can be installed via Composer.

```sh
composer require derhasi/boxfile
```

## Command

Creating symlinks for environment specific paths.
```sh
./vendor/bin/boxfile symlink [env] --boxfile=Boxfile --docroot=docroot
```

## Example boxfile

```yaml
version: 1.0
shared_folders:
  - sites/default/files
env_specific_files:
  .htaccess:
    local: .htaccess.local
    staging: .htaccess.stage
  sites/default/settings.php:
    local: settings.local.php
    staging: settings.stage.php
```

With `./vendor/bin/boxfile local` symlinks for the given example will be applied.
