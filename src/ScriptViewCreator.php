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

        $view
            ->with('enabled', $this->googleTagManager->isEnabled())
            ->with('id', $this->googleTagManager->id())
            ->with('dataLayer', $this->googleTagManager->getDataLayer());
    }
}
