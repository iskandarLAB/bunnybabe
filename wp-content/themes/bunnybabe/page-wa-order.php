<?php
/**
 * Template Name: WhatsApp order
 *
 * Ad landing page: pick scent SKUs + quantity, see the live bundle price, then
 * either order on WhatsApp (pre-filled chat) or pay now by DuitNow QR / CHIP.
 */
defined( 'ABSPATH' ) || exit;
get_header();

$bb       = bb_config();
$has_woo  = class_exists( 'WooCommerce' );
$wa_num   = bb_whatsapp_number();
$qr_img   = bb_qr_image_url();
$ajax_url = admin_url( 'admin-ajax.php' );
$icon_wa  = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-13.4 7.8L3 21l1.2-4.4A9 9 0 1 1 21 12z"/></svg>';

// Scent data for the picker (name, SKU, mood, poster, product id).
$order_scents = array();
foreach ( $bb['scents'] as $key => $s ) {
	$order_scents[] = array(
		'key'   => $key,
		'name'  => $s['name'],
		'sku'   => $s['sku'],
		'mood'  => $s['mood'],
		'img'   => bb_asset( 'img/' . $s['poster'] ),
		'pid'   => $has_woo ? bb_scent_product_id( $key ) : 0,
	);
}
?>

<section class="bb-wrap bb-order" id="order">
	<div class="bb-order__head">
		<span class="bb-sticker">order on whatsapp ♡</span>
		<h1 class="bb-h2" style="margin:10px 0 6px"><?php esc_html_e( 'Pick your scents, we chat on WhatsApp', 'bunnybabe' ); ?></h1>
		<p class="bb-lead" style="color:#111;max-width:560px"><?php esc_html_e( 'Choose any scents and quantity below. Order on WhatsApp or pay now by DuitNow QR or CHIP. 30ml EDP · RM39 each · FREE shipping from 2 bottles.', 'bunnybabe' ); ?></p>
	</div>

	<?php if ( $has_woo && ! bb_scent_product_id( array_key_first( $bb['scents'] ) ) ) : ?>
		<p class="bb-order__warn"><?php esc_html_e( 'Products are not set up yet. Run Appearance → Bunny Babe Setup, then reload this page.', 'bunnybabe' ); ?></p>
	<?php endif; ?>

	<div class="bb-order__grid">
		<?php foreach ( $order_scents as $s ) : ?>
			<article class="bb-order__card" data-pid="<?php echo esc_attr( $s['pid'] ); ?>" data-sku="<?php echo esc_attr( $s['sku'] ); ?>" data-name="<?php echo esc_attr( $s['name'] ); ?>">
				<img src="<?php echo esc_url( $s['img'] ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %s scent */ __( 'Bunny Babe %s', 'bunnybabe' ), $s['name'] ) ); ?>" width="400" height="596" loading="lazy">
				<div class="bb-order__info">
					<strong><?php echo esc_html( $s['name'] ); ?></strong>
					<small><?php echo esc_html( $s['mood'] ); ?></small>
					<span class="bb-order__sku"><?php echo esc_html( $s['sku'] ); ?></span>
				</div>
				<div class="bb-stepper bb-order__step">
					<button type="button" data-bb-dec aria-label="<?php echo esc_attr( sprintf( /* translators: %s scent */ __( 'Less %s', 'bunnybabe' ), $s['name'] ) ); ?>">−</button>
					<span data-bb-qty>0</span>
					<button type="button" data-bb-inc aria-label="<?php echo esc_attr( sprintf( /* translators: %s scent */ __( 'More %s', 'bunnybabe' ), $s['name'] ) ); ?>">+</button>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<?php if ( $qr_img ) : ?>
		<div class="bb-order__pay">
			<span><?php esc_html_e( 'Pay by:', 'bunnybabe' ); ?></span>
			<span class="bb-order__paytag"><?php esc_html_e( 'DuitNow QR', 'bunnybabe' ); ?></span>
			<span class="bb-order__paytag"><?php esc_html_e( 'CHIP (FPX / card / e-wallet)', 'bunnybabe' ); ?></span>
		</div>
	<?php endif; ?>
