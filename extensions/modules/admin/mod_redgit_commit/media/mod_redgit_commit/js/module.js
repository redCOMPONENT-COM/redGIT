(function($) {
	$(document).ready(function(e) {
		var $form             = $('form#mod-redgit-commit'),
			$actionsContainer = $('.js-mod-redgit-commit-actions'),
			$legend           = $('.js-mod-redgit-commit-msg'),
			// Hard reset Alerts
			$confirmResetAlert = $('.js-mod-redgit-commit-msg-confirm-reset'),
			$wipResetAlert     = $('.js-mod-redgit-commit-msg-wip-reset'),
			$successResetAlert = $('.js-mod-redgit-commit-msg-success-reset'),
			// Commit Alerts
			$confirmCommitAlert = $('.js-mod-redgit-commit-msg-confirm-commit'),
			$wipCommitAlert     = $('.js-mod-redgit-commit-msg-wip-commit'),
			$successCommitAlert = $('.js-mod-redgit-commit-msg-success-commit'),
			// Error Alerts
			$errorAlert       = $('.js-mod-redgit-commit-msg-error');
			$errorMessage     = $('.js-mod-redgit-commit-msg-error-message');

		// Reset button clicked
		$('.js-mod-redgit-commit-btn-reset').click(function(){
			$legend.hide();
			$confirmResetAlert.show(150);
			$actionsContainer.hide(150);
		});

		// Cancel reset button clicked
		$('.js-mod-redgit-commit-btn-cancel-reset').click(function(){
			$legend.show();
			$confirmResetAlert.hide(150);
			$actionsContainer.show(150);
		});

		// Confirm reset button clicked
		$('.js-mod-redgit-commit-btn-confirm-reset').click(function(){
			$confirmResetAlert.hide(150);
			$wipResetAlert.show(150);

			var data = $form.serializeArray();

			$.post('index.php?option=com_redgit&task=git.ajaxHardReset', data, 'json')
			.done(function(){
				$wipResetAlert.hide(150);
				$successResetAlert.show(150);
			})
			.fail(function(response){
				$wipResetAlert.hide(150);
				$errorMessage.text(response.responseText)
				$errorAlert.show(150);
			});
		});

		// Commit button clicked
		$('.js-mod-redgit-commit-btn-commit').click(function(){
			$legend.hide();
			$confirmCommitAlert.show(150);
			$actionsContainer.hide(150);
		});

		// Cancel commit button clicked
		$('.js-mod-redgit-commit-btn-cancel-commit').click(function(){
			$legend.show();
			$confirmCommitAlert.hide(150);
			$actionsContainer.show(150);
		});

		// Confirm commit button clicked
		$('.js-mod-redgit-commit-btn-confirm-commit').click(function(){
			$confirmCommitAlert.hide(150);
			$wipCommitAlert.show(150);

			var data = $form.serializeArray();

			$.post('index.php?option=com_redgit&task=git.ajaxCommit', data, 'json')
			.done(function(){
				$wipCommitAlert.hide(150);
				$successCommitAlert.show(150);
			})
			.fail(function(response){
				$wipCommitAlert.hide(150);
				$errorMessage.text(response.responseText)
				$errorAlert.show(150);
			});
		});

		// Return button clicked
		$('.js-mod-redgit-commit-btn-return').click(function(){
			$legend.show();

			// Hide reset alerts
			$wipResetAlert.hide(150);
			$successResetAlert.hide(150);
			$confirmResetAlert.hide(150);

			// Hide commit alerts
			$wipCommitAlert.hide(150);
			$successCommitAlert.hide(150);
			$confirmCommitAlert.hide(150);

			// Hide errors
			$errorAlert.hide(150);

			$actionsContainer.show(150);
		});

		// Reload button clicked
		$('.js-mod-redgit-commit-btn-reload').click(function(){
			window.location.href = window.location.href;
		});
	});
})(jQuery);
