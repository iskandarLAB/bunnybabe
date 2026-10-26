<?php defined( 'ABSPATH' ) || exit; ?>
</main>

<footer class="bb-footer">
	<div class="bb-wrap bb-footer__inner">
		<div class="bb-footer__brand">
			<img src="<?php echo esc_url( bb_asset( 'img/logo.png' ) ); ?>" alt="<?php esc_attr_e( 'Bunny Babe', 'bunnybabe' ); ?>" width="580" height="104">
			<span><?php esc_html_e( 'Affordable fragrance for everyday girls.', 'bunnybabe' ); ?></span>
		</div>
		<div class="bb-footer__cols">
			<div>
				<strong><?php esc_html_e( 'Shop', 'bunnybabe' ); ?></strong>
				<a href="<?php echo esc_url( home_url( '/#scents' ) ); ?>"><?php esc_html_e( 'All scents', 'bunnybabe' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#bundles' ) ); ?>"><?php esc_html_e( 'Bundles', 'bunnybabe' ); ?></a>
			</div>
			<div>
				<strong><?php esc_html_e( 'Help', 'bunnybabe' ); ?></strong>
				<a href="<?php echo esc_url( bb_track_url() ); ?>"><?php esc_html_e( 'Track order', 'bunnybabe' ); ?></a>
				<span><?php esc_html_e( 'Shipping RM5 · FREE for 2+ bottles', 'bunnybabe' ); ?></span>
				<a href="<?php echo esc_url( bb_whatsapp_url() ); ?>"><?php esc_html_e( 'Contact', 'bunnybabe' ); ?></a>
			</div>
			<div>
				<strong><?php esc_html_e( 'Policies', 'bunnybabe' ); ?></strong>
				<a href="<?php echo esc_url( home_url( '/shipping-policy/' ) ); ?>"><?php esc_html_e( 'Shipping', 'bunnybabe' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/refund-returns/' ) ); ?>"><?php esc_html_e( 'Refund & returns', 'bunnybabe' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy', 'bunnybabe' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'bunnybabe' ); ?></a>
			</div>
		</div>
	</div>
	<div class="bb-wrap bb-footer__legal">© <?php echo esc_html( gmdate( 'Y' ) ); ?> Bunny Babe. <?php esc_html_e( 'Cute outside, chaos inside.', 'bunnybabe' ); ?></div>
</footer>

<?php
if ( is_front_page() && class_exists( 'WooCommerce' ) && WC()->cart ) :
	$bb_cnt = (int) WC()->cart->get_cart_contents_count();
	?>
<!-- Sticky buy bar (TikTok-style) -->
<div class="bb-buybar">
	<a class="bb-buybar__icon" href="<?php echo esc_url( bb_whatsapp_url() ); ?>" target="_blank" rel="noopener">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a9 9 0 0 1-13.4 7.8L3 21l1.2-4.4A9 9 0 1 1 21 12z"/></svg>
		<span><?php esc_html_e( 'Chat', 'bunnybabe' ); ?></span>
	</a>
	<button type="button" class="bb-buybar__icon" data-bb-openbag data-bb="bag-target" aria-label="<?php esc_attr_e( 'Open bag', 'bunnybabe' ); ?>">
		<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 7h12l-1 13H7z"/><path d="M9 7a3 3 0 0 1 6 0"/></svg>
		<span class="bb-dot" data-bb="count" <?php echo $bb_cnt ? '' : 'hidden'; ?>><?php echo (int) $bb_cnt; ?></span>
		<span><?php esc_html_e( 'Bag', 'bunnybabe' ); ?></span>
	</button>
	<button type="button" class="bb-btn bb-btn--pink bb-buybar__buy" data-bb="buy-main" data-mode="<?php echo $bb_cnt ? 'checkout' : 'buy'; ?>">
		<?php if ( $bb_cnt ) : ?>
			<strong><?php echo esc_html( sprintf( /* translators: %d count */ __( 'Checkout (%d)', 'bunnybabe' ), $bb_cnt ) ); ?></strong>
			<small><?php echo wp_kses_post( WC()->cart->get_total() ); ?></small>
		<?php else : ?>
			<strong><?php esc_html_e( 'Buy now', 'bunnybabe' ); ?></strong>
			<small><?php esc_html_e( 'RM39 · FREE shipping 2+', 'bunnybabe' ); ?></small>
		<?php endif; ?>
	</button>
</div>
<div class="bb-toast" data-bb="toast" role="status" aria-live="polite"></div>
<div class="bb-recent" data-bb="recent" aria-live="polite" hidden>
	<button type="button" class="bb-recent__main" data-bb-open="">
		<img alt="" width="52" height="52">
		<span class="bb-recent__text"><strong></strong><span></span><small></small></span>
	</button>
	<button type="button" class="bb-recent__x" data-bb="recent-x" aria-label="<?php esc_attr_e( 'Hide recent purchases', 'bunnybabe' ); ?>">×</button>
</div>
<?php endif; ?>

<?php
$bb_wa = bb_whatsapp_url();
if ( '#' !== $bb_wa ) :
	$bb_wa = add_query_arg( 'text', rawurlencode( __( 'Hi Bunny Babe! I have a question ♡', 'bunnybabe' ) ), $bb_wa );
	?>
<a class="bb-wa" href="<?php echo esc_url( $bb_wa ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'bunnybabe' ); ?>">
	<svg viewBox="0 0 32 32" width="30" height="30" fill="currentColor" aria-hidden="true"><path d="M16.04 4C9.9 4 4.9 9 4.9 15.14c0 2.2.64 4.25 1.74 5.98L4.5 28l7.05-2.08a11.1 11.1 0 0 0 4.49.95h.01c6.14 0 11.14-5 11.14-11.14C27.18 9 22.18 4 16.04 4zm0 20.3h-.01a9.2 9.2 0 0 1-4.68-1.28l-.34-.2-3.49 1.03.93-3.4-.22-.35a9.17 9.17 0 0 1-1.4-4.86c0-5.07 4.13-9.2 9.2-9.2 2.46 0 4.77.96 6.5 2.7a9.13 9.13 0 0 1 2.7 6.5c0 5.07-4.13 9.2-9.2 9.2zm5.05-6.9c-.28-.14-1.63-.8-1.88-.9-.25-.09-.43-.14-.62.14-.18.28-.71.9-.87 1.08-.16.18-.32.2-.6.07-.28-.14-1.17-.43-2.22-1.37-.82-.73-1.37-1.63-1.53-1.9-.16-.28-.02-.43.12-.57.13-.13.28-.32.42-.49.14-.16.18-.28.28-.46.09-.18.05-.35-.02-.49-.07-.14-.62-1.5-.85-2.05-.22-.53-.45-.46-.62-.47l-.53-.01c-.18 0-.49.07-.74.35-.25.28-.97.95-.97 2.3 0 1.36.99 2.67 1.13 2.85.14.18 1.95 2.98 4.73 4.18.66.28 1.18.45 1.58.58.66.21 1.27.18 1.75.11.53-.08 1.63-.67 1.86-1.31.23-.64.23-1.19.16-1.31-.07-.12-.25-.18-.53-.32z"/></svg>
	<span class="bb-wa__txt"><?php esc_html_e( 'Chat', 'bunnybabe' ); ?></span>
</a>
<?php endif; ?>

</div>
<?php wp_footer(); ?>
</body>
</html>
