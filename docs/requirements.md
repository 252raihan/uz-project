# Requirements Specification

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform |
| Document | Functional and non-functional requirements |
| Version | 0.1 (Milestone 1 baseline) |
| Last updated | 4 November 2026 |
| Status | Baseline for prototyping; subject to stakeholder validation |

The requirement IDs below are stable references for design, implementation, and testing. Priority uses MoSCoW: **Must**, **Should**, **Could**. Milestone references point to the delivery plan in [development-roadmap.md](development-roadmap.md). No requirement in this document authorizes the collection of real sensitive data in the current prototype.

---

## 1. Actors

| Actor | Description |
| --- | --- |
| Guest | Unauthenticated visitor using public information |
| Citizen | Resident with a prototype or verified account |
| Activist / Volunteer | Registered supporter working within an assigned area |
| Union Chairman | Elected local representative with union-scoped authority |
| MP | Member of Parliament with upazila-level aggregate access |
| Upazila Coordinator | Optional delegated administrative role |
| Super Admin | Platform administrator with global configuration authority |
| Auditor | Read-only oversight role with time-bound access |

## 2. Functional requirements

### 2.1 Public information and platform transparency

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-001 | The platform shall provide a public landing page describing services, geographic coverage, eligibility guidance, and current limitations. | Must | M1 (prototype) |
| FR-002 | Every public page shall display a clear notice that the platform is not an official government website unless and until formal authorization is granted. | Must | M1 |
| FR-003 | Prototype-only features and unavailable actions shall be visibly labelled as prototypes; disabled actions shall explain why they are unavailable. | Must | M1 |
| FR-004 | Public content shall be available in Bangla and English, with Bangla as the primary public-service language. | Must | M1 (structure), M2+ (full content) |
| FR-005 | Public pages shall be responsive and usable on entry-level mobile devices and slow connections. | Must | M1 |
| FR-006 | The platform shall provide accessible navigation, labelled forms, keyboard support, and WCAG 2.2 AA-targeted contrast. | Must | M1 (baseline), M2+ (full audit) |

**Acceptance criteria (FR-001 to FR-006)**

- A visitor can reach the landing page and understand the platform purpose, covered area, and prototype status within one screen.
- The disclaimer is visible without opening a modal and remains available in the footer on every page.
- Prototype actions use disabled controls and explanatory text; no action silently fails.
- The five Milestone 1 pages render at 360 px, 768 px, and 1280 px widths without horizontal scrolling.
- All form controls have programmatically associated labels; the page can be navigated with a keyboard.

### 2.2 Citizen registration and geographic selection

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-010 | A citizen shall be able to start registration with a mobile number and optional email address. | Must | M2 |
| FR-011 | Registration shall require selection of division, district, upazila, union/municipality, and ward from authoritative geographic data. | Must | M2 |
| FR-012 | Geographic cascading controls shall only display active children of the selected parent. | Must | M2 |
| FR-013 | The system shall record consent to the privacy notice and terms before activating an account. | Must | M2 |
| FR-014 | Phone ownership shall be verified by OTP before account activation. | Must | M3 |
| FR-015 | NID verification, if enabled, shall occur only through an approved integration and shall store a hash plus an encrypted value, never a plaintext NID. | Should | M3+ (requires authorization) |
| FR-016 | A citizen shall be able to view and update their own contact details and address, subject to re-verification where required. | Must | M3 |
| FR-017 | A citizen shall have exactly one active primary geographic residence; historical changes shall be retained with effective dates. | Must | M2 |
| FR-018 | A citizen shall be able to request correction of their personal data and track the correction request. | Should | M4 |

**Acceptance criteria (FR-010 to FR-018)**

- The registration API rejects missing or inconsistent geography values (for example, a ward that does not belong to the selected union).
- A citizen cannot select a ward outside the selected upazila via direct request tampering.
- No account becomes active before consent and OTP verification are complete.
- Prototype registration shows synthetic examples only and never asks for a real NID.

