<?php

declare(strict_types=1);

namespace App\Infrastructure\RPC\ValueObject;

use App\Infrastructure\RPC\SocketRelay;
use Nyholm\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use Spiral\Goridge\Exception\RelayFactoryException;
use Spiral\Goridge\RelayInterface;

final class Server implements \JsonSerializable, \Stringable
{
    private const CONNECTION_EXP = '/(?P<protocol>[^:\/]+):\/\/(?P<arg1>[^:]+)(:(?P<arg2>[^:]+))?/';

    private bool $hasError = false;
    private readonly UriInterface $address;

    public function __construct(
        private readonly string $name,
        string $address,
    ) {
        $this->address = new Uri($address);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): UriInterface
    {
        return $this->address;
    }

    public function hasError(): bool
    {
        return $this->hasError;
    }

    public function getRelay(): RelayInterface
    {
        if (!preg_match(self::CONNECTION_EXP, (string)$this->address, $match)) {
            throw new RelayFactoryException('unsupported connection format');
        }

        $protocol = strtolower($match['protocol']);
        $port = isset($match['arg2'])
            ? (int)$match['arg2']
            : null;

        $socketType = $protocol === 'tcp'
            ? SocketRelay::SOCK_TCP
            : SocketRelay::SOCK_UNIX;

        return new SocketRelay($match['arg1'], $port, $socketType);
    }

    public function notRespond(): self
    {
        $this->hasError = true;
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'address' => (string)$this->address,
            'has_error' => $this->hasError,
        ];
    }

    public static function fromArray(array $data): self
    {
        $self = new self(
            $data['name'],
            $data['address'],
        );

        $self->hasError = $data['has_error'] ?? false;

        return $self;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
