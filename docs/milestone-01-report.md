# Milestone 1 Report — Project Foundation & Requirement Analysis

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform (independent, non-official prototype) |
| Milestone | **Milestone 1 — Project Foundation & Requirement Analysis** |
| Status | **COMPLETE — ready for GitHub commit (not yet committed)** |
| Milestone 2 | **Not started** (by instruction) |
| Report date | 2026-11-04 |
| Runtime | PHP 8.3.36 (ZTS, Windows x64), Laravel 13.39.0 |
| Frontend | Blade + Tailwind CSS v4 + Vite 7 |
| Repository | Git initialized; branch has commits `dcfa466`, `e74b7f2`; Milestone 1 fixes staged locally and uncommitted |

> This is an independent prototype. It is not an official website of the Government of
> Bangladesh, Phulbaria Upazila Administration, any Union Parishad, or any public authority.
> No government authorization is claimed. It contains no real personal data.

---

## 1. Deliverables completed

### 1.1 Documentation (9 documents)

| Document | Status |
| --- | --- |
| `docs/project-overview.md` | Complete |
| `docs/requirements.md` | Complete |
| `docs/architecture.md` | Complete |
| `docs/role-permission-matrix.md` | Complete |
| `docs/database-design.md` | Complete |
| `docs/security-requirements.md` | Complete |
| `docs/ui-ux-guidelines.md` | Complete |
| `docs/development-roadmap.md` | Complete (updated with M1 additions) |
| `docs/route-map.md` | Complete (new this review) |
| `docs/milestone-01-report.md` | This document |

### 1.2 Application

- Five read-only prototype pages served by `app/Http/Controllers/PrototypePageController.php`:
  landing (`/`), login (`/login`), registration (`/register`), citizen dashboard
  (`/dashboard`), admin dashboard (`/admin`).
- Bilingual (Bangla + English) responsive Blade UI with shared layouts
  (`layouts/public`, `layouts/portal`) and partials (brand, footer, prototype banner).
- Persistent prototype banner, non-official-government disclaimer, and `noindex` meta tag on
  every page.
- `config/platform.php` holding names, geography, and demo scope — no secrets.
- Route names prefixed `prototype.` so framework names (`login`, `register`, `dashboard`,
  `password.*`) stay free for future authentication scaffolding.

### 1.3 Issues fixed in this review

| # | Issue | Resolution |
| --- | --- | --- |
| 1 | **HTTP 500 on every page.** `SESSION_DRIVER=database` while the PHP build has no `pdo_sqlite` (`could not find driver`). | Switched session/cache/queue to file/file/sync; kept `DB_CONNECTION=sqlite`; cleared all caches. All pages now HTTP 200. |
| 2 | Login/registration forms used `method="get"` and submitted personal data in the query string. | Removed `action` and `method` entirely; disabled every data-bearing input; submit buttons disabled; `data-prototype="non-functional"` marker; regression tests added. |
| 3 | `public/robots.txt` was `Disallow:` (allowed everything). | Now `Disallow: /` for all agents plus explicit blocks for major crawlers, AI crawlers, and the Wayback Machine. |
| 4 | No security headers. | New `App\Http\Middleware\SecurityHeaders` appended globally in `bootstrap/app.php`. |
| 5 | Route map not reviewed for future auth/Filament conflicts. | `docs/route-map.md` added with conflict analysis and reserved URL space; regression test locks route naming. |
| 6 | README stated Git was not initialized; run commands and warnings outdated. | README corrected (see §6). |

---

## 2. The HTTP 500 — root cause and fix

**Symptom:** every page returned HTTP 500; `/up` (framework health check) returned 200.

**Log evidence** (`storage/logs/laravel.log`):

```text
local.ERROR: could not find driver
(Connection: sqlite, Database: E:\UZ PROJECT\database\database.sqlite,
 SQL: select * from "sessions" where "id" = ... limit 1)
```

**Cause:** `php -m` confirms `pdo_sqlite` is **not** in the installed PHP extension set
(`pdo_pgsql`/`pgsql` are present instead). Because `SESSION_DRIVER=database`, the web
middleware tried to read the session from SQLite before the controller ran, so no view
could render.

**Fix (prototype-only, reversible):**

| Variable | Before | After |
| --- | --- | --- |
| `SESSION_DRIVER` | `database` | `file` |
| `CACHE_STORE` | `database` | `file` |
| `QUEUE_CONNECTION` | `database` | `sync` |
| `DB_CONNECTION` | `sqlite` | `sqlite` (unchanged, kept for future work) |

Applied to both `.env` (local) and `.env.example` (template), with an explanatory comment.
Caches cleared with `config:clear`, `cache:clear`, `view:clear`, `route:clear`.

