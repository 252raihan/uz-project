# UI/UX Guidelines

| Field | Value |
| --- | --- |
| Project | Phulbaria Upazila Service Platform |
| Document | Design system and interaction guidelines |
| Version | 0.1 |
| Last updated | 4 November 2026 |
| Current implementation | Blade + Tailwind CSS v4 prototype (Milestone 1) |

---

## 1. Design principles

1. **Public service first.** Content is clear, calm, and task-oriented. Citizens should understand what a service is, who it is for, what is needed, and what happens next.
2. **Bangla-first bilingualism.** Bangla is the primary language on public pages; English is presented as a secondary line or alternative, not a decorative afterthought.
3. **Mobile-first and low-bandwidth.** Design for a 360 px Android phone on a slow connection before designing for desktop.
4. **Accessible by default.** Labels, focus states, contrast, and error handling are built in, not patched later.
5. **Honest about status.** Prototype features, unverified data, and unavailable actions are explicit.
6. **No government impersonation.** Never use official emblems, seals, portraits, or wording that implies authorization.
7. **Privacy-respecting.** Ask for the minimum information, explain why, and never show sensitive data unnecessarily.

## 2. Brand and language

### 2.1 Names

| Use | Bangla | English |
| --- | --- | --- |
| Product | ফুলবাড়ীয়া সেবা | Phulbaria Seba |
| Full platform | ফুলবাড়ীয়া উপজেলা সেবা প্ল্যাটফর্ম | Phulbaria Upazila Service Platform |
| Area | ফুলবাড়ীয়া উপজেলা, ময়মনসিংহ | Phulbaria Upazila, Mymensingh |
| Prototype label | প্রোটোটাইপ | Prototype |

The working name "Phulbaria Seba" is independent branding. It does not imply government operation. A formal authorization process would review the name and visual identity before any official launch.

### 2.2 Bilingual pattern

- Public headings: Bangla first, English second, with a clear hierarchy.
- Form labels: Bangla label plus a smaller English label.
- Buttons: include both languages where space allows: `নিবন্ধন করুন / Register`.
- Errors and helper text: bilingual, plain language, and specific.
- Avoid mixing languages inside a single sentence unless the term is a widely used proper noun.
- Use `lang="bn"` and `lang="en"` attributes on language spans for screen readers.
- Bangla copy should be reviewed by a native-language editor before production.

### 2.3 Tone

- Respectful, direct, and non-bureaucratic.
- Explain acronyms on first use.
- Use "you" and active voice.
- Do not promise eligibility, approval, or response times that are not guaranteed.
- Do not use fear, urgency, or political framing.

## 3. Colour

The palette uses teal/green as the civic primary, warm amber for prototype notices, and neutral slate for content. Colour is always paired with text or an icon; never the sole indicator.

| Token | Hex | Usage |
| --- | --- | --- |
| `brand-50` | `#f0fdfa` | Tinted backgrounds |
| `brand-100` | `#ccfbf1` | Badges, highlights |
| `brand-600` | `#0d9488` | Primary interactive |
| `brand-700` | `#0f766e` | Primary dark, headers |
| `brand-800` | `#115e59` | Hero/footer |
| `brand-900` | `#134e4a` | Deep background |
| `accent-500` | `#d97706` | Prototype/warning accent |
| `surface` | `#f8fafc` | Page background |
| `ink` | `#0f172a` | Primary text |
| `muted` | `#475569` | Secondary text |
| `danger` | `#b91c1c` | Errors and destructive actions |
| `success` | `#15803d` | Confirmed/completed |

Contrast targets: body text at least 4.5:1; large text at least 3:1; focus indicators clearly visible against both light and dark backgrounds. Do not use brand teal as the only error/success distinction.

## 4. Typography

- Font stack: `"Noto Sans Bengali", "Hind Siliguri", "Nirmala UI", "Instrument Sans", ui-sans-serif, system-ui, sans-serif`.
- Noto Sans Bengali/Hind Siliguri should be self-hosted in a later milestone for consistent rendering and offline reliability.
- Bangla body line-height: 1.7–1.8; English body line-height: 1.5–1.6.
- Base body size: 16 px minimum; do not use text smaller than 14 px for essential content.
- Headings use tighter leading but never overlap Bengali ascenders/descenders.
- Avoid all-caps English; use sentence case.
- Numerals: use Western Arabic numerals by default for form fields and references; option to localize later.

### Type scale (mobile → desktop)

| Role | Size |
| --- | --- |
| Display / hero | 30 → 52 px |
| H1 | 26 → 40 px |
| H2 | 22 → 30 px |
| H3 | 18 → 22 px |
| Body | 16 px |
| Small/helper | 14 px |
| Micro label | 12–13 px |

## 5. Layout and spacing

