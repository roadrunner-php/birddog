<?php

declare(strict_types=1);

namespace App\Infrastructure\RoadRunner\RPC\ValueObject;

use App\Domain\Server\Service\ServersRegistryInterface;
use App\Infrastructure\RoadRunner\RPC\SocketRelay;
use Nyholm\Psr7\Uri;
use Psr\Http\Message\UriInterface;
use Spiral\Goridge\Exception\RelayFactoryException;
use Spiral\Goridge\RelayInterface;
use Spiral\Goridge\SocketType;

/**
 * @psalm-import-type TName from ServersRegistryInterface
 * @psalm-import-type THost from ServersRegistryInterface
 * @psalm-type TServerArray = array{name: TName, address: THost, has_error: bool}
 */
final class Server implements \JsonSerializable, \Stringable
{
    private const CONNECTION_EXP = '/(?P<protocol>[^:\/]+):\/\/(?P<arg1>[^:]+)(:(?P<arg2>[^:]+))?/';

    private bool $hasError = false;
    public readonly UriInterface $address;

    /**
     * @param TName $name
     * @param THost $address
     */
    public function __construct(
        public readonly string $name,
        string $address,
    ) {
        $this->address = new Uri($address);
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
            ? SocketType::TCP
            : SocketType::UNIX;

        return new SocketRelay($match['arg1'], $port, $socketType);
    }

    public function notRespond(): self
    {
        $this->hasError = true;
        return $this;
    }

    /**
     * @return TServerArray
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'address' => (string)$this->address,
            'has_error' => $this->hasError,
        ];
    }

    /**
     * @param TServerArray $data
     */
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
