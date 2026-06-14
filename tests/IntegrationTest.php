<?php

declare(strict_types=1);

namespace yasmuru\LaravelTinify\Tests;

use PHPUnit\Framework\Attributes\Test;
use yasmuru\LaravelTinify\Services\TinifyService;

/**
 * Live smoke tests against the real Tinify API.
 *
 * Skipped automatically unless TINIFY_APIKEY is set in the environment.
 * Run with:
 *     TINIFY_APIKEY=your-real-key vendor/bin/phpunit --filter Integration
 *
 * Each run consumes ~3 of your 500/month free-tier credits.
 */
class IntegrationTest extends TestCase
{
    private static ?string $apiKey = null;

    public static function setUpBeforeClass(): void
    {
        self::$apiKey = getenv('TINIFY_APIKEY') ?: null;
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('tinify.apikey', self::$apiKey ?? 'unused');
    }

    private function skipIfNoKey(): void
    {
        if (self::$apiKey === null) {
            $this->markTestSkipped('Set TINIFY_APIKEY to run integration tests.');
        }
    }

    #[Test]
    public function validate_returns_true_for_a_real_key(): void
    {
        $this->skipIfNoKey();

        /** @var TinifyService $service */
        $service = $this->app->make('tinify');

        $this->assertTrue(
            $service->validate(),
            'validate() should return true for a real, accepted API key.',
        );
    }

    #[Test]
    public function validate_returns_false_for_an_invalid_key(): void
    {
        $this->skipIfNoKey();

        /** @var TinifyService $service */
        $service = $this->app->make('tinify');
        $service->setKey('invalid-key-for-testing-' . bin2hex(random_bytes(8)));

        $this->assertFalse(
            $service->validate(),
            'validate() must return false for an invalid key. '
            . 'Before the fix, this returned true because the AccountException '
            . 'was caught as a generic \Exception.',
        );
    }

    #[Test]
    public function compression_count_is_an_integer_after_a_call(): void
    {
        $this->skipIfNoKey();

        /** @var TinifyService $service */
        $service = $this->app->make('tinify');
        $service->validate(); // ensures the API has responded at least once

        $count = $service->getCompressionCount();

        $this->assertIsInt($count);
        $this->assertGreaterThanOrEqual(0, $count);
    }

    #[Test]
    public function from_buffer_compresses_a_real_png(): void
    {
        $this->skipIfNoKey();

        if (!function_exists('imagecreatetruecolor')) {
            $this->markTestSkipped('GD extension required to generate the test PNG.');
        }

        $png = $this->makeTestPng();
        $this->assertNotEmpty($png, 'Failed to generate input PNG.');

        /** @var TinifyService $service */
        $service = $this->app->make('tinify');
        $compressed = $service->fromBuffer($png)->toBuffer();

        $this->assertIsString($compressed);
        $this->assertNotEmpty($compressed, 'Compressed output should not be empty.');
        // PNG magic bytes — output should still be a PNG.
        $this->assertSame("\x89PNG\r\n\x1a\n", substr($compressed, 0, 8));
    }

    private function makeTestPng(): string
    {
        $img = imagecreatetruecolor(200, 200);
        $red   = imagecolorallocate($img, 220, 50, 47);
        $white = imagecolorallocate($img, 255, 255, 255);
        $blue  = imagecolorallocate($img, 38, 139, 210);
        imagefilledrectangle($img, 0, 0, 200, 200, $red);
        imagefilledrectangle($img, 40, 40, 160, 160, $white);
        imagefilledrectangle($img, 80, 80, 120, 120, $blue);

        ob_start();
        imagepng($img);
        $bytes = (string) ob_get_clean();
        imagedestroy($img);

        return $bytes;
    }
}
