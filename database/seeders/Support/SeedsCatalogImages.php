<?php

namespace Database\Seeders\Support;

use Illuminate\Support\Facades\File;

trait SeedsCatalogImages
{
    /** @var array<int, string> */
    private const SERVICE_IMAGE_URLS = [
        'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1400&h=900&q=85',
    ];

    /** @var array<int, string> */
    private const UNIQUE_IMAGE_URLS = [
        'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1544197150-361451702afe?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1550751827-4bd374c3d58b?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1473341304170-971dccb5ac71?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1535223396211-9c8dcf2b6d3a?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&w=1400&h=900&q=85',
        'https://images.unsplash.com/photo-1614064641938-3bbee52942c7?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1639322537504-6427a16b0ef8?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1504639725590-34d0984388bd?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1400&h=900&q=80',
        'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1400&h=900&q=80',
    ];

    protected function seedServiceImages(): void
    {
        $serviceDir = public_path('images/services');
        File::ensureDirectoryExists($serviceDir);

        $serviceSeeds = [
            'd3-svc-strategy-advisory-01',
            'd3-svc-investment-diligence-02',
            'd3-svc-engineering-design-03',
            'd3-svc-procurement-execution-04',
            'd3-svc-demand-generation-05',
        ];

        foreach ($serviceSeeds as $i => $seed) {
            $this->downloadUniqueImage(
                self::SERVICE_IMAGE_URLS[$i],
                "{$serviceDir}/service-".($i + 1).'.jpg',
                $seed,
            );
        }
    }

    protected function seedSolutionImages(): void
    {
        $solutionDir = public_path('images/solutions');
        File::ensureDirectoryExists($solutionDir);

        $solutionSeeds = [
            'd3-sol-financial-01',
            'd3-sol-healthcare-02',
            'd3-sol-media-streaming-03',
            'd3-sol-government-04',
            'd3-sol-ecommerce-05',
            'd3-sol-gaming-06',
            'd3-sol-telecom-07',
            'd3-sol-energy-utilities-08',
            'd3-sol-education-09',
            'd3-sol-manufacturing-iot-10',
            'd3-sol-saas-scale-11',
            'd3-sol-research-hpc-12',
        ];

        foreach ($solutionSeeds as $i => $seed) {
            $this->downloadUniqueImage(
                self::UNIQUE_IMAGE_URLS[$i + 12],
                "{$solutionDir}/solution-".($i + 1).'.jpg',
                $seed,
            );
        }
    }

    private function downloadUniqueImage(string $url, string $destination, string $fallbackSeed): void
    {
        if (File::exists($destination) && File::size($destination) > 10_000) {
            return;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'header' => "User-Agent: d3-CMS-Seeder/1.0\r\n",
                    'timeout' => 60,
                    'ignore_errors' => true,
                ],
            ]);

            $body = @file_get_contents($url, false, $context);

            if ($body !== false && strlen($body) > 10_000) {
                File::put($destination, $body);

                return;
            }
        } catch (\Throwable) {
            // Fall back to local copy below.
        }

        $this->copyFallbackImage($fallbackSeed, $destination);
    }

    private function copyFallbackImage(string $seed, string $destination): void
    {
        $sources = [
            public_path('images/hero-slide-1.jpg'),
            public_path('images/hero-slide-2.jpg'),
            public_path('images/hero-slide-3.jpg'),
            public_path('images/hero-slide-4.jpg'),
            public_path('images/hero-slide-5.jpg'),
            public_path('images/hero-datacenter.jpg'),
            public_path('images/data-centre-facility.jpg'),
            public_path('images/about-technology.jpg'),
        ];

        $available = array_values(array_filter($sources, fn (string $path) => File::exists($path)));

        if ($available === []) {
            return;
        }

        $index = abs(crc32($seed)) % count($available);
        $source = $available[$index];

        if (! extension_loaded('gd')) {
            File::copy($source, $destination);

            return;
        }

        $type = exif_imagetype($source);
        $image = match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($source),
            IMAGETYPE_PNG => imagecreatefrompng($source),
            IMAGETYPE_WEBP => imagecreatefromwebp($source),
            default => null,
        };

        if (! $image) {
            File::copy($source, $destination);

            return;
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $offsetX = abs(crc32($seed.'-x')) % max(1, $width - 400);
        $offsetY = abs(crc32($seed.'-y')) % max(1, $height - 300);
        $cropWidth = min(1200, $width - $offsetX);
        $cropHeight = min(800, $height - $offsetY);

        $cropped = imagecrop($image, [
            'x' => $offsetX,
            'y' => $offsetY,
            'width' => $cropWidth,
            'height' => $cropHeight,
        ]) ?: $image;

        imagejpeg($cropped, $destination, 88);
        imagedestroy($image);
        if ($cropped !== $image) {
            imagedestroy($cropped);
        }
    }
}