### 2.3 Ward-scoped citizen access

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-020 | Every authenticated request shall resolve the actor's active role assignments and geographic scopes in the backend. | Must | M2 |
| FR-021 | A citizen shall access only their own profile, applications, requests, and reports, plus explicitly public ward-level information. | Must | M2 |
| FR-022 | A user with multiple roles shall receive the union of permitted actions, still bounded by each role's geographic scope. | Must | M2 |
| FR-023 | Changing a user's ward or union shall not retroactively grant access to records outside the permitted scope. | Must | M2 |
| FR-024 | Direct object access shall be protected against IDOR: fetching another citizen's record by changing an ID shall return an authorization error. | Must | M2 |
| FR-025 | Sensitive list and export endpoints shall apply scope filters before pagination and aggregation. | Must | M3 |

**Acceptance criteria (FR-020 to FR-025)**

- Automated feature tests cover same-union, cross-union, and cross-upazila access attempts.
- A citizen in Ward 3 cannot read a complaint or application belonging to Ward 4 by editing a URL or request payload.
- Authorization failures return a generic, non-enumerating error and are logged without sensitive payloads.

### 2.4 Role, permission, and delegation management

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-030 | A Super Admin shall be able to create custom roles and assign granular permissions. | Must | M2 |
| FR-031 | Role assignments shall include a geographic scope and an effective period. | Must | M2 |
| FR-032 | An administrator shall only grant permissions that they themselves hold and only within their own geographic authority. | Must | M2 |
| FR-033 | The system shall prevent self-escalation, removal of the last Super Admin, and modification of protected system roles. | Must | M2 |
| FR-034 | High-risk permission grants and revocations shall require a reason and create an audit record. | Must | M2 |
| FR-035 | Role and permission changes shall invalidate affected sessions or cached authorization within a defined, short interval. | Must | M3 |
| FR-036 | The system shall provide a permission catalogue with human-readable descriptions in Bangla and English. | Should | M4 |

**Acceptance criteria (FR-030 to FR-036)**

- A Union Chairman cannot assign the MP or Super Admin role.
- A delegated manager can create a role only with a subset of their own permissions and within their own scope.
- The final active Super Admin cannot be deleted, deactivated, or stripped of the role.
- Every role/permission mutation produces an audit entry containing actor, target, before/after values, reason, and scope.

### 2.5 Blood donor directory and emergency requests

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-040 | A citizen shall be able to opt in as a blood donor with blood group, availability, last donation date, and preferred contact method. | Must | M4 |
| FR-041 | Donor visibility shall be opt-in and scoped; public users shall not see full contact details or precise addresses. | Must | M4 |
| FR-042 | A requester shall be able to create an emergency blood request with blood group, units needed, hospital, needed-by time, urgency, and approximate location. | Must | M4 |
| FR-043 | The system shall match active, eligible, consenting donors within an appropriate geographic radius and blood compatibility rules. | Must | M4 |
| FR-044 | Contact details shall be shared only after mutual consent or through a privacy-preserving relay. | Must | M4 |
| FR-045 | Donor responses shall be tracked (offered, accepted, fulfilled, declined, expired) and donors shall be able to withdraw. | Must | M4 |
| FR-046 | A donor's last donation date shall prevent matching before a configurable minimum interval. | Should | M4 |
| FR-047 | Emergency requests shall expire automatically and be archived with an outcome. | Must | M4 |
| FR-048 | Blood-related health information shall be stored in restricted tables with access logging. | Must | M4 |

**Acceptance criteria (FR-040 to FR-048)**

- A donor who opts out is removed from matching immediately.
- A request in Phulbaria Union does not expose donors in a different upazila unless the request is explicitly escalated by an authorized role.
- Contact details are absent from list responses and API logs.
- The matching algorithm has unit tests for blood compatibility and donation intervals.

### 2.6 Activists and volunteers

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-050 | A citizen shall be able to apply to become an activist or volunteer with skills, availability, and preferred area. | Must | M4 |
| FR-051 | A Union Chairman or delegated verifier shall be able to approve, reject, suspend, or expire a volunteer within their union. | Must | M4 |
| FR-052 | Verification decisions shall record the decision-maker, reason, and timestamp. | Must | M4 |
| FR-053 | Authorized staff shall be able to assign volunteers to programmes, reports, or blood drives within the same geographic scope. | Must | M4 |
| FR-054 | Volunteers shall see only assignments and citizen information necessary for the assigned task. | Must | M4 |
| FR-055 | Volunteer profiles shall not expose private citizen data or sensitive health/financial details. | Must | M4 |
| FR-056 | Volunteer activity and assignment completion shall be recorded for accountability and recognition. | Should | M5 |

