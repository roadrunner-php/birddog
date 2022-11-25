<?php

declare(strict_types=1);

use App\Centrifuge\Interceptor;
use App\Interfaces\Centrifuge\ConnectService;
use App\Interfaces\Centrifuge\RPCService;
use App\Interfaces\Centrifuge\SubscribeService;
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
