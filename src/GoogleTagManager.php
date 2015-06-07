<?php

namespace Spatie\GoogleTagManager;

class GoogleTagManager
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $dataLayer;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->dataLayer = new DataLayer();

        $this->enabled = true;
    }

    /**
     * Return the Google Tag Manager id.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Check whether script rendering is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Enable Google Tag Manager scripts rendering.
     */
    public function enable()
    {
        $this->enabled = true;
    }

    /**
     * Enable Google Tag Manager scripts rendering.
     */
    public function disable()
    {
        $this->enabled = false;
    }

    /**
     * Add data to the data layer.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function set($key, $value = null)
    {
        $this->dataLayer->set($key, $value);
    }

    /**
     * Clear the data layer.
     */
    public function clear()
    {
        $this->dataLayer->clear();
    }

    /**
     * Return the data layer's contents as a string.
     *
     * @return string
     */
    public function dump()
    {
        return $this->dataLayer->toJson();
    }
}
