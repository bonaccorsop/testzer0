<?php

namespace Test0\Cli\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorldCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:hello')
            ->setDescription('Let\'s greet!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello developer!');
        $output->writeln('Welcome to the Jungle baby...');
    }
}