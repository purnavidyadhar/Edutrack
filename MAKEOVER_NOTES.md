# EduTrack Full Dashboard Makeover

This build focuses on the project statement: identifying slow learners and giving tailored remedial support.

## Major changes

- Removed old sidebar dashboard approach and replaced it with a modern top navigation studio layout.
- Added real RBAC route protection using `role` middleware.
- Students can no longer access student creation, marks upload, reports, or teacher/admin management.
- Teacher dashboard is now a command center, not a simple analytics template.
- Student dashboard is now a personal learning journey, not a generic dashboard.
- Evaluation logic no longer uses random values.
- Student risk is calculated from marks, attendance, assignments where available, and progress records.

## Teacher-side features added

- Priority Learner Board
- Intervention Queue
- Risk Distribution chart
- Subject Weakness map
- Explainable learner support strategy
- Quick actions for marks, students and remedial plans
- Viva-ready feature cards explaining the algorithmic flow

## Student-side features added

- My Learning Space dashboard
- Readiness score ring
- Today Mission Board
- Focus Areas from weakest subjects
- Growth graph
- Active remedial plan section
- Badge system based on performance/support state

## Login accounts after seeding

- Admin: admin@edutrack.com / password
- Teacher: sarah@edutrack.com / password
- Student examples: alex@edutrack.com / password, emily@edutrack.com / password

## Run commands

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
npm run dev
```
