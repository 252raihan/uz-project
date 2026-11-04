# Role and Permission Matrix

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform |
| Version | 0.1 (design baseline) |
| Last updated | 4 November 2026 |
| Implementation status | Specified only; not enforced in Milestone 1 prototype |

This matrix is the design baseline for server-side authorization. It is not a description of the current prototype, which has no authentication or protected data.

---

## 1. Authorization principles

1. **Permission plus scope.** A permission never grants access on its own. Every decision also checks geographic scope and record state.
2. **Backend authority.** The UI may hide actions, but the backend must enforce every rule.
3. **Deny by default.** Missing role, missing scope, expired assignment, or ambiguous rules result in denial.
4. **No upward delegation.** An actor cannot grant a permission, role, or scope they do not possess.
5. **No wider scope.** Delegation may only narrow geographic scope; it can never widen it.
6. **Separation of duties.** Financial preparation, assessment, approval, and disbursement are distinct permissions. The same person cannot perform incompatible steps.
7. **Least data.** Even authorized roles receive only the fields needed for the task, not entire citizen records.
8. **Audited administration.** Role, permission, scope, and sensitive-data actions are logged with an actor and reason.
9. **Protected system roles.** Base roles cannot be edited into privilege-escalation paths or deleted while in use.
10. **Immediate revocation.** Revoked roles/permissions take effect on the next request; caches and sessions are invalidated for high-risk changes.

## 2. Geographic scope model

| Scope | Meaning | Typical holder |
| --- | --- | --- |
| Self | The actor's own citizen record and own submissions | Citizen |
| Assigned tasks | Records explicitly assigned to the volunteer/activist | Volunteer |
| Ward | A specific ward within a union/municipality | Ward focal person (optional) |
| Union | A specific union parishad, including its wards | Union Chairman |
| Municipality | A specific municipality, including its wards | Municipal administrator (optional) |
| Upazila | All unions and municipalities in Phulbaria Upazila | MP (aggregate) |
| Global | Platform-wide configuration | Super Admin |
| Time-bound | A scope valid only between two dates | Auditors, temporary support staff |

Scope is stored on the role assignment, never inferred from the user's home address. A user can have different roles in different scopes, and the effective permission set is the union of grants, each bounded by its own scope.

## 3. Roles

| Code | Role | Description | Default scope |
| --- | --- | --- | --- |
| `guest` | Guest / public | Unauthenticated visitor | Public content only |
| `citizen` | Citizen | Resident with an account | Self |
| `volunteer` | Activist / volunteer | Verified supporter | Assigned tasks |
| `ward_focal` | Ward focal person (optional) | Local coordination support | One ward |
| `chairman` | Union Chairman | Elected union representative | Own union |
| `mp` | Member of Parliament | Upazila-level oversight | Phulbaria Upazila, aggregate |
| `coordinator` | Upazila coordinator (optional) | Programme support staff | Delegated upazila subsets |
| `super_admin` | Super Admin | Platform administration | Global |
| `auditor` | Auditor | Read-only oversight | Scoped, time-bound |

The `ward_focal`, `coordinator`, and `auditor` roles are optional and may be introduced only if the operating authority approves them.

## 4. Permission catalogue

