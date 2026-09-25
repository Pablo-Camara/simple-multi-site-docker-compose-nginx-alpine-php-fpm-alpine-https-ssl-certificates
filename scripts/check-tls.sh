#!/bin/sh
set -eu
cd "$(dirname "$0")/.."
port=${HTTPS_PORT:-8443}
for site in site-one site-two; do
  # Trust only this generated certificate for the request; never disable validation.
  curl --silent --show-error --fail --noproxy '*' \
    --cacert certificates/local.crt \
    --resolve "$site.localhost:$port:127.0.0.1" \
    "https://$site.localhost:$port/" | grep -q 'PHP request served successfully'
done
status=$(curl --silent --show-error --noproxy '*' \
  --cacert certificates/local.crt \
  --resolve "site-one.localhost:$port:127.0.0.1" \
  --header 'Host: unknown.invalid' --output /dev/null --write-out '%{http_code}' \
  "https://site-one.localhost:$port/")
test "$status" = 404
printf '%s\n' 'Both HTTPS hosts passed certificate and response validation.'
