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
|   Derived from Lumen\Console\Kernel @ Lumen 5.1.2
|--------------------------------------------------------------------------   
*/

namespace Dais\Console;

use Exception;
use RuntimeException;
use Dais\Console\Peach;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Console\Kernel as KernelContract;

class Console implements KernelContract {

    protected $app;

    protected $peach;

    protected $includeDefaultCommands = true;

    public function __construct(Application $app) {
        $this->app = $app;

        if ($this->includeDefaultCommands):
            $this->app->prepareForConsoleCommand();
        endif;

        $this->defineConsoleSchedule();
    }

    protected function defineConsoleSchedule() {
        $this->app->instance(
            'Illuminate\Console\Scheduling\Schedule', $schedule = new Schedule
        );

        $this->schedule($schedule);
    }

    public function handle($input, $output = null) {
        try {
            return $this->getPeach()->run($input, $output);
        } catch (Exception $e) {
            $this->reportException($e);
            $this->renderException($output, $e);

            return 1;
        }
    }

    protected function schedule(Schedule $schedule) {
        //
    }

    public function call($command, array $parameters = []) {
        return $this->getPeach()->call($command, $parameters);
    }

    public function queue($command, array $parameters = []) {
        throw new RuntimeException("Queueing Peach commands is not supported by Dais.");
    }

    public function all() {
        return $this->getPeach()->all();
    }

    public function output() {
        return $this->getPeach()->output();
    }

    protected function getPeach() {
        if (is_null($this->peach)):
            return $this->peach = (new Peach($this->app, $this->app->make('events'), $this->app->version()))
                                ->resolveCommands($this->getCommands());
        endif;

        return $this->peach;
    }

    protected function getCommands() {
        if ($this->includeDefaultCommands):
            return array_merge($this->commands, [
                'Illuminate\Console\Scheduling\ScheduleRunCommand',
                'Laravel\Lumen\Console\Commands\ServeCommand',
            ]);
        else:
            return $this->commands;
        endif;
    }

    protected function reportException(Exception $e) {
        $this->app['Illuminate\Contracts\Debug\ExceptionHandler']->report($e);
    }

    protected function renderException($output, Exception $e) {
        $this->app['Illuminate\Contracts\Debug\ExceptionHandler']->renderForConsole($output, $e);
    }
}
