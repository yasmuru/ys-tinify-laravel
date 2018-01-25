<?php
namespace yasmuru\LaravelTinify\Services;

use Tinify\Source;
use Tinify\Tinify;

class TinifyService {

    /**
     * Get api key from env, fail if any are missing.
     * Instantiate API client and set api key.
     *
     * @throws Exception
     */
    public function __construct() {
        $this->apikey = config('tinify.apikey');
        if(!$this->apikey) {
            throw new \InvalidArgumentException('Please set TINIFY_APIKEY environment variables.');
        }
        $this->client = new Tinify();
        $this->client->setKey($this->apikey);

        $this->s3_key = env('S3_KEY');
        $this->s3_secret = env('S3_SECRET');
        $this->s3_region = env('S3_REGION');
    }
    public function setKey($key) {
        return $this->client->setKey($key);
    }

    public function setAppIdentifier($appIdentifier) {
        return $this->client->setAppIdentifier($appIdentifier);
    }

    public function getCompressionCount() {
        return $this->client->getCompressionCount();
    }

     public function compressionCount() {
        return $this->client->getCompressionCount();
    }

    public function fromFile($path) {
        return Source::fromFile($path);
    }

    public function fromBuffer($string) {
        return Source::fromBuffer($string);
    }

    public function fromUrl($string) {
        return Source::fromUrl($string);
    }

    function isS3Set() {
        if($this->s3_key && $this->s3_secret && $this->s3_region ) {
            return true;
        }

        throw new \InvalidArgumentException('Please set S3 environment variables.');
    }

    public function fileToS3($source_path, $bucket, $destination_path) {
        if($this->isS3Set()) {
            return Source::fromFile($source_path)
                ->store(array(
                    "service" => "s3",
                    "aws_access_key_id" => $this->s3_key,
                    "aws_secret_access_key" => $this->s3_secret,
                    "region" => $this->s3_region,
                    "path" => $bucket . $destination_path,
                ));
        }
    }

    public function bufferToS3($string, $bucket, $path) {
        if($this->isS3Set()) {
            return Source::fromBuffer($string)
                ->store(array(
                    "service" => "s3",
                    "aws_access_key_id" => $this->s3_key,
                    "aws_secret_access_key" => $this->s3_secret,
                    "region" => $this->s3_region,
                    "path" => $bucket . $path,
                ));
        }
    }

    public function urlToS3($url, $bucket, $path) {
        if($this->isS3Set()) {
            return Source::fromUrl($url)
                ->store(array(
                    "service" => "s3",
                    "aws_access_key_id" => $this->s3_key,
                    "aws_secret_access_key" => $this->s3_secret,
                    "region" => $this->s3_region,
                    "path" => $bucket . $path,
                ));
        }
    }

    public function validate() {
        try {
            $this->client->getClient()->request("post", "/shrink");
        } catch (ClientException $e) {
            return true;
        }
    }
}