<?php namespace Laracasts\Commander;

use ReflectionClass;
use InvalidArgumentException;
use Input, App;

trait CommanderTrait {

    /**
     * Execute the command.
     *
     * @param  string $command
     * @param  array $input
     * @param  array $decorators
     * @return mixed
     */
    protected function execute($command, array $input = null, $decorators = [])
    {
        $input = $input ?: Input::all();
        $input = array_except($input, ['_token', 'q']);

        $command = $this->mapInputToCommand($command, $input);

        $bus = $this->getCommandBus();

        // If any decorators are passed, we'll filter through and register them
        // with the CommandBus, so that they are executed first.
        foreach ($decorators as $decorator)
        {
            $bus->decorate($decorator);
        }

        return $bus->execute($command);
    }

    /**
     * Fetch the command bus
     *
     * @return mixed
     */
    public function getCommandBus()
    {
        return App::make('Laracasts\Commander\CommandBus');
    }

    /**
     * Map an array of input to a command's properties.
     *
     * @param  string $command
     * @param  array $input
     * @throws InvalidArgumentException
     * @author Taylor Otwell
     *
     * @return mixed
     */
    protected function mapInputToCommand($command, array $input)
    {
        return new $command($input);
    }

}