**Acceptance criteria (FR-050 to FR-056)**

- A chairman cannot verify a volunteer from another union.
- A volunteer loses access to an assignment when it is closed or reassigned.
- Assignment views expose only the minimum contact information needed to complete the task.

### 2.7 Benefit programme applications

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-060 | Authorized staff shall be able to publish benefit programmes with eligibility guidance, required documents, deadline, coverage area, and status. | Must | M5 |
| FR-061 | A citizen shall be able to browse programmes available in their union/ward and start an application. | Must | M5 |
| FR-062 | Applications shall support structured fields, supporting documents, and a declaration/consent step. | Must | M5 |
| FR-063 | The system shall prevent duplicate active applications for the same programme and citizen unless the programme allows it. | Must | M5 |
| FR-064 | Applications shall have a status history visible to the applicant and authorized reviewers. | Must | M5 |
| FR-065 | Reviewers shall only see and decide applications within their assigned scope and permission. | Must | M5 |
| FR-066 | Eligibility rules shall be transparent to applicants; automated hints shall not be presented as final decisions. | Should | M5 |
| FR-067 | Document uploads shall be type/size validated, stored privately, scanned where available, and access logged. | Must | M5 |
| FR-068 | Applicants shall be able to withdraw an application before a final decision. | Should | M5 |

**Acceptance criteria (FR-060 to FR-068)**

- A programme scoped to one union is not visible or applicable in another union.
- An application cannot be submitted without required consent and mandatory documents.
- Status changes are append-only and displayed with date, status, and public reason.
- Supporting documents cannot be downloaded by unauthorized users even with a guessed URL.

### 2.8 Financial assistance requests

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-070 | A citizen shall be able to submit a financial assistance request with category, amount requested, reason, and supporting documents. | Must | M5 |
| FR-071 | Requests shall support assessment notes and a recommendation with a documented rationale. | Must | M5 |
| FR-072 | Approval shall use maker-checker separation; the requester and assessor cannot be the same person as the final approver. | Must | M5 |
| FR-073 | Approval thresholds shall determine the required approver role(s); high-value requests require escalation. | Must | M6 |
| FR-074 | Disbursement records shall reference method, date, amount, reference number, and responsible officer. | Must | M6 |
| FR-075 | Financial records shall be access-restricted, encrypted where feasible, and excluded from aggregate dashboards below the privacy threshold. | Must | M5 |
| FR-076 | Citizens shall see a plain-language status and next action without exposing internal assessment notes. | Must | M5 |
| FR-077 | Financial data shall not be exported in bulk without a specific, audited permission and time-bound approval. | Must | M6 |

**Acceptance criteria (FR-070 to FR-077)**

- A reviewer cannot approve their own assessment or submit and approve the same request.
- A request above the configured threshold cannot be approved by a role below the required level.
- Internal notes are absent from applicant-facing responses and logs.
- Every financial status transition creates an immutable audit record.

### 2.9 Public problem reporting

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-080 | A citizen shall be able to report a public problem with category, description, location, and optional photo. | Must | M6 |
| FR-081 | Reports shall be assigned to the responsible union/ward or infrastructure team based on location and category. | Must | M6 |
| FR-082 | Reporters shall receive a tracking reference and be able to follow public status updates. | Must | M6 |
| FR-083 | Authorized staff shall be able to triage, assign, add internal notes, request more information, resolve, and close reports. | Must | M6 |
| FR-084 | Public maps and feeds shall show approximate locations and must not reveal reporter identity. | Must | M6 |
| FR-085 | Duplicate reports at the same location/category may be linked, with the original retained. | Could | M6 |
| FR-086 | Resolution evidence (photo/note) shall be stored with the report and shown publicly where appropriate. | Should | M6 |
| FR-087 | The system shall allow anonymous public reports only if abuse controls, rate limits, and moderation are in place. | Could | M7 |

**Acceptance criteria (FR-080 to FR-087)**

