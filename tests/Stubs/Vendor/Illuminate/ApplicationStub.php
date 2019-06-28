<?php
declare(strict_types=1);

namespace Tests\LoyaltyCorp\Auditing\Stubs\Vendor\Illuminate;

use Laravel\Lumen\Application as ApplicationBase;

class ApplicationStub extends ApplicationBase
{
    /**
     * Get globally applied middleware
     *
     * @return string[]
     */
    public function getMiddlewares(): array
    {
        return $this->middleware;
    }
}
