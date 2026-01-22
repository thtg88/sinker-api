<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as GuardContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class Guard implements GuardContract
{
    use GuardHelpers;

    public function __construct(
        UserProvider $provider,
        protected Request $request,
        protected string $input_key,
        protected string $input_user_id,
        protected string $storage_key = 'api_key',
        protected string $storage_user_id = 'uuid',
        protected bool $hash = false,
    ) {
        $this->provider = $provider;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    #[\Override]
    public function user(): ?Authenticatable
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $api_key = $this->getKeyForRequest();
        $user_id = $this->getUserIdForRequest();
        if (empty($api_key) || empty($user_id)) {
            return $this->user = $user;
        }
        if (!Uuid::isValid($user_id)) {
            return $this->user = $user;
        }

        $user = $this->provider->retrieveByCredentials([
            $this->storage_key => $this->hash ? hash('sha256', $api_key) : $api_key,
            $this->storage_user_id => $this->hash ? hash('sha256', $user_id) : $user_id,
        ]);

        return $this->user = $user;
    }

    public function getKeyForRequest(): string|array|null
    {
        return $this->request->header($this->input_key);
    }

    public function getUserIdForRequest(): string|array|null
    {
        return $this->request->header($this->input_user_id);
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     * @return bool
     */
    #[\Override]
    public function validate(array $credentials = []): bool
    {
        if (
            empty($credentials[$this->input_key]) ||
            empty($credentials[$this->input_user_id])
        ) {
            return false;
        }
        if (!Uuid::isValid($credentials[$this->input_user_id])) {
            return false;
        }

        $user = $this->provider->retrieveByCredentials([
            $this->storage_key => $credentials[$this->input_key],
            $this->storage_user_id => $credentials[$this->input_user_id],
        ]);
        if ($user) {
            return true;
        }

        return false;
    }

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}
