<?php

namespace Ozdemir\Datatables\DB;

use DB;
use Ozdemir\Datatables\Query;


/**
 * Class LaravelAdapter
 * @package Ozdemir\Datatables\DB
 */
class LaravelAdapter implements DatabaseInterface
{
    /**
     * LaravelAdapter constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
    }

    /**
     * @return $this
     */
    public function connect()
    {
        return $this;
    }

    /**
     * @param Query $query
     * @return array
     */
    public function query(Query $query)
    {
        $data = DB::select($query, $query->escape);
        $row = [];

        foreach ($data as $item) {
            $row[] = (array)$item;
        }

        return $row;
    }

    /**
     * @param Query $query
     * @return mixed
     */
    public function count(Query $query)
    {
        $query = 'Select count(*) as rowcount,'.substr($query, 6);

        $data = DB::select($query, $query->escape);

        return $data[0]->rowcount;
    }

    /**
     * @param $string
     * @param Query $query
     * @return string
     */
    public function escape($string, Query $query)
    {
        $this->escape[':binding_'.(count($query->escape) + 1)] = '%'.$string.'%';

        return ':binding_'.count($query->escape);
    }
}