- A report cannot be assigned to a union outside the report location's scope by an unauthorized actor.
- The public tracking view shows status history but redacts citizen identity and internal notes.
- Photo metadata is stripped or treated as untrusted; uploads are private by default.

### 2.10 Education, health, roads, infrastructure, and GIS

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-090 | The platform shall provide a directory of education institutions with name, type, location, contact, and services. | Must | M6 |
| FR-091 | The platform shall provide a directory of health facilities with type, services, hours, contact, and emergency information. | Must | M6 |
| FR-092 | Authorized staff shall be able to maintain institution records with review/approval and change history. | Must | M6 |
| FR-093 | The platform shall maintain a road and infrastructure asset register including type, condition, location, and responsible authority. | Must | M6 |
| FR-094 | GIS data shall be stored as spatial geometry in PostGIS with coordinate system EPSG:4326 and documented provenance. | Must | M6 |
| FR-095 | Public maps shall support ward/union boundaries, institutions, infrastructure, and report layers with accessible list alternatives. | Must | M7 |
| FR-096 | The platform shall provide aggregate counts by union/ward without exposing restricted records. | Must | M7 |
| FR-097 | Map data shall clearly show data freshness and must not present unverified data as authoritative. | Must | M7 |
| FR-098 | GIS imports shall be validated (geometry type, SRID, duplicates) and logged with source and version. | Should | M6 |

**Acceptance criteria (FR-090 to FR-098)**

- Institution records display provenance and last-verified date.
- A user can access the same information as a list when maps or JavaScript are unavailable.
- Spatial queries are bounded by the actor's geographic scope.
- Invalid or out-of-bounds geometries are rejected with a clear import error.

### 2.11 Union Chairman portal

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-100 | A chairman shall see a dashboard scoped exclusively to their own union. | Must | M7 |
| FR-101 | The dashboard shall show service queues, reports, applications, volunteer status, and aggregate counts. | Must | M7 |
| FR-102 | The chairman shall be able to assign permitted actions to union-scoped staff without exceeding their own authority. | Must | M7 |
| FR-103 | The chairman shall not see citizen NID, health, family, or financial details beyond what is necessary for a specific authorized decision. | Must | M7 |
| FR-104 | Cross-union aggregate comparisons shall require an aggregate-only role and must not expose small-cell data. | Should | M7 |

**Acceptance criteria (FR-100 to FR-104)**

- A chairman of Union A receives no records from Union B in lists, search, counts, or exports.
- The dashboard identifies its scope visibly (union name and effective period).
- Attempts to broaden scope via query parameters are ignored or rejected.

### 2.12 MP portal

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-110 | An MP shall see upazila-level aggregate dashboards for service demand, reports, programmes, and infrastructure. | Must | M7 |
| FR-111 | Individual-level citizen, health, family, and financial data shall not be visible to the MP role by default. | Must | M7 |
| FR-112 | Aggregate results below a configurable minimum group size shall be suppressed or coarsened. | Must | M7 |
| FR-113 | The MP portal shall show data definitions, freshness, and known limitations. | Should | M7 |
| FR-114 | Any drill-down beyond aggregate data shall require a separate, audited permission and a lawful basis. | Must | M7 |

**Acceptance criteria (FR-110 to FR-114)**

- The MP dashboard cannot be used to identify a specific citizen or household.
- Counts below the privacy threshold display as "suppressed" rather than a number.
- Scope and aggregation rules are covered by automated tests and documented in the security requirements.

### 2.13 Audit, reporting, and notifications

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-120 | The system shall record security-relevant and administrative events in an append-only audit log. | Must | M2 |
| FR-121 | Audit events shall include actor, action, target, scope, timestamp, result, request/correlation ID, and redacted change data. | Must | M2 |
| FR-122 | Audit logs shall be readable only by authorized audit roles and protected from application-level deletion. | Must | M3 |
| FR-123 | The system shall send in-app notifications for request status changes and assignment updates. | Must | M4 |
| FR-124 | SMS/email notifications shall be opt-in where legally appropriate and shall not contain sensitive details. | Should | M5 |
| FR-125 | Operational reports shall be scoped to the requester and export only the minimum necessary fields. | Must | M6 |
| FR-126 | Bulk export of sensitive data shall require explicit permission, purpose, time limit, and audit. | Must | M6 |

