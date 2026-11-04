# Security Requirements

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform |
| Document | Security and privacy requirements |
| Version | 0.1 (Milestone 1 baseline) |
| Last updated | 4 November 2026 |
| Status | Design baseline; controls referenced are not implemented in the Milestone 1 prototype |

---

## 1. Objectives

The platform will handle identity attributes, health-related donor information, family details, financial assistance records, and location data. A breach could cause serious harm: exposure of NID data, financial hardship information, health conditions, household composition, or the location of vulnerable people. Security is therefore a first-class functional requirement, not a later hardening task.

The core objectives are:

1. Enforce **role and geographic scope** on the server for every request.
2. Prevent **privilege escalation** and unauthorized delegation.
3. Protect **NID, health, family, and financial information** throughout its lifecycle.
4. Keep **prototype and demo environments free of real sensitive data**.
5. Maintain **auditable, accountable** administrative and sensitive operations.
6. Apply **data minimisation and consent** principles.
7. Never falsely claim **official government authorization**.

## 2. Scope and assumptions

This document covers application security, data protection, and privacy controls for the platform. It assumes:

- The platform is not yet an authorized government service.
- Production hosting, identity providers, SMS gateways, and legal agreements are not yet selected.
- Legal review is required before processing real personal data or integrating with any government registry.
- The current prototype is a static, unauthenticated Blade UI with no persistent data or external integrations.

## 3. Threat model

### 3.1 Trust boundaries

| Boundary | Risk |
| --- | --- |
| Public internet to application | Anonymous abuse, credential attacks, scraping, injection |
| Citizen session to API | IDOR, CSRF, session theft, scope tampering |
| Union staff to other unions | Cross-union data access, parameter tampering |
| Delegated admin to roles | Privilege escalation, hidden permission grants |
| Application to database | Over-broad queries, leaked secrets in logs, backup exposure |
| Application to file storage | Unauthorized document retrieval, malware upload |
| Application to external services | Data leakage, provider compromise, unclear legal basis |
| Admin (Filament) to domain | Authorization bypass, unrestricted model access |

### 3.2 STRIDE summary

| Threat | Example | Primary mitigation |
| --- | --- | --- |
| Spoofing | Stolen citizen credentials; fake admin account | Strong password hashing, MFA for privileged roles, session controls, account alerts |
| Tampering | Changing `geographic_unit_id` in a request; modifying approval records | Server-side validation, scoped queries, append-only history, database constraints |
| Repudiation | Denying a role grant or financial approval | Immutable audit events with actor, reason, and timestamp |
| Information disclosure | Cross-union report access; NID in logs; public document URLs | Backend authorization, field masking, redaction, private storage, signed URLs |
| Denial of service | Report/OTP/upload flooding; expensive GIS queries | Rate limits, quotas, bounded spatial queries, queueing |
| Elevation of privilege | Delegating a permission the actor lacks; self-assigning Super Admin | Delegation invariants, protected roles, last-admin guard, audit, tests |
| Supply chain | Vulnerable Composer/npm package | Lockfiles, version review, dependency scanning, least-privilege CI tokens |

## 4. Authorization requirements

| ID | Requirement |
| --- | --- |
| SEC-AUTHZ-01 | Every request, including page loads, API calls, exports, and admin panel actions, must be authorized in the backend. Client-side hiding is never sufficient. |
| SEC-AUTHZ-02 | Authorization must combine permission, geographic scope, and record state (for example, active/withdrawn). |
| SEC-AUTHZ-03 | Geographic scope must be resolved from active role assignments in the backend, not from client-supplied ward/union IDs. |
| SEC-AUTHZ-04 | All list, search, count, aggregate, export, and download endpoints must apply scope filters before returning results. |
| SEC-AUTHZ-05 | Direct object access must be protected against IDOR for every record type. |
| SEC-AUTHZ-06 | A user with multiple roles receives only the union of grants, each bounded by its own scope; permissions must never merge scopes. |
| SEC-AUTHZ-07 | Expired, revoked, suspended, or future-dated assignments must not grant access. |
| SEC-AUTHZ-08 | Revocation must take effect on the next request; high-risk changes must invalidate sessions/caches within a documented interval. |
| SEC-AUTHZ-09 | Admin panels (including Filament) must use the same domain policies and scoped queries as public/citizen code. |
| SEC-AUTHZ-10 | Unauthorized access attempts must return a generic error and be logged without sensitive payloads. |
| SEC-AUTHZ-11 | The final active Super Admin cannot be removed, deactivated, or stripped of the role through any path. |
| SEC-AUTHZ-12 | System roles and permissions are protected from destructive or escalating edits. |

### 4.1 Delegation requirements

