#!/usr/bin/env bash
# Replace self-signed cert with Let's Encrypt and enable HTTP→HTTPS redirect.
set -euo pipefail

EMAIL="${CERTBOT_EMAIL:-hello@d3.vedmint.com}"
DOMAINS=(-d d3.vedmint.com -d www.d3.vedmint.com)
CONF="/etc/nginx/sites-available/d3.vedmint.com"

echo "Checking public DNS for d3.vedmint.com..."
if ! host -t A d3.vedmint.com 8.8.8.8 2>/dev/null | grep -q 'has address'; then
    echo "ERROR: No public A record for d3.vedmint.com yet."
    echo ""
    echo "In Cloudflare (vedmint.com), add:"
    echo "  A    d3      95.135.166.167   (DNS only / grey cloud for first issue)"
    echo "  AAAA d3      2001:41d0:306:276c::2472   (optional)"
    echo ""
    echo "Wait a few minutes, then run this script again."
    exit 1
fi

echo "Requesting certificate from Let's Encrypt..."
certbot --nginx "${DOMAINS[@]}" \
    --non-interactive --agree-tos --email "$EMAIL" --redirect

if grep -q '/etc/nginx/ssl/d3.vedmint.com/' "$CONF"; then
    sed -i 's|/etc/nginx/ssl/d3.vedmint.com/fullchain.pem|/etc/letsencrypt/live/d3.vedmint.com/fullchain.pem|g' "$CONF"
    sed -i 's|/etc/nginx/ssl/d3.vedmint.com/privkey.pem|/etc/letsencrypt/live/d3.vedmint.com/privkey.pem|g' "$CONF"
fi

nginx -t && systemctl reload nginx
echo ""
echo "Done. Test: curl -sI https://d3.vedmint.com/"
