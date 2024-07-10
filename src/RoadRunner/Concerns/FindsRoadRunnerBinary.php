<?php

namespace Laravel\Octane\RoadRunner\Concerns;

use Illuminate\Support\Str;
use Symfony\Component\Process\ExecutableFinder;

trait FindsRoadRunnerBinary
{
    /**
     * Find the RoadRunner binary used by the application.
     */
    protected function findRoadRunnerBinary(): ?string
    {
        if (! is_null($roadRunnerBinary = config('octane.roadrunner.binary'))) {
            if (! file_exists($roadRunnerBinary)) {
                throw new \RuntimeException(
                    'RoadRunner binary is not found at path: '.config('octane.roadrunner.binary')
                );
            }
            return $roadRunnerBinary;
        }

        if (file_exists(base_path('rr'))) {
            return base_path('rr');
        }

        if (! is_null($roadRunnerBinary = (new ExecutableFinder)->find('rr', null, [base_path()]))) {
            if (! Str::contains($roadRunnerBinary, 'vendor/bin/rr')) {
                return $roadRunnerBinary;
            }
        }

        return null;
    }
}
