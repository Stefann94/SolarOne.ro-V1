# SolarOne — mediu local de dezvoltare

Mediu izolat pentru construirea noii interfețe (temă OpenCart), fără să atingem site-ul real.

## Ce rulează

| Serviciu | Adresă | Ce este |
|---|---|---|
| Site | http://localhost:8091 | OpenCart 3.0.3.8, PHP 7.4 + Apache |
| Administrare | http://localhost:8091/admin | panoul OpenCart |
| phpMyAdmin | http://localhost:8092 | baza de date locală |

## Date de autentificare (doar local, nu sunt secrete)

**Baza de date**
- server: `db` (așa se numește containerul în rețeaua Docker)
- bază: `solarone`
- utilizator: `solarone` / parolă: `solarone`
- root: `root` / parolă: `root`

**Administrare OpenCart** — se stabilesc la instalare (vezi mai jos).

## Comenzi

Toate se rulează din folderul `docker`.

```bash
docker compose up -d        # pornește mediul
docker compose down         # îl oprește (datele rămân)
docker compose down -v      # îl oprește ȘI șterge baza de date
docker compose logs -f web  # vezi ce face site-ul, în timp real
docker compose restart web  # repornește Apache
docker compose exec web bash  # intri în container, în linia de comandă
```

## Structura

```
Solarone.ro/
├── docker/      configurația mediului (Dockerfile, compose, php.ini)
├── www/         fișierele site-ului — se editează direct de aici
├── db/init/     fișiere .sql importate automat la PRIMA pornire
├── tema/        tema nouă (repository Git separat)
└── index.html   SITE-UL — deschide-l direct în browser (plus categorie.html, produs.html, CSS, poze)
```

Folderul `www` de pe calculator **este** folderul site-ului din container. Orice modificare se vede instant în browser, fără repornire.

## Prima instalare

1. `docker compose up -d`
2. Deschide http://localhost:8091 — pornește instalatorul OpenCart
3. La pasul cu baza de date:
   - Hostname: `db`
   - Utilizator: `solarone`
   - Parolă: `solarone`
   - Bază de date: `solarone`
   - Prefix: lasă gol (ca pe site-ul real)
4. Setezi utilizatorul de administrare (ex. `admin` / `admin`)
5. După instalare, **șterge folderul `www/install`**

## Importul catalogului real

După instalare, exportul din site-ul real se importă din phpMyAdmin (http://localhost:8092), în baza `solarone`.
Se importă **doar** tabelele de catalog și configurare. **Niciodată** `customer*`, `order*`, `user*`, `api*`.

## Reguli

- Mediul nu are nicio legătură cu site-ul real. Nu poate modifica nimic în producție.
- Plățile rămân dezactivate local.
- Fără date de clienți în copia locală (GDPR).
- Dacă se strică ceva: `docker compose down -v` și o iei de la capăt în 2 minute.
