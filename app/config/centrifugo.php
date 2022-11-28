<?php

declare(strict_types=1);

use App\Centrifuge\ConnectService;
use App\Centrifuge\RPCService;
use App\Centrifuge\SubscribeService;
use RoadRunner\Centrifugo\Request\RequestType;

$interceptors = [
    // Interceptor\LoggingInterceptor::class,
];

return [
    'services' => [
        RequestType::Connect->value => ConnectService::class,
        RequestType::Subscribe->value => SubscribeService::class,
        RequestType::RPC->value => RPCService::class,
    ],
    'interceptors' => [
        RequestType::Connect->value => $interceptors,
        RequestType::Subscribe->value => $interceptors,
        RequestType::RPC->value => $interceptors,
    ],
];
