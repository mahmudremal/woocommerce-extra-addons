/**
 * Frontend Script.
 * 
 * @package WooXtraAddons
 */

( function ( $ ) {
	class Frontend {
		/**
		 * Constructor for the Frontend class.
		 * Initializes configuration and sets up hooks.
		 */
		constructor() {
			this.config = fwpSiteConfig;
			this.ajaxUrl = this.config?.ajaxUrl??'';
			this.ajaxNonce = this.config?.ajax_nonce??'';
			var i18n = this.config?.i18n??{};
			this.i18n = {confirming: 'Confirming', ...i18n};
			this.setup_hooks();
		}

		/**
		 * Sets up hooks for the frontend.
		 */
		setup_hooks() {
			this.init_single_product();
		}

		/**
		 * Initializes single product functionality.
		 * Handles tab click events and form submission validation.
		 */
		init_single_product() {
			/**
			 * Handle tab click events.
			 */
			const tabHandlers = document.querySelectorAll('.product-tab .tab-title');
			tabHandlers.forEach(tabHandler => {
				tabHandler.addEventListener('click', function(event) {
					const tabContent = event.target.nextElementSibling;
					if (tabHandler.parentElement.classList.contains('active')) {
						$(tabContent).slideUp();
						tabHandler.parentElement.classList.remove('active');
					} else {
						$(tabContent).slideDown();
						tabHandler.parentElement.classList.add('active');
					}
				});
			});
			/**
			 * Function to remove error notices on checkbox change.
			 */
			const tabs = document.querySelectorAll('[data-required-fields="true"], [data-required-fields="1"]');
			[...tabs].forEach(tab => {
				tab.querySelectorAll('[type=checkbox]').forEach(checkbox => {
					checkbox.addEventListener('change', function(event) {
						if (! event.target.checked) {return;}
						[...tabs].forEach(tab => tab.querySelectorAll('.notice').forEach(notice => notice.remove()));
					});
				});
			});
			/**
			 * Validate form submission.
			 */
			document.querySelectorAll('form.cart').forEach(form => {
				form.addEventListener('submit', function(e) {
					let valid = tabs.length === 0 || [...tabs].some(tab => tab.querySelectorAll('[type=checkbox]:checked').length > 0);
					if (!valid) {
						/**
						 * Prevent form submission if required fields are not filled.
						 */
						e.preventDefault();
						/**
						 * Stop propagation to prevent multiple
						 */
						e.stopPropagation();
						/**
						 * Show error notices on the required tabs
						 */
						const errorShownOn = [...tabs].filter(tab => tab.querySelectorAll('[type=checkbox]:checked').length <= 0);
						errorShownOn.forEach(tab => {
							tab.querySelectorAll('.notice').forEach(notice => notice.remove());
							tab.scrollIntoView({ behavior: 'smooth' });
							// 
							const notice = document.createElement('div');
							notice.classList.add('notice', 'notice-error');
							notice.textContent = 'Please select at least one option in this tab.';
							tab.insertBefore(notice, tab.children[0]);
						});
						/**
						 * Scroll to the first tab with an error
						 */
						if (errorShownOn.length > 0) {
							errorShownOn[0].scrollIntoView({ behavior: 'smooth' });
						}
						// alert('Please select at least one option in the required tabs.');
						return false;
					}
					/**
					 * Approve submission to proceed.
					 */
					return true;
				});
			});
		}
	}
	new Frontend();
} )( jQuery );