| ID | Requirement |
| --- | --- |
| SEC-DEL-01 | An actor may grant only permissions they currently hold. |
| SEC-DEL-02 | An actor may grant only roles whose permissions are a subset of their own grantable permissions. |
| SEC-DEL-03 | An actor may assign only geographic scopes equal to or narrower than their own. |
| SEC-DEL-04 | Self-escalation is prohibited: actors cannot modify their own roles, permissions, or scope. |
| SEC-DEL-05 | A custom role cannot include a protected permission unless granted by a Super Admin under a documented review. |
| SEC-DEL-06 | High-risk grants, revocations, and scope changes require a reason and a separate audit event. |
| SEC-DEL-07 | Delegation chains are recorded; an actor cannot launder authority through an intermediate account. |
| SEC-DEL-08 | Delegations may be time-bound and automatically expire. |

## 5. Sensitive data protection

### 5.1 Data classification

| Class | Examples | Handling |
| --- | --- | --- |
| Public | Service descriptions, public institution names, aggregate statistics above threshold | May be public; provenance still required |
| Internal | Non-public operational notes, draft content, assignment metadata | Authenticated, scoped access |
| Confidential | Citizen contact details, ward-level case information, volunteer records | Least privilege, masking, access logging |
| Restricted | NID, health/donor eligibility, family details, financial records, documents, audit logs | Explicit access, encryption, strong audit, no bulk exposure |
| Secrets | Database passwords, API keys, signing keys | Secret storage only; never in source, logs, screenshots, or client bundles |

### 5.2 NID requirements

| ID | Requirement |
| --- | --- |
| SEC-NID-01 | No real NID may be collected or stored in prototype, demo, or development environments. |
| SEC-NID-02 | NID collection is disabled until a lawful basis, approved integration, and written authorization exist. |
| SEC-NID-03 | When enabled, store a keyed hash for duplicate detection and an encrypted value; never store plaintext. |
| SEC-NID-04 | Display only a masked form (for example, last four digits) and only to roles with an explicit need. |
| SEC-NID-05 | NID must never appear in logs, analytics, error reports, URLs, notification bodies, or exports. |
| SEC-NID-06 | NID access/reveal actions are separately logged with purpose and authorization basis. |
| SEC-NID-07 | Verification documents, if any, are stored privately with short retention and strict access. |

### 5.3 Health and family data

- Blood group/availability is shown only under the donor's opt-in preferences; contact details are never public by default.
- Donor eligibility notes must not contain diagnoses or detailed medical history.
- Household/family fields are restricted and collected only where a service requires them.
- Health facility records are institutional/public data only; patient data is out of scope.
- Internal notes containing health/family details must be excluded from applicant-facing responses and logs.

### 5.4 Financial data

- Financial records use integer minor units, restricted tables, and masked display.
- Internal assessment notes are never returned to applicants.
- Maker-checker separation is mandatory; the same actor cannot prepare, assess, and approve the same request.
- Approval thresholds are enforced server-side and audited.
- Bulk exports require a specific permission, stated purpose, expiry, and audit.
- Financial data is excluded from small aggregate groups and public dashboards.

### 5.5 Encryption

| Layer | Requirement |
| --- | --- |
| Transit | TLS 1.2+ (TLS 1.3 preferred); HSTS in production; secure cookies |
| Database | Encrypted volumes/managed encryption at rest |
| Field level | Application-level encryption for NID, financial notes, and other high-risk fields where justified; envelope encryption with key rotation |
| Backups | Encrypted, access-controlled, restore-tested |
| Files | Private storage with server-side encryption and signed, short-lived access |
| Secrets | Managed secret store/environment with rotation; never committed to Git |

## 6. Authentication and session security

These controls apply when authentication is implemented in Milestone 2/3.

| ID | Requirement |
| --- | --- |
| SEC-AUTHN-01 | Passwords are hashed with Argon2id or bcrypt using a current work factor; plaintext or reversible storage is prohibited. |
| SEC-AUTHN-02 | Mobile/email verification uses single-use, short-lived, rate-limited OTPs stored as hashes. |
| SEC-AUTHN-03 | OTP attempts are limited; repeated failures trigger temporary lockout and alerting. |
| SEC-AUTHN-04 | Privileged accounts require MFA before production use. |
| SEC-AUTHN-05 | Password reset tokens are single-use, expiring, and invalidated after use. |
| SEC-AUTHN-06 | Session identifiers are rotated on login and privilege change; cookies are `Secure`, `HttpOnly`, and `SameSite=Lax` or stricter. |
| SEC-AUTHN-07 | Sessions have idle and absolute timeouts appropriate to role sensitivity. |
| SEC-AUTHN-08 | Concurrent session limits or alerts are available for privileged accounts. |
| SEC-AUTHN-09 | Login, OTP, reset, and MFA endpoints are rate-limited per IP and per account. |
| SEC-AUTHN-10 | Authentication errors do not reveal whether an account exists. |
| SEC-AUTHN-11 | No shared or generic administrator accounts are permitted. |
| SEC-AUTHN-12 | Accounts are locked or challenged after repeated failures, with a recovery process. |

