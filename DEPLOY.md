# Auto-deploy to bunnybabe.my (Hostinger)

Every push that changes `wp-content/themes/bunnybabe/` uploads the theme to
Hostinger automatically over FTP, via `.github/workflows/deploy.yml`.

You only set this up **once**. Until the secrets below are added, the workflow
runs green and just prints a reminder — nothing breaks.

## 1. Get your FTP details from Hostinger

hPanel → **Files → FTP Accounts**. You'll see:

- **FTP hostname** (e.g. `ftp.bunnybabe.my` or an IP like `153.x.x.x`)
- **FTP username** (e.g. `u123456789.bunnybabe`)
- **FTP password** (use the one you set, or click *Change password*)

Then find the **theme path**. In hPanel → **Files → File Manager**, open the
folder that holds `wp-content`. The full path to the theme is usually:

```
/public_html/wp-content/themes/bunnybabe/
```

If your store is an addon domain it may be:

```
/domains/bunnybabe.my/public_html/wp-content/themes/bunnybabe/
```

The path **must end with a slash**.

## 2. Add 4 secrets to GitHub

GitHub repo → **Settings → Secrets and variables → Actions → New repository secret**.
Add each of these (names exactly):

| Secret name      | Value                                               |
|------------------|-----------------------------------------------------|
| `FTP_SERVER`     | the FTP hostname                                    |
| `FTP_USERNAME`   | the FTP username                                     |
| `FTP_PASSWORD`   | the FTP password                                     |
| `FTP_THEME_PATH` | the theme path, ending with `/` (see above)         |

## 3. Trigger it

- Push any change (or GitHub → **Actions → Deploy theme to Hostinger → Run workflow**).
- Watch it under the **Actions** tab. Green tick = uploaded.
- First run uploads everything; later runs upload only what changed.
- After it finishes, **purge your cache** (LiteSpeed/plugin) and hard-refresh.

## Notes

- Uses secure FTPS on port 21. If Hostinger rejects it, change `protocol: ftps`
  to `protocol: ftp` in `.github/workflows/deploy.yml`.
- The deploy only mirrors the theme folder — it never touches WordPress core,
  plugins, the database, or uploads.
- It deploys from `main` and `claude/affectionate-ptolemy-xih3ys`. To deploy
  from a different branch, edit the `branches:` list in the workflow.
