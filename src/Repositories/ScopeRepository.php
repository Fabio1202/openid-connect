<?php

declare(strict_types=1);

namespace OpenIDConnect\Repositories;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use OpenIDConnect\Entities\ScopeEntity;

class ScopeRepository implements ScopeRepositoryInterface
{
    public function finalizeScopes(
        array $scopes, $grantType, ClientEntityInterface $clientEntity, $userIdentifier = null, ?string $authCodeId = null): array
    {
        return array_filter($scopes, function (ScopeEntityInterface $scope) {
            return $this->getScopeEntityByIdentifier($scope->getIdentifier());
        });
    }

    public function getScopeEntityByIdentifier($identifier): ?ScopeEntityInterface
    {
        $scopes = [
            'openid' => ['description' => 'Enable OpenID Connect'],
            'profile' => ['description' => 'Information about your profile'],
            'email' => ['description' => 'Information about your email address'],
            'phone' => ['description' => 'Information about your phone numbers'],
            'address' => ['description' => 'Information about your address'],
        ];

        if (array_key_exists($identifier, $scopes) === false) {
            return null;
        }

        $scope = new ScopeEntity();
        $scope->setIdentifier($identifier);
        return $scope;
    }
}
