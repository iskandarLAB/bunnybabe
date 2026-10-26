# Previews (drafts)

Standalone HTML mockups — open in any browser. These are **demos only**, not the live site.

- **`whatsapp-bot-preview.html`** — simulation of the WhatsApp ordering bot:
  greeting → pick scent + qty → **upsell to 2 bottles (RM59 + free shipping)**
  and **Babe Pack 5 bottles (RM99)** → address → pay by DuitNow QR or CHIP.
  Prices, SKUs and bundle logic mirror `wp-content/themes/bunnybabe/inc/config.php`.
- **`order-page-preview.html`** — mockup of the `/order` ad-landing page (SKU
  picker + live bundle price + "Order on WhatsApp" / "Pay now").

## Status / next step
The real `/order` page and the DuitNow QR + CHIP checkout are already built into
the theme (see `wp-content/themes/bunnybabe/`). The WhatsApp **bot** is still a
mockup.

To make the bot real, it needs the **WhatsApp Business Cloud API** (Meta):
1. A WhatsApp Business number registered to the Cloud API (a normal WhatsApp /
   WhatsApp Business app number can't be used once on the API).
2. From Meta: Access token + Phone Number ID + a webhook verify token.
3. A webhook endpoint (can live at `bunnybabe.my/wa-webhook`) that replies with
   the interactive menu + upsell and sends the DuitNow QR image + CHIP link.

Once the WhatsApp number is sorted, the next task is to write that webhook using
the same config (SKUs, prices, QR, CHIP) as the theme.
