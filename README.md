# RoadRunner Monitor

The RoadRunner Monitor is a tool for monitoring [workers](https://roadrunner.dev/docs/php-rpc/2.x/en), services
and [jobs](https://roadrunner.dev/docs/plugins-jobs/2.x/en) of a RoadRunner instance.

## Installation

```bash
docker run \
    --pull always \
    -p 8080:8080 \
    -p 3000:3000 \
    --env DEFAULT_RPC_SERVER_ADDRESS=tcp://127.0.0.1:6001 \
    ghcr.io/roadrunner-server/monitor:latest
```

or using docker compose:

```yaml
version: "3.7"

rr-php:
    build:
        dockerfile: ./docker/php/Dockerfile
    command: rr serve
    restart: on-failure

services:
    monitor:
        image: ghcr.io/roadrunner-server/monitor:0.0.8
        ports:
            - "8080:8080"
            - "3000:3000"
        environment:
            DEFAULT_RPC_SERVER_ADDRESS: tcp://rr-php:6001
            BASE_URL: http://127.0.0.1:8080
```

## Configuration

There ENV varaibles that can be used to configure the monitor:

```dotenv
# Default RR RPC server address
DEFAULT_RPC_SERVER_ADDRESS=tcp://127.0.0.1:6001

# Default Monitor API url
BASE_URL=http://127.0.0.1:8080
```
