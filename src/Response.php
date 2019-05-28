<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing;

use LoyaltyCorp\Auditing\Interfaces\ResponseInterface;

final class Response implements ResponseInterface
{
    /**
     * Response.
     *
     * @var mixed[]
     */
    private $content;

    /**
     * Response constructor.
     *
     * @param mixed[]|null $content
     */
    public function __construct(?array $content = null)
    {
        $this->content = $content ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * {@inheritdoc}
     */
    public function hasKey(string $key): bool
    {
        return isset($this->content[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key)
    {
        return $this->hasKey($key) === true ?  $this->content[$key] : null;
    }
}