## 7. Application security

| ID | Requirement |
| --- | --- |
| SEC-APP-01 | CSRF protection is enabled for all state-changing browser requests. |
| SEC-APP-02 | Output is escaped by default; raw HTML rendering is allow-listed and sanitized. |
| SEC-APP-03 | Database access uses parameterized queries/ORM bindings; raw SQL is reviewed. |
| SEC-APP-04 | Mass assignment is restricted with explicit fillable/guarded attributes and form requests. |
| SEC-APP-05 | File uploads validate content type, extension, size, and malware where available; metadata is stripped. |
| SEC-APP-06 | Uploaded files are private by default and served only after authorization, via short-lived URLs. |
| SEC-APP-07 | Server-side request forgery protections apply to URL fetches and integrations. |
| SEC-APP-08 | Security headers: CSP, frame-ancestors, `X-Content-Type-Options: nosniff`, referrer policy, and HSTS in production. |
| SEC-APP-09 | Error pages in production do not reveal stack traces, SQL, secrets, or internal paths. |
| SEC-APP-10 | Logs redact passwords, OTPs, tokens, NID, financial details, and health/family data; correlation IDs are used instead of PII. |
| SEC-APP-11 | Rate limits and quotas apply to public forms, report submission, blood requests, uploads, and search. |
| SEC-APP-12 | Dependencies and container images are scanned; lockfiles are committed; critical vulnerabilities block release. |
| SEC-APP-13 | A Content Security Policy is deployed and tested; inline scripts are minimized. |
| SEC-APP-14 | Administrative actions use POST/DELETE with CSRF protection, not state-changing GET requests. |
| SEC-APP-15 | API and web routes share the same authorization layer; no hidden debug routes in production. |
| SEC-APP-16 | Debug mode is disabled in production; verbose errors are restricted to local development. |

## 8. Audit logging

### 8.1 Events to log

- authentication success/failure, logout, MFA changes, password reset;
- role, permission, scope, and delegation changes;
- access to NID, financial, health/family, and sensitive documents;
- financial assessment/approval/disbursement transitions;
- benefit application decisions;
- report assignment/closure and internal-note access;
- bulk exports and downloads;
- break-glass access and high-risk settings changes;
- failed authorization above a threshold;
- data import/export and retention/deletion jobs.

### 8.2 Log content and protection

| ID | Requirement |
| --- | --- |
| SEC-AUD-01 | Audit events include actor, action, target, scope, timestamp, result, request ID, IP hash/user agent where appropriate, and redacted before/after values. |
| SEC-AUD-02 | Audit events are append-only; the application database role cannot update or delete them. |
| SEC-AUD-03 | Audit logs are readable only by Auditor/Super Admin roles with scoped, read-only access. |
| SEC-AUD-04 | Logs must not contain NID, OTPs, passwords, tokens, full financial details, or sensitive free text. |
| SEC-AUD-05 | Time synchronization (UTC) and retention are documented; exports are integrity-protected. |
| SEC-AUD-06 | Audit records are included in backup and incident-response procedures. |
| SEC-AUD-07 | Routine access is logged at a level that supports investigation without creating a privacy-invasive surveillance record. |

Proposed minimum retention: 12 months for security/audit events, longer where legal or financial rules require. Final values require legal review.

## 9. Consent and data minimisation

| ID | Requirement |
| --- | --- |
| SEC-PRIV-01 | Each data collection point states purpose, required/optional status, recipients, and retention in plain Bangla and English. |
| SEC-PRIV-02 | Consent is specific, informed, recorded with document version and time, and withdrawable where the lawful basis allows. |
| SEC-PRIV-03 | Withdrawal stops future processing but does not erase records that must be retained for legal/audit reasons; this must be explained. |
| SEC-PRIV-04 | Only data necessary for the service is collected; optional fields are clearly marked. |
| SEC-PRIV-05 | Data is not reused for unrelated analytics, political profiling, advertising, or automated decisions without a lawful basis and transparency. |
| SEC-PRIV-06 | Citizens can request access to and correction of their own data through a documented process. |
| SEC-PRIV-07 | Deletion/retention jobs are documented, tested, and produce aggregate (not personal) evidence. |
| SEC-PRIV-08 | Aggregate dashboards suppress small groups (initial threshold: 10) and avoid reconstructing suppressed values. |
| SEC-PRIV-09 | Data sharing with any third party requires a written agreement, legal basis, minimum fields, and audit. |
| SEC-PRIV-10 | No real sensitive data is used in demos, screenshots, tests, or training materials. |

