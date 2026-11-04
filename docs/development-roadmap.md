# Development Roadmap

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform |
| Current milestone | Milestone 1 — Project Foundation & Requirement Analysis |
| Status | Milestone 1 delivered; Milestone 2 not started |
| Last updated | 4 November 2026 |

---

## 1. Delivery principles

- Deliver in small, reviewable milestones with explicit acceptance criteria.
- Do not claim a milestone complete until its checks and documentation are updated.
- Keep the prototype and production data separated at all times.
- Implement authorization and privacy controls before exposing a module to real users.
- No real NID, health, family, or financial data until legal review and formal authorization.
- Every milestone ends with a report in `docs/`.

## 2. Milestone sequence

| Milestone | Focus | Status |
| --- | --- | --- |
| M1 | Project foundation, documentation, responsive prototype | Complete |
| M2 | Application foundation, geography, scoped RBAC, audit baseline | Not started |
| M3 | Citizen registration, OTP, verification design, session hardening | Not started |
| M4 | Blood donor directory, emergency requests, volunteers | Not started |
| M5 | Benefit programmes and financial assistance workflows | Not started |
| M6 | Public reports, institutions, infrastructure, GIS data | Not started |
| M7 | Chairman and MP portals, aggregate dashboards, public maps | Not started |
| M8 | Hardening, accessibility/security audits, UAT, deployment readiness | Not started |
| M9 (optional) | Controlled pilot with formal authorization and operational handover | Not started |

Dates are intentionally not fixed until the operating authority, team capacity, and legal prerequisites are confirmed.

## 3. Milestone 1 — Project Foundation & Requirement Analysis

### Goal

Establish a documented, testable foundation and a bilingual UI prototype without implementing authentication or business features.

### Completed deliverables

- Project overview, requirements, architecture, role/permission matrix, database design, security requirements, UI/UX guidelines, roadmap, route map, and milestone report.
- Laravel routes and a prototype controller for five read-only pages.
- Responsive Blade + Tailwind prototype: landing, login, registration, citizen dashboard placeholder, admin dashboard placeholder.
- Persistent non-official-government disclaimer and prototype labels.
- Prototype login and registration forms that cannot submit (no `action`, no `method`, disabled fields) with regression tests.
- Baseline security headers (nosniff, referrer policy, frame restrictions, CSP) and `robots.txt` / `X-Robots-Tag` indexing blocks.
- Smoke tests for all five pages.
- README with stack, setup, status, and security notes.
- Build and test verification.

### Exit criteria

- All nine documentation files exist and are internally consistent.
- All five pages return HTTP 200 and are responsive.
- No real authentication, OTP, NID, or business workflow exists.
- No secrets or `.env` content are exposed.
- `npm run build` succeeds.
- `composer test` succeeds.
- The report records limitations and the exact next step.

## 4. Milestone 2 — Application Foundation, Geography, and Scoped RBAC

**Do not start this milestone until Milestone 1 is reviewed and approved.**

### Goal

Turn the static prototype into a secure, data-backed foundation with real geographic scope enforcement and an auditable RBAC system. No citizen business workflows yet.

### Scope

1. **Frontend foundation**
   - Install Inertia.js, Vue 3, TypeScript, and the Vue Vite plugin.
   - Configure a typed Inertia entry point and preserve the current bilingual design.
   - Convert shared layouts to Vue or use Inertia with Blade shells, documenting the decision.
   - Add `npm run typecheck` and keep `npm run build` green.

2. **Database foundation**
   - Provision PostgreSQL 16+ with PostGIS locally (Docker Compose or documented native setup).
   - Configure separate local/test databases and keep SQLite only for legacy smoke tests if useful.
   - Add migrations for `geographic_units`, `citizen_profiles`, `consents`, `role_assignments`, and audit baseline.
   - Seed only synthetic/admin demo data and public geographic names; no boundary geometry unless sourced.

