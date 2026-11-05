<?php

namespace Spatie\GoogleTagManager;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;

class GoogleTagManager
{
    use Macroable;

    protected bool $enabled = true;

    protected DataLayer $dataLayer;

    protected DataLayer $flashDataLayer;

    /** @var Collection<int, DataLayer> */
    protected Collection $pushDataLayer;

    /** @var Collection<int, DataLayer> */
    protected Collection $flashPushDataLayer;

    public function __construct(
        protected string $id,
        protected string $gtmScriptDomain,
        protected bool $nonceEnabled = false,
    ) {
        $this->dataLayer = new DataLayer;
        $this->flashDataLayer = new DataLayer;
        $this->pushDataLayer = new Collection;
        $this->flashPushDataLayer = new Collection;
    }

    /**
     * Return the Google Tag Manager id.
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Return the Google Tag Manager script domain.
     */
    public function gtmScriptDomain(): string
    {
        return $this->gtmScriptDomain;
    }

    /**
     * Check whether CSP nonce is enabled.
     */
    public function isNonceEnabled(): bool
    {
        return $this->nonceEnabled;
    }

    /**
     * Check whether script rendering is enabled.
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Enable Google Tag Manager scripts rendering.
     */
    public function enable(): void
    {
        $this->enabled = true;
    }

    /**
     * Disable Google Tag Manager scripts rendering.
     */
    public function disable(): void
    {
        $this->enabled = false;
    }

    /**
     * Add data to the data layer.
     *
     * @param  array<string, mixed>|string  $key
     */
    public function set(array|string $key, mixed $value = null): void
    {
        $this->dataLayer->set($key, $value);
    }

    /**
     * Retrieve the data layer.
     */
    public function getDataLayer(): DataLayer
    {
        return $this->dataLayer;
    }

    /**
     * Add data to the data layer for the next request.
     *
     * @param  array<string, mixed>|string  $key
     */
    public function flash(array|string $key, mixed $value = null): void
    {
        $this->flashDataLayer->set($key, $value);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return array<string, mixed>
     */
    public function getFlashData(): array
    {
        return $this->flashDataLayer->toArray();
    }

    /**
     * Add data to be pushed to the data layer.
     *
     * @param  array<string, mixed>|string  $key
     */
    public function push(array|string $key, mixed $value = null): void
    {
        $pushItem = new DataLayer;
        $pushItem->set($key, $value);
        $this->pushDataLayer->push($pushItem);
    }

    /**
     * Retrieve the data layer's data for the next request.
     *
     * @return Collection<int, DataLayer>
     */
    public function getPushData(): Collection
    {
        return $this->pushDataLayer;
    }

    /**
     * Add data to be pushed to the data layer for the next request.
     *
     * @param  array<string, mixed>|string  $key
     */
    public function flashPush(array|string $key, mixed $value = null): void
    {
        $pushItem = new DataLayer;
        $pushItem->set($key, $value);
        $this->flashPushDataLayer->push($pushItem);
    }

    /**
     * Retrieve the push data for the next request.
     *
     * @return Collection<int, DataLayer>
     */
    public function getFlashPushData(): Collection
    {
        return $this->flashPushDataLayer;
    }

    /**
     * Clear the data layer.
     */
    public function clear(): void
    {
        $this->dataLayer = new DataLayer;
        $this->pushDataLayer = new Collection;
        $this->flashDataLayer = new DataLayer;
        $this->flashPushDataLayer = new Collection;
    }

    /**
     * Utility function to dump an array as json.
     *
     * @param  array<string, mixed>  $data
     */
    public function dump(array $data): string
    {
        return (new DataLayer($data))->toJson();
    }
}
