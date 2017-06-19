<?php

namespace Test0\Repository;

use stdClass;
use Illuminate\Database\Capsule\Manager as MysqlClient;
use Illuminate\Database\Query\Builder;
use Carbon\Carbon;

abstract class Repository
{
    private $mysqlClient = null;

    protected $idField = 'id';
    protected $softDeleteField = 'deleted_at';
    protected $createdAtField = 'created_at';
    protected $updatedAtField = 'updated_at';

    /**
     * @param MysqlClient $mysqlClient
     * @return Repository
     */
    public function __construct(MysqlClient $mysqlClient)
    {
        $this->setMysqlClient($mysqlClient);
    }

    /**
     * @param callable $filterCallback (optional)
     * @return stdClass
     */
    public function pick(int $id)
    {
        return $this->getFirst([$this->idField => $id]);
    }

    /**
     * @param array $filter
     * @return stdClass
     */
    public function getFirst(array $filter)
    {
        return $this->getFiltered(function(Builder $query) use ($filter) {
            return $query->where($filter);
        })->first();
    }

    /**
     * @param callable $filterCallback (optional)
     * @return int
     */
    public function getCount(callable $filterCallback = null) : int
    {
        return $this->getFiltered($filterCallback)->count();
    }

    /**
     * @param array $params (optional)
     * @return array
     */
    public function getAll(callable $filterCallback = null, int $page, int $pagelen) : array
    {
        return $this->paginate($this->getFiltered($filterCallback), $pagelen, $page)->get()->toArray();
    }

    /**
     * @param array $data
     * @return stdClass
     */
    public function create(array $data) : stdClass
    {
        if(! empty($this->createdAtField)) {
            $data = array_merge($data, [$this->createdAtField => $this->getCurrentDateTimeString()]);
        }

        return $this->pick($this->getTable()->insertGetId($data));
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data) : bool
    {
        if(! empty($this->updatedAtField)) {
            $data = array_merge($data, [$this->updatedAtField => $this->getCurrentDateTimeString()]);
        }

        return $this->getTable()->where([$this->idField => $id])->update($data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {
        if(! empty($this->softDeleteField)) {
            $this->update($id, [$this->softDeleteField => $this->getCurrentDateTimeString()]);
        } else {
            $this->getTable()->where([$this->idField => $id])->delete();
        }

        return true;
    }


    /**
     * @param MysqlClient $mysqlClient
     * @return Service
     */
    protected function setMysqlClient(MysqlClient $mysqlClient) : Repository
    {
        $this->mysqlClient = $mysqlClient;
        return $this;
    }

    /**
     * @return MysqlClient
     */
    protected function getMysqlClient() : MysqlClient
    {
        return $this->mysqlClient;
    }

    /**
     * @param int $pagelen
     * @param int $page
     * @return Builder
     */
    protected function paginate(Builder $query, int $pagelen, int $page) : Builder
    {
        return $query->forPage($page, $pagelen);
    }

    /**
     * @param callable $filterCallback
     * @return Builder
     */
    protected function getFiltered(callable $filterCallback = null) : Builder
    {
        $query = $this->getTable();

        if(! empty($this->softDeleteField)) {
            $query->where([$this->softDeleteField => null]);
        }

        return ! empty($filterCallback) ? $filterCallback($query) : $query;
    }


    /**
     * @return string
     */
    private function getCurrentDateTimeString() : string
    {
        return Carbon::now()->toDateTimeString();
    }

}