| Permission | Description | Data sensitivity |
| --- | --- | --- |
| `public.content.view` | View public service information | Public |
| `citizen.profile.view_self` | View own citizen profile | Internal |
| `citizen.profile.update_self` | Update own contact/address | Internal |
| `citizen.profile.view_scoped` | View limited citizen details for service delivery | Confidential |
| `citizen.profile.correct` | Process a citizen correction request | Confidential |
| `blood.donor.register_self` | Opt in as a donor | Confidential |
| `blood.donor.view_scoped` | View donor availability in scope | Confidential |
| `blood.donor.manage_self` | Update/withdraw own donor profile | Confidential |
| `blood.request.create` | Create an emergency blood request | Confidential |
| `blood.request.view_scoped` | View and triage requests in scope | Confidential |
| `blood.request.manage` | Update request status and assignments | Confidential |
| `blood.request.escalate` | Escalate outside the normal scope | Restricted |
| `volunteer.register_self` | Apply to become a volunteer | Internal |
| `volunteer.verify_scoped` | Approve/reject/suspend volunteers | Confidential |
| `volunteer.assign_scoped` | Assign volunteers to tasks | Internal |
| `benefit.program.view` | View programme catalogue | Public |
| `benefit.program.manage_scoped` | Create/publish programmes in scope | Internal |
| `benefit.application.create` | Apply for a programme | Confidential |
| `benefit.application.view_self` | Track own application | Confidential |
| `benefit.application.review_scoped` | Review applications in scope | Restricted |
| `benefit.application.decide_scoped` | Approve/reject applications in scope | Restricted |
| `finance.request.create` | Submit a financial assistance request | Restricted |
| `finance.request.view_self` | Track own financial request | Restricted |
| `finance.request.assess_scoped` | Assess need and recommend | Restricted |
| `finance.request.approve_scoped` | Approve assistance within threshold | Restricted |
| `finance.disbursement.record_scoped` | Record an approved disbursement | Restricted |
| `report.create` | Submit a public problem report | Internal |
| `report.view_self` | Track own reports | Internal |
| `report.triage_scoped` | Triage/assign reports in scope | Internal |
| `report.resolve_scoped` | Resolve/close reports in scope | Internal |
| `institution.view` | View institution directory | Public |
| `institution.manage_scoped` | Add/edit institutions in scope | Internal |
| `infrastructure.view` | View road/infrastructure data | Public |
| `infrastructure.manage_scoped` | Maintain assets in scope | Internal |
| `gis.layer.view` | View public GIS layers | Public |
| `gis.import_scoped` | Import/validate spatial data in scope | Restricted |
| `gis.layer.manage_scoped` | Publish/manage GIS layer metadata | Internal |
| `union.dashboard.view` | View union-scoped dashboard | Confidential (aggregate) |
| `mp.dashboard.view` | View upazila aggregate dashboard | Confidential (aggregate) |
| `user.view_scoped` | View limited user accounts in scope | Confidential |
| `user.manage_scoped` | Activate/suspend accounts in scope | Confidential |
| `role.view_scoped` | View roles and assignments in scope | Internal |
| `role.manage_scoped` | Create/assign scoped roles within own authority | Restricted |
| `permission.grant_scoped` | Grant permissions held by the actor | Restricted |
| `audit.view_scoped` | Read audit events in scope | Restricted |
| `export.data_scoped` | Export approved fields for a stated purpose | Restricted |
| `system.settings.manage` | Change platform settings | Restricted |

## 5. Permission matrix by role

Legend: **Yes** = permitted within the role's scope; **Aggregate** = aggregate/read-only with small-cell suppression; **Self** = own records only; **Assigned** = only explicitly assigned records; **No** = not permitted by default; **Break-glass** = requires separate approval, re-authentication, and audit.

