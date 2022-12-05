<?php

return [
	'client-id' => env('OFFICE365_CLIENT_ID'),
	'object-id' => env('OFFICE365_OBJECT_ID'),
	'tenant-id' => env('OFFICE365_TENANT_ID'),
	'secret' => env('OFFICE365_CLIENT_SECRET'),
	'redirect-url' => env('OFFICE365_REDIRECT_URI'),
	'scopes' => env('OFFICE365_SCOPES', 'openid profile offline_access User.Read Mail.Read Mail.ReadWrite Directory.Read.All Directory.ReadWrite.All Mail.Read.Shared Mail.ReadWrite.Shared'),
	'authority-base-uri' => env('OFFICE365_AUTHORITY_BASE_URI', sprintf('https://login.microsoftonline.com/%s', env('OFFICE365_TENANT_ID'))),
	'authorize-endpoint' => env('OFFICE365_AUTHORIZE_ENDPOINT', '/oauth2/v2.0/authorize'),
	'token-endpoint' => '/oauth2/v2.0/token',
];