3. **Authentication foundation**
   - Install and configure Laravel authentication without NID/OTP.
   - Keep registration disabled or limited to invited test accounts until M3.
   - Add session security, password hashing configuration, CSRF, and rate limiting.
   - Extend the existing security headers middleware (`App\Http\Middleware\SecurityHeaders`) rather than adding a second one.
   - Keep `noindex` for non-public environments.
   - Replace the prototype `GET /login` and `GET /register` pages with the real `login`/`register` routes (see [route-map.md](route-map.md)).

4. **Authorization foundation**
   - Install `spatie/laravel-permission` or implement equivalent primitives.
   - Implement geographic scope resolution and the delegation invariants from [role-permission-matrix.md](role-permission-matrix.md).
   - Add policies for at least: own profile, scoped citizen lookup, role management, and audit viewing.
   - Block privilege escalation, self-escalation, and last-Super-Admin removal.
   - Add feature tests for same-union, cross-union, cross-upazila, IDOR, and delegation attempts.

5. **Audit baseline**
   - Add append-only audit events for authentication, role/permission changes, and sensitive reads.
   - Add redaction rules and request correlation IDs.
   - Ensure audit logs never contain passwords, OTPs, tokens, NID, or financial details.

6. **Admin foundation**
   - Install Filament only after the authorization layer is stable, and take over the reserved `/admin` path (see [route-map.md](route-map.md)).
   - Build a minimal geography and role-assignment admin panel with policy enforcement.
   - Verify Filament cannot bypass geographic scope.

### Acceptance criteria

- PostgreSQL/PostGIS is the local development database; PostgreSQL-specific tests run in CI or a documented local command.
- A citizen can authenticate and view only their own placeholder profile.
- A Union Chairman fixture can access only their union's placeholder records; cross-union access returns 403.
- A delegated manager cannot grant a permission or scope they do not hold.
- Role changes create audit records and invalidate authorization caches.
- The last active Super Admin cannot be removed.
- `composer test`, `npm run build`, and the new `npm run typecheck` pass.
- No real NID, health, family, or financial data is present.

### Suggested first commands (for the next session; do not run in Milestone 1)

