<?php

namespace derhasi\boxfile\Command;

use derhasi\boxfile\Config\BoxfileConfiguration;
use derhasi\boxfile\Config\Loader\BoxfileLoader;
use derhasi\boxfile\Exception\DirectoryNotFoundException;
use derhasi\boxfile\Exception\FileNotFoundException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Symlink extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
          ->setName('symlink')
          ->setDescription('Ensure symlinks')
          ->addArgument(
            'environment',
            InputArgument::REQUIRED,
            'Name of the environment to set the symlinks for.'
          )
          ->addOption(
            'boxfile',
            null,
            InputOption::VALUE_REQUIRED,
            'Location of the boxfile holding the configuration.',
            'Boxfile'
          )
          ->addOption(
            'docroot',
            null,
            InputOption::VALUE_REQUIRED,
            'Path to use as root for the specified configuration',
            'docroot'
          )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $environment = $input->getArgument('environment');
        $boxfile = $input->getOption('boxfile');
        $docroot = $input->getOption('docroot');

        $locator = new FileLocator(getcwd());
        $loader = new BoxfileLoader($locator);
        $conf = $loader->loadObject($boxfile);

        $file_mappings = $conf->getEnvironmentSpecificFiles($environment);

        if (!is_dir($docroot)) {
            throw new DirectoryNotFoundException('Could not set symlinks as "%s" is no valid directory.', $docroot);
        }

        // Change to docroot, so we can set symlinks relative.
        chdir($docroot);

        // Ensure symlink for each file mapping.
        foreach ($file_mappings as $target => $source) {

            // Check if the source exists.
            if (!file_exists($source)) {
                throw new FileNotFoundException('Could not create symlink as source "%s" does not exist.', $source);
            }

            // In the case the target does not exist, we simply can create the
            // symlink.
            if (!file_exists($target)) {
                if ($this->symlink($target, $source)) {
                    $output->writeln(sprintf('"%s" is now linked to "%s".', $target, $source));
                }
                else {
                    throw new \Exception(sprintf('Could not create symlink from "%s" is to "%s".', $target, $source));
                }
            }
            // If the target exists but is no link ...
            elseif (!is_link($target)) {
                // @todo solve with backup
                throw new \Exception(sprintf('Target "%s" is already set, but no symlink.', $target));
            }
            // If target is a symlink and points to source, we do not have to
            // do anything.
            elseif (readlink($target) == $source) {
                $output->writeln(sprintf('"%s" already linked to "%s".', $target, $source));
            }
            // If the target points to a different source ...
            else {
                // @todo backup
                throw new \Exception(sprintf('Target "%s" is already a symlink, but not linked to "%s".', $target, $source));
            }
        }
    }

    protected function symlink($target, $source)
    {
        // todo: target directory exists.
        return symlink($target, $source);
    }
}
