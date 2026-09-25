#!/bin/sh
set -eu
cd "$(dirname "$0")/.."
image=$(docker compose images -q nginx)
if [ -z "$image" ]; then
  echo "Start the HTTP stack first: docker compose up --build --wait" >&2
  exit 1
fi
mkdir -p certificates
if [ -e certificates/local.key ] || [ -e certificates/local.crt ]; then
  echo "Certificate files already exist; move them aside explicitly to generate a new pair." >&2
  exit 1
fi
# Local demonstration certificate only. Production keys must be provisioned separately.
umask 077
openssl req -x509 -nodes -newkey rsa:2048 -days 30 \
  -keyout certificates/local.key -out certificates/local.crt \
  -subj '/CN=site-one.localhost' \
  -addext 'subjectAltName=DNS:site-one.localhost,DNS:site-two.localhost' \
  -addext 'extendedKeyUsage=serverAuth'
# The unprivileged NGINX process needs read access through the read-only bind mount.
chmod 644 certificates/local.crt
# Keep the key private to the image's nginx UID; no world-readable private keys.
# This one-shot helper only changes ownership inside the certificate directory.
docker run --rm --network none --user 0 --entrypoint sh \
  -v "$PWD/certificates:/certificates" "$image" -c \
  'chown nginx:nginx /certificates/local.key && chmod 600 /certificates/local.key'
printf '%s\n' 'Created a local-only certificate. Never commit certificates/.'
