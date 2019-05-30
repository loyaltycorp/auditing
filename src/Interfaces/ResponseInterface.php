<?php
declare(strict_types=1);

namespace LoyaltyCorp\Auditing\Interfaces;

interface ResponseInterface
{
    /**
     * Get value for a given key from content.
     *
     * @param string $key Key to retrieve.
     *
     * @return mixed|null Value of the key or NULL if not found.
     */
    public function get(string $key);

    /**
     * Get reponse content.
     *
     * @return mixed[]
     */
    public function getContent(): array;

    /**
     * Check if the content contains a key
     *
     * @param string $key Name of the key to retrieve
     *
     * @return bool
     */
    public function hasKey(string $key): bool;
}