- Spacing scale: 4, 8, 12, 16, 24, 32, 48, 64 px.
- Page padding: 16 px mobile, 24 px tablet, 32 px desktop.
- Content width: max 1200 px; reading columns max 70 characters.
- Cards: 16 px radius, 1 px border, subtle shadow only when needed.
- Use generous whitespace around forms and service cards.
- Breakpoints: `sm` 640 px, `md` 768 px, `lg` 1024 px, `xl` 1280 px.
- No horizontal scroll at 320 px width.
- Sticky elements must not cover content or trap keyboard focus.

## 6. Components

### 6.1 Header

- Prototype notice bar above the header on every page.
- Brand mark (text-based or simple abstract mark) plus product name in Bangla and English.
- Public navigation: Home, Services, Portals, About, Sign in, Create account.
- Dashboard header: role and scope context, prototype badge, account menu.
- Mobile: a visible menu button implemented with an accessible disclosure; links remain keyboard reachable.
- Do not imply government ownership through logos, colors alone, or official terminology.

### 6.2 Buttons

| Variant | Use |
| --- | --- |
| Primary | Main action on a page |
| Secondary | Alternative action |
| Quiet/text | Low-emphasis navigation |
| Danger | Destructive action, with confirmation |
| Disabled | Unavailable prototype action, with explanation |

- Minimum 44 px height.
- Label describes the action (`Submit application`, not `Submit`).
- Loading state prevents duplicate submission and announces progress.
- Disabled buttons must have adjacent explanatory text; do not rely on grey colour alone.

### 6.3 Forms

- Every input has a visible label, not a placeholder-only label.
- Required fields are marked in text; optional fields are labelled `ঐচ্ছিক / Optional`.
- Helper text appears before errors; errors appear next to the field and in an error summary.
- Use the correct `autocomplete` tokens (`tel`, `email`, `current-password`, `new-password`).
- Validate on submit and on blur where appropriate; do not punish users while typing.
- Geographic selects cascade from division to district to upazila to union/municipality to ward.
- Show the selected administrative scope in a confirmation summary.
- Do not ask for a real NID in the prototype.
- Consent checkboxes are unchecked by default, specific, and link to the privacy notice.
- Never disable the ability to review entered data before submission.

### 6.4 Cards and badges

- Service cards show bilingual title, short description, availability status, and one clear action.
- Status badges use text plus colour: `Planned`, `Prototype`, `Open`, `In review`, `Resolved`.
- Do not use colour alone for status.
- Data cards label demo/sample values clearly.

### 6.5 Tables and dashboards

- Tables have captions, column headers, and a responsive overflow strategy.
- On mobile, prefer stacked definition lists or cards for complex records.
- Show scope context near the title: `Union: Phulbaria (demo)`, `Ward: 3`.
- Distinguish aggregate data from individual records.
- Suppress small cells explicitly ("Suppressed for privacy") rather than showing zero.
- Charts need a text summary and an accessible table alternative.

### 6.6 Maps

- Maps must be optional; provide a list view with the same locations and status.
- Do not show precise citizen locations publicly.
- Label unverified boundaries and approximate points.
- Include scale, attribution, and data freshness.
- Ensure map controls are keyboard accessible and not the only way to access information.

### 6.7 Dialogs and confirmations

- Use for destructive or irreversible actions only.
- Focus moves into the dialog, is trapped, and returns to the trigger on close.
- Provide a clear cancel action.
- Do not use dialogs for long forms or privacy notices.

## 7. Accessibility

- Target WCAG 2.2 Level AA.
- Include a skip link to main content.
- One H1 per page; do not skip heading levels.
- Use semantic landmarks: header, nav, main, footer.
- All interactive elements are reachable and operable by keyboard.
- Focus ring: at least 2 px, high contrast, visible on all backgrounds.
- Use `aria-current="page"` for active navigation.
- Form errors use `aria-describedby` and `role="alert"` where appropriate.
- Announce asynchronous results (status changes, validation summaries) politely.
- Provide text alternatives for icons and images; decorative SVGs use `aria-hidden="true"`.
- Maintain 44 x 44 px touch targets with adequate spacing.
- Support 200% zoom and 320 px viewport width.
- Respect `prefers-reduced-motion`; avoid unnecessary animation.
- Do not use blinking, flashing, or auto-playing media.
- Test with screen readers (NVDA/JAWS on Windows, TalkBack on Android) before production.

## 8. Content and microcopy

### 8.1 Prototype notice (required)

Bangla:

> এটি একটি স্বাধীন প্রোটোটাইপ। এটি বাংলাদেশ সরকার, ফুলবাড়ীয়া উপজেলা প্রশাসন, কোনো ইউনিয়ন পরিষদ বা কোনো সরকারি সংস্থার অফিসিয়াল ওয়েবসাইট নয়। কোনো সরকারি অনুমোদনের দাবি করা হয় না।

