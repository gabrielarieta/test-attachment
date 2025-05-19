<?php

namespace App\Services;

use App\Repositories\TaskRepository;

trait UsesRepository
{

    /**
     * Metodo utilizado apenas para deixar a sintaxe mais legível
     *
     * @return $this
     */
    public function repository(): static
    {

        return $this;
    }

    public function task(): TaskRepository
    {
        return new TaskRepository();
    }
}
