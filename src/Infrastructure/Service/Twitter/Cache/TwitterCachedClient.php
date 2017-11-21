<?php


namespace LetShout\Infrastructure\Service\Twitter\Cache;

use LetShout\Infrastructure\Service\Twitter\TwitterClient;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class TwitterCachedClient
 */
class TwitterCachedClient implements TwitterClient
{
    /** @var CacheItemPoolInterface */
    private $cache;

    /** @var TwitterClient */
    private $client;

    /** @var int */
    private $ttl;

    public function __construct(
        CacheItemPoolInterface $cache,
        TwitterClient $client,
        int $ttl
    ) {
        $this->cache = $cache;
        $this->client = $client;
        $this->ttl = $ttl;
    }


    public function get(string $endpoint, array $parameters = [])
    {
        $requestKey = $this->generateKey($endpoint, $parameters);

        $item = $this->cache->getItem($requestKey);

        if (!$item->isHit()) {
            $content = $this->client->get($endpoint, $parameters);

            $item->set($content);
            $item->expiresAt($this->computeExpirationDate());

            $this->cache->save($item);
        }

        return $item->get();
    }

    /**
     * @return static
     */
    private function computeExpirationDate(): \DateTimeImmutable
    {
        $now = new \DateTimeImmutable();

        return $now->add(new \DateInterval("PT{$this->ttl}S"));
    }

    private function generateKey(string $endpoint, array $parameters): string
    {
        return md5(
            json_encode([
                $endpoint,
                $parameters
            ])
        );
    }
}