```bash
composer require inertiajs/inertia-laravel
npm install vue @vitejs/plugin-vue @inertiajs/vue3 typescript
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

These commands must be preceded by a compatibility review, a backup of `composer.lock`/`package-lock.json`, and a documented decision about versions. Filament and PostgreSQL setup should follow the authorization foundation, not lead it.

### Out of scope for M2

- OTP, NID verification, and real citizen onboarding.
- Blood, volunteer, benefit, financial, report, institution, and GIS workflows.
- Public maps and aggregate dashboards.
- Production deployment or real user data.

## 5. Milestone 3 — Citizen Registration and Verification

### Scope

- Dynamic geographic cascade in Vue using M2 geography data.
- Mobile OTP verification (if an approved provider is selected).
- NID verification design and, only with legal authorization, a controlled integration.
- Consent capture, privacy notice versioning, account activation, password reset.
- Session hardening, MFA for privileged accounts, data access logging.
- Citizen can view/update own profile and request correction.

### Exit criteria

- No account activates without consent and phone verification.
- NID fields are absent unless a lawful, authorized flow is enabled.
- Registration is tested for tampering, duplicate accounts, and rate limits.
- Sensitive fields never appear in logs or notifications.

## 6. Milestone 4 — Blood and Volunteers

### Scope

- Donor opt-in, availability, eligibility intervals, and privacy-preserving contact relay.
- Emergency blood requests, matching, responses, expiry, and outcome tracking.
- Volunteer application, verification, assignments, and completion records.
- In-app notifications and redacted SMS/email templates.

### Exit criteria

- Donors can withdraw and are removed from matching immediately.
- Contact details are never public or logged.
- Chairman/verifier actions are union-scoped and audited.
- Blood compatibility and eligibility tests pass.

## 7. Milestone 5 — Benefits and Financial Assistance

### Scope

- Programme catalogue with scopes, eligibility summaries, and document requirements.
- Benefit applications, private uploads, status history, review, and decisions.
- Financial assistance intake, assessment, maker-checker approvals, thresholds, and disbursements.
- Retention jobs and export controls.

### Exit criteria

- A reviewer cannot be the approver.
- Threshold escalation is enforced server-side.
- Documents are private and access-logged.
- Applicant-facing views redact internal notes and financial details.

## 8. Milestone 6 — Public Reports, Institutions, Infrastructure, and GIS

### Scope

- Problem reports with categories, approximate location, photos, triage, and resolution evidence.
- Education and health institution directories with provenance.
- Road/infrastructure asset register and maintenance history.
- PostGIS schema, imports, validation, and spatial indexes.
- Financial disbursement completion and reporting.

### Exit criteria

- Report locations are approximate in public views and reporter identity is protected.
- Invalid geometries are rejected with clear errors.
- Institution/asset records show source and verification status.
- Scope-bounded spatial queries pass performance tests.

## 9. Milestone 7 — Chairman and MP Portals, Public Maps

### Scope

- Union-scoped chairman dashboard with queues, reports, applications, volunteers, and counts.
- Upazila aggregate MP dashboard with small-cell suppression and data definitions.
- Public GIS layers, accessible map alternatives, and aggregate reporting.
- Cross-union comparison only where explicitly permitted and privacy-safe.

### Exit criteria

- Chairman sees no cross-union records by any route, count, or export.
- MP cannot identify individuals; groups below the threshold are suppressed.
- Maps have list alternatives and freshness labels.

## 10. Milestone 8 — Hardening and Deployment Readiness

### Scope

- Accessibility audit, performance/load testing, penetration test, privacy impact assessment.
- Backup/restore tests, monitoring, alerting, incident response, retention enforcement.
- UAT with representative users and staff.
- Deployment pipeline, environment separation, secret management, and runbooks.

### Exit criteria

- Critical/high security findings are closed.
- WCAG 2.2 AA issues are closed or formally accepted.
- Restore and incident drills are documented.
- No production launch until ownership and authorization are documented.

## 11. Milestone 9 (optional) — Authorized Pilot

Only after formal written authorization, legal review, data-sharing agreements, and operational ownership:

- controlled pilot in one or more unions;
- onboarding and training;
- service-level and support model;
- monitoring and feedback loop;
- public communication that accurately describes the platform's status.

## 12. Risks and dependencies

| Risk | Likelihood | Impact | Mitigation |
| --- | --- | --- | --- |
| No government authorization/ownership | Medium | High | Keep independent prototype status explicit; plan formal engagement |
| NID integration unavailable or unlawful | Medium | High | Design verification as optional; do not depend on it for core access |
| Geographic boundary data unavailable | High | Medium | Launch with names and ward selection; add geometry only from authoritative sources |
| Scope bugs cause data exposure | Medium | Critical | Central scope service, tests, code review, pen testing |
| Small team and competing priorities | High | Medium | Milestone gating, narrow scope, no premature features |
| Bangla translation/accessibility quality | Medium | Medium | Native review and accessibility audit before launch |
| SMS/email costs and delivery | Medium | Medium | Provider abstraction, opt-in, retries, cost monitoring |
| Data protection legal uncertainty | Medium | High | Legal review before real data; minimise collection |
| Prototype mistaken for official service | Medium | High | Persistent disclaimers, no official marks, `noindex` |

## 13. Immediate next step

After Milestone 1 review and approval, begin **Milestone 2** with a short inception checklist:

1. Record the approved architecture decisions and dependency versions.
2. Create a local PostgreSQL/PostGIS environment and run the existing test suite against it.
3. Install Inertia/Vue/TypeScript and preserve the five prototype pages.
4. Implement geography, consents, scoped role assignments, audit baseline, and authorization tests.
5. Add Filament only after policy enforcement is proven.

Do not start Milestone 2 in this delivery.
