<?php

namespace Lithe\Support\Security;

class Hash
{
    /**
     * Cria um hash a partir de uma string.
     *
     * @param string $value
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function make(string $value, array $options = []): string
    {
        $cost = $options['cost'] ?? 10;

        if ($cost < 4 || $cost > 31) {
            throw new \InvalidArgumentException('The cost must be between 4 and 31.');
        }

        return password_hash($value, PASSWORD_BCRYPT, ['cost' => $cost]);
    }

    /**
     * Verifica se a string corresponde ao hash.
     *
     * @param string $value
     * @param string $hash
     * @return bool
     */
    public static function check(string $value, string $hash): bool
    {
        return password_verify($value, $hash);
    }

    /**
     * Rehashes o valor fornecido se necessário.
     *
     * @param string $hash
     * @param array $options
     * @return bool
     */
    public static function needsRehash(string $hash, array $options = []): bool
    {
        $cost = $options['cost'] ?? 10;
        return password_needs_rehash($hash, PASSWORD_BCRYPT, ['cost' => $cost]);
    }
}
