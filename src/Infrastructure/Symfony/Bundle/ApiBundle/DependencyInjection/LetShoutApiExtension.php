<?php

namespace LetShout\Infrastructure\Symfony\Bundle\ApiBundle\DependencyInjection;

use LetShout\Infrastructure\Service\String\Format\UpperCaseStringFormatter;
use LetShout\Infrastructure\Service\Twitter\Cache\TwitterCachedClient;
use LetShout\Infrastructure\Service\Twitter\OAuth\TwitterOAuthClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class LetShoutApiExtension
 */
class LetShoutApiExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $processedConfiguration = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'let_shout_api.configuration.twitter.base_uri',
            $processedConfiguration['twitter']['base_uri']
        );

        $container->setParameter(
            'let_shout_api.configuration.twitter.consumer_key',
            $processedConfiguration['twitter']['consumer_key']
        );

        $container->setParameter(
            'let_shout_api.configuration.twitter.consumer_secret',
            $processedConfiguration['twitter']['consumer_secret']
        );

        $container->setParameter(
            'let_shout_api.configuration.twitter.token',
            $processedConfiguration['twitter']['token']
        );

        $container->setParameter(
            'let_shout_api.configuration.twitter.token_secret',
            $processedConfiguration['twitter']['token_secret']
        );

        $container->setParameter(
            'let_shout_api.configuration.cache.ttl',
            $processedConfiguration['cache']['ttl']
        );


        $this->processTwitterClientConfiguration($container, $processedConfiguration);
        $this->processFormatterConfiguration($container, $processedConfiguration);
    }

    private function processTwitterClientConfiguration(ContainerBuilder $container, array $processedConfiguration): void
    {
        if (false === $processedConfiguration['cache']['enabled']) {
            $container->setAlias('let_shout.twitter_client', TwitterOAuthClient::class);
        } else {
            $container->setAlias('let_shout.twitter_client', TwitterCachedClient::class);
        }
    }

    private function processFormatterConfiguration(ContainerBuilder $container, array $processedConfiguration): void
    {
        $formatterType = $processedConfiguration['formatter']['type'];

        switch ($formatterType) {
            case 'uppercase':
                $container->setAlias('let_shout.formatter', UpperCaseStringFormatter::class);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Formatter "%s" is not allowed'));
        }
    }
}
