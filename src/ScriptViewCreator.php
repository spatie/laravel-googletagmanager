<?php

namespace Spatie\GoogleTagManager;

use Illuminate\View\View;
use Spatie\GoogleTagManager\Exceptions\ApiKeyNotSetException;

class ScriptViewCreator
{
    /**
     * @var \Spatie\GoogleTagManager\GoogleTagManager
     */
    protected $googleTagManager;

    /**
     * @param  \Spatie\GoogleTagManager\GoogleTagManager
     */
    public function __construct(GoogleTagManager $googleTagManager)
    {
        $this->googleTagManager = $googleTagManager;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     */
    public function create(View $view)
    {
        if (empty($this->googleTagManager->id())) {
            throw new ApiKeyNotSetException();
        }

        $data = $view->getData();

        $dataLayer = isset($data['dataLayer']) ? $data['dataLayer'] : $this->googleTagManager->getDataLayer();

        if (is_array($dataLayer)) {
            $dataLayer = new DataLayer($dataLayer);
        }

        $view
            ->with('dataLayer', $dataLayer)
            ->with('enabled', $this->googleTagManager->isEnabled());
    }
}
