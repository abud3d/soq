# Security

- PHP 8.2+ and prepared PDO statements.
- Passwords use PHP `password_hash` / `password_verify`.
- CSRF token required for state-changing browser requests.
- Session cookies are HttpOnly, SameSite=Lax and Secure under HTTPS.
- Registration, login and publishing IPs are private operational data and must never be rendered publicly.
- Production must rate-limit authentication, comments and publishing at the reverse proxy/application layer.
- Image uploads must be decoded/re-encoded server-side before public serving; never trust extension or client MIME.
- Secrets live in `.env`, never Git.
- Email verification is required before production publishing.
