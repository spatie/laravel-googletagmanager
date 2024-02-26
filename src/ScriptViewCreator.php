<?php

namespace Spatie\GoogleTagManager;

use Illuminate\View\View;
use Spatie\GoogleTagManager\Exceptions\ApiKeyNotSetException;

class ScriptViewCreator
{
    /** @var \Spatie\GoogleTagManager\GoogleTagManager */
    protected $googleTagManager;

    public function __construct(GoogleTagManager $googleTagManager)
    {
        $this->googleTagManager = $googleTagManager;
    }

    public function create(View $view)
    {
        if ($this->googleTagManager->isEnabled() && empty($this->googleTagManager->id())) {
            throw new ApiKeyNotSetException();
        }

        $view
            ->with('enabled', $this->googleTagManager->isEnabled())
            ->with('id', $this->googleTagManager->id())
            ->with('dataLayer', $this->googleTagManager->getDataLayer())
            ->with('pushData', $this->googleTagManager->getPushData());
    }
}
