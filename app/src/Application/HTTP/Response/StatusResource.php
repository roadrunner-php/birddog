<?php

declare(strict_types=1);

namespace App\Application\HTTP\Response;

final class StatusResource extends JsonResource
{
    public function __construct(private readonly bool $status = true)
    {
        parent::__construct([]);
    }

    protected function mapData(): array|\JsonSerializable
    {
        return [
            'status' => $this->status,
        ];
    }
}
