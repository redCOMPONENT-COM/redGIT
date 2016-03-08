(function($) {
	$(document).ready(function(e) {
		var $form             = $('#mod-redgit-database'),
			$actionsContainer = $('.js-mod-redgit-database-actions'),
			$legend           = $('.js-mod-redgit-database-msg'),
			// Dump Alerts
			$confirmDumpAlert = $('.js-mod-redgit-database-msg-confirm-dump'),
			$wipDumpAlert     = $('.js-mod-redgit-database-msg-wip-dump'),
			$successDumpAlert = $('.js-mod-redgit-database-msg-success-dump'),
			// Restore Alerts
			$confirmRestoreAlert = $('.js-mod-redgit-database-msg-confirm-restore'),
			$wipRestoreAlert     = $('.js-mod-redgit-database-msg-wip-restore'),
			$successRestoreAlert = $('.js-mod-redgit-database-msg-success-restore'),
			// Error Alerts
			$errorAlert       = $('.js-mod-redgit-database-msg-error');
			$errorMessage     = $('.js-mod-redgit-database-msg-error-message');

		// Dump button clicked
		$('.js-mod-redgit-database-btn-dump').click(function(){
			$legend.hide();
			$confirmDumpAlert.show(150);
			$actionsContainer.hide(150);
		});

		// Cancel dump button clicked
		$('.js-mod-redgit-database-btn-cancel-dump').click(function(){
			$legend.show();
			$confirmDumpAlert.hide(150);
			$actionsContainer.show(150);
		});

		// Confirm dump button clicked
		$('.js-mod-redgit-database-btn-confirm-dump').click(function(){
			$confirmDumpAlert.hide(150);
			$wipDumpAlert.show(150);

			var data = $form.serializeArray();

			$.post('index.php?option=com_redgit&task=database.ajaxDump', data, 'json')
			.done(function(){
				$wipDumpAlert.hide(150);
				$successDumpAlert.show(150);
			})
			.fail(function(response){
				$wipDumpAlert.hide(150);
				$errorMessage.text(response.responseText)
				$errorAlert.show(150);
			});
		});

		// Restore button clicked
		$('.js-mod-redgit-database-btn-restore').click(function(){
			$legend.hide();
			$confirmRestoreAlert.show(150);
			$actionsContainer.hide(150);
		});

		// Cancel restore button clicked
		$('.js-mod-redgit-database-btn-cancel-restore').click(function(){
			$legend.show();
			$confirmRestoreAlert.hide(150);
			$actionsContainer.show(150);
		});

		// Confirm restore button clicked
		$('.js-mod-redgit-database-btn-confirm-restore').click(function(){
			$confirmRestoreAlert.hide(150);
			$wipRestoreAlert.show(150);

			var data = $form.serializeArray();

			$.post('index.php?option=com_redgit&task=database.ajaxRestore', data, 'json')
			.done(function(){
				$wipRestoreAlert.hide(150);
				$successRestoreAlert.show(150);
			})
			.fail(function(response){
				$wipRestoreAlert.hide(150);
				$errorMessage.text(response.responseText)
				$errorAlert.show(150);
			});
		});

		// Return button clicked
		$('.js-mod-redgit-database-btn-return').click(function(){
			$legend.show();

			// Hide dump alerts
			$wipDumpAlert.hide(150);
			$successDumpAlert.hide(150);
			$confirmDumpAlert.hide(150);

			// Hide restore alerts
			$wipRestoreAlert.hide(150);
			$successRestoreAlert.hide(150);
			$confirmRestoreAlert.hide(150);

			// Hide errors
			$errorAlert.hide(150);

			$actionsContainer.show(150);
		});

		// Reload button clicked
		$('.js-mod-redgit-database-btn-reload').click(function(){
			window.location.href = window.location.href;
		});
	});
})(jQuery);
