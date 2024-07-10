<?php

namespace Laravel\Octane\FrankenPhp\Concerns;

use Symfony\Component\Process\ExecutableFinder;

trait FindsFrankenPhpBinary
{
    /**
     * Find the FrankenPHP binary used by the application.
     */
    protected function findFrankenPhpBinary(): ?string
    {
        if (! is_null($frankenPhpBinary = config('octane.frankenphp.binary'))) {
            if (! file_exists($frankenPhpBinary)) {
                throw new \RuntimeException(
                    'FrankenPHP binary is not found at path: '.config('octane.frankenphp.binary')
                );
            }
            return $frankenPhpBinary;
        }

        return (new ExecutableFinder())->find('frankenphp', null, [base_path()]);
    }
}
