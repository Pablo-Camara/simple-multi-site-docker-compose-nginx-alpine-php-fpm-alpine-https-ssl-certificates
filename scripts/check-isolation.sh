#!/bin/sh
set -eu
for service in nginx site-one-php site-two-php; do
  test "$(docker compose exec -T "$service" id -u)" != 0
  container=$(docker compose ps -q "$service")
  test "$(docker inspect --format '{{.HostConfig.ReadonlyRootfs}}' "$container")" = true
done
for service in site-one-php site-two-php; do
  docker compose exec -T "$service" php -r 'exit(is_writable("/var/www/html") ? 1 : 0);'
done
# Each worker must be unable to resolve the other worker on its private network.
docker compose exec -T site-one-php php -r 'exit(gethostbyname("site-two-php") === "site-two-php" ? 0 : 1);'
docker compose exec -T site-two-php php -r 'exit(gethostbyname("site-one-php") === "site-one-php" ? 0 : 1);'
printf '%s\n' 'Non-root users, read-only filesystems and separate worker networks verified.'
