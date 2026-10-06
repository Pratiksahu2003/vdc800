<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MapUrlResolver
{
    public function normalizeInput(?string $input): ?string
    {
        if (blank($input)) {
            return null;
        }

        $input = trim(html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        if (preg_match('/src=["\']([^"\']+)["\']/i', $input, $matches)) {
            $input = trim($matches[1]);
        }

        if (preg_match('#https?://[^\s"\'<>]+#i', $input, $matches) && ! str_starts_with(strtolower($input), 'http')) {
            $input = trim($matches[0]);
        }

        if (! preg_match('#^https?://#i', $input)) {
            if (Str::contains(strtolower($input), ['google.com/maps', 'maps.google.com', 'maps.app.goo.gl', 'goo.gl/maps'])) {
                $input = 'https://'.ltrim($input, '/');
            }
        }

        $input = rtrim($input, '"\'>');

        return filter_var($input, FILTER_VALIDATE_URL) ? $input : null;
    }

    public function resolveMapLink(?string $mapLink = null, ?array $addressParts = null): ?string
    {
        $mapLink = $this->normalizeInput($mapLink);

        if (filled($mapLink)) {
            if ($this->isShortGoogleMapsUrl($mapLink)) {
                return $this->expandShortUrl($mapLink) ?? $mapLink;
            }

            return $mapLink;
        }

        $addressParts ??= $this->defaultAddressParts();

        if (empty($addressParts)) {
            return null;
        }

        return 'https://www.google.com/maps/search/?api=1&query='.urlencode(implode(', ', $addressParts));
    }

    public function resolveEmbedUrl(?string $mapLink = null, ?array $addressParts = null): ?string
    {
        $link = $this->resolveMapLink($mapLink, $addressParts);

        if (blank($link)) {
            return null;
        }

        if (str_contains($link, '/maps/embed')) {
            return $link;
        }

        if ($this->isShortGoogleMapsUrl($link)) {
            $expanded = $this->expandShortUrl($link);
            if ($expanded) {
                return $this->buildEmbedUrl($expanded);
            }
        }

        return $this->buildEmbedUrl($link);
    }

    private function buildEmbedUrl(string $url): string
    {
        if (preg_match('#/maps/embed#i', $url)) {
            return $url;
        }

        if (preg_match('#google\.com/maps/search/\?api=1&query=([^&]+)#i', $url, $matches)) {
            return 'https://www.google.com/maps?q='.urlencode(urldecode($matches[1])).'&output=embed';
        }

        if (preg_match('#[?&]query=([^&]+)#i', $url, $matches)) {
            return 'https://www.google.com/maps?q='.urlencode(urldecode($matches[1])).'&output=embed';
        }

        if (preg_match('#/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)(?:,(\d+(?:\.\d+)?)z)?#i', $url, $matches)) {
            $embed = 'https://www.google.com/maps?q='.$matches[1].','.$matches[2].'&output=embed';

            if (! empty($matches[3])) {
                $embed .= '&z='.(int) $matches[3];
            }

            return $embed;
        }

        if (preg_match('#google\.com/maps|maps\.google\.com#i', $url)) {
            $separator = str_contains($url, '?') ? '&' : '?';

            if (str_contains($url, 'output=embed')) {
                return $url;
            }

            if (preg_match('#/place/#i', $url) && preg_match('#/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)(?:,(\d+(?:\.\d+)?)z)?#i', $url, $matches)) {
                $embed = 'https://www.google.com/maps?q='.$matches[1].','.$matches[2].'&output=embed';

                if (! empty($matches[3])) {
                    $embed .= '&z='.(int) $matches[3];
                }

                return $embed;
            }

            return $url.$separator.'output=embed';
        }

        return 'https://www.google.com/maps?q='.urlencode($url).'&output=embed';
    }

    private function isShortGoogleMapsUrl(string $url): bool
    {
        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');

        return in_array($host, [
            'maps.app.goo.gl',
            'goo.gl',
            'g.co',
            'bit.ly',
        ], true) || str_contains($host, 'goo.gl');
    }

    private function expandShortUrl(string $url): ?string
    {
        try {
            $response = Http::timeout(8)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; VDC800/1.0)'])
                ->get($url);

            if ($response->failed()) {
                return null;
            }

            $effective = (string) ($response->effectiveUri() ?? $url);

            return $this->cleanExpandedGoogleUrl($effective);
        } catch (\Throwable) {
            return null;
        }
    }

    private function cleanExpandedGoogleUrl(string $url): string
    {
        if (str_contains($url, 'consent.google.com') && preg_match('/continue=([^&]+)/i', $url, $matches)) {
            $url = urldecode($matches[1]);
        }

        return $url;
    }

    private function defaultAddressParts(): array
    {
        return array_values(array_filter([
            settings('company.address'),
            settings('company.city'),
            settings('company.postal_code'),
            settings('company.country'),
        ]));
    }
}