| Permission | Guest | Citizen | Volunteer | Chair | MP | Coordinator | Super Admin | Auditor |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `public.content.view` | Yes | Yes | Yes | Yes | Yes | Yes | Yes | Yes |
| `citizen.profile.view_self` | No | Self | Self | Self | Self | Self | Self | No |
| `citizen.profile.update_self` | No | Self | Self | Self | Self | Self | Self | No |
| `citizen.profile.view_scoped` | No | No | Assigned, limited | Yes | No | Delegated | Yes | Read-only, limited |
| `citizen.profile.correct` | No | No | No | Yes | No | Delegated | Yes | Read-only |
| `blood.donor.register_self` | No | Self | Self | Self | Self | Self | Self | No |
| `blood.donor.view_scoped` | No | Limited public | Assigned | Union | No | Delegated | Yes | Aggregate |
| `blood.donor.manage_self` | No | Self | Self | Self | Self | Self | Self | No |
| `blood.request.create` | No | Yes | Yes | Yes | Yes | Yes | Yes | No |
| `blood.request.view_scoped` | No | No | Assigned | Union | Aggregate | Delegated | Yes | Aggregate |
| `blood.request.manage` | No | No | Assigned response | Union | No | Delegated | Yes | No |
| `blood.request.escalate` | No | No | No | No | No | Delegated | Yes | No |
| `volunteer.register_self` | No | Yes | Yes | Yes | Yes | Yes | Yes | No |
| `volunteer.verify_scoped` | No | No | No | Union | No | Delegated | Yes | Read-only |
| `volunteer.assign_scoped` | No | No | No | Union | No | Delegated | Yes | No |
| `benefit.program.view` | Yes | Yes | Yes | Yes | Yes | Yes | Yes | Yes |
| `benefit.program.manage_scoped` | No | No | No | No | No | Delegated | Yes | No |
| `benefit.application.create` | No | Yes | Yes | Yes | Yes | Yes | Yes | No |
| `benefit.application.view_self` | No | Self | Self | Self | Self | Self | Self | No |
| `benefit.application.review_scoped` | No | No | No | Union | Aggregate | Delegated | Yes | Read-only, limited |
| `benefit.application.decide_scoped` | No | No | No | Union* | No | Delegated* | Yes* | No |
| `finance.request.create` | No | Yes | Yes | Yes | Yes | Yes | Yes | No |
| `finance.request.view_self` | No | Self | Self | Self | Self | Self | Self | No |
| `finance.request.assess_scoped` | No | No | No | Union | No | Delegated | Yes | No |
| `finance.request.approve_scoped` | No | No | No | Threshold* | No | Threshold* | Yes* | No |
| `finance.disbursement.record_scoped` | No | No | No | No | No | Delegated* | Yes* | No |
| `report.create` | No | Yes | Yes | Yes | Yes | Yes | Yes | No |
| `report.view_self` | No | Self | Self | Self | Self | Self | Self | No |
| `report.triage_scoped` | No | No | No | Union | No | Delegated | Yes | No |
| `report.resolve_scoped` | No | No | No | Union | No | Delegated | Yes | No |
| `institution.view` | Yes | Yes | Yes | Yes | Yes | Yes | Yes | Yes |
| `institution.manage_scoped` | No | No | No | No | No | Delegated | Yes | No |
| `infrastructure.view` | Yes | Yes | Yes | Yes | Yes | Yes | Yes | Yes |
| `infrastructure.manage_scoped` | No | No | No | Union* | No | Delegated* | Yes | No |
| `gis.layer.view` | Yes | Yes | Yes | Yes | Yes | Yes | Yes | Yes |
| `gis.import_scoped` | No | No | No | No | No | Delegated | Yes | No |
| `gis.layer.manage_scoped` | No | No | No | No | No | Delegated | Yes | No |
| `union.dashboard.view` | No | No | No | Union | No | Delegated | Yes | Read-only |
| `mp.dashboard.view` | No | No | No | No | Upazila aggregate | Delegated | Yes | Read-only |
| `user.view_scoped` | No | No | No | Union, limited | No | Delegated | Yes | Read-only |
| `user.manage_scoped` | No | No | No | Union, limited | No | Delegated | Yes | No |
| `role.view_scoped` | No | No | No | Union | No | Delegated | Yes | Read-only |
| `role.manage_scoped` | No | No | No | Union, limited* | No | Delegated* | Yes* | No |
| `permission.grant_scoped` | No | No | No | No | No | Delegated* | Yes* | No |
| `audit.view_scoped` | No | No | No | No | No | No | Yes | Yes |
| `export.data_scoped` | No | No | No | No | No | No | Break-glass | No |
| `system.settings.manage` | No | No | No | No | No | No | Yes* | No |

\* Additional constraints:

- `benefit.application.decide_scoped` for Chairman: only low-risk programmes explicitly delegated by the Upazila authority; financial/high-risk programmes require an authorised programme owner.
- `finance.request.approve_scoped`: subject to approval thresholds and maker-checker. The assessor cannot be the approver. Higher-value approvals require an elevated role.
- `finance.disbursement.record_scoped`: only after an approved decision and a separate disbursement permission.
- `infrastructure.manage_scoped` for Chairman: may propose/update local asset observations, not alter authoritative network data.
- Any `role.manage_scoped`, `permission.grant_scoped`, or `system.settings.manage` action requires the actor to hold the target permissions and scope. Super Admin actions are audited; high-risk changes may require a second approver.

## 6. Delegation rules

### 6.1 Allowed delegation

| Delegator | May delegate | Constraints |
| --- | --- | --- |
| Super Admin | Custom roles, permissions, global or narrower scopes | Cannot create an undeletable last-admin state; all changes audited |
| Upazila Coordinator | Programme, volunteer, report, or dashboard permissions | Only permissions held by the delegator; only delegated upazila/union scopes |
| Union Chairman | Volunteer verification, local report triage, local review tasks | Only within own union; cannot grant MP/Super Admin/Coordinator roles or financial approval beyond threshold |
| Auditor | Nothing | Read-only by design |

