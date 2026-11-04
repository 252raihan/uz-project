# Phulbaria Upazila Service Platform — Project Overview

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform (`ফুলবাড়ীয়া উপজেলা সেবা প্ল্যাটফর্ম`) |
| Working product name | Phulbaria Seba (`ফুলবাড়ীয়া সেবা`) |
| Location | Phulbaria (Fulbaria) Upazila, Mymensingh District, Mymensingh Division, Bangladesh |
| Current milestone | Milestone 1 — Project Foundation & Requirement Analysis |
| Document status | Draft foundation, approved for prototyping |
| Last updated | 4 November 2026 |

> **Important notice**
>
> This project is an independent civic-technology prototype. It is **not** an official website of the Government of the People's Republic of Bangladesh, Phulbaria Upazila Administration, any Union Parishad, or any public authority. No government authorization, endorsement, or partnership is claimed. Production use by a public authority would require a formal memorandum of understanding, legal review, operational ownership, and explicit written authorization.

---

## 1. Purpose

The platform is intended to give the residents of Phulbaria Upazila one accessible, mobile-first place to:

- discover public services and local institutions;
- register as a citizen and select their union and ward;
- request help and track the progress of requests;
- connect with verified blood donors and volunteers in emergencies;
- apply for benefit programmes and financial assistance;
- report public problems such as damaged roads, drainage issues, or safety hazards;
- view public information about education, health, roads, infrastructure, and GIS data.

For elected representatives and administrators, the platform is intended to provide scoped dashboards, transparent service queues, and aggregate insight. Access must always be limited by role **and** geographic responsibility.

## 2. Context and problem statement

Public services in the upazila are often spread across offices, paper forms, notice boards, and informal communication channels. Citizens may not know which office is responsible for a service, what documents are required, or what happened after a request was submitted. Data about donors, volunteers, institutions, roads, and infrastructure is frequently maintained in disconnected registers. Decision-makers lack timely, comparable information while citizens lack a clear, privacy-respecting channel for follow-up.

This project will build a modular, ward-aware service platform that makes service information easier to find, makes request handling more accountable, and provides role-scoped dashboards. It will be developed incrementally and will not claim to replace statutory government systems. Integration with any official registry will only be considered after formal authorization.

## 3. Geographic model

The platform models the public administrative hierarchy:

```text
Bangladesh
└── Mymensingh Division
    └── Mymensingh District
        └── Phulbaria Upazila
            ├── Phulbaria Municipality (9 wards)
            └── 13 Union Parishads
                └── Wards
```

The 13 union parishads are: Asimpatuli (Achim Patuli), Bakta, Balian, Bhabanipur, Deukhola (Deokhola), Enayetpur, Fulbaria/Phulbaria, Kaladaha, Kushmail, Naogaon, Putijana, Radhakanai, and Rangamatia.

Administrative names and boundaries are public information, but boundary geometry, ward numbers, and official contact data must be validated with the relevant public authority before production use. Demo data must not invent sensitive attributes for real places.

### Geographic scope rule

Data visibility narrows as the administrative level narrows:

- a citizen sees their own records and public information for their selected ward/union;
- an activist or volunteer sees assignments within their assigned union/ward;
- a Union Chairman sees operational data for **their own union only**;
- an MP sees **upazila-level aggregate** information, not individually identifiable citizen records by default;
- a Super Admin can administer the platform, but sensitive access is logged and subject to additional controls.

The backend, not the user interface, is the authority for every scope decision.

## 4. Primary users

| User group | Primary needs | Default scope |
| --- | --- | --- |
| Citizen | Register, find services, apply for benefits, report problems, request blood, track status | Own profile and own requests; public ward information |
| Activist / volunteer | Register, receive assignments, help citizens, support blood drives | Assigned union/ward |
| Union Chairman | Review local service queues, verify local volunteers, monitor reports, view union dashboard | Own union only |
| Member of Parliament (MP) | View upazila-level aggregate service and infrastructure information | Upazila, aggregate/read-only |
| Upazila coordinator (optional support role) | Coordinate programme catalogues and escalation across the upazila | Assigned upazila, delegated permissions |
| Super Admin | Manage platform configuration, roles, permissions, and emergency operations | Global platform scope |
| Auditor / oversight reviewer | Review audit trails and verify process compliance | Read-only, scoped and time-bound |

## 5. Full project scope

The intended full scope includes:

