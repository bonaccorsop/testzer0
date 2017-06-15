<?php

namespace Test0\Repository;

use Illuminate\Database\Query\Builder;

interface RepositoryInterface
{
    public function getTable() : Builder;
}