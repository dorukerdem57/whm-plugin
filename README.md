# WHM WP Manager

A **WebHost Manager (WHM) plugin** for centrally managing **WordPress sites** at scale.
Built to work with the **Network Campaign Hub WordPress theme** and its companion **WordPress REST plugin**.

This plugin gives you full control over **100% of the theme’s features** and lets you run **bulk updates** across dozens or hundreds of WordPress sites directly from WHM.

---

## ✨ Features

- **Site Registry**
  - Auto-scan WHM/cPanel accounts for WordPress installations
  - Store base URLs, tokens, and group/subgroup assignments

- **Header & Identity**
  - Update logo (dark/light variants, alt text, max width, retina toggle)
  - Change site title & tagline
  - Switch header layout (compact / stacked / logo-only)
  - Update favicon / site icon

- **Content Blocks**
  - Head banner (title, subtitle, image, CTA)
  - Latest posts row (3-card layout)
  - Short intro text (100–200 words)
  - Middle banner slot
  - Long SEO content (~800+ words)
  - FAQ section (full CRUD)

- **Brands Sidebar**
  - Full CRUD (add, edit, remove brands)
  - Update logo, link, bonus text, extra text
  - Reorder with drag & drop
  - Bulk edit brands across multiple sites

- **Posts & Media**
  - Create / update posts & pages (title, slug, content, excerpt, featured image)
  - Replace images inside content
  - Upload media (with alt text)

- **SEO**
  - Update meta title & description
  - Update OG/Twitter tags
  - Toggle schema data
  - Refresh “last updated” date
  - Purge caches

- **Bulk Operations**
  - Select any number of sites (5, 10, 100+)
  - Apply updates to one or many theme sections
  - Dry-run preview & diff
  - Job queue with retries and logs

- **Security**
  - AES-256 encrypted token & credential vault
  - Bearer token auth for WordPress REST plugin
  - IP allowlist for WHM server
  - Idempotency keys for safe retries

---

## 📂 File Structure

```
/usr/local/cpanel/whostmgr/docroot/cgi/whm-wp-manager/
├─ index.php          # Router entrypoint
├─ bootstrap.php      # Autoload + config
├─ config.php         # Secrets + constants (chmod 600)
/lib
├─ Http.php           # HTTP client to WP REST
├─ Crypto.php         # AES-256 encryption
├─ Db.php             # SQLite wrapper
├─ Jobs.php           # Job queue + bulk runner
├─ Sites.php          # Site scanning
├─ Validator.php      # Input validation
/views
├─ layout.php         # Layout wrapper
├─ dashboard.php      # Overview
├─ sites.php          # Site registry + groups
├─ brands.php         # Brand Manager CRUD
├─ header.php         # Header/logo/title controls
├─ content.php        # Content sections
├─ seo.php            # SEO + schema
├─ media.php          # Media manager
├─ bulk.php           # Multi-site bulk editor
└─ jobs.php           # Job status & logs
/public
├─ styles.css
├─ app.js
└─ icon.svg
/data
└─ whmwp.sqlite       # SQLite DB (sites, groups, jobs, vault)
/logs
└─ app.log
```

Plugin registration file:

```
/var/cpanel/apps/whm-wp-manager.conf
```

```ini
name=WHM WP Manager
api_version=1
app=whm-wp-manager
category=thirdparty
group=WordPress Tools
displayname=WHM WP Manager
entry=/cgi/whm-wp-manager/index.php
icon=/cgi/whm-wp-manager/public/icon.svg
```

Enable + restart:

```
/usr/local/cpanel/scripts/restartsrv_cpsrvd
```

🔐 Configuration

Keyfile for encryption

```
mkdir -p /etc/whmwp && chmod 700 /etc/whmwp
openssl rand -hex 48 > /etc/whmwp/key
chmod 600 /etc/whmwp/key
```

config.php

```php
<?php
define('WHM_WP_KEYFILE', '/etc/whmwp/key');
define('WHM_WP_CONCURRENCY', 6);
```

🗄 Database Schema

SQLite tables (auto-created on first run):

- `sites` — domains, users, base_url, token (encrypted)
- `groups`, `subgroups`, `site_groups` — org hierarchy
- `jobs`, `job_results` — job queue + per-site results
- `wp_users_vault` — encrypted human publisher accounts

🚀 Usage Flow

1. Register & enable plugin in WHM (.conf file + restart cpsrvd).
2. Open WHM sidebar → WordPress Tools → WHM WP Manager.
3. Scan for sites (auto-detect WP installs).
4. Add API tokens from each site (issued by WP companion plugin).
5. Manage sections:
   - Header (logo/title/tagline/favicon)
   - Content (banner, intro, latest posts, long content, FAQ, middle banner)
   - Brands (CRUD logos/texts, reorder)
   - SEO (meta/OG/Twitter/schema, last-updated)
6. Bulk select sites → choose scope (Brands, Header, etc.) → preview changes → run job.
7. Check job status & logs in Jobs tab.

🔒 Security Notes

- Always run over HTTPS.
- Tokens are encrypted with AES-256-GCM (key at /etc/whmwp/key).
- Logs should never contain plaintext passwords or tokens.
- Idempotency keys prevent duplicate writes.
- Optional IP allowlist at the WordPress REST companion plugin.

🔧 Development Notes

- PHP 8+ required on WHM server.
- Uses cURL + SQLite (PDO).
- No external dependencies; simple vanilla CSS/JS.
- Code style: WordPress PHP standards.

📌 Next Steps

- Implement UI panels in /views/ mapped 1:1 to companion plugin REST endpoints.
- Build Brand Manager (add/edit/remove/reorder brands with logos + campaign texts).
- Extend Bulk Editor to apply any theme section changes across multiple sites.
- Test end-to-end on staging sites before production.

