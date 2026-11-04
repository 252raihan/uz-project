# Phulbaria Upazila Service Platform

**ফুলবাড়ীয়া উপজেলা সেবা প্ল্যাটফর্ম** — an independent prototype for a ward-aware public service platform in Phulbaria (Fulbaria) Upazila, Mymensingh, Bangladesh.

> **Not an official government website.** This project is not operated, endorsed, or authorized by the Government of Bangladesh, Phulbaria Upazila Administration, any Union Parishad, or any public authority. No government authorization is claimed. The current build is a non-production prototype containing no real personal data.

## Project purpose

The platform is being designed to give residents one accessible, mobile-first place to:

- register as a citizen and select their union/municipality and ward;
- find services, eligibility guidance, and local institution information;
- request and offer blood donations in emergencies;
- connect with activists and volunteers;
- apply for benefit programmes and financial assistance;
- report public problems and track resolution;
- view education, health, road, infrastructure, and GIS information;
- give Union Chairmen a portal scoped to their own union and the MP an upazila-level aggregate view;
- let Super Admins manage roles, permissions, and geographic scopes without allowing privilege escalation.

The full scope and security model are documented in [`docs/`](docs/).

## Current status

| Item | Value |
| --- | --- |
| Milestone | Milestone 1 — Project Foundation & Requirement Analysis |
| Status | Complete, pending review; Milestone 2 not started |
| Application | Laravel 13.39.0 skeleton (not recreated) |
| Runtime | PHP 8.3.36 |
| Frontend in this build | Blade + Tailwind CSS v4 (static prototype) |
| Authentication | Not implemented (by design) |
| NID / OTP | Not implemented (by design) |
| Session / cache / queue | `file` / `file` / `sync` (database drivers unavailable locally — see below) |
| Database | `DB_CONNECTION=sqlite`, but the local PHP build has **no `pdo_sqlite`**; no migrations have been run |
| Production target | PostgreSQL + PostGIS, Vue 3 + TypeScript + Inertia.js, Filament (not installed yet) |

### Prototype pages

| Route | Page | State |
| --- | --- | --- |
| `/` | Public landing page | Static prototype |
| `/login` | Login page | Form inert (no `action`, no `method`); no authentication |
| `/register` | Registration page | Form inert; no data is stored or submitted |
| `/dashboard` | Citizen dashboard placeholder | Static demo data only |
| `/admin` | Admin dashboard placeholder | Static demo data only |

All pages carry a visible prototype notice, a non-official-government disclaimer, and
`noindex, nofollow`. The intended route structure, including the URL space reserved for
authentication and Filament, is documented in [`docs/route-map.md`](docs/route-map.md).

## Stack

### Installed

- **Laravel** 13.39.0 on **PHP** 8.3.36
- **Tailwind CSS** v4 with **Vite** 7
- **PHPUnit** 12 for backend tests
- **Laravel Pint** for PHP formatting
- `DB_CONNECTION=sqlite` for future database work (driver not yet available locally, see below)

### Proposed, not installed in Milestone 1

- **Vue 3** + **TypeScript** + **Inertia.js** for interactive workflows
- **PostgreSQL 16+** + **PostGIS 3.4+** for relational and spatial data
- **Filament** for the administrative back office
- `spatie/laravel-permission` for role/permission primitives, extended with custom geographic scopes
- Redis and S3-compatible storage for production-scale caching/queues and private files

Installing these is a Milestone 2 activity. See [`docs/architecture.md`](docs/architecture.md) for the proposed architecture and [`docs/development-roadmap.md`](docs/development-roadmap.md) for the sequence.

## Local setup

### Prerequisites

- PHP 8.3+ with the extensions required by Laravel
- Composer 2
- Node.js 20+ and npm
- SQLite (default) or PostgreSQL 16+ / PostGIS 3.4+ for future work

### Install and run the prototype

```powershell
# PowerShell, from the project root
composer install
if (-not (Test-Path .env)) { Copy-Item .env.example .env }
php artisan key:generate

npm install
npm run build

php artisan serve
```

Open <http://127.0.0.1:8000>.

> **Do not run `php artisan migrate` yet.** The local PHP build does not include the
> `pdo_sqlite` extension, so a migration run fails with `could not find driver`. The
> prototype does not need a database: `.env` uses `SESSION_DRIVER=file`,
> `CACHE_STORE=file` and `QUEUE_CONNECTION=sync`. `DB_CONNECTION=sqlite` is kept only for
> future database work.

For frontend hot reload, run `npm run dev` in a second terminal.

### Local run commands (verified)

| Purpose | Command |
| --- | --- |
| Start the prototype | `php artisan serve` |
| Frontend watch / build | `npm run dev` / `npm run build` |
| Tests | `composer test` |
| Code style check | `vendor\bin\pint --test` (fix with `vendor\bin\pint`) |
| Route overview | `php artisan route:list` |
| Clear caches after editing `.env` | `php artisan config:clear; php artisan cache:clear; php artisan view:clear` |

`composer dev` starts the server, queue listener (`queue:listen`), logs (`pail`), and Vite
in one process. Because `QUEUE_CONNECTION=sync` and nothing dispatches jobs, the queue
listener is idle in this prototype.

### Restoring the database drivers later

Once `pdo_sqlite` is enabled in `php.ini` (`extension=pdo_sqlite`) or PostgreSQL is
available:

1. Set `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=database`.
2. Create `database/database.sqlite` (PowerShell:
   `New-Item -ItemType File -Force database/database.sqlite`) and run `php artisan migrate`.
3. Run `php artisan config:clear` before retesting.

### Environment and secrets