</section>

<!-- Sticky order bar -->
<div class="bb-orderbar" data-bb-orderbar hidden>
	<div class="bb-orderbar__sum">
		<strong data-bb-total>RM0</strong>
		<small data-bb-count><?php esc_html_e( 'No bottles yet', 'bunnybabe' ); ?></small>
	</div>
	<div class="bb-orderbar__btns">
		<a class="bb-btn bb-btn--whatsapp" data-bb-wa href="<?php echo esc_url( bb_whatsapp_order_url() ); ?>" target="_blank" rel="noopener">
			<?php echo $icon_wa; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?>
			<span><?php esc_html_e( 'Order on WhatsApp', 'bunnybabe' ); ?></span>
		</a>
		<?php if ( $has_woo ) : ?>
			<button type="button" class="bb-btn bb-btn--pink" data-bb-paynow><?php esc_html_e( 'Pay now', 'bunnybabe' ); ?></button>
		<?php endif; ?>
	</div>
</div>

<style>
.bb-order{padding:28px 0 140px}
.bb-order__head{text-align:center;margin:0 auto 22px;display:flex;flex-direction:column;align-items:center}
.bb-order__warn{background:#fff3cd;border:2px solid #111;border-radius:12px;padding:12px 14px;font-weight:600;max-width:560px;margin:0 auto 18px;text-align:center}
.bb-order__grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:14px}
.bb-order__card{border:2px solid #111;border-radius:18px;background:#fff;padding:10px;display:flex;flex-direction:column;gap:8px;transition:transform .15s,box-shadow .15s}
.bb-order__card.is-on{box-shadow:6px 6px 0 #FF5CB8;transform:translateY(-2px)}
.bb-order__card img{width:100%;height:auto;border-radius:12px;display:block;aspect-ratio:2/3;object-fit:cover}
.bb-order__info{display:flex;flex-direction:column;gap:2px}
.bb-order__info strong{font-size:17px;line-height:1.1}
.bb-order__info small{color:#555}
.bb-order__sku{font-size:11px;letter-spacing:.04em;color:#888;font-weight:700;text-transform:uppercase}
.bb-order__step{align-self:stretch;justify-content:space-between}
.bb-order__pay{display:flex;flex-wrap:wrap;gap:8px;align-items:center;justify-content:center;margin-top:20px;font-weight:600}
.bb-order__paytag{border:2px solid #111;border-radius:999px;padding:4px 12px;font-size:13px;background:#fff}
.bb-orderbar{position:fixed;left:0;right:0;bottom:0;z-index:40;background:#fff;border-top:2px solid #111;padding:10px 16px;display:flex;gap:12px;align-items:center;justify-content:space-between;box-shadow:0 -6px 24px rgba(0,0,0,.08)}
.bb-orderbar__sum{display:flex;flex-direction:column;line-height:1.15}
.bb-orderbar__sum strong{font-size:22px}
.bb-orderbar__sum small{color:#555}
.bb-orderbar__btns{display:flex;gap:8px;flex-wrap:wrap;justify-content:flex-end}
.bb-btn--whatsapp{background:#25D366;color:#fff;display:inline-flex;align-items:center;gap:6px}
.bb-btn--whatsapp[aria-disabled="true"],.bb-orderbar .bb-btn[disabled]{opacity:.5;pointer-events:none}
@media(max-width:560px){.bb-orderbar{flex-wrap:wrap}.bb-orderbar__btns{flex:1 1 100%}.bb-orderbar__btns .bb-btn{flex:1}}
</style>

<script>
(function () {
	var CFG = {
		unit: <?php echo (float) $bb['unit']; ?>,
		duo: <?php echo (float) $bb['duo']; ?>,
		pack: <?php echo (float) $bb['pack']; ?>,
		ajax: <?php echo wp_json_encode( $ajax_url ); ?>,
		checkout: <?php echo wp_json_encode( home_url( '/#checkout' ) ); ?>,
		waBase: <?php echo wp_json_encode( $wa_num ? 'https://wa.me/' . $wa_num : 'https://wa.me/' ); ?>,
		hasQR: <?php echo $qr_img ? 'true' : 'false'; ?>
	};

	function money(n) {
		return 'RM' + (Math.round(n * 100) / 100).toFixed(2).replace(/\.00$/, '');
	}
	// Mirror of bb_bundle_price(): best combo of 5-packs, pairs, singles.
	function bundlePrice(n) {
		var packs = Math.floor(n / 5), rest = n % 5;
		var duos = Math.floor(rest / 2), single = rest % 2;
		return packs * CFG.pack + duos * CFG.duo + single * CFG.unit;
	}

	var cards = Array.prototype.slice.call(document.querySelectorAll('.bb-order__card'));
	var bar = document.querySelector('[data-bb-orderbar]');
	var elTotal = bar.querySelector('[data-bb-total]');
	var elCount = bar.querySelector('[data-bb-count]');
	var waBtn = bar.querySelector('[data-bb-wa]');
	var payBtn = bar.querySelector('[data-bb-paynow]');
	var qtys = {};

	function selected() {
		return cards.map(function (c) {
			return { pid: c.getAttribute('data-pid'), sku: c.getAttribute('data-sku'), name: c.getAttribute('data-name'), qty: qtys[c.getAttribute('data-sku')] || 0 };
		}).filter(function (x) { return x.qty > 0; });
	}

	function waMessage(items, n, total) {
		var lines = ['Hi Bunny Babe! Nak order:'];
		items.forEach(function (x) { lines.push('• ' + x.qty + '× ' + x.name + ' (' + x.sku + ')'); });
		lines.push('');
		lines.push('Total: ' + money(total) + (n >= 2 ? ' (FREE shipping)' : ' + RM' + <?php echo (float) $bb['ship_fee']; ?> + ' shipping'));
		lines.push('Bayar guna: ' + (CFG.hasQR ? 'DuitNow QR / CHIP?' : 'CHIP?'));
		return lines.join('\n');
	}

	function render() {
		var items = selected();
		var n = items.reduce(function (s, x) { return s + x.qty; }, 0);
		var total = bundlePrice(n);
		cards.forEach(function (c) {
			var q = qtys[c.getAttribute('data-sku')] || 0;
			c.classList.toggle('is-on', q > 0);
			c.querySelector('[data-bb-qty]').textContent = q;
		});
		bar.hidden = n === 0;
		elTotal.textContent = money(total);
		elCount.textContent = n === 0 ? 'No bottles yet' : n + (n === 1 ? ' bottle' : ' bottles') + (n >= 2 ? ' · FREE shipping' : '');
		waBtn.href = CFG.waBase + '?text=' + encodeURIComponent(waMessage(items, n, total));
	}

	cards.forEach(function (c) {
		var sku = c.getAttribute('data-sku');
		var dec = c.querySelector('[data-bb-dec]');
		var inc = c.querySelector('[data-bb-inc]');
		// Picking always works (SKUs come from config); "Pay now" uses the product id.
		inc.addEventListener('click', function () { qtys[sku] = Math.min(50, (qtys[sku] || 0) + 1); render(); });
		dec.addEventListener('click', function () { qtys[sku] = Math.max(0, (qtys[sku] || 0) - 1); render(); });
	});

	if (payBtn) {
		payBtn.addEventListener('click', function () {
			var items = selected();
			if (!items.length) { return; }
			var map = {};
			items.forEach(function (x) { if (x.pid && parseInt(x.pid, 10) > 0) { map[x.pid] = x.qty; } });
			if (!Object.keys(map).length) { window.location.href = waBtn.href; return; }
			payBtn.disabled = true;
			payBtn.textContent = 'One sec…';
			var body = new URLSearchParams();
			body.set('action', 'bb_bag');
			body.set('op', 'addmulti');
			body.set('items', JSON.stringify(map));
			fetch(CFG.ajax, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: body.toString() })
				.then(function (r) { return r.json(); })
				.then(function () { window.location.href = CFG.checkout; })
				.catch(function () { window.location.href = CFG.checkout; });
		});
	}

	render();
})();
</script>

<?php
get_footer();
