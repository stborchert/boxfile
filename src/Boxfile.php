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

}
