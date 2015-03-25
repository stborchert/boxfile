<?php
/**
 * Created by PhpStorm.
 * User: derhasi
 * Date: 25.03.15
 * Time: 18:58
 */

namespace derhasi\boxfile\Config\Loader;

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

}