### 6.2 Prohibited delegation

- Granting any permission the actor does not hold.
- Granting a geographic scope broader than the actor's own.
- Assigning a role that contains permissions the actor cannot grant.
- Granting a role to oneself or modifying one's own scope/permissions.
- Creating a role that includes protected system permissions without Super Admin review.
- Delegating to an external person or unverified account.
- Using a shared account for administrative actions.

### 6.3 Maker-checker requirements

| Action | Preparer | Approver | Constraint |
| --- | --- | --- | --- |
| Benefit application decision | Reviewer | Programme approver | Cannot be the same person |
| Financial assistance assessment | Assessor | Approval officer | Cannot be the same person |
| Financial disbursement | Finance officer | Authorising officer | Approved request required |
| High-value financial approval | Approval officer | Elevated approver | Threshold configured by policy |
| Bulk sensitive export | Requesting officer | Data owner/Super Admin | Time-bound, purpose recorded |
| Role/permission change | Administrator | Second administrator (high risk) | Optional break-glass with audit |

## 7. Field-level access rules

| Data field | Citizen | Volunteer | Chairman | MP | Super Admin | Auditor |
| --- | --- | --- | --- | --- | --- | --- |
| Own phone/email | Full | Own | Own | Own | Administrative need | No |
| Citizen phone | Own | Assigned only | Masked by default, reveal with reason | No | Masked by default | Masked |
| NID number | Own status only | No | Masked last 4, if strictly required | No | Masked; break-glass only | No |
| NID hash | No | No | No | No | Not displayed | No |
| Blood group/availability | Public opt-in | Assigned | Union roster | Aggregate | Operational | Aggregate |
| Health/family details | Own | Minimum necessary | Minimum necessary | No | Restricted | No |
| Financial amounts | Own | No | Scoped cases | Aggregate | Scoped/administrative | Aggregate |
| Internal notes | No | No | Scoped | No | Yes | Read-only |
| Audit events | No | No | No | No | Yes | Scoped |

Masking is not a substitute for authorization. Masked values are omitted server-side where possible, not merely hidden with CSS.

## 8. Aggregate and MP portal rules

- MP dashboards return counts, rates, trends, and service performance at upazila level.
- Groups below the minimum cell size (initial proposal: 10) are suppressed, including derived percentages that could reveal small counts.
- No names, phone numbers, NID data, precise addresses, or individual financial amounts appear in MP responses.
- Drill-down to union level is permitted only where the group meets the threshold and the permission explicitly allows it.
- Exports from the MP portal contain aggregate tables and data definitions only.
- Any request for individual-level data requires a separate lawful basis, a specific permission, and audit approval.

## 9. Audit events for authorization

The following events must be recorded:

- role created, updated, archived;
- permission granted or revoked;
- role assignment created, changed, expired, or revoked;
- scope changed or delegated;
- failed authorization attempts above a threshold;
- sensitive-field reveal;
- break-glass access;
- export created, downloaded, or expired;
- maker-checker override;
- protected role modification attempt;
- last-admin protection triggered.

Each event records actor, target, previous/new state (redacted), scope, reason, request ID, IP, user agent, and timestamp.

## 10. Testing requirements

Automated tests must cover at least:

1. Each role's allowed and denied permissions.
2. Same-union success and cross-union denial for chairman actions.
3. Cross-upazila denial for all scoped roles.
4. Citizen IDOR attempts on profiles, applications, reports, and blood requests.
5. Delegation attempts that exceed the actor's permissions or scope.
6. Protected-role and last-Super-Admin safeguards.
7. Maker-checker separation for financial actions.
8. Small-cell suppression in MP aggregates.
9. Field-level masking in list, detail, export, and log output.
10. Revocation taking effect on the next request.

## 11. Milestone 1 status

- The matrix is documented for design review.
- No roles, permissions, policies, or scopes are implemented yet.
- The prototype's admin dashboard is static and labelled as a placeholder.
- Milestone 2 will implement the geographic scope foundation, role assignments, authorization policies, and the first automated access tests.
