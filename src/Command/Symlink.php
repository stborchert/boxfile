<?php

namespace derhasi\boxfile\Command;

use derhasi\boxfile\Config\BoxfileConfiguration;
use derhasi\boxfile\Config\Loader\BoxfileLoader;
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

        $output->writeln(sprintf('Env: %s, Boxfile: %s, Docroot: %s', $environment, $boxfile, $docroot));
    }
}