- `.env` is local-only and must not be committed or shared.
- Keep `.env.example` free of real credentials.
- Do not add API keys, database passwords, SMS credentials, or NID integration secrets to source control.
- Milestone 1 does not require any external service credentials.

## Checks

```powershell
npm run build              # Vite production build
composer test              # clears config and runs the PHPUnit suite
vendor\bin\pint --test     # PHP style check (Pint)
php artisan route:list     # inspect registered routes
php artisan about          # environment summary
```

Milestone 1 results: `composer test` 18 passed / 96 assertions, `npm run build` succeeded,
`pint --test` 31 files clean, all five prototype pages return HTTP 200.

The Milestone 1 report records the commands and results in [`docs/milestone-01-report.md`](docs/milestone-01-report.md).

## Project structure

```text
app/
├── Http/Controllers/
│   └── PrototypePageController.php   # Read-only prototype page controller
├── Http/Middleware/
│   └── SecurityHeaders.php           # CSP, nosniff, referrer, frame, robots headers
config/
│   └── platform.php                  # Names, geography, demo scope (no secrets)
docs/                                 # Project documentation
resources/
├── css/app.css                       # Tailwind theme and components
├── js/app.js                         # Vite entry point
└── views/
    ├── layouts/                      # Public and portal shells
    ├── partials/                     # Brand, banner, footer
    └── prototype/                    # Five Milestone 1 pages
public/robots.txt                     # Blocks all crawlers (advisory only)
routes/web.php                        # Read-only GET routes
tests/Feature/PrototypePagesTest.php  # Smoke/access tests
tests/Feature/PrototypeFormSafetyTest.php  # Proves forms cannot submit credentials
```

The target modular-monolith code layout (`app/Modules/...`) is documented but not created yet.

## Documentation

| Document | Purpose |
| --- | --- |
| [Project overview](docs/project-overview.md) | Purpose, scope, geography, principles, non-goals |
| [Requirements](docs/requirements.md) | Functional and non-functional requirements |
| [Architecture](docs/architecture.md) | Modular monolith, stack, modules, decisions |
| [Role and permission matrix](docs/role-permission-matrix.md) | Roles, permissions, scopes, delegation rules |
| [Database design](docs/database-design.md) | Proposed entities, sensitive data, migrations |
| [Security requirements](docs/security-requirements.md) | Authorization, privacy, audit, demo safety |
| [UI/UX guidelines](docs/ui-ux-guidelines.md) | Bilingual design, accessibility, components |
| [Development roadmap](docs/development-roadmap.md) | Milestones and next steps |
| [Route map](docs/route-map.md) | Current routes, reserved auth/Filament URL space, conflicts |
| [Milestone 1 report](docs/milestone-01-report.md) | Deliverables, checks, limitations, next step |

## Security notes

- **Authorization must be server-side.** Future access decisions must combine permission, geographic scope, and record state. Hiding a link is not access control.
- **No privilege escalation.** Users may not grant permissions, roles, or geographic scopes beyond their own authority. The last Super Admin is protected.
- **Sensitive data protection.** NID, health, family, and financial information require encryption, strict access control, masking, and audit logging. These controls are not yet implemented.
- **No real NID or sensitive demo data.** Prototype and demo environments use synthetic data only. NID verification requires a lawful basis, an approved integration, and written authorization.
- **Consent and minimisation.** Collect only what a service requires, explain why, record consent versions, and define retention.
- **Audit and separation of duties.** Financial approvals will use maker-checker separation; administrative actions will be auditable.
- **No false official claims.** Do not add government emblems, seals, official portraits, `.gov.bd`-style branding, or "official portal" language without documented authorization.
- **Prototype limits.** The login and registration forms cannot submit: they have no `action` and no `method`, every data-bearing input is disabled, and the submit buttons are disabled. No credentials, personal data, or business records are stored or transmitted. This is enforced by `tests/Feature/PrototypeFormSafetyTest.php`.
- **Security headers.** Every response sends `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `X-Frame-Options: DENY`, `Cross-Origin-Opener-Policy`, a restrictive `Permissions-Policy`, a Content-Security-Policy (`default-src 'self'`, `script-src 'self'`, `frame-ancestors 'none'`, `form-action 'none'`), and `X-Robots-Tag: noindex`. `style-src` still allows `'unsafe-inline'` because the current markup uses inline styles.
- **Indexing is blocked, but only advisory.** `public/robots.txt` disallows all agents and the responses carry `noindex`; neither is an access control. Do not host this prototype on a public URL.
- **The prototype `/admin` page is publicly reachable.** It is a static placeholder with no data and no working controls, but it is not protected by authentication. Never treat it as administration.
- **No database driver locally.** `pdo_sqlite` is missing from the installed PHP build. Do not run migrations or store real data until this is resolved.
- **Deployment.** Production use requires PostgreSQL/PostGIS, environment separation, backups, monitoring, secret management, a privacy impact assessment, penetration testing, and legal review.

## Next milestone

Milestone 2 is **Application Foundation, Geography, and Scoped RBAC**: install Inertia/Vue/TypeScript and PostgreSQL/PostGIS, add geographic and authorization schemas, implement scoped roles/policies with audit baseline, and keep the prototype pages working. It has not been started. See [`docs/development-roadmap.md`](docs/development-roadmap.md) for the exact scope and acceptance criteria.

## Repository status

Git is initialized and the repository has existing milestone commits (`dcfa466`, `e74b7f2`).
The Milestone 1 review fixes are present in the working tree and have **not** been committed
or pushed. Nothing has been published or deployed.

Do not publish or deploy this prototype as an official service.
