<?php
namespace App\Model;

class Reservation {
    public function __construct(
        public int $id,
        public int $eventId,
        public int $userId,
        public \DateTimeImmutable $createdAt
    ) {}
}
