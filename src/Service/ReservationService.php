<?php
namespace App\Service;

use App\Repository\ReservationRepository;

class ReservationService
{
    public function __construct(
        private ReservationRepository $repo = new ReservationRepository()
    ) {}

    /** Réserve une place (lance une exception si complet) */
    public function reserve(int $eventId, int $userId)
    {
        if ($this->repo->remainingSeats($eventId) <= 0) {
            throw new \RuntimeException('Aucune place disponible');
        }
        return $this->repo->create($eventId, $userId);
    }

    /** Renvoie le nombre de places restantes pour un événement */
    public function remainingSeats(int $eventId): int
    {
        return $this->repo->remainingSeats($eventId);
    }
}
