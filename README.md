# Birddog

Birddog is a free tool for monitoring [workers](https://docs.roadrunner.dev/php-worker/rpc), services
and [jobs](https://docs.roadrunner.dev/queues-and-jobs/overview-queues) of a RoadRunner instance.

![birddog-plugins](https://user-images.githubusercontent.com/773481/200691160-314cc757-89b7-46ec-b55a-6b1b2788087b.png)
![birddog-config](https://user-images.githubusercontent.com/773481/200691269-9383b752-0b6e-448a-aa6a-020936aeb1e5.png)
![birddog-service-manager](https://user-images.githubusercontent.com/773481/200691288-e19fdf5a-490a-4712-90e1-79e46fc8dcc2.png)
![birddog-metrics](https://user-images.githubusercontent.com/773481/200691355-8209cc73-e72e-4d52-a2b0-4bb567564977.png)

## Installation

```bash
docker run \
    -p 8080:8080 \
    -p 3000:3000 \
    --env DEFAULT_RPC_SERVER_ADDRESS=tcp://127.0.0.1:6001 \
    ghcr.io/roadrunner-server/birddog:latest
```

You can also define multiple RPC servers via env variables:

```bash
docker run \
    -p 8080:8080 \
    -p 3000:3000 \
    --env DEFAULT_RPC_SERVER=foo \
    --env RPC_SERVER_FOO=tcp://127.0.0.1:6001 \ 
    --env RPC_SERVER_BAR=tcp://127.0.0.1:6001 \
    ghcr.io/roadrunner-server/birddog:latest
```

or using docker compose:

```yaml
version: "3.7"

services:
    rr-php:
        build:
            dockerfile: ./docker/php/Dockerfile
        command: rr serve
        restart: on-failure

    monitor:
        image: ghcr.io/roadrunner-server/birddog:latest
        ports:
            - "8080:8080"
            - "3000:3000"
        environment:
            DEFAULT_RPC_SERVER_ADDRESS: tcp://rr-php:6001
            API_URL: http://127.0.0.1:8080
```

## Configuration

There ENV variables that can be used to configure the Birddog:

```dotenv
# Birddog Websocket API URL
WS_URL=http://127.0.0.1:8080/connection/websocket

# Default RR RPC server address
# It works only if you won't relace DEFAULT_RPC_SERVER ENV variable
DEFAULT_RPC_SERVER_ADDRESS=tcp://127.0.0.1:6001

# Default RPC server name 
DEFAULT_RPC_SERVER=foo

# Servers definition
# You can define multiple servers using the following format. Every server should start with RPC_SERVER_ prefix.
RPC_SERVER_FOO=tcp://127.0.0.1:6001
RPC_SERVER_BAR=tcp://127.0.0.1:6001
```
