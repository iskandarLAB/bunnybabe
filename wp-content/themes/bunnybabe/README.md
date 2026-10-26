# Bunny Babe theme — setup guide

## 1. Before you upload
- WordPress installed on bunnybabe.my with SSL (https) on.
- Plugins installed and active: **WooCommerce**, **CHIP for WooCommerce**, **EasyParcel**.
- Settings → Permalinks → **Post name**.

## 2. Upload the theme
Appearance → Themes → Add New → Upload Theme → choose `bunnybabe.zip` → Install → **Activate**.

## 3. Run setup (one click)
Appearance → **Bunny Babe Setup** → **Run setup**. It creates only what is missing:
- 5 products (Vanilla, Secret, Aurelle, Marsh, Swift) at RM19.90 with photos, in the "Bunny Babe" category
- Voucher **BUNNY5** (RM5, first order only)
- "Home" page as the front page + "Track Order" page + **"Order on WhatsApp"** page (`/order`, the ad landing)
- Classic WooCommerce checkout (old content is kept as a backup)
- Store set to Malaysia only, currency RM
- Shipping zone "Malaysia" with RM6 flat rate

## 4. Your settings
- Appearance → Customize → **Bunny Babe**: WhatsApp number, affiliate form link, courier tracking link (use `{tracking}` where the AWB goes), top bar text, **DuitNow QR image + payee name**.
- WooCommerce → Settings → Payments → **CHIP**: turn on and enter your keys there. **DuitNow QR** is a built-in payment method (on by default, no plugin needed).

## Ads → WhatsApp → QR / CHIP (the funnel)
Point your Meta / TikTok ads at **`/order`** (your `bunnybabe.my/order` page):
1. The customer picks any scents + quantity. They see the live bundle price.
2. **Order on WhatsApp** opens a chat with your number, pre-filled with the chosen SKUs, quantities and total — e.g. `2× Vanilla (BB-VANILLA)`. You reply and take payment in the chat.
3. **Pay now** sends them to checkout where they choose **DuitNow QR** or **CHIP**.
- **DuitNow QR**: after placing the order they see your QR + the exact amount + a *Send receipt on WhatsApp* button. The order waits **on-hold** until you confirm payment, then you mark it **Processing** and ship.
- **CHIP**: FPX / card / e-wallet, paid online instantly (needs the CHIP plugin + keys).
- Upload your QR in Appearance → Customize → **Bunny Babe → DuitNow QR image**.

## How the store rules work
| Rule | Where |
|---|---|
| 1 = RM19.90, 2 = RM35.50, 5 = RM85.50 (mixed scents, best combo) | Automatic "Bundle savings" line at checkout |
| Shipping RM6, FREE from 2 bottles | Flat rate in the Malaysia zone; the theme makes it free at 2+ |
| BUNNY5 first order only | Checked by phone + email at checkout |
| RM5 voucher for the 2nd order | Created automatically when a first order is paid; shown on the thank-you page, in the order email and as an order note |
| Claim-voucher WhatsApp numbers | WooCommerce → **Voucher leads** (with an "Open WhatsApp" link) |

Change any price or rule in `inc/config.php`.

## Shipping + tracking (EasyParcel)
1. Book the parcel in EasyParcel as usual.
2. In the order, fill the **Bunny Babe tracking** box (courier + tracking number).
3. Change the order status: **Processing** → **Shipped** → **Out for delivery** → **Completed**. Bulk actions work too.
4. Customers see this on the Track Order page using their order number + phone.

## Test before going live
Place a real order end to end (small amount), check the thank-you page, the email, then Track Order.
