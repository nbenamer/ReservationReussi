<?php
use PHPUnit\Framework\TestCase;
use App\Service\ReservationService;
use App\Repository\ReservationRepository;

final class ReservationServiceTest extends TestCase {
    public function testRefuseIfFull(): void {
        $repo = $this->createMock(ReservationRepository::class);
        $repo->method('remainingSeats')->willReturn(0);
        $service = new ReservationService($repo);
        $this->expectException(RuntimeException::class);
        $service->reserve(1, 42);
    }
}