**To restore database drivers:** enable `pdo_sqlite` in `php.ini`
(`extension=pdo_sqlite`), then set `SESSION_DRIVER=database`, `CACHE_STORE=database`,
`QUEUE_CONNECTION=database` and run `php artisan migrate`.

---

## 3. Verification results

All results below were produced by actually running the commands, not assumed.

### 3.1 `composer test`

```text
Tests:    18 passed (96 assertions)
Duration: 2.87s
```

| Suite | Tests | Result |
| --- | --- | --- |
| `Tests\Unit\ExampleTest` | 1 | PASS |
| `Tests\Feature\ExampleTest` | 1 | PASS |
| `Tests\Feature\PrototypePagesTest` | 7 | PASS |
| `Tests\Feature\PrototypeFormSafetyTest` | 9 | PASS |

`PrototypeFormSafetyTest` proves the forms cannot submit credentials:

1. login form has no `action`/`method`
2. registration form has no `action`/`method`
3. no form in any prototype template (layouts/partials/pages) can submit
4. no form anywhere uses `method="get"`
5. every `type="submit"` button is `disabled`
6. credential/personal fields (`password`, `password_confirmation`, `mobile`, `full-name`,
   `login-password`) are disabled and use `autocomplete="off"`
7. forms still show the "not connected / disabled" notices
8. no write routes (POST/PUT/PATCH/DELETE) exist besides Laravel's built-in `storage/{path}`
9. `POST /login`, `POST /register`, `POST /dashboard`, `POST /admin` all return **405**;
   credentials in a query string are never echoed back

### 3.2 `npm run build`

```text
vite v7.3.7 building client environment for production...
✓ 61 modules transformed.
public/build/manifest.json             0.33 kB │ gzip:  0.17 kB
public/build/assets/app-B8aU2QmC.css  85.19 kB │ gzip: 14.86 kB
public/build/assets/app-Buj5iI_6.js   59.10 kB │ gzip: 22.24 kB
✓ built in 717ms
```

Exit code 0.

### 3.3 `vendor/bin/pint --test`

```text
PASS   ... 31 files
```

Exit code 0 — no style violations.

### 3.4 `php artisan route:list`

```text
GET|HEAD  / .............. home › PrototypePageController@home
GET|HEAD  admin .......... prototype.admin.dashboard › PrototypePageController@adminDashboard
GET|HEAD  dashboard ...... prototype.citizen.dashboard › PrototypePageController@citizenDashboard
GET|HEAD  login .......... prototype.login › PrototypePageController@login
GET|HEAD  register ....... prototype.register › PrototypePageController@register
GET|HEAD  storage/{path} . storage.local  (framework)
PUT       storage/{path} . storage.local.upload  (framework)
GET|HEAD  up ............. Illuminate\Foundation\HealthCheck  (framework)
Showing [8] routes
```

No application write routes. No Filament routes. No authentication routes.

### 3.5 HTTP smoke tests (live `php artisan serve` on 127.0.0.1:8123)

| Request | Result |
| --- | --- |
| `GET /` | **200** |
| `GET /login` | **200** |
| `GET /register` | **200** |
| `GET /dashboard` | **200** |
| `GET /admin` | **200** |
| `GET /up` | **200** |
| `GET /robots.txt` | **200** |
| `POST /login` (with credentials) | **405** Method Not Allowed |
| `POST /register` (with credentials) | **405** |
| `PUT /login` | **405** |
| `GET /login?password=secret123` | 200, secret **not** reflected in the response |
| `GET /admin` (unauthenticated) | 200 (static placeholder — see limitation L4) |
| `GET /admin/x` | 404 |

**Baseline before the fix:** `/`, `/login`, `/register`, `/dashboard`, `/admin` all returned **500**.

### 3.6 Rendered page check (headless Chrome)

Both form pages were loaded in a real browser to confirm the CSP does not break the UI:

| Page | HTTP | Console errors | Failed requests | Render |
| --- | --- | --- | --- | --- |
| `/login` | 200 | 0 | 0 | Correct: styles applied, fields greyed out, disabled submit button |
| `/register` | 200 | 0 | 0 | Correct: 3-step form laid out, all inputs disabled, disabled submit button |

### 3.7 Response headers (verified on `GET /login`)

```http
X-Robots-Tag: noindex, nofollow, noarchive, nosnippet
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
X-Frame-Options: DENY
Content-Security-Policy: default-src 'self'; base-uri 'self'; object-src 'none';
    frame-ancestors 'none'; form-action 'none'; img-src 'self' data:;
    font-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self';
    connect-src 'self'; manifest-src 'self'; media-src 'self'; worker-src 'self';
    upgrade-insecure-requests;
Cross-Origin-Opener-Policy: same-origin
Permissions-Policy: accelerometer=(), camera=(), geolocation=(), gyroscope=(),
    magnetometer=(), microphone=(), payment=(), usb=(), interest-cohort=()
```

