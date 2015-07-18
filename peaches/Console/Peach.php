<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|    (c) Vince Kronlein <vince@dais.io>
|    
|    For the full copyright and license information, please view the LICENSE
|    file that was distributed with this source code.
|    
*/

/*
|--------------------------------------------------------------------------
|   Derived from Illuminate\Console\Application @ Lumen 5.1.2
|--------------------------------------------------------------------------   
*/

namespace Dais\Console;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Illuminate\Contracts\Console\Application as ApplicationContract;

class Peach extends SymfonyApplication implements ApplicationContract {
 
    protected $peach;

    protected $lastOutput;

    public function __construct(Container $peach, Dispatcher $events, $version) {
        
        parent::__construct('Dais Framework', $version);

        $this->peach = $peach;
        $this->setAutoExit(false);
        $this->setCatchExceptions(false);

        $events->fire('artisan.start', [$this]);
    }

    public function call($command, array $parameters = []) {

        $parameters['command'] = $command;

        $this->lastOutput = new BufferedOutput;

        return $this->find($command)->run(new ArrayInput($parameters), $this->lastOutput);
    }

    public function output() {

        return $this->lastOutput ? $this->lastOutput->fetch() : '';
    }

    public function add(SymfonyCommand $command) {

        if ($command instanceof Command):
            $command->setPeach($this->peach);
        endif;

        return $this->addToParent($command);
    }

    protected function addToParent(SymfonyCommand $command) {

        return parent::add($command);
    }

    public function resolve($command) {

        return $this->add($this->peach->make($command));
    }

    public function resolveCommands($commands) {

        $commands = is_array($commands) ? $commands : func_get_args();

        foreach ($commands as $command):
            $this->resolve($command);
        endforeach;

        return $this;
    }

    protected function getDefaultInputDefinition() {

        $definition = parent::getDefaultInputDefinition();

        $definition->addOption($this->getEnvironmentOption());

        return $definition;
    }

    protected function getEnvironmentOption() {

        $message = 'The environment the command should run under.';

        return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
    }

    public function getPeach() {

        return $this->peach;
    }
}
