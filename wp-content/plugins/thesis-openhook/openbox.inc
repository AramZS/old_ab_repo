<?php
/*
Name: OpenBox
Author: Rick Beckman
Version: 2.3
Description: OpenBox gives you the freedom to add any markup or programming, whether HTML, CSS, JS, or even PHP, to any location on your site. Simply add an OpenBox to your Skin, add your custom code to the box, and enjoy! Warning: OpenBox is *awesome* in that it provides you complete and unfettered access to your site via simple text boxes. If you do not know what you are doing, you *can* break things; therefore, you are strongly recommended to have a test installation of your site, upon which you may test all of your custom code before placing it on your live site. Remember: After you place OpenBox into your Thesis template, you can edit the OpenBox content itself via the Thesis Skin Content page.
Class: openbox
*/

class openbox extends thesis_box {
	/**
	 * Contains the translatable string of the box's name
	 */
	protected function translate() {
		$this->title = $this->name = __( 'OpenBox', 'openhook' );
	}

	/**
	 * Registers the box's options, which in this case is just a code box
	 */
	protected function options() {
		global $thesis;

		return array(
			'code' => array(
				'type' => 'textarea',
				'rows' => 8,
				'code' => true,
				'label' => __( 'Your Custom Code', 'openhook' ),
				'tooltip' => sprintf( __( 'This OpenBox allows you to insert arbitrary %1$s, plain text, JavaScript, %2$s, or more.<br /><br /><strong>Note:</strong> Scripts and %2$s which are improperly coded may break your site or prevent access to this screen. Check and double-check all code!', 'brazenly_coded_box' ), $thesis->api->base[ 'html' ], $thesis->api->base[ 'php' ] ) ),
			);
	}

	/**
	 * Processes & displays users' custom code
	 */
	public function html() {
		echo trim( ! empty( $this->options[ 'code' ] ) ? eval( '?>' . stripslashes( $this->options[ 'code'] ) . '<?php ' ) : '' );
	}
}