# Route Map — Milestone 1 and Intended Future Structure

| Field | Value |
| --- | --- |
| Milestone | Milestone 1 — Project Foundation & Requirement Analysis |
| Document status | Current routes (implemented) + reserved future structure (not implemented) |
| Last reviewed | 2026-11-04 |
| Authentication / Filament | **Not installed.** No auth scaffolding, no Filament panel. |

This document records the routes that exist today, and reserves the URL space that
Laravel authentication and Filament will need later, so Milestone 2+ does not have to
break existing links or rename routes.

---

## 1. Implemented routes (Milestone 1)

All prototype routes are **read-only `GET` pages**. There are no `POST`, `PUT`,
`PATCH`, or `DELETE` routes in the application. The only framework-registered
write route is Laravel's built-in local storage server, `PUT /storage/{path}`,
which serves files from `storage/app/public` through the `local` disk and is not
used by this prototype.

| Method | URI | Route name | Controller action | View | Status |
| --- | --- | --- | --- | --- | --- |
| GET | `/` | `home` | `PrototypePageController@home` | `prototype.home` | Static prototype |
| GET | `/login` | `prototype.login` | `PrototypePageController@login` | `prototype.login` | Form disabled, non-functional |
| GET | `/register` | `prototype.register` | `PrototypePageController@register` | `prototype.register` | Form disabled, non-functional |
| GET | `/dashboard` | `prototype.citizen.dashboard` | `PrototypePageController@citizenDashboard` | `prototype.dashboard` | Static placeholder |
| GET | `/admin` | `prototype.admin.dashboard` | `PrototypePageController@adminDashboard` | `prototype.admin` | Static placeholder |
| GET | `/up` | `(none)` | Laravel health check | — | Framework built-in |

### Why these names

* The `prototype.` prefix marks every route and view that is throwaway UI scaffolding.
  When real screens arrive in Milestone 3+, they get new names (e.g. `dashboard`)
  and these prototype routes are removed in a single diff.
* The framework's conventional names `login`, `register`, `password.request`,
  `password.reset`, `verification.notice`, `logout`, `dashboard`, and `profile.*`
  are **deliberately not used**, so `php artisan route:list` shows no reserved name
  is already taken when authentication is installed.

---

## 2. Reserved URL space (not implemented yet)

Nothing below exists today. It is documented so future work lands in a predictable
place. **Do not create these routes in Milestone 1.**

### 2.1 Laravel authentication scaffolding (planned, later milestone)

Installing `php artisan make:auth`-style scaffolding (Laravel Fortify/Breeze or a
custom implementation) will claim these names by default. The prototype already
avoids them.

| Method | URI | Reserved name | Owner |
| --- | --- | --- | --- |
| GET | `/login` | `login` | Auth scaffolding |
| POST | `/login` | `(login)` | Auth scaffolding |
| POST | `/logout` | `logout` | Auth scaffolding |
| GET | `/register` | `register` | Auth scaffolding |
| POST | `/register` | `(register)` | Auth scaffolding |
| GET | `/forgot-password` | `password.request` | Auth scaffolding |
| POST | `/forgot-password` | `password.email` | Auth scaffolding |
| GET | `/reset-password/{token}` | `password.reset` | Auth scaffolding |
| POST | `/reset-password` | `password.store` | Auth scaffolding |
| GET | `/verify-email` | `verification.notice` | Auth scaffolding |
| GET | `/confirm-password` | `password.confirm` | Auth scaffolding |

**Conflict:** `/login` and `/register` are currently the prototype pages. When auth
scaffolding is installed these two URIs are reused by real GET/POST routes and the
prototype `GET` routes must be deleted in the same change. Because the prototype
forms cannot submit, nothing in the current UI depends on those URIs behaving
like the prototype.

### 2.2 Authenticated citizen area (planned, Milestone 3+)

| Method | URI | Proposed name | Middleware |
| --- | --- | --- | --- |
| GET | `/dashboard` | `dashboard` | `auth`, `verified` |
| GET/POST | `/profile` | `profile.edit` / `profile.update` | `auth` |
| GET | `/profile/privacy` | `profile.privacy` | `auth` |
| Resource | `/applications` | `applications.*` | `auth`, scope policy |
| Resource | `/blood-requests` | `blood-requests.*` | `auth`, scope policy |
| Resource | `/problem-reports` | `reports.*` | `auth`, scope policy |

`/dashboard` currently serves the prototype placeholder and will be taken over by
the authenticated citizen dashboard.

### 2.3 Administration — Filament (planned, only after authorization is proven)

Filament's panel path is **reserved as `/admin`** for the future back office. The
prototype `/admin` placeholder must therefore be removed (or moved) when Filament is
installed.

| Item | Decision |
| --- | --- |
| Filament panel path | `/admin` (reserved — do not build permanent features on it) |
| Filament route name prefix | `filament.admin.` (Laravel's default Filament panel names) |
| Access control | Filament resources must call the same policies/scoped queries as citizen code |
| Installation timing | After the scoped RBAC foundation (see `docs/development-roadmap.md`) |
| Current state | **Not installed**; prototype `/admin` is a static, unauthorized placeholder |

### 2.4 Public / API (planned)

| Method | URI | Proposed name | Notes |
| --- | --- | --- | --- |
| GET | `/` | `home` | Permanent public landing page |
| GET | `/services/{slug}` | `services.show` | Service catalogue (M5) |
| GET | `/institutions` | `institutions.index` | Education/health directory (M6) |
| GET | `/map` | `map.index` | GIS layers (M6–M7) |
| API | `/api/v1/...` | `api.v1.*` | Reserved namespace; no API exists today |

---

## 3. Rules for adding routes

1. **No write routes for prototype pages.** The login and registration forms must stay
   inert (no `action`, no `method`, disabled fields) and be covered by
   `tests/Feature/PrototypeFormSafetyTest.php`.
2. **Never take a framework-reserved name** (`login`, `register`, `logout`, `dashboard`,
   `password.*`, `verification.*`) until the real implementation replaces it.
3. **Reserve `/admin` for Filament.** Do not build features that assume the prototype
   admin placeholder is permanent.
4. **Group by area and prefix** once more than one controller exists:
   `routes/web.php` (public), `routes/auth.php` (auth, when installed),
   `routes/citizen.php`, `routes/admin.php`, `routes/api.php`.
5. **Name every route.** Untitled URIs make link maintenance and tests fragile.
6. **Middleware is the access control**, never the menu. Future `auth`, `verified`,
   and scope middleware must be verified by feature tests.

---

## 4. Overview of the conflict analysis

| Reserved by future work | Prototype uses it now | Resolution |
| --- | --- | --- |
| `login` / `register` route names | `prototype.login` / `prototype.register` | No conflict — prototype uses a `prototype.` prefix |
| `login` / `register` URIs | `GET /login`, `GET /register` | Prototype GET routes are deleted when auth is added |
| `dashboard` name and URI | `prototype.citizen.dashboard` at `GET /dashboard` | Name is free; URI is taken over by the real dashboard |
| Filament `/admin` panel | `GET /admin` placeholder | Placeholder is removed when Filament is installed |
| `/up` health endpoint | Framework built-in | Keep; do not repurpose |

No conflicts exist in the current build. Filament and authentication scaffolding are
**not installed**, as required for Milestone 1.