## 10. Prototype and demo safety

| ID | Requirement |
| --- | --- |
| SEC-DEMO-01 | The prototype must display a persistent, visible notice that it is not an official government website. |
| SEC-DEMO-02 | Prototype forms must not send or persist real personal data; disabled actions must explain their status. |
| SEC-DEMO-03 | Demo data must be synthetic and clearly labelled. No real NID, health, family, financial, or contact data. |
| SEC-DEMO-04 | Do not use government emblems, seals, official portraits, or `.gov.bd`-style branding. |
| SEC-DEMO-05 | Demo environments must be isolated from production secrets and data. |
| SEC-DEMO-06 | Seeders must refuse to run in production unless explicitly and safely overridden for synthetic demo data. |
| SEC-DEMO-07 | Public prototype pages should be `noindex` until approval to publish. |

## 11. Claims and public trust

The platform must not:

- state or imply that it is operated, endorsed, or authorized by the Government of Bangladesh, any ministry, the Upazila Administration, a Union Parishad, or an MP unless written authorization exists;
- use the national emblem, government seal, official flag treatment, or a deceptive domain name;
- present prototype data as official records;
- imply that a submitted application creates a legal entitlement;
- use titles such as "official portal" without documented authorization.

Required wording is maintained in the public layout and repeated in the README and project documentation. If authorization is later granted, the wording, branding, legal notices, and ownership must be updated through a documented review.

## 12. Operational security

| ID | Requirement |
| --- | --- |
| SEC-OPS-01 | Separate development, staging, and production environments; production data is never copied to development. |
| SEC-OPS-02 | Least-privilege database and storage credentials per environment. |
| SEC-OPS-03 | Secrets are injected at deploy time, rotated, and never logged or committed. |
| SEC-OPS-04 | Backups are encrypted, tested for restore, and access-controlled. |
| SEC-OPS-05 | Dependency and OS patches are applied on a defined schedule; critical patches are expedited. |
| SEC-OPS-06 | Administrative access to servers uses MFA and is audited. |
| SEC-OPS-07 | Access reviews occur periodically for privileged roles and production credentials. |
| SEC-OPS-08 | A vulnerability disclosure contact and process are published before production. |
| SEC-OPS-09 | A data breach response plan includes containment, assessment, notification, and post-incident review. |
| SEC-OPS-10 | Logging and monitoring cover authentication anomalies, authorization failures, export activity, and job failures. |

## 13. Secure development and verification

- Threat model reviewed at each milestone.
- Authorization tests are mandatory for every new endpoint and role.
- Static analysis, dependency audits, and secret scanning run in CI.
- A pre-release checklist covers OWASP Top 10 and ASVS Level 2 controls.
- Penetration testing is required before handling real citizen data.
- Privacy impact assessment is required before NID, health, family, or financial processing goes live.
- Accessibility and security reviews include the Filament admin panel.
- Incident tabletop exercises are conducted before launch.

## 14. Requirements traceability

| Milestone | Security work |
| --- | --- |
| M1 | Documentation, prototype disclaimers, no real data, read-only routes, `noindex` prototype pages, secret hygiene |
| M2 | Authentication foundation, geographic scope, role assignments, policy layer, audit baseline, security headers, CSRF, rate limits |
| M3 | OTP/NID design (not necessarily live), session hardening, MFA for admins, audit immutability, data access logs |
| M4 | Donor/volunteer privacy, contact relay, notification redaction, file access controls |
| M5 | Benefit/financial maker-checker, field-level protections, export controls, retention jobs |
| M6 | Report media security, GIS import validation, financial disbursement controls, aggregate privacy |
| M7 | MP/Chairman dashboard privacy thresholds, map data governance, export review |
| M8 | Penetration test, privacy impact assessment, backup/restore test, incident readiness, production hardening |

## 15. Milestone 1 security status

Implemented in the prototype:

- persistent non-official notice on every page;
- clearly labelled prototype actions;
- disabled login/registration submission;
- read-only GET routes with no auth POST endpoints;
- `noindex, nofollow` meta on prototype pages;
- no database writes, no real personal data, no external integrations;
- no secrets added to source; `.env` remains untracked.

Not yet implemented (by design):

- authentication, OTP, NID verification, RBAC, scope enforcement, audit logging;
- security headers middleware, CSP, rate limiting, file-upload controls;
- PostgreSQL/PostGIS, encryption, private storage, backups;
- MFA, account recovery, incident tooling.

The prototype must not be presented as secure or production-ready. Milestone 2 begins the authorization and data-protection foundation.
