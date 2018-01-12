(function() {
/*
 *
 * Register custom button in mce.
 *
 */
	tinymce.PluginManager.add('et_mce_button', function( editor, url ) {
		editor.addButton( 'et_mce_button', {
			text: 'xclean',
			tooltip: 'xclean shortcodes',
			type: 'menubutton',
			minWidth: 210,
				menu: [
				{
				/*
				 *
				 * Add Grid downdown to mce.
				 *
				 */

					text: 'Grid',
					menu: [
						{
						/*
						 *
						 * Add Row shorcode to mce.
						 *
						 */

							text: 'Row',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Row section',
									body: [
										{	
											type: 'textbox',
											name: 'ExtraClassName',
											label: 'Extra class name',
											tooltip: 'For example "my-class"',
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[et_row class="' + e.data.ExtraClassName + '"][/et_row]');
									}
								});
							}
						},
						{
						/*
						 *
						 * Add Col shorcode to mce.
						 *
						 */

							text: 'Column',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Content section',
									minWidth: 400,
									body: [
										{
											type: 'textbox',
											name: 'md',
											label: 'Medium screen',
											value: '12',
											tooltip: 'Number of columns for medium devices. Desktops (≥992px)',
											
										},
										{
											type: 'textbox',
											name: 'sm',
											label: 'Small screen',
											value: '12',
											tooltip: 'Number of columns for small devices. Tablets (≥768px)',
											
										},
										{
											type: 'textbox',
											name: 'xs',
											label: 'Extra small screen',
											value: '12',
											tooltip: 'Number of columns for extra small devices. Phones (<768px)',
											
										},
										{
											type: 'textbox',
											name: 'ExtraClassName',
											label: 'Extra class name',
											tooltip: 'For example "my-class"',
										},
									],
									onsubmit: function( e ) {
										editor.insertContent( '[et_col md="' + e.data.md + '" sm="' + e.data.sm + '" xs="' + e.data.xs + '" class="' + e.data.ExtraClassName + '"][/et_col]');
									}
								});
							}
						},
					]
				},
				{
				/*
				 *
				 * Add Banner shorcode to mce.
				 *
				 */

					text: 'Banner',
					onclick: function() {
						HorizontalAlign = 'center';
						VerticalAlign = 'middle';
						Pass = '';
						function HorizontalOrder() {
							if (HorizontalAlign == 'center') {
								return [{text: HorizontalAlign, value: HorizontalAlign}, {text: 'Right', value: 'right'}, {text: 'Left', value: 'left'}];
							};

							if (HorizontalAlign == 'right') {
								return [{text: HorizontalAlign, value: HorizontalAlign}, {text: 'Center', value: 'center'}, {text: 'Left', value: 'left'}];
							};

							if (HorizontalAlign == 'left') {
								return [{text: HorizontalAlign, value: HorizontalAlign}, {text: 'Right', value: 'right'}, {text: 'Center', value: 'center'}];
							};
						};
						function VerticalOrder() {
							if (VerticalAlign == 'middle') {
								return [{text: VerticalAlign, value: VerticalAlign}, {text: 'Top', value: 'top'}, {text: 'Bottom', value: 'bottom'}];
							};

							if (VerticalAlign == 'top') {
								return [{text: VerticalAlign, value: VerticalAlign}, {text: 'Middle', value: 'middle'}, {text: 'Bottom', value: 'bottom'}];
							};

							if (VerticalAlign == 'bottom') {
								return [{text: VerticalAlign, value: VerticalAlign}, {text: 'Middle', value: 'middle'}, {text: 'Top', value: 'top'}];
							};
						};
						editor.windowManager.open( {
							title: 'Content section',
							minWidth: 400,
							body: [
								{
									type: 'textbox',
									name: 'Title',
									label: 'Title',
									value: 'Your title',
									tooltip: 'Enter your title hire only text.',
									
								},
								{
									type: 'textbox',
									name: 'Content',
									label: 'Content',
									value: 'Banner-content',
									tooltip: 'Enter your content hire arbitrary text or HTML',
									multiline: true,
									minWidth: 300,
									minHeight: 100,
									
								},
								{
									text: 'Options',
									type: 'button',
									tooltip: 'Tap to see text align options',
									label: 'Text align',
									onclick: function() {
										editor.windowManager.open( {
											title: 'Align options',
											minWidth: 400,
											body: [
												{
													type: 'listbox',
													name: 'HorizontalAlign',
													label: 'Horizontal align',
													tooltip: 'Horizontal text position on the banner',
													values: 
													HorizontalOrder()
												},
												{
													type: 'listbox',
													name: 'VerticalAlign',
													label: 'Vertical align',
													tooltip: 'Vertical text position on the banner',
													values: 
													VerticalOrder()
												},
											],
											onsubmit: function( e ) {
												HorizontalAlign = e.data.HorizontalAlign;
												VerticalAlign = e.data.VerticalAlign;
											}
										});
									}
								},
								{
									type: 'listbox',
									name: 'BannerStyle',
									label: 'Banner style',
									values:[
										{
											text: 'bordered',
											value: 'bordered', 
										},
										{
											text: 'img', 
											value: 'img',
											onclick: function() {
												editor.windowManager.open( {
													title: 'Pass to img',
													body: [
														{
															type: 'textbox',
															name: 'Pass',
															label: 'Pass to img',
														},
													],
													onsubmit: function( e ) {
														Pass = e.data.Pass;
													}
												});
											}
										},
									]
								},
								{
									type: 'textbox',
									name: 'ExtraClassName',
									label: 'Extra class name',
									tooltip: 'For example "my-class"',
								},
								{	
									type: 'textbox',
									name: 'BannerUrl',
									label: 'Banner url',
									tooltip: 'Enter url here',
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[et_banner horizontal="' + HorizontalAlign + '" vertical="' + VerticalAlign + '" image="' + Pass + '" class="' + e.data.ExtraClassName + '" title="' + e.data.Title + '" type="' + e.data.BannerStyle + '" url="' + e.data.BannerUrl + '"]' + e.data.Content + '[/et_banner]');
							}
						});
					}
				},
				{
				/*
				 *
				 * Add heading shorcode to mce.
				 *
				 */

					text: 'Heading',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Heading section',
							body: [
								{	
									type: 'textbox',
									name: 'HeadingTitle',
									label: 'Title',
									value: 'Your title',
								},
								{	
									type: 'textbox',
									name: 'HeadingSubtitle',
									label: 'Subtitle',
									value: 'Your subtitle',
								},
								{
									type: 'listbox',
									name: 'Headinglink',
									label: 'link options',
									values: [
										{text: 'Link to blog page', value: 'blog'},
										{text: 'Product categories', value: 'categories'},
										{text: 'Post categories', value: 'post'},
									]
								},
								{	
									type: 'textbox',
									name: 'ExtraClassName',
									label: 'Extra class name',
									tooltip: 'For example "my-class"',
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[et_heading title="' + e.data.HeadingTitle + '" subtitle="' + e.data.HeadingSubtitle + '" link="' + e.data.Headinglink + '" class="' + e.data.ExtraClassName + '"][/et_heading]');
							}
						});
					}
				},
				{
				/*
				 *
				 * Add latest post shorcode to mce.
				 *
				 */

					text: 'Latest posts',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Latest posts options',
							body: [
								{	
									type: 'textbox',
									name: 'LatestQuantity',
									label: 'Quantity of posts',
									value: '4',
								},
								{
									type: 'listbox',
									name: 'LatestSorting',
									label: 'Order by',
									values: [
										{text: 'ID', value: 'ID'},
										{text: 'comment count', value: 'comment_count'},
									]
								},
								{
									type: 'listbox',
									name: 'LatestSortingType',
									label: 'Order',
									values: [
										{text: 'Ascending', value: 'ASC'},
										{text: 'Descending', value: 'DESC'},
									]
								},
								{	
									type: 'textbox',
									name: 'LatestCategory',
									label: 'Category ID',
									tooltip: 'For example "27,28,1"',
								},
								{	
									type: 'textbox',
									name: 'ExtraClassName',
									label: 'Extra class name',
									tooltip: 'For example "my-class',
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[et_latest_posts quantity="' + e.data.LatestQuantity + '" orderby="' + e.data.LatestSorting + '" order="' + e.data.LatestSortingType + '" category="' + e.data.LatestCategory + '" class="' + e.data.ExtraClassName + '"][/et_latest_posts]');
							}
						});
					}
				},
				{
				/*
				 *
				 * Add toogle shorcode to mce.
				 *
				 */

					text: 'Toggle',
					onclick: function() {
						editor.windowManager.open( {
							title: 'Toggle settings',
							body: [
								{	
									type: 'textbox',
									name: 'ToggleTitle',
									label: 'Title',
									value: 'Your title',
									tooltip: 'Enter your title hire only text.',
								},
								{	
									type: 'textbox',
									name: 'ToggleContent',
									label: 'Toggle contents',
									value: 'Your content',
									tooltip: 'Enter your content hire arbitrary text or HTML',
									multiline: true,
									minWidth: 300,
									minHeight: 100,
								},
								{	
									type: 'textbox',
									name: 'ExtraClassName',
									label: 'Extra class name',
									tooltip: 'For example "my-class"',
								},
							],
							onsubmit: function( e ) {
								editor.insertContent( '[et_toggle title="' + e.data.ToggleTitle + '" class="' + e.data.ExtraClassName + '"]' + e.data.ToggleContent + '[/et_toggle]');
							}
						});
					}
				},
			]
		});
	});
})();