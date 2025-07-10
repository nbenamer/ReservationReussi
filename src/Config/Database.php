<?php
namespace App\Config;

use PDO;
use PDOException;

/**
 * Singleton de connexion PDO avec bascule Galera.
 * Essaie mariadb1 → mariadb2 → mariadb3.
 */
class Database
{
    /** Retourne une instance PDO connectée au premier nœud disponible */
    public static function get(): PDO
    {
        static $pdo = null;
        if ($pdo !== null) {
            return $pdo;                  // déjà connecté
        }

        $hosts = ['mariadb1', 'mariadb2', 'mariadb3'];
        foreach ($hosts as $host) {
            try {
                $pdo = new PDO(
                    "mysql:host={$host};dbname=reservation_db;charset=utf8",
                    'root',
                    'password',
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                // ping immédiat
                $pdo->query('SELECT 1');
                error_log("✅ Connecté à {$host}");
                return $pdo;
            } catch (PDOException $e) {
                error_log("❌ {$host} indisponible ({$e->getMessage()})");
            }
        }

        // Aucun nœud joignable
        throw new PDOException('Aucun nœud MariaDB Galera disponible');
    }
}
