<?php

namespace Test0\Repository;

final class PostRepository extends Repository
{
    /**
     * @param array $params (optional)
     * @return array
     */
    public function getAll(array $params = null) : array
    {
        return [
            ['id' => 1, 'content' => 'Lorem ipsum', 'emotion' => 'happy'],
            ['id' => 2, 'content' => 'docet imsam', 'emotion' => 'sad'],
            ['id' => 3, 'content' => 'cotti nerto', 'emotion' => 'angry'],
        ];
    }

}