1. **Citizen registration and geographic selection** — account creation, union/ward selection, consent capture, status tracking. National identity verification is a later, separately approved capability.
2. **Ward-scoped citizen access** — authorization checks on every query and action, with no access to another ward's private records.
3. **Blood donor directory and emergency requests** — voluntary donor opt-in, blood group matching, request lifecycle, privacy-protected contact sharing.
4. **Activists and volunteers** — registration, skills, verification, assignments, and activity records.
5. **Benefit programme applications** — programme catalogue, eligibility guidance, applications, documents, status timeline, and decisions.
6. **Financial assistance requests** — intake, assessment, maker-checker approval, disbursement records, and audit trail.
7. **Public problem reporting** — categorised reports, photos, location, assignment, updates, and resolution evidence.
8. **Education, hospital, road, infrastructure, and GIS data** — institution directories, road/infrastructure asset registers, public maps, and location-based search.
9. **Chairman portal** — a union-scoped operational dashboard for the elected chairman and authorised support staff.
10. **MP portal** — upazila-level aggregate dashboards and reports, with privacy thresholds for small groups.
11. **Super Admin and dynamic role/permission management** — scoped role assignment, delegated administration, and protection against privilege escalation.
12. **Audit, reporting, notifications, and data protection** — cross-cutting capabilities required by every module.

## 6. Milestone 1 scope

Milestone 1 establishes the foundation only:

- project-specific documentation for scope, requirements, architecture, roles, data, security, UI/UX, and roadmap;
- a responsive bilingual Blade/Tailwind prototype with five pages: public landing, login, registration, citizen dashboard placeholder, and admin dashboard placeholder;
- explicit prototype labelling and government-authorization disclaimers;
- route and smoke-test coverage for the prototype pages;
- README and Milestone 1 report.

Milestone 1 deliberately excludes:

- real authentication, sessions, password reset, or account creation;
- NID verification, OTP, SMS, email verification, or integration with government registries;
- database tables or seed data for the business modules;
- real benefit, financial, blood, volunteer, reporting, or GIS workflows;
- Vue, Inertia, Filament, PostgreSQL/PostGIS installation or configuration;
- production deployment, Git repository initialization, or publication.

## 7. Product principles

- **Privacy by design.** Collect the minimum data needed for a service. Avoid NID collection until there is a lawful, authorized verification process.
- **Least privilege and scope.** Backend authorization enforces both permission and geography. A role name alone never grants access.
- **No privilege escalation.** An administrator cannot grant permissions, roles, or geographic scopes beyond their own authority.
- **Honest presentation.** The interface must not imply official government status. Prototype features must be labelled as prototypes.
- **Bilingual and accessible.** Bangla-first public content with English support, WCAG 2.2 AA targets, and mobile-first layouts.
- **Accountable operations.** Sensitive actions are audited, financial decisions use separation of duties, and audit records are protected from modification.
- **Modular monolith.** One deployable Laravel application with clear domain boundaries, so modules can evolve without premature microservices.
- **Incremental delivery.** Each milestone is independently reviewable, testable, and reversible.

## 8. Explicit non-goals

The platform will not, without a separate formal decision and legal basis:

- claim official status or use government emblems, seals, or domain names;
- replace statutory government records or issue legally binding certificates;
- collect or store real NID numbers, biometric data, health records, or household financial records in prototype environments;
- make automated eligibility, law-enforcement, surveillance, or political decisions;
- publish individual-level data about citizens, donors, or assistance recipients;
- process payments or disburse funds before financial controls and authorization are approved.

## 9. Glossary

| Term | Meaning |
| --- | --- |
| Upazila | Sub-district administrative unit |
| Union Parishad (UP) | Lowest tier of rural local government |
| Ward | Geographic subdivision of a union or municipality |
| Chairman | Elected head of a Union Parishad |
| MP | Member of Parliament |
| NID | National Identity document/number issued in Bangladesh |
| GIS | Geographic Information System |
| PostGIS | Spatial database extension for PostgreSQL |
| RBAC | Role-Based Access Control |
| ABAC / scope | Attribute- or geography-based constraint applied in addition to a permission |
| Maker-checker | Separation of duties where one person prepares and another approves |
| Prototype | A non-production demonstration artefact, not connected to live data |

## 10. Current status

The Laravel 13.39.0 / PHP 8.3.36 skeleton is healthy. Milestone 1 documentation and the static UI prototype have been added. No authentication, business workflow, or production data processing exists yet. See [milestone-01-report.md](milestone-01-report.md) for exact checks and limitations, and [development-roadmap.md](development-roadmap.md) for the next milestone.
