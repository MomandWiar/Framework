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
	public function select($table, $select = [], $where = [])
	{
		$parameters = $this->formatSelect($select);

        $sql = sprintf(
            'SELECT %s FROM %s',
            $parameters, $table
        );

		$sql .= $this->checkWhere($where);

		$this->statement = $this->pdo->prepare($sql);
	}

    /**
     * Insert a record(s) into a table.
     *
     * @param  string $table
     * @param  array  $parameters
     */
	public function insert($table, $parameters)
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

        $set = $this->formatParameters(', ', $where);

        $sql = sprintf(
            "UPDATE %s SET %s",
            $table, $set
        );

        $sql .= $this->checkWhere($where);

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
	   $sql = "DELETE FROM {$table}";

	   $sql .= $this->checkWhere($where);

	   $this->execute($sql, $where);
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
     * Check where array.
     *
     * @param  array $where
     * @return mixed
     */
    private function checkWhere($where)
    {
        if (! empty($where)) {
            $where = $this->formatParameters(' AND ', $where);

            return " WHERE {$where}";
        }
        return null;
    }

    /**
     * Format select.
     *
     * @param  array $parameter
     * @return mixed
     */
	private function formatSelect($parameters)
	{
		$parameters = implode(', ', $parameters);

		if (empty($parameters)) {
			$parameters = "*";
		}

		return $parameters;
	}

    /**
     * Format parameters.
     *
     * @param  array $parameter
     * @return array
     */
	private function formatParameters($separator, $parameter)
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