`Strict-Transport-Security` is added only when the request is HTTPS (avoids pinning
`localhost`).

---

## 4. Security summary

| Control | State | Notes |
| --- | --- | --- |
| Indexing prevention | Implemented (best effort) | `meta robots` + `X-Robots-Tag` + `robots.txt` `Disallow: /`. Robots.txt is advisory; none of these is an access control. |
| MIME sniffing | `nosniff` | — |
| Referrer leakage | `strict-origin-when-cross-origin` | No referrer sent to external HTTP origins. |
| Framing / clickjacking | `X-Frame-Options: DENY` + `frame-ancestors 'none'` | — |
| Form submission | `form-action 'none'` + no `action`/`method` in markup | Belt and braces. |
| CSP | Enforced | `script-src 'self'`; `'unsafe-inline'` allowed for styles only (Tailwind build output is a file; inline style attributes remain permitted). Verified in a real browser with zero CSP violations. |
| Cross-origin isolation | `Cross-Origin-Opener-Policy: same-origin` | — |
| Permissions | `Permissions-Policy` denies all | — |
| Authentication | **Not implemented** (intentional) | — |
| Authorization | **Not implemented** (intentional) | — |
| CSRF | Laravel default active | No write routes to protect. |
| Secrets | `.env` not committed (`.gitignore`) | `config/platform.php` contains no secrets. |

---

## 5. Remaining limitations

| ID | Limitation | Impact | Planned resolution |
| --- | --- | --- | --- |
| L1 | **No `pdo_sqlite` in the local PHP build.** Database cannot be used at all locally; session/cache/queue work around it with file/sync drivers. | Blocks any database work locally. | Enable `pdo_sqlite` (or move to PostgreSQL/PostGIS) in Milestone 2. |
| L2 | **No authentication, OTP, NID verification, or authorization.** | Prototype only; not deployable. | Milestone 2 (auth foundation) and M3. |
| L3 | **No business functionality** — no applications, blood requests, reports, benefits, or GIS. | Pages are static placeholders. | M3–M7 per roadmap. |
| L4 | **`/admin` is publicly reachable** and shows a static placeholder to anyone. Nothing is exposed because there is no data and no controls, but the route is not guarded. | Low in this prototype; unacceptable once real admin exists. | Filament with auth/policies in M2+; remove the placeholder. |
| L5 | **`robots.txt`/`noindex` are advisory.** They do not prevent access by someone who already has the URL. | Prototype could be indexed by a crawler that ignores robots.txt. | Do not publish the prototype on a public host; add HTTP auth at the host level if it must be shared. |
| L6 | **`'unsafe-inline'` in `style-src`.** Required by the current Tailwind/inline-style markup. | Weakens style-injection protection slightly (not script execution). | Move to hashed/nonce styles or external stylesheet only when adopting a component build. |
| L7 | **`upgrade-insecure-requests`** is sent on plain HTTP localhost. | Harmless locally; some browsers warn about mixed use. | Keep; review at HTTPS deployment. |
| L8 | Local server is `php artisan serve` (single-threaded dev server). | Not a production server. | Real web server in deployment milestone. |
| L9 | Documentation is in English with Bangla UI copy; Bangla documentation/translation review is still pending. | Reviewers may need translation. | Before public launch. |

---

## 6. Exact Milestone 1 status

**Milestone 1 — Project Foundation & Requirement Analysis: COMPLETE (pending review).**

| Exit criterion (`docs/development-roadmap.md` §3) | Result |
| --- | --- |
| All documentation files exist and are internally consistent | ✅ 10 documents, cross-linked |
| All five pages return HTTP 200 and are responsive | ✅ 200/200/200/200/200, verified via live HTTP and headless Chrome |
| No real authentication, OTP, NID, or business workflow exists | ✅ No write routes; forms inert; tests enforce it |
| No secrets or `.env` content are exposed | ✅ `.env` git-ignored; no secrets in tracked files |
| `npm run build` succeeds | ✅ exit code 0 |
| `composer test` succeeds | ✅ 18 passed, 96 assertions |
| Report records limitations and exact next step | ✅ this document, §5 and §7 |

**Git state:** repository initialized with commits `dcfa466` and `e74b7f2`. All Milestone 1
review fixes are present in the working tree and **not yet committed or pushed**, as
instructed.

---

## 7. Next step (not started)

**Milestone 2 — Application Foundation, Geography, and Scoped RBAC** remains *not started*.
Before it begins, resolve L1 (database driver) since every Milestone 2 task depends on a
working database. See `docs/development-roadmap.md` §4 and `docs/route-map.md` §2 for the
reserved routes.