### 2.14 Data protection and consent

| ID | Requirement | Priority | Milestone |
| --- | --- | --- | --- |
| FR-130 | The platform shall present a privacy notice describing purpose, data categories, sharing, retention, and rights. | Must | M2 |
| FR-131 | Consent shall be specific, informed, recorded with version/time, and withdrawable where applicable. | Must | M2 |
| FR-132 | Data collection shall be limited to fields necessary for the stated service. | Must | M2 |
| FR-133 | Prototype and demo environments shall contain only synthetic data and shall not accept real NID or sensitive personal data. | Must | M1 |
| FR-134 | Data retention and deletion rules shall be defined per module and enforced by scheduled jobs. | Must | M5 |
| FR-135 | Citizens shall be able to request access to their own data and correction of inaccurate data. | Should | M4 |
| FR-136 | Logs and analytics shall exclude NID, health, family, and financial details. | Must | M2 |

## 3. Non-functional requirements

### 3.1 Security

| ID | Requirement | Target |
| --- | --- | --- |
| NFR-SEC-01 | Authorization is enforced server-side for every request; client-side hiding is never sufficient. | Must |
| NFR-SEC-02 | All access decisions combine permission, geographic scope, and record state. | Must |
| NFR-SEC-03 | Sensitive data is encrypted in transit (TLS 1.2+) and at rest (database/volume encryption plus application-level field encryption where risk requires). | Must |
| NFR-SEC-04 | Passwords use Argon2id or bcrypt with a work factor aligned to current guidance. | Must |
| NFR-SEC-05 | Administrative accounts support MFA before production use. | Must (pre-production) |
| NFR-SEC-06 | CSRF, XSS, SQL injection, SSRF, file upload, and rate-limit protections are implemented and tested. | Must |
| NFR-SEC-07 | Security headers (CSP, HSTS in production, frame-ancestors, nosniff, referrer policy) are configured. | Must |
| NFR-SEC-08 | Secrets are stored outside version control and rotated through an operational process. | Must |
| NFR-SEC-09 | Dependency and container vulnerabilities are scanned before each release. | Must |
| NFR-SEC-10 | The prototype never falsely claims official government authorization. | Must |

See [security-requirements.md](security-requirements.md) for the detailed control set.

### 3.2 Privacy

- Data minimisation: do not collect NID, health, family, or financial data unless a specific service requires it and a lawful basis exists.
- Purpose limitation: data collected for one service is not repurposed for unrelated analytics or political activity.
- Small-cell suppression: aggregate dashboards suppress counts below the configured threshold (initial proposal: 10).
- Retention: define per-record retention with automatic review; audit logs retained according to legal and operational requirements.
- Prototype safety: synthetic data only; no production data copied into development or demo environments.

### 3.3 Performance and availability

| ID | Requirement | Target |
| --- | --- | --- |
| NFR-PERF-01 | Public landing page is usable on a 3G-class connection. | Initial meaningful render under 3 s at 1.6 Mbps; total transfer budget reviewed in M2 |
| NFR-PERF-02 | Typical scoped list requests complete within 1 s at the 95th percentile on reference data volumes. | Must |
| NFR-PERF-03 | GIS queries use spatial indexes and bounding constraints. | Must |
| NFR-PERF-04 | The system degrades gracefully when maps or third-party services are unavailable. | Must |
| NFR-AVAIL-01 | Production target availability is 99.5% excluding planned maintenance (to be confirmed). | Should |
| NFR-AVAIL-02 | Backups are encrypted, tested, and have a documented restore procedure. | Must (pre-production) |

### 3.4 Accessibility and inclusion

- Target WCAG 2.2 Level AA for all citizen-facing pages.
- Bangla-first content with English alternatives; form labels and error messages bilingual.
- Minimum 44 x 44 CSS pixel touch targets, visible focus indicators, logical heading order, and no reliance on colour alone.
- Support 200% browser zoom and text resizing without loss of content.
- Respect `prefers-reduced-motion`.
- Provide list/table alternatives to maps and charts.
- Do not require a smartphone app, high-bandwidth video, or biometric hardware to access core information.

### 3.5 Compatibility and maintainability

