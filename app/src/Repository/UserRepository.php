<?php

namespace Test0\Repository;

use Illuminate\Database\Query\Builder;

class UserRepository extends Repository implements RepositoryInterface
{
    /**
     * @return Illuminate\Database\Query\Builder
     */
    public function getTable() : Builder
    {
        return $this->getMysqlClient()->table('users');
    }

    /**
     * @param string $email
     * @param string $password
     * @throws stdClass
     */
    public function findByCredentials(string $email, string $password)
    {
        return $this->getFirst(['email' => $email, 'password' => $password]);
    }

    /**
     * @param string $token
     * @throws stdClass
     */
    public function findByToken(string $token)
    {
        return $this->getFirst(['jwt_token' => $token]);
    }

    /**
     * @param int $id
     * @param string $token
     * @throws stdClass
     */
    public function storeToken(int $id, string $token = null)
    {
        return $this->update($id, ['jwt_token' => $token]);
    }

}