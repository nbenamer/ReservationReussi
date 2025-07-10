# ReservationReussi

Cluster MariaDB Galera (3 nœuds) + application PHP/Apache, prêts à être lancés avec **Docker Compose**.

---

## 🚀 Mise en route rapide

```bash
# Cloner le dépôt
git clone https://github.com/nbenamer/ReservationReussi.git
cd ReservationReussi

# Construire l’image PHP/Apache
docker compose build php

# ─── Première exécution seulement : bootstrap du cluster ───
docker compose up -d mariadb1           # démarre UNIQUEMENT mariadb1
docker compose logs -f mariadb1         # attendre « Synced / Primary »

# Démarrer le reste
docker compose up -d mariadb2 mariadb3 php

# Ouvrir l’application
xdg-open http://localhost:3021          # ou navigateur favori
