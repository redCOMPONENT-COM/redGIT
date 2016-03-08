(function($) {
	$(document).ready(function(e) {
		var $commitForm             = $('form#mod-redgit-commit'),
			$commitActionsContainer = $('.js-mod-redgit-commit-actions'),
			$commitLegend           = $('.js-mod-redgit-commit-msg'),
			// Hard reset Alerts
			$commitConfirmResetAlert = $('.js-mod-redgit-commit-msg-confirm-reset'),
			$commitWipResetAlert     = $('.js-mod-redgit-commit-msg-wip-reset'),
			$commitSuccessResetAlert = $('.js-mod-redgit-commit-msg-success-reset'),
			// Commit Alerts
			$confirmCommitAlert = $('.js-mod-redgit-commit-msg-confirm-commit'),
			$wipCommitAlert     = $('.js-mod-redgit-commit-msg-wip-commit'),
			$successCommitAlert = $('.js-mod-redgit-commit-msg-success-commit'),
			// Error Alerts
			$commitErrorAlert       = $('.js-mod-redgit-commit-msg-error');
			$commitErrorMessage     = $('.js-mod-redgit-commit-msg-error-message');

		// Reset button clicked
		$('.js-mod-redgit-commit-btn-reset').click(function(){
			$commitLegend.hide();
			$commitConfirmResetAlert.show(150);
			$commitActionsContainer.hide(150);
		});

		// Cancel reset button clicked
		$('.js-mod-redgit-commit-btn-cancel-reset').click(function(){
			$commitLegend.show();
			$commitConfirmResetAlert.hide(150);
			$commitActionsContainer.show(150);
		});

		// Confirm reset button clicked
		$('.js-mod-redgit-commit-btn-confirm-reset').click(function(){
			$commitConfirmResetAlert.hide(150);
			$commitWipResetAlert.show(150);

			var data = $commitForm.serializeArray();

			$.post('index.php?option=com_redgit&task=git.ajaxHardReset', data, 'json')
			.done(function(){
				$commitWipResetAlert.hide(150);
				$commitSuccessResetAlert.show(150);
			})
			.fail(function(response){
				$commitWipResetAlert.hide(150);
				$commitErrorMessage.text(response.responseText)
				$commitErrorAlert.show(150);
			});
		});

		// Commit button clicked
		$('.js-mod-redgit-commit-btn-commit').click(function(){
			$commitLegend.hide();
			$confirmCommitAlert.show(150);
			$commitActionsContainer.hide(150);
		});

		// Cancel commit button clicked
		$('.js-mod-redgit-commit-btn-cancel-commit').click(function(){
			$commitLegend.show();
			$confirmCommitAlert.hide(150);
			$commitActionsContainer.show(150);
		});

		// Confirm commit button clicked
		$('.js-mod-redgit-commit-btn-confirm-commit').click(function(){
			$confirmCommitAlert.hide(150);
			$wipCommitAlert.show(150);

			var data = $commitForm.serializeArray();

			$.post('index.php?option=com_redgit&task=git.ajaxCommit', data, 'json')
			.done(function(){
				$wipCommitAlert.hide(150);
				$successCommitAlert.show(150);
			})
			.fail(function(response){
				$wipCommitAlert.hide(150);
				$commitErrorMessage.text(response.responseText);
				$commitErrorAlert.show(150);
			});
		});

		// Return button clicked
		$('.js-mod-redgit-commit-btn-return').click(function(){
			$commitLegend.show();

			// Hide reset alerts
			$commitWipResetAlert.hide(150);
			$commitSuccessResetAlert.hide(150);
			$commitConfirmResetAlert.hide(150);

			// Hide commit alerts
			$wipCommitAlert.hide(150);
			$successCommitAlert.hide(150);
			$confirmCommitAlert.hide(150);

			// Hide errors
			$commitErrorAlert.hide(150);

			$commitActionsContainer.show(150);
		});

		// Reload button clicked
		$('.js-mod-redgit-commit-btn-reload').click(function(){
			window.location.href = window.location.href;
		});
	});
})(jQuery);
