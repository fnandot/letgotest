# LetShout

A Twitter based API.

## Technology

Principal technologies used in this project are:
```
docker 17.09.0-ce
docker-compose 1.16.1
symfony 3.3.6
phpunit 5.7.25
behat 3.4.2
```

Docker is used to build and execute the application in a *contanerized* environment.
The unit and integration tests are also executed in containers.

The docker stack of the application consists of the following containers:
```
nginx
php-fpm
redis
``` 

In order to improve the build process I pushed the image "fnando08/lshout:php71-runner" to DockerHub (there's no code inside image). 
But If you would rather to build the image locally on your system, then execute:
```
make build-runner
```

## Use case

Our business model is simple, we have Tweets and we have Users. A Tweet belongs to a user and a lot of Tweets can belong to the same user (many-to-one relationship).
```
[User]1----n[Tweet]

```

The presented use case has the next specification:

```
Given an user username and a number n
When I request for last n tweets of user
Then last n tweets are returned in uppercase
```

And in the presentation layer we have the next requirements:

```
Response format should be in JSON
Tweets text should be in uppercase
```

## About software engineering

This application is based on several concepts of DDD and, mainly, in a layered architecture. Thus, we have 3 main layers of abstraction that are Application, Domain and Infrastucture.

Going into detail, in this way, from the Domain point of view we have the UserRepository and the TweetRepository, which are nothing more than an abstraction that tells to Domain that Users
and Tweets will be retrieved but does not specify how. We will found concrete adapter implementations in Infrastructure layer. 
That abstraction allows us, for example, to implement different types of adapters without having to modify our domain or application layer. 
For example, we can implement, a repository that obtains data from *twitter.com* or from a relational database.

For our case, we have *UserTwitterRepository* and *TweetTwitterRepository* implementations.
In these implementations we can find another layer of abstraccion that delegates in the TwitterClient interface the implementation of the type of connection with the *twitter.com* API.

For this, in our case we have 2 implementations that are the TwitterOAuthClient and the TwitterCachedClient.
The first encapsulates the connection to the *twitter.com* API with OAuth authentication.
And the second is nothing more than an implementation that adds a layer of cache and depends on the TwitterOAuthClient to connect.

Since the UserRepository and the TweetRepository are services of the Domain layer and therefore must return something that concerns to that layer (remembering that infrastructure is aware of the domain and application layers, but not on the other way).

So we need to return User and Tweet entities respectively. 
Therefore, we need another *actor* to translate the *twitter.com* model to our Domain model.
Here come into play the TweetTranslator and UserTranslator which, as we have said, are nothing more than two classes responsible for translating the *twitter.com* model to the LetShout model.


## Cache

Cache can be implemented in different layers of your application,
but I decided to put cache layer on TwitterClient before external HTTP communication to cache external API responses.

So we have a CachedTwitterClient that relies on a PSR-6 CacheItemPoolInterface implementation to get and save on cache.
For that project we will use Symfony Cache Component which includes a lot of adapters (redis, memcached, apcu, etc), but we can use any external or internal library that implements CacheItemPoolInterface.

##Configuration reference

This application provides some configuration options that can be changed in "*let_shout_config.yml*".

Text transformation: you can change Tweet transformation strategy (now only uppercase is avaliable):
```
let_shout_api:
    formatter:
        type: 'uppercase'
```

Cache: you can enable or disable the application cache and change expiration time:
```
let_shout_api:
    cache:
        enabled: true
        ttl: 60
``` 

## Testing

Whe have 2 types of tests:

- Unit tests
- Integration tests

### Unit tests

To run them execute:
```
make test
```

It will show you unit tests in *testdox* format and a code coverage report. 

### Integration tests

I have used Behat to implement the integration tests, even though that Behat it is mainly oriented to acceptance and functional tests.

I explored other options like make them as WebTestCase of Symfony, but I decided finally Behat beucause because, among others, it allows you to write tests quickly and in a more natural language, more suitable for that integration tests, in my opinion.
Also because it allows us to run integration tests that not only test the application at the framework level (in this case Symfony) but also at the system level since our test environment is identical to what we could have in production.

An important thing to be mentioned is the usage of a mock server for integration tests

There are 3 main reasons for that:

- Because we do not want to be banned in the Twitter API (by number of requests: P)
- Because we want to be able to execute these tests without the need to generate OAuth credentials.
- Because if api.twitter.com fails we don't want our integration tests to be affected (despite that our application won't run :P) 

I tried different mock servers, but finally I decided to use an application in NodeJS called *mockserver* becuase its easy start up process. 

To run integration tests execute:

```
make test-integration
```

## Getting started

The build an run this project the only thing you'll need is *make*, *docker* and *docker-compose*.

First of all, you need to build the project by executing:
```
make build
```

This will install the necessary dependencies with composer and execute the necessary tasks to run the application.

In order to authenticate in twitter API you have to specify your OAuth credentials inside *.env* file:
```
LET_SHOUT_API_TWITTER_CONSUMER_KEY=ConsumerKey
LET_SHOUT_API_TWITTER_CONSUMER_SECRET=ConsumerSecret
LET_SHOUT_API_TWITTER_TOKEN=Token
LET_SHOUT_API_TWITTER_TOKEN_SECRET=TokenSecret
```

Then to start the application execute:
```
make start
```

And that is all, the unique endpoint is now avaliable on:
```
 http://<your-docker-host>:8080/{version}/users/{username}/tweets.{_format}?count={number}
```

Where:
- version: 1.0 
- username: An username
- format: json
- number: Maximum 50, Default: 10
 
Example: http://localhost:8080/1.0/users/letgo/tweets.json?count=10

## Things that could be improved

- Make application errors more verbose (now any error with comunication will be shown as "username not found").
- Add authentication to our api, like JWT or OAuth.
- Write a documentation for our API in a standard format (like Swagger/OpenAPI).
- Improve code coverage.
- ...
