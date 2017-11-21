<?php


namespace LetShout\Infrastructure\Model\Tweet;

class TweetResource
{
    /** @var string */
    private $id;

    /** @var string */
    private $externalId;

    /** @var \DateTimeImmutable */
    private $createdAt;

    /** @var string */
    private $text;

    public function __construct(
        string $id,
        string $externalId,
        \DateTimeImmutable $createdAt,
        string $text
    ) {
        $this->id = $id;
        $this->externalId = $externalId;
        $this->createdAt = $createdAt;
        $this->text = $text;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function externalId(): string
    {
        return $this->externalId;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function text(): string
    {
        return $this->text;
    }
}
