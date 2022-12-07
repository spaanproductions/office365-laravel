<?php

namespace SpaanProductions\Office365;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use League\OAuth2\Client\Provider\GenericProvider;

class Office365
{
	private GenericProvider $client;
	private Graph $graph;

	public function __construct(array $config)
	{
		$this->graph = new Graph();

		$this->client = new GenericProvider([
			'clientId' => $config['client-id'],
			'clientSecret' => $config['secret'],
			'redirectUri' => $config['redirect-url'],
			'urlAuthorize' => $config['authority-base-uri'] . $config['authorize-endpoint'],
			'urlAccessToken' => $config['authority-base-uri'] . $config['token-endpoint'],
			'urlResourceOwnerDetails' => '',
			'scopes' => $config['scopes'],
		]);
	}

	public function login(): string
	{
		return $this->client->getAuthorizationUrl();
	}

	public function getState(): string
	{
		return $this->client->getState();
	}

	public function getAccessToken($code): array
	{
		$accessToken = $this->client->getAccessToken('authorization_code', [
			'code' => $code,
		]);

		return [
			'token' => $accessToken->getToken(),
			'RefreshToken' => $accessToken->getRefreshToken(),
			'expires' => $accessToken->getExpires(),
		];
	}

	public function refreshToken($refreshToken): array
	{
		$token = $this->client->getAccessToken('refresh_token', [
			'refresh_token' => $refreshToken,
		]);

		return [
			'token' => $token->getToken(),
			'RefreshToken' => $token->getRefreshToken(),
			'expires' => $token->getExpires(),
		];
	}

	public function getUser($user_access_token)
	{
		$this->graph->setAccessToken($user_access_token);

		return $this->graph
			->createRequest('GET', '/me')
			->setReturnType(Model\User::class)
			->execute();
	}

	public function getMailboxes($user_access_token): array
	{
		$this->graph->setAccessToken($user_access_token);

		return $this->graph
			->createRequest('GET', '/users?')
			->setReturnType(Model\User::class)
			->execute();
	}

	public function getMailboxMessages($user_access_token, $mailboxId): array
	{
		$this->graph->setAccessToken($user_access_token);

		return $this->graph
			->createRequest('GET', "/users/{$mailboxId}/mailfolders/inbox/messages?\$expand=attachments")
			->addHeaders(['Prefer' => 'outlook.body-content-type=text'])
			->setReturnType(Model\Message::class)
			->execute();
	}

	public function deleteMailboxMessage($user_access_token, $mailboxId, $messageId)
	{
		$this->graph->setAccessToken($user_access_token);

		return $this->graph
			->createRequest('DELETE', "/users/{$mailboxId}/messages/{$messageId}")
			->execute()
			->getBody();
	}

	public function getEmails($user_access_token, $limit = 10): array
	{
		$this->graph->setAccessToken($user_access_token);

		$messageQueryParams = [
			"\$orderby" => "receivedDateTime DESC",
			"\$top" => $limit,
		];

		return $this->graph
			->createRequest('GET', '/me/mailfolders/inbox/messages?' . http_build_query($messageQueryParams))
			->setReturnType(Model\Message::class)
			->execute();
	}
}
