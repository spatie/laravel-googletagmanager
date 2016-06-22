<?php

namespace Spatie\GoogleTagManager;

class DataLayer
{
    /**
     * @var array
     */
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Add data to the data layer. Supports dot notation.
     * Inspired by laravel's config repository class.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $innerKey => $innerValue) {
                array_set($this->data, $innerKey, $innerValue);
            }

            return;
        }

        array_set($this->data, $key, $value);
    }

    /**
     * Empty the data layer.
     */
    public function clear()
    {
        $this->data = [];
    }

    /**
     * Return an array representation of the data layer.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Return a json representation of the data layer.
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->data);
    }
}
