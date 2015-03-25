<?php

namespace derhasi\boxfile\Exception;

class FileNotFoundException extends \Symfony\Component\Filesystem\Exception\FileNotFoundException {

    public function __construct($message, $path)
    {
        parent::__construct(sprintf($message, $path), 0, null, $path);
    }

}
