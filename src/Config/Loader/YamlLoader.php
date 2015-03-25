<?php

namespace derhasi\boxfile\Config\Loader;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

/**
 * File loader supporting Yaml.
 */
class YamlLoader extends FileLoader
{
    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        return Yaml::parse($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return is_string($resource) && 'yml' === pathinfo(
          $resource,
          PATHINFO_EXTENSION
        );
    }

}
