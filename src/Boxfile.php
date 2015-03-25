<?php

namespace derhasi\boxfile;

/**
 * Representation of boxfile configuration.
 */
class Boxfile {

    protected $version;

    protected $sharedFolders = array();

    protected $envSpecificFiles = array();

    /**
     * Constructor.
     *
     * @param array $boxfile_data
     */
    public function __construct(array $boxfile_data)
    {
        $this->version = $boxfile_data['version'];
        $this->sharedFolders = $boxfile_data['shared_folders'];
        $this->envSpecificFiles = $boxfile_data['env_specific_files'];
    }

    /**
     * Retrieves environement specific file mappings.
     *
     * @param string $environment
     *   Environment indicator, such as 'stage', 'live', 'local'.
     *
     * @return array
     *   Key value array, with target being the key and source being the value.
     */
    public function getEnvironmentSpecificFiles($environment)
    {
        $return = array();
        foreach ($this->envSpecificFiles as $target => $data) {
            if (isset($data[$environment])) {
                $return[$target] = $data[$environment];
            }
        }
        return $return;
    }
}
