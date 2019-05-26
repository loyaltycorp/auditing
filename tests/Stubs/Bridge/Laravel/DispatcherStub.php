<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Bridge\Laravel;

use Illuminate\Contracts\Bus\Dispatcher;

/**
 * @coversNothing
 */
class DispatcherStub implements Dispatcher
{
    /**
     * {@inheritdoc}
     */
    public function dispatch($command)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchNow($command, $handler = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandHandler($command)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function hasCommandHandler($command)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function map(array $map)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function pipeThrough(array $pipes)
    {
    }
}
