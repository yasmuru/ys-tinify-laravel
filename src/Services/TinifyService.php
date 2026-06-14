<?php

declare(strict_types=1);

namespace yasmuru\LaravelTinify\Services;

use Tinify\Source;
use Tinify\Tinify;
use InvalidArgumentException;

class TinifyService
{
    private string $apikey;
    private Tinify $client;
    private ?string $s3_key;
    private ?string $s3_secret;
    private ?string $s3_region;

    /**
     * Get api key from env, fail if any are missing.
     * Instantiate API client and set api key.
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $apikey = config('tinify.apikey');
        if (!is_string($apikey) || $apikey === '') {
            throw new InvalidArgumentException('Please set TINIFY_APIKEY environment variable.');
        }
        $this->apikey = $apikey;
        $this->client = new Tinify();
        $this->client->setKey($this->apikey);

        $this->s3_key = config('tinify.s3.key');
        $this->s3_secret = config('tinify.s3.secret');
        $this->s3_region = config('tinify.s3.region');
    }
    /**
     * Set the API key for Tinify.
     */
    public function setKey(string $key): void
    {
        $this->client->setKey($key);
    }

    /**
     * Set the app identifier for Tinify.
     */
    public function setAppIdentifier(string $appIdentifier): void
    {
        $this->client->setAppIdentifier($appIdentifier);
    }

    /**
     * Get the compression count.
     */
    public function getCompressionCount(): ?int
    {
        return $this->client->getCompressionCount();
    }

    /**
     * Alias for getCompressionCount().
     */
    public function compressionCount(): ?int
    {
        return $this->client->getCompressionCount();
    }

    /**
     * Create a Source from a file path.
     */
    public function fromFile(string $path): Source
    {
        return Source::fromFile($path);
    }

    /**
     * Create a Source from a buffer string.
     */
    public function fromBuffer(string $string): Source
    {
        return Source::fromBuffer($string);
    }

    /**
     * Create a Source from a URL.
     */
    public function fromUrl(string $string): Source
    {
        return Source::fromUrl($string);
    }

    /**
     * Check if S3 credentials are set.
     *
     * @throws InvalidArgumentException
     */
    private function isS3Set(): bool
    {
        if ($this->s3_key && $this->s3_secret && $this->s3_region) {
            return true;
        }

        throw new InvalidArgumentException('Please set S3_KEY, S3_SECRET, and S3_REGION environment variables.');
    }

    /**
     * Compress and upload a file to S3.
     */
    public function fileToS3(string $source_path, string $bucket, string $destination_path): mixed
    {
        if ($this->isS3Set()) {
            return Source::fromFile($source_path)
                ->store([
                    "service" => "s3",
                    "aws_access_key_id" => $this->s3_key,
                    "aws_secret_access_key" => $this->s3_secret,
                    "region" => $this->s3_region,
                    "path" => $bucket . $destination_path,
                ]);
        }
        
        return null;
    }

    /**
     * Compress and upload a buffer to S3.
     */
    public function bufferToS3(string $string, string $bucket, string $path): mixed
    {
        if ($this->isS3Set()) {
            return Source::fromBuffer($string)
                ->store([
                    "service" => "s3",
                    "aws_access_key_id" => $this->s3_key,
                    "aws_secret_access_key" => $this->s3_secret,
                    "region" => $this->s3_region,
                    "path" => $bucket . $path,
                ]);
        }
        
        return null;
    }

    /**
     * Compress and upload an image from URL to S3.
     */
    public function urlToS3(string $url, string $bucket, string $path): mixed
    {
        if ($this->isS3Set()) {
            return Source::fromUrl($url)
                ->store([
                    "service" => "s3",
                    "aws_access_key_id" => $this->s3_key,
                    "aws_secret_access_key" => $this->s3_secret,
                    "region" => $this->s3_region,
                    "path" => $bucket . $path,
                ]);
        }
        
        return null;
    }

    /**
     * Validate the Tinify API key.
     *
     * Mirrors the upstream tinify-php behaviour: a `ClientException` (empty
     * input, 400) means the key was accepted; anything else — including an
     * `AccountException` for an invalid key — is treated as invalid.
     */
    public function validate(): bool
    {
        try {
            $this->client->getClient()->request("post", "/shrink");
        } catch (\Tinify\ClientException $e) {
            return true;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}