import React from 'react';
import ReactDOM from 'react-dom';

(function ($) {
	class Backend {
		constructor() {
			this.ajaxUrl = fwpSiteConfig?.ajaxUrl??'';
			this.ajaxNonce = fwpSiteConfig?.ajax_nonce??'';
			var i18n = fwpSiteConfig?.i18n??{};
			this.config = fwpSiteConfig?.config??{};
			this.i18n = {submit: 'Submit', ...i18n};
			this.setup_hooks();
		}
		setup_hooks() {
			this.init_metabox();
		}
		async init_metabox() {
			const container = document.getElementById('product-options-container');
			if (container) {
				const tabs = container.dataset?.tabs ?? '[]';
				let data;
				try {
					data = JSON.parse(tabs);
				} catch (e) {
					console.error('Failed to parse JSON:', e);
					data = [];
				}
				// console.log(typeof data, data);
				ReactDOM.render(<ProductOptions data={data} />, container);
			}
		}
	}
	
	class ProductOptions extends React.Component {
		constructor(props) {
			super(props);
			this.state = {
				tabs: props.data || [],
				activeTab: null
			};
		}

		addTab = () => {
			this.setState((prevState) => ({
				tabs: [...prevState.tabs, { tabTitle: '', tabContent: '', tabRequired: false, tabOptions: [] }]
			}));
		};

		addOption = (tabIndex) => {
			this.setState((prevState) => {
				const tabs = [...prevState.tabs];
				tabs[tabIndex].tabOptions.push({ title: 'Option #' + (tabs[tabIndex].tabOptions.length + 1), content: '', price: 0, thumbnail: '' });
				return { tabs };
			});
		};

		handleTabChange = (tabIndex, field, value) => {
			this.setState((prevState) => {
				const tabs = [...prevState.tabs];
				tabs[tabIndex][field] = value;
				return { tabs };
			});
		};

		handleOptionChange = (tabIndex, optionIndex, field, value) => {
			this.setState((prevState) => {
				const tabs = [...prevState.tabs];
				tabs[tabIndex].tabOptions[optionIndex][field] = value;
				return { tabs };
			});
		};

		deleteOption = (tabIndex, optionIndex) => {
			this.setState((prevState) => {
				const tabs = [...prevState.tabs];
				tabs[tabIndex].tabOptions.splice(optionIndex, 1);
				return { tabs };
			});
		};

		toggleTab = (tabIndex) => {
			this.setState((prevState) => ({
				activeTab: prevState.activeTab === tabIndex ? null : tabIndex
			}));
		};

		render() {
			return (
				<div>
					<input type="hidden" name="product_options" value={JSON.stringify(this.state.tabs)} />
					{this.state.tabs.length > 0 ? (
						this.state.tabs.map((tab, tabIndex) => (
							<div key={tabIndex} className="xpo_mb-4 xpo_border xpo_rounded-lg xpo_shadow-md">
								<div className="xpo_p-4 xpo_bg-gray-100 xpo_cursor-pointer" onClick={() => this.toggleTab(tabIndex)}>
									<h2 className="xpo_text-xl xpo_font-semibold">Tab #{tabIndex + 1}: {tab.tabTitle}</h2>
								</div>
								{this.state.activeTab === tabIndex && (
									<div className="xpo_p-4">
										<label className="xpo_block xpo_mb-2">
											<span className="xpo_text-gray-700">Tab Title</span>
											<input type="text" value={tab.tabTitle} onChange={(e) => this.handleTabChange(tabIndex, 'tabTitle', e.target.value)} className="xpo_mt-1 xpo_block xpo_w-full" />
										</label>
										<label className="xpo_block xpo_mb-2">
											<span className="xpo_text-gray-700">Tab Content</span>
											<textarea value={tab.tabContent} onChange={(e) => this.handleTabChange(tabIndex, 'tabContent', e.target.value)} className="xpo_mt-1 xpo_block xpo_w-full"></textarea>
										</label>
										<label className="xpo_block xpo_mb-2">
											<span className="xpo_text-gray-700">Require it?</span>
											<input type="checkbox" checked={tab.tabRequired} onChange={(e) => this.handleTabChange(tabIndex, 'tabRequired', e.target.checked)} className="xpo_mt-1 xpo_block xpo_w-full" />
										</label>
										<div className="xpo_tab-options xpo_grid xpo_grid-cols-1 xpo_gap-4 md:xpo_grid-cols-2 lg:xpo_grid-cols-3">
											{tab.tabOptions.length === 0 ? (
												<p className="xpo_text-gray-500">No options available. Click "Add Option" to create a new option.</p>
											) : (
												tab.tabOptions.map((option, optionIndex) => (
													<div key={optionIndex} className="xpo_tab-option xpo_p-4 xpo_border xpo_rounded-lg xpo_shadow-md hover:xpo_shadow-lg xpo_transition-shadow xpo_duration-300">
														<label className="xpo_block xpo_mb-2">
															<span className="xpo_text-gray-700">Option Title</span>
															<input type="text" value={option.title} onChange={(e) => this.handleOptionChange(tabIndex, optionIndex, 'title', e.target.value)} className="xpo_mt-1 xpo_block xpo_w-full" />
														</label>
														<label className="xpo_block xpo_mb-2">
															<span className="xpo_text-gray-700">Option Price</span>
															<input type="number" step="any" value={option.price} onChange={(e) => this.handleOptionChange(tabIndex, optionIndex, 'price', e.target.value)} className="xpo_mt-1 xpo_block xpo_w-full" />
														</label>
														<label className="xpo_block xpo_mb-2">
															<span className="xpo_text-gray-700">Image URL</span>
															<input type="text" value={option.thumbnail} onChange={(e) => this.handleOptionChange(tabIndex, optionIndex, 'thumbnail', e.target.value)} className="xpo_mt-1 xpo_block xpo_w-full" />
														</label>
														<button type="button" onClick={() => this.deleteOption(tabIndex, optionIndex)} className="xpo_mt-2 xpo_px-2 xpo_py-1 xpo_bg-red-600 xpo_text-white xpo_rounded-lg">
															Trash
														</button>
													</div>
												))
											)}
										</div>
										<button type="button" onClick={() => this.addOption(tabIndex)} className="xpo_mt-4 xpo_px-4 xpo_py-2 xpo_bg-blue-600 xpo_text-white xpo_rounded-lg">
											Add Option
										</button>
									</div>
								)}
							</div>
						))
					) : (

						<p className="xpo_text-gray-500">No tabs available. Click "Add Tab" to create a new tab.</p>
					)}
					<button type="button" onClick={this.addTab} className="xpo_mt-4 xpo_px-4 xpo_py-2 xpo_bg-green-600 xpo_text-white xpo_rounded-lg">
						Add Tab
					</button>
				</div>
			);
		}
	}

	new Backend();
})(jQuery);
