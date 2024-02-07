<?php
if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["etDeactivate"]) && $_POST["etDeactivate"] == "deactivate" ){

	// get plugin deactivate url
	$etDeactivateUrl = ( isset($_POST["etDeactivateUrl"]) ) ? sanitize_url($_POST["etDeactivateUrl"]) : "?";

    // get deactivate reason
	$reason = ( isset($_POST["reason"]) ) ? intval($_POST["reason"]) : 0;
	
    // get deactivate user reason
	$userReason = ( isset($_POST["user-reason"]) ) ? sanitize_text_field($_POST["user-reason"]) : null;

	$requestUrl = "https://store.planetstudio.am/test.php";
	$args = array(
		'headers'	=> array('Content-Type: text/html; charset=UTF-8'),
		'body'		=> array(
			'domain'		=> get_site_url(),
			'reason'		=> $reason,
			'userReason'	=> $userReason,
			'plugin'		=> 'WPC Simple Translate ' . ET_VERSION,
		),
		'method'		=> 'POST',
		'data_format'	=> 'body',
	);
	wp_remote_post( $requestUrl, $args );

	// redirect to bank page
	wp_redirect($etDeactivateUrl);
	exit;

}
?>
<div id="et-deactivate-popup" class="et-popup">
	<div id="et-deactivate-form-container">
		
		<form method="post">

			<div class="et-deactivate-form-header">
				<?php _e( "WPC Simple Translate", 'et' ) ?>
			</div>

			<div class="et-deactivate-form-body">

				<p><?php _e( "If you have a moment, please let us know why you are deactivating this plugin. All submissions are anonymous and we only use this feedback to improve this plugin.", 'et' ) ?></p>

				<label>
					<input type="radio" name="reason" value="1">
					<?php _e( "I'm only deactivating temporarily", 'et' ) ?>
				</label>
				<label>
					<input type="radio" name="reason" value="2">
					<?php _e( "I no longer need the plugin", 'et' ) ?>
				</label>
				<label>
					<input type="radio" name="reason" value="3">
					<?php _e( "I only needed the plugin for a short period", 'et' ) ?>
				</label>
				<label>
					<input type="radio" name="reason" value="4">
					<?php _e( "The plugin broke my site", 'et' ) ?>
				</label>
				<div id="et-reason-other-field-4" class="et-reason-other-field">
					<p><?php _e( "We're sorry to hear that, check our support. Can you describe the issue?", 'et' ) ?></p>
					<textarea name="user-reason" rows="6"></textarea>
				</div>			
				<label>
					<input type="radio" name="reason" value="5">
					<?php _e( "The plugin suddenly stopped working", 'et' ) ?>
				</label>
				<div id="et-reason-other-field-5" class="et-reason-other-field">
					<p><?php _e( "We're sorry to hear that, check our support. Can you describe the issue?", 'et' ) ?></p>
					<textarea name="user-reason" rows="6"></textarea>
				</div>
				<label>
					<input type="radio" name="reason" value="6">
					<?php _e( "Other", 'et' ) ?>
				</label>
				<div id="et-reason-other-field-6" class="et-reason-other-field">
					<p><?php _e( "Please describe why you're deactivating", 'et' ) ?></p>
					<textarea name="user-reason" rows="6"></textarea>
				</div>

				<div id="et-deactivation-error-msg">
					<?php _e( "Please select at least one option.", 'et' ) ?>
				</div>

			</div>
				
			<div class="et-deactivate-form-footer">
				<a href="#" id="et-skip-and-deactivate"><?php _e( "Skip and Deactivate", 'et' ) ?></a>
				<input type="hidden" name="etDeactivate" value="deactivate">
				<input type="hidden" id="et-deactivate-url" name="etDeactivateUrl" value="">
				<input type="button" class="button popupCloseButton" value="<?php _e( "Cancel", 'et' ) ?>">
				<input type="submit" class="button button-primary" value="<?php _e( "Submit and Deactivate", 'et' ) ?>">
			</div>

		</form>

	</div>
</div>