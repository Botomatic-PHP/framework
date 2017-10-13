<?php namespace Botomatic\Engine\Core\Models;

/**
 * Class Base
 * @package Botomatic\Engine\Core\Models
 */
class Base
{
    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var bool
     */
    protected $has_created_at = true;

    /**
     * @var bool
     */
    protected $has_updated_at = true;

    /**
     * Very important: array of all fields of the table
     *
     * @var array
     */
    protected $fields = [];

    /**
     * @author Alexandru Muresan
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return app('db')->table($this->table);
    }

    /**
     * @return string
     */
    public function table($field = null) : string
    {
        if (is_null($field))
        {
            return $this->table;
        }
        return $this->table . '.' . $field;
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function insert($data) : int
    {
        // if Created at or Updated at
        if ($this->has_created_at == true)
        {
            $data['created_at'] = \Carbon\Carbon::now();

        }

        if ($this->has_updated_at == true)
        {
            $data['updated_at'] = \Carbon\Carbon::now();
        }

        return $this->query()->insertGetId($data);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function insertBulk($data)
    {
        return $this->query()->insert($data);
    }

    /**
     * @param string $field
     * @param string $value
     * @param array $data
     *
     * @return int
     */
    public function update($field, $value, $data) : int
    {
        if ($this->has_updated_at == true)
        {
            $data['updated_at'] = \Carbon\Carbon::now();
        }

        return $this->query()->where($field, $value)->update($data);
    }

    /**
     * Composer an array of all fields to be selected with alias
     *
     * @return array
     */
    public function composeSelect() : array
    {
        $result = [];

        foreach ($this->fields as $field)
        {
            $result[] = $this->table .'.'. $field . ' as ' . $this->table .'.'. $field;
        }

        return $result;
    }

    /**
     * @param string $field
     * @return string
     */
    public function field(string $field) : string
    {
        return $this->table . '.' . $field;
    }

    /**
     * Aliases used for each table
     *
     * @return array
     */
    public function getAliases() : array
    {
        $result = [];

        foreach ($this->fields as $field)
        {
            $result[$field] = $this->table .'.'. $field;
        }

        return $result;
    }
}