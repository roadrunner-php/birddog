<?php

declare(strict_types=1);

namespace App\Application\HTTP\Response;

use Psr\Http\Message\ResponseInterface;

interface ResourceInterface extends \JsonSerializable, \Stringable
{
    public function toResponse(ResponseInterface $response): ResponseInterface;
}
