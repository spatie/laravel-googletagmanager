<?php

namespace Spatie\GoogleTagManager;

use Closure;
use Illuminate\Config\Repository as Config;
use Illuminate\Session\Store as Session;
use Spatie\GoogleTagManager\GoogleTagManager;

class GoogleTagManagerMiddleware
{
    /**
     * @var \Spatie\GoogleTagManager\GoogleTagManager
     */
    protected $googleTagManager;

    /**
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * @var string
     */
    protected $sessionKey;

    /**
     * @param \Spatie\GoogleTagManager\GoogleTagManager $googleTagManager
     * @param \Illuminate\Session\Store $session
     */
    public function __construct(GoogleTagManager $googleTagManager, Session $session, Config $config)
    {
        $this->googleTagManager = $googleTagManager;
        $this->session = $session;

        $this->sessionKey = $config->get('googletagmanager.sessionKey');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $flashPushKey = $this->sessionKey.':push';

        if ($this->session->has($this->sessionKey)) {
            $this->googleTagManager->set($this->session->get($this->sessionKey));
        }
        if ($this->session->has($flashPushKey)) {
            foreach ($this->session->get($flashPushKey) as $pushData) {
                $this->googleTagManager->push($pushData);
            }
        }

        $response = $next($request);

        $this->session->flash($this->sessionKey, $this->googleTagManager->getFlashData());
        $this->session->flash($flashPushKey, $this->googleTagManager->getFlashPushData()->map(function ($dataLayer) {
            return $dataLayer->toArray();
        })->toArray());

        return $response;
    }
}
