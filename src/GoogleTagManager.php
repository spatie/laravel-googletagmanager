<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\Traits\Macroable;

class GoogleTagManager
{
    use Macroable;

    /**
     * @var string[]
     */
    protected $id;

    /**
     * @var string
     */
    protected $layer;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $dataLayer;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $flashDataLayer;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $noJSDataLayer;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $pushDataLayer;

    /**
     * @param string[] $id
     * @param string $layer
     */
    public function __construct($id, $layer)
    {
        $this->id = $id;
        $this->layer = $layer;
        $this->dataLayer = new DataLayer();
        $this->flashDataLayer = new DataLayer();
        $this->noJSDataLayer = new DataLayer();
        $this->pushDataLayer = new \Illuminate\Support\Collection();

        $this->enabled = true;
    }

    /**
     * Return the Google Tag Manager id.
     *
     * @return string[]
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Return the Google Tag Manager id.
     *
     * @return string
     */
    public function getLayer()
    {
        return $this->layer;
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
     * Disable Google Tag Manager scripts rendering.
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
     * Retrieve the data layer.
     *
     * @return \Spatie\GoogleTagManager\DataLayer
     */
    public function getDataLayer()
    {
        return $this->dataLayer;
    }

    /**
     * Add data to the data layer for the next request.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function flash($key, $value = null)
    {
        $this->flashDataLayer->set($key, $value);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return array
     */
    public function getFlashData()
    {
        return $this->flashDataLayer->toArray();
    }

    /**
     * Add data to the data layer for the next request.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function noScript($key, $value = null)
    {
        $this->noJSDataLayer->set($key, $value);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return array
     */
    public function getNoScriptData()
    {
        return $this->noJSDataLayer->toArray();
    }

    /**
     * Add data to be pushed to the data layer.
     *
     * @param array|string $key
     * @param mixed        $value
     */
    public function push($key, $value = null)
    {
        $pushItem = new DataLayer();
        $pushItem->set($key, $value);
        $this->pushDataLayer->push($pushItem);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPushData()
    {
        return $this->pushDataLayer;
    }

    /**
     * Clear the data layer.
     */
    public function clear()
    {
        $this->dataLayer = new DataLayer();
        $this->pushDataLayer = new \Illuminate\Support\Collection();
    }

    /**
     * Utility function to dump an array as json.
     *
     * @param  array $data
     * @return string
     */
    public function dump($data)
    {
        return (new DataLayer($data))->toJson();
    }
}
