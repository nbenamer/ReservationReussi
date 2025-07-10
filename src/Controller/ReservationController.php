<?php
namespace App\Controller;

use App\Service\ReservationService;

class ReservationController
{
    private ReservationService $service;

    public function __construct()
    {
        $this->service = new ReservationService();
    }

    /** Route unique : GET = disponibilité, POST = réservation */
    public function handle(string $method, array $data): void
    {
        header('Content-Type: application/json');

        /* ---------- GET /index.php?event_id=1 ---------- */
        if ($method === 'GET') {
            $eventId   = (int)($_GET['event_id'] ?? 0);
            if ($eventId <= 0) {
                http_response_code(400);
                echo json_encode(['error' => 'event_id manquant']);
                return;
            }
            $remaining = $this->service->remainingSeats($eventId);
            echo json_encode([
                'event_id'  => $eventId,
                'remaining' => $remaining
            ]);
            return;
        }

        /* ---------- POST (réservation) ---------- */
        if ($method === 'POST') {
            try {
                $eventId = (int)($data['event_id'] ?? 0);
                $userId  = (int)($data['user_id']  ?? 0);
                $reservation = $this->service->reserve($eventId, $userId);
                echo json_encode(['success' => true, 'reservation' => $reservation]);
            } catch (\Throwable $e) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            return;
        }

        /* ---------- Méthode non autorisée ---------- */
        http_response_code(405);
        echo json_encode(['error' => 'Méthode non autorisée']);
    }
}
