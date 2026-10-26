<?php
/**
 * Appearance → Customize → Bunny Babe.
 */
defined( 'ABSPATH' ) || exit;

add_action(
	'customize_register',
	function ( $wp_customize ) {
		$wp_customize->add_section(
			'bb_settings',
			array(
				'title'    => __( 'Bunny Babe', 'bunnybabe' ),
				'priority' => 30,
			)
		);

		$fields = array(
			'bb_whatsapp'      => array(
				'label'   => __( 'WhatsApp number (with country code)', 'bunnybabe' ),
				'default' => '60176842008',
				'type'    => 'text',
				'clean'   => 'sanitize_text_field',
			),
			'bb_affiliate_url' => array(
				'label'   => __( 'Affiliate sign-up form link', 'bunnybabe' ),
				'default' => '',
				'type'    => 'url',
				'clean'   => 'esc_url_raw',
			),
			'bb_tracking_url'  => array(
				'label'       => __( 'Courier tracking link', 'bunnybabe' ),
				'description' => __( 'Use {tracking} where the tracking number goes. Leave empty to hide the button.', 'bunnybabe' ),
				'default'     => '',
				'type'        => 'text',
				'clean'       => 'sanitize_text_field',
			),
			'bb_announcement'  => array(
				'label'   => __( 'Top bar text', 'bunnybabe' ),
				'default' => 'FREE shipping for 2+ bottles ♡',
				'type'    => 'text',
				'clean'   => 'sanitize_text_field',
			),
			'bb_qr_name'       => array(
				'label'       => __( 'DuitNow QR — payee name', 'bunnybabe' ),
				'description' => __( 'The name shown next to your QR (e.g. your business or bank account name).', 'bunnybabe' ),
				'default'     => '',
				'type'        => 'text',
				'clean'       => 'sanitize_text_field',
			),
		);

		foreach ( $fields as $id => $f ) {
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $f['default'],
					'sanitize_callback' => $f['clean'],
				)
			);
			$wp_customize->add_control(
				$id,
				array(
					'label'       => $f['label'],
					'description' => isset( $f['description'] ) ? $f['description'] : '',
					'section'     => 'bb_settings',
					'type'        => $f['type'],
				)
			);
		}

		// DuitNow QR image (shown at checkout and on the thank-you page when the
		// customer pays by QR, and on the WhatsApp order page).
		$wp_customize->add_setting(
			'bb_qr_image',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'bb_qr_image',
				array(
					'label'       => __( 'DuitNow QR image', 'bunnybabe' ),
					'description' => __( 'Upload your DuitNow / bank QR. Customers scan it to pay when they pick "DuitNow QR".', 'bunnybabe' ),
					'section'     => 'bb_settings',
				)
			)
		);
	}
);
