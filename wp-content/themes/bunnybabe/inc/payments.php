<?php
/**
 * DuitNow QR — a manual WooCommerce payment method.
 *
 * Gives customers a second way to pay next to CHIP: they place the order, see
 * your DuitNow QR + the exact amount, scan & pay with any Malaysian bank app,
 * then send the receipt on WhatsApp. The order sits on-hold until you confirm.
 *
 * Upload the QR and set the payee name in Appearance → Customize → Bunny Babe.
 */
defined( 'ABSPATH' ) || exit;

add_filter(
	'woocommerce_payment_gateways',
	function ( $gateways ) {
		$gateways[] = 'BB_Gateway_DuitNow_QR';
		return $gateways;
	}
);

add_action(
	'plugins_loaded',
	function () {
		if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
			return;
		}

		class BB_Gateway_DuitNow_QR extends WC_Payment_Gateway {

			public function __construct() {
				$this->id                 = 'bb_duitnow_qr';
				$this->method_title       = __( 'DuitNow QR', 'bunnybabe' );
				$this->method_description = __( 'Customer scans your DuitNow QR to pay, then sends the receipt on WhatsApp. The order waits on-hold until you confirm payment.', 'bunnybabe' );
				$this->has_fields         = false;
				$icon                     = bb_qr_image_url();
				if ( $icon ) {
					$this->icon = $icon;
				}

				$this->init_form_fields();
				$this->init_settings();

				$this->title             = $this->get_option( 'title' );
				$this->description       = $this->get_option( 'description' );
				$this->order_button_text = __( 'Place order & show QR', 'bunnybabe' );

				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
				add_action( 'woocommerce_thankyou_' . $this->id, array( $this, 'thankyou_page' ) );
				add_action( 'woocommerce_email_before_order_table', array( $this, 'email_instructions' ), 10, 3 );
			}

			public function init_form_fields() {
				$this->form_fields = array(
					'enabled'     => array(
						'title'   => __( 'Enable / Disable', 'bunnybabe' ),
						'type'    => 'checkbox',
						'label'   => __( 'Enable DuitNow QR', 'bunnybabe' ),
						'default' => 'yes',
					),
					'title'       => array(
						'title'   => __( 'Title', 'bunnybabe' ),
						'type'    => 'text',
						'default' => __( 'DuitNow QR', 'bunnybabe' ),
					),
					'description' => array(
						'title'   => __( 'Description', 'bunnybabe' ),
						'type'    => 'textarea',
						'default' => __( 'Scan the QR with any Malaysian bank app, pay the exact amount, then send your receipt on WhatsApp so we can ship your order.', 'bunnybabe' ),
					),
				);
			}

			public function process_payment( $order_id ) {
				$order = wc_get_order( $order_id );
				$order->update_status( 'on-hold', __( 'Awaiting DuitNow QR payment — customer to send receipt on WhatsApp.', 'bunnybabe' ) );
				wc_reduce_stock_levels( $order_id );
				if ( WC()->cart ) {
					WC()->cart->empty_cart();
				}
				return array(
					'result'   => 'success',
					'redirect' => $this->get_return_url( $order ),
				);
			}

			public function thankyou_page( $order_id ) {
				$order = wc_get_order( $order_id );
				if ( $order ) {
					echo wp_kses_post( $this->instructions_html( $order ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped in builder.
				}
			}

			public function email_instructions( $order, $sent_to_admin, $plain_text = false ) {
				if ( $sent_to_admin || $order->get_payment_method() !== $this->id || 'on-hold' !== $order->get_status() ) {
					return;
				}
				echo wp_kses_post( $this->instructions_html( $order, true ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped in builder.
			}

			/** QR + amount + "send receipt on WhatsApp" block. */
			private function instructions_html( $order, $email = false ) {
				$qr     = bb_qr_image_url();
				$name   = (string) get_theme_mod( 'bb_qr_name', '' );
				$amount = html_entity_decode( wp_strip_all_tags( wc_price( $order->get_total() ) ), ENT_QUOTES, 'UTF-8' );
				$msg    = sprintf(
					/* translators: 1: order number, 2: amount */
					__( "Hi Bunny Babe! I've paid for order %1\$s (%2\$s) by DuitNow QR. Here's my receipt:", 'bunnybabe' ),
					$order->get_order_number(),
					$amount
				);
				$wa = bb_whatsapp_order_url( $msg );

				ob_start();
				?>
				<section class="bb-qrpay" style="margin:18px 0;padding:18px;border:2px solid #111;border-radius:16px;background:#fff">
					<h2 style="margin:0 0 6px"><?php esc_html_e( 'Pay by DuitNow QR', 'bunnybabe' ); ?></h2>
					<p style="margin:0 0 10px">
						<?php
						echo esc_html__( 'Scan the QR below and pay ', 'bunnybabe' );
						echo '<strong>' . esc_html( $amount ) . '</strong>';
						echo esc_html__( ', then send your receipt on WhatsApp so we can ship your order.', 'bunnybabe' );
						?>
					</p>
					<?php if ( $qr ) : ?>
						<p style="margin:0 0 10px"><img src="<?php echo esc_url( $qr ); ?>" alt="<?php esc_attr_e( 'DuitNow QR', 'bunnybabe' ); ?>" style="max-width:280px;width:100%;height:auto;border-radius:12px"></p>
					<?php elseif ( ! $email && current_user_can( 'manage_options' ) ) : ?>
						<p style="margin:0 0 10px"><em><?php esc_html_e( 'Admin: upload your DuitNow QR in Appearance → Customize → Bunny Babe.', 'bunnybabe' ); ?></em></p>
					<?php endif; ?>
					<?php if ( $name ) : ?>
						<p style="margin:0 0 10px"><?php esc_html_e( 'Payee:', 'bunnybabe' ); ?> <strong><?php echo esc_html( $name ); ?></strong></p>
					<?php endif; ?>
					<p style="margin:0">
						<a href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener" style="display:inline-block;background:#25D366;color:#fff;font-weight:700;padding:12px 18px;border-radius:999px;text-decoration:none">
							<?php esc_html_e( 'Send receipt on WhatsApp →', 'bunnybabe' ); ?>
						</a>
					</p>
				</section>
				<?php
				return ob_get_clean();
			}
		}
	}
);
