/* eslint-disable no-undef, array-callback-return  */

CKEDITOR.dialog.add('calendarDialog', function (editor) {
	// extract attributes from the supplied iframe HTML
	// returns an object with the keys and values.
	function extractAttributes(iframeMarkup) {
		var o = {};

		var elements = $(iframeMarkup);
		var attributes = elements[0].attributes;

		Object.keys(attributes).map(function (key) {
			o[attributes[key].name] = attributes[key].value;
		});

		return o;
	}

	return {
		title: 'Embed Google Calendar',
		minWidth: 400,
		minHeight: 200,
		contents: [
			{
				id: 'tab-basic',
				label: 'Embed Settings',
				elements: [{
					type: 'textarea',
					id: 'embedMarkup',
					label: 'Embed Code',
					validate: CKEDITOR.dialog.validate.notEmpty('Embed cannot be empty.'),
					setup: function (element) {
						var containingElement = element.$.firstElementChild;

						if (containingElement && containingElement.localName === 'iframe') {
							this.setValue(containingElement.outerHTML);
						}
					}
				}, {
					type: 'checkbox',
					id: 'responsive',
					label: 'Responsive? (check if you want the calendar to scale)',
					default: 'checked',
					setup: function (element) {
						console.log('e', element);
						console.log('t', this);

						var containingElement = element.$.firstElementChild;

						if (containingElement && containingElement.localName === 'iframe') {
							if (containingElement.hasAttribute('width') && containingElement.getAttribute('width') === '100%') {
								this.setValue(true, false);
							} else {
								this.setValue(false, false);
							}
						}
					}
				}]
			}
		],
		onShow: function () {
			var selection = editor.getSelection();
			var element = selection.getStartElement();

			this.insertMode = false;

			if (!element || !element.hasClass('calendar-insulator')) {
				element = editor.document.createElement('div');
				this.insertMode = true;
			}

			this.element = element;

			if (this.insertMode === false) {
				this.setupContent(element);
			}
		},
		onOk: function () {
			var dialog = this;
			var element = dialog.element;

			dialog.commitContent(element);

			// the iframe html from embedMarkup
			var embedIframe = CKEDITOR.dom.element.createFromHtml(dialog.getValueOf('tab-basic', 'embedMarkup'));

			if (dialog.insertMode) {
				element.setAttribute('class', 'calendar-insulator');
				embedIframe.appendTo(element);
				embedIframe.setAttribute('width', '100%');
				editor.insertElement(element);
			} else {
				// just update the embed markup that is currently in the editor
				var currentIframe = element.getFirst();

				// only update if we are working on an iframe
				if (currentIframe && currentIframe.getName() === 'iframe') {
					// get a list of attributes on the current iframe (in the editor)
					var currentAttributes = extractAttributes(currentIframe.getOuterHtml());

					// get a list of attributes on the new iframe (the dialog's embedMarkup)
					var newAttributes = extractAttributes(embedIframe.getOuterHtml());

					// first remove all current attributes
					Object.keys(currentAttributes).map(function (key) {
						currentIframe.removeAttribute(key);
					});

					// now copy the new attributes from embedMarkup to the current embedIframe
					Object.keys(newAttributes).map(function (key) {
						currentIframe.setAttribute(key, newAttributes[key]);
					});

					// force 100% width if the `responsive` is checked
					if (dialog.getValueOf('tab-basic', 'responsive')) {
						currentIframe.setAttribute('width', '100%');
					}

				} else {
					console.log('ignoring non-iframe element:', currentIframe.getName());
				}
			}
		}
	};
});
