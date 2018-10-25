<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\Traits\Macroable;
use Spatie\GoogleTagManager\Exceptions\EnvironmentParametersNotSetException;

class GoogleTagManager
{
    use Macroable;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool
     */
    protected $enabled;

    /**
     * @var bool true if the environments are used in Google Tag Manager
     */
    protected $environmentsEnabled;

    /**
     * @var string the value to use as gtm_auth parameter (for environments in Google Tag Manager)
     */
    protected $gtmAuth;

    /**
     * @var string the value to use as gtm_preview parameter (for environments in Google Tag Manager)
     */
    protected $gtmPreview;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $dataLayer;

    /**
     * @var \Spatie\GoogleTagManager\DataLayer
     */
    protected $flashDataLayer;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $pushDataLayer;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
        $this->dataLayer = new DataLayer();
        $this->flashDataLayer = new DataLayer();
        $this->pushDataLayer = new \Illuminate\Support\Collection();

        $this->enabled = true;
        $this->environmentsEnabled = false;
    }

    /**
     * Enable the use of environments for Google Tag Manager.
     * @param string $gtmAuth the value to use as gtm_auth
     * @param string $gtmPreview the value to use as gtm_preview
     */
    public function enableEnvironmentWithParameters($gtmAuth, $gtmPreview)
    {
        $this->enableEnvironments();
        $this->gtmAuth = $gtmAuth;
        $this->gtmPreview = $gtmPreview;
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
     * Check whether environments are enabled.
     *
     * @return bool
     */
    public function isEnvironmentsEnabled()
    {
        return $this->environmentsEnabled;
    }

    /**
     * @return string the environments parameters to use or an empty string if environments are not enabled.
     *
     * @throws EnvironmentParametersNotSetException if the gtmAuth and gtmPreview are not set and environments are used.
     */
    public function getEnvironmentParameters()
    {
        $environmentParameters = '';
        // Verify GTM is enabled as well, to prevent generating exception while disabled completely.
        if ($this->isEnabled() && $this->isEnvironmentsEnabled()) {
            $gtmAuth = $this->getGtmAuth();
            $gtmPreview = $this->getGtmPreview();
            if (empty($gtmAuth) || empty($gtmPreview)) {
                throw new EnvironmentParametersNotSetException(
                    'Both parameters (gtmAuth and gtmPreview) are required.'
                );
            }
            $environmentParameters = '&gtm_auth=' . $gtmAuth . '&gtm_preview=' . $gtmPreview;
        }
        return $environmentParameters;
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
     * Enable Google Tag Manager environments parameters rendering.
     */
    public function enableEnvironments()
    {
        $this->environmentsEnabled = true;
    }

    /**
     * Disable Google Tag Manager environments parameters rendering.
     */
    public function disableEnvironments()
    {
        $this->environmentsEnabled = false;
    }

    /**
     * Return the value to use for the gtm_auth parameter.
     *
     * @return string
     */
    public function getGtmAuth()
    {
        return $this->gtmAuth;
    }

    /**
     * Return the value to use for the gtm_preview parameter.
     *
     * @return string
     */
    public function getGtmPreview()
    {
        return $this->gtmPreview;
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
