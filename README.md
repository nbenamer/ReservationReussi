# ReservationReussi

# 1. Cloner le projet
git clone https://github.com/nbenamer/ReservationReussi/
cd ReservationReussi

# 2. Construire l’image PHP/Apache
docker compose build php

# 3. PREMIER LANCEMENT ─ bootstrap du cluster Galera
#    (ne faire qu'une seule fois, la toute première)
docker compose up -d mariadb1           # lance le nœud 1 seul
docker compose logs -f mariadb1         # attendre "Synced / Primary"

# 4. Démarrer le reste des services
docker compose up -d mariadb2 mariadb3 php
URL : http://localhost:3021

Normalement ca fonctionne 