English:

> This is an independent prototype. It is not an official website of the Government of Bangladesh, Phulbaria Upazila Administration, any Union Parishad, or any public authority. No government authorization is claimed.

### 8.2 Status messages

- Planned: "This service is planned for a later milestone. / এই সেবাটি পরবর্তী মাইলফলকে যুক্ত হবে।"
- Prototype: "Prototype only — no real data is stored. / শুধুমাত্র প্রোটোটাইপ — কোনো বাস্তব তথ্য সংরক্ষণ করা হয় না।"
- Disabled action: "Sign-in is disabled in this prototype because authentication is not implemented yet. / এই প্রোটোটাইপে সাইন-ইন বন্ধ আছে কারণ প্রমাণীকরণ এখনো তৈরি হয়নি।"
- Privacy: "Do not enter real NID, health, family, or financial information in this prototype. / এই প্রোটোটাইপে প্রকৃত এনআইডি, স্বাস্থ্য, পারিবারিক বা আর্থিক তথ্য লিখবেন না।"

### 8.3 Writing rules

- Lead with the task, then context.
- Keep sentences short and avoid bureaucratic jargon.
- Use consistent terms: union parishad, ward, upazila, chairman, MP.
- Explain what happens after submission and expected next steps.
- Do not claim official status, guaranteed eligibility, or response times.
- Write bilingual pairs in a consistent order and typography.

## 9. Page specifications (Milestone 1)

### 9.1 Public landing page (`/`)

Purpose: explain the platform and its prototype status, show services and geographic coverage, and route users to login/registration.

Required elements:

- persistent prototype notice;
- hero with bilingual product name and purpose;
- clear "not an official government website" statement;
- geographic coverage strip (Phulbaria Upazila, 13 unions + municipality, ward-aware);
- eight service cards covering the full scope;
- portal overview for citizen, chairman, MP, and admin;
- privacy/security summary and demo-data warning;
- footer with disclaimer and navigation.

### 9.2 Login page (`/login`)

Purpose: demonstrate the future sign-in experience without implementing authentication.

- bilingual labels for mobile/email and password;
- remember-me checkbox and a placeholder "forgot password" note;
- disabled submit with an explicit explanation;
- link to registration and back to home;
- no social login, no government ID button, no credentials stored.

### 9.3 Registration page (`/register`)

Purpose: demonstrate citizen registration and cascading geographic selection.

- personal details: full name, mobile, optional email;
- geography: division, district, upazila, union/municipality, ward;
- password and confirmation fields;
- consent checkbox and privacy note;
- explicit "do not enter a real NID" warning;
- disabled submit with prototype explanation;
- summary of what happens in later milestones.

### 9.4 Citizen dashboard placeholder (`/dashboard`)

Purpose: demonstrate the future citizen home and ward-scoped framing.

- demo profile card with a clearly fictional name and ward;
- scope banner explaining ward-scoped access;
- service shortcuts with "planned" status;
- sample request statuses labelled demo;
- privacy and prototype notices;
- no authentication or personal data.

### 9.5 Admin dashboard placeholder (`/admin`)

Purpose: demonstrate the future administrative overview without exposing data.

- demo counts labelled as sample data;
- role and scope summary;
- module readiness table;
- warnings that authorization, audit, and data protection are not active;
- no real accounts, no sensitive data, no actionable admin controls.

## 10. Error, empty, and loading states

- **Empty:** explain why the list is empty and what to do next; avoid blaming the user.
- **Error:** state what happened, whether data was saved, and how to recover.
- **Permission denied:** do not reveal whether the record exists; provide a support path.
- **Offline:** preserve entered form data where safe and explain that submission did not occur.
- **Loading:** use skeleton or text status; announce long operations; prevent duplicate submissions.
- **Session expiry:** warn before expiry where possible; preserve non-sensitive work; never expose data after expiry.

## 11. Privacy and trust in the interface

- Show why each sensitive field is requested.
- Use progressive disclosure for sensitive details.
- Mask NID and financial values by default.
- Never show another person's contact details without a clear, lawful workflow.
- Mark demo/sample data consistently.
- Provide a visible privacy notice and consent record link once implemented.
- Avoid dark patterns: no pre-checked consent, no hidden unsubscribe, no confusing double negatives.

## 12. Prototype limitations

The current prototype:

- uses Blade instead of Vue/Inertia;
- has static demo content and no database-backed records;
- does not authenticate users or create accounts;
- does not submit forms or store entered data;
- does not connect to SMS, email, NID, GIS, or payment services;
- is marked `noindex, nofollow` to avoid being mistaken for a live service.

These limitations must remain visible in the UI and in the README until the corresponding milestone is complete.
