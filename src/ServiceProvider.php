<?php

namespace Sydante\LaravelEloquentWithNotOverwritten;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    public function boot(): void
    {
        Builder::macro(
            'withNotOverwritten',
            function ($relations, $callback = null) {
                /** @var Builder $this */

                if ($callback instanceof Closure) {
                    $prepareEagerLoads = $this->parseWithRelations(
                        [$relations => $callback]
                    );
                } else {
                    $prepareEagerLoads = $this->parseWithRelations(
                        is_string($relations) ? func_get_args() : $relations
                    );
                }

                $eagerLoads = $this->getEagerLoads();

                // Not Overwritten eagerLoad
                foreach ($prepareEagerLoads as $name => $constraints) {
                    // Already exists relationships?
                    if (isset($eagerLoads[$name])) {
                        // Ignore
                        unset($prepareEagerLoads[$name]);
                    }
                }

                return $this->setEagerLoads(array_merge($eagerLoads, $prepareEagerLoads));
            }
        );
    }

}
