<?php

namespace EmilMoe\Guardian\Http;

class PermissionParameter
{
    /**
     * Name of ID column, will default to 'id'.
     *
     * @var string
     */
    private $column;

    /**
     * Name of the permission.
     *
     * @var string
     */
    private $name;

    /**
     * Create a new PermissionParameter instance.
     *
     * PermissionParameter constructor.
     * @param $input
     */
    public function __construct($input)
    {
        strpos($input, '.') === false
            ? $this->withDefaultID($input)
            : $this->withCustomID(explode('.', $input));
    }

    /**
     * Get the permission name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the column name.
     *
     * @return string
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Instantiate the instance with a column name 'id'.
     *
     * @param $permission
     */
    private function withDefaultID($permission)
    {
        $this->column = 'id';
        $this->name   = $permission;
    }

    /**
     * Instantiate the instance with a custom column name.
     *
     * @param array $args
     */
    private function withCustomID(array $args)
    {
        $this->name   = $args[0];
        $this->column = $args[1];
    }
}