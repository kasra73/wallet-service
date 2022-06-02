<?php

declare(strict_types=1);

namespace App\Dtos;

use DateTimeImmutable;

/** @psalm-immutable */
final class TransactionDto
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(
        private string $uuid,
        private int $walletId,
        private string $type,
        private float|int|string $amount,
        private bool $confirmed,
        private ?array $meta
    ) {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getWalletId(): int
    {
        return $this->walletId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): float|int|string
    {
        return $this->amount;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function getMeta(): ?array
    {
        return $this->meta;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function extract(): array
    {
        return [
            'uuid' => $this->getUuid(),
            'wallet_id' => $this->getWalletId(),
            'type' => $this->getType(),
            'amount' => $this->getAmount(),
            'confirmed' => $this->isConfirmed(),
            'meta' => $this->getMeta(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
        ];
    }
}
