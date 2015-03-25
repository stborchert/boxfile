<?php

namespace derhasi\boxfile\Config\Loader;

use derhasi\boxfile\Boxfile;
use Symfony\Component\Config\Definition\Processor;

/**
 * Loader for a Boxfile.
 */
class BoxfileLoader extends YamlLoader {

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        return array(
          'boxfile' => parent::load($resource, $type),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        // Boxfile needs not to be a .yml file.
        return is_string($resource);
    }

    /**
     * Loads the processed boxfile object directly.
     *
     * @param $resource
     * @param null $type
     *
     * @return \derhasi\boxfile\Boxfile
     */
    public function loadObject($resource, $type = null)
    {
        $data = $this->load($resource, $type);
        $processor = new Processor();
        $configuration = new \derhasi\boxfile\Config\Definition\BoxfileConfiguration();
        $processedData = $processor->processConfiguration($configuration, $data);

        return new Boxfile($processedData);

    }

}
