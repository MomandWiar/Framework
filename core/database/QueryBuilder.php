<?php

namespace Wiar\Core\Database;

use PDO;

class QueryBuilder
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
	protected $pdo;

    /**
     * The statement instance.
     *
     * @var statement
     */
	private $statement;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

    /**
     * Create a SQL query.
     *
     * @param  string $sql
     */
	public function createQuery($sql)
	{
		$this->statement = $this->pdo->prepare($sql);
	}

    /**
     * Select record(s) from a database table.
     *
     * @param  string $table
     * @return array
     */
	public function select($table, $parameters = [], $where = [])
	{
		$parameters = $this->checkParameters($parameters);

		$sql = "SELECT {$parameters} FROM {$table}";

		$sql .= $this->checkWhere($where);

		$this->statement = $this->pdo->prepare($sql);
	}

    /**
     * Insert a record(s) into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
	public function insert($table, $parameters = [])
	{
		$column = implode(', ', array_keys($parameters));
		$value = ':' . implode(', :', array_keys($parameters));

		$sql = sprintf(
			'INSERT INTO %s (%s) VALUES (%s)',
			$table, $column, $value
		);

		$this->execute($sql, $parameters);
	}

    /**
     * Update a record(s) of a table.
     *
     * @param  string $table
     * @param  array  $set
     * @param  array  $where
     */
	public function update($table, $set, $where = [])
	{
		$parameters = array_merge($set, $where);

		$set = $this->createUpdateClause(', ', $set);
		$where = $this->createUpdateClause(' AND ', $where);

        $sql = sprintf(
            "UPDATE %s SET %s",
            $table, $set
        );

        if (! empty($where)) {
        	$sql .= " WHERE {$where}";
        }

		$this->execute($sql, $parameters);
	}

    /**
     * Delete record(s) of a table.
     *
     * @param  string $table
     * @param  arrat  $set
     * @param  array  $where
     */
	public function delete($table, $where = [])
	{
		$where = $this->createWhereClaue($where);

		$sql = "DELETE FROM {$table}";

		if (! empty($where)) {
			$sql .= " WHERE {$where}";
		}

		$this->execute($sql);
	}

    /**
     * Fetch the next row from a result set.
     *
     * @return array
     */
	public function fetch()
	{
	    $this->statement->execute();

	    return $this->statement->fetch(PDO::FETCH_OBJ);
	}

    /**
     * Fetch an array containing all of the result set rows. 
     *
     * @return array
     */
	public function fetchAll()
	{
	    $this->statement->execute();

	    return $this->statement->fetchAll(PDO::FETCH_OBJ);
	}

    /**
     * Check parameters array.
     *
     * @param  array $parameter
     * @return mixed
     */
	private function checkParameters($parameters)
	{
		$parameters = implode(', ', $parameters);

		if (empty($parameters)) {
			$parameters = "*";
		}

		return $parameters;
	}

    /**
     * Check where array.
     *
     * @param  array $where
     * @return mixed
     */
	private function checkWhere($where)
	{
		if (! empty($where)) {
			$where = $this->createWhereClaue($where);

	    	return " WHERE {$where}";
		}
		return;
	}

    /**
     * Create where claus.
     *
     * @param  array $parameter
     * @return array
     */
	private function createWhereClaue($parameter)
	{
		return implode(' AND ', array_map(
                function($key, $value) {
                    return "{$key} = '{$value}'";
                },
                array_keys($parameter),
                array_values($parameter)
            )
		);
	}

	/**
     * Create update claus.
     *
     * @param  array $parameter
     * @return array
     */
	private function createUpdateClause($separator, $parameter)
	{
		return implode($separator, array_map(
                function($key, $value) {
                    return "{$key} = :{$value}";
                },
                array_keys($parameter),
                array_keys($parameter)
            )
        );
	}

	/**
     * Execute the statement.
     *
     * @param  string $sql
     * @param  array  $parameter
     */
	private function execute($sql, $parameters = [])
	{
        try {
            $statement = $this->pdo->prepare($sql);

            $statement->execute($parameters);
        } catch (Exception $e) {
            die('Whoops, something went wrong.');
        }
	}
}