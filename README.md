# Wedding E-Invitation System

A premium wedding e-invitation system with guest RSVP, wishes moderation, and admin management.

## Project Structure

- `/admin`           - Administrative management module.
    - `/gallery`     - Gallery and captured moments management.
    - `/rsvp`        - Guest list and RSVP data.
    - `/settings`    - Global site settings (Couple names, dates, maps).
    - `/users`       - Admin user management.
    - `/wishes`      - Guest wishes moderation.
    - `/assets`      - Admin-specific stylesheets.
- `/assets`          - Global public assets.
    - `/images`      - Static site images and icons.
    - `/uploads`     - User-uploaded content (Gallery, Favicons).
- `/auth`            - Authentication processing logic.
- `/config`          - Core system configuration and database connections.
- `/database`        - Database schema and migration files.
- `/includes`        - Reusable frontend components (Sticky navbar, music player).

## Production Deployment & Security

1. **Environment Variables**: All sensitive database credentials are stored in `.env`. Ensure this file is NOT tracked by version control systems.
2. **Access Control**: `.htaccess` is configured to:
    - Block direct browser access to `/config`, `/database`, and `/includes`.
    - Protect `.env` and `.sql` files from being downloaded.
    - Disable directory browsing (`Options -Indexes`).
    - Enforce security headers (XSS Protection, Frame Options).
3. **Wishes Moderation**: By default, all wishes with messages are set to `pending`. Admins must approve them in the dashboard before they appear on the public site.

## Installation

1. Create a database named `wedding_db`.
2. Import `/database/wedding.sql`.
3. Configure your credentials in `.env`.
4. Set the `BASE_URL` in `config/config.php`.
# wedding-invitation
# wedding-invitation
# weeding-invitation