- Latest two versions of Chrome, Edge, Firefox, and Safari; Android Chrome on low-end devices.
- Progressive enhancement: public content remains readable without JavaScript.
- Backend: PHP 8.3+, Laravel 13, PostgreSQL/PostGIS target; SQLite only for local skeleton/testing.
- Frontend target: Vue 3 + TypeScript + Inertia.js + Tailwind CSS v4; Milestone 1 uses Blade + Tailwind.
- Code style enforced with Laravel Pint; static analysis and frontend type checking added in Milestone 2.
- Every module has feature tests for authorization, validation, and happy-path workflow.

### 3.6 Observability and operations

- Structured application logs with correlation IDs and secret/PII redaction.
- Health endpoint `/up` and queue/database checks in production.
- Audit trail for administrative and sensitive actions.
- Metrics for request latency, error rate, queue depth, and failed notifications.
- Documented runbooks for backup/restore, role incidents, and data breach response.

## 4. Data requirements summary

| Data category | Examples | Classification | Prototype rule |
| --- | --- | --- | --- |
| Public | Service catalogue, institution names, public maps, aggregate counts | Public | Synthetic or clearly sourced public data only |
| Account | Name, mobile, email, hashed password, locale | Internal | Synthetic demo accounts only |
| Identity | NID hash, encrypted NID, verification status | Restricted | Not collected in prototype; placeholder text only |
| Health | Blood group, donation eligibility, health facility details | Restricted | No real health data; minimal donor fields |
| Family | Household members, relationships, income indicators | Restricted | Not implemented in prototype |
| Financial | Assistance requests, assessments, disbursements | Restricted | No real financial data |
| Location | Union/ward, report location, asset geometry | Internal/Public depending on context | Synthetic geometry or public boundaries |
| Audit | Actor, action, target, change summary, IP | Restricted | Enabled once authentication exists |

## 5. Assumptions and constraints

1. The project currently has no formal government authorization, data-sharing agreement, or integration credentials.
2. Union, ward, and boundary data will be validated with the Upazila Administration or an authoritative public source before production.
3. NID verification requires a lawful basis, an approved integration path, and explicit authorization; it is out of scope until then.
4. Production hosting, domain, SMS gateway, email provider, and file storage are not selected in Milestone 1.
5. The team will use synthetic demo data and document its provenance.
6. Bangla typography and translation review require a native-language reviewer before public launch.
7. PostgreSQL/PostGIS, Vue, Inertia, TypeScript, and Filament are target dependencies but are not installed in Milestone 1.
8. The platform will follow applicable Bangladeshi law and good-practice privacy principles; legal review is required before any production data collection.

## 6. Open questions

- Which public authority, if any, will own and operate the production platform?
- Which union/ward code list and boundary dataset is authoritative?
- What is the approved process and legal basis for NID verification?
- Which benefit programmes and financial assistance categories are in the first production release?
- What retention periods apply to reports, applications, financial records, and audit logs?
- What are the exact approval thresholds and maker-checker roles for financial assistance?
- Which SMS/email providers are approved, and what is the notification consent model?
- What language review and accessibility certification process will be used?
- What uptime, support hours, and disaster-recovery targets will the operator commit to?

## 7. Traceability

| Milestone | Requirements introduced or completed |
| --- | --- |
| M1 | FR-001 to FR-006 (prototype), FR-133, NFR-SEC-10, initial UI/UX and documentation |
| M2 | FR-010 to FR-014, FR-016 to FR-024, FR-030 to FR-034, FR-120, FR-121, FR-130 to FR-132, NFR-SEC-01/02/04/06/08 |
| M3 | FR-015, FR-025, FR-035, FR-036, FR-122, FR-134 to FR-136, NFR-SEC-03/05/07/09 |
| M4 | FR-040 to FR-056, FR-123, MFA and donor/volunteer privacy controls |
| M5 | FR-060 to FR-077, FR-124, FR-134 |
| M6 | FR-073, FR-074, FR-077, FR-080 to FR-098, FR-125, FR-126 |
| M7 | FR-090 to FR-114, public GIS experience, chairman and MP portals |
| M8 | Hardening, accessibility audit, performance/load testing, UAT, deployment readiness |
