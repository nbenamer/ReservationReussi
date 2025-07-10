<?php
namespace App\Repository;

use App\Config\Database;
use App\Model\Reservation;

class ReservationRepository {
    public function create(int $eventId, int $userId): Reservation {
        $pdo = Database::get();
        $stmt = $pdo->prepare(
            'INSERT INTO reservations (event_id, user_id) VALUES (?, ?)'
        );
        $stmt->execute([$eventId, $userId]);
        $id = (int)$pdo->lastInsertId();
        return new Reservation($id, $eventId, $userId, new \DateTimeImmutable());
    }

    public function remainingSeats(int $eventId): int {
        $pdo = Database::get();
        $cap = $pdo->prepare('SELECT capacity FROM events WHERE id = ?');
        $cap->execute([$eventId]);
        $capacity = (int)$cap->fetchColumn();

        $used = $pdo->prepare('SELECT COUNT(*) FROM reservations WHERE event_id = ?');
        $used->execute([$eventId]);
        $taken = (int)$used->fetchColumn();

        return $capacity - $taken;
    }
}
