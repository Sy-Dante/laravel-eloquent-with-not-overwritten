<?php

/** @noinspection AutoloadingIssuesInspection */

namespace Illuminate\Database\Eloquent {

    class Builder
    {

        /**
         * @param      $relations
         * @param null $callback
         *
         * @return $this
         * @see \Sydante\LaravelEloquentWithNotOverwritten\ServiceProvider::boot()
         */
        public function withNotOverwritten($relations, $callback = null): self
        {
            return $this;
        }

    }
}
