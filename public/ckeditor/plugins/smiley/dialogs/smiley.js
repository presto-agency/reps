<<<<<<< HEAD
﻿/*
 Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
CKEDITOR.dialog.add("smiley",function(f){for(var e=f.config,a=f.lang.smiley,h=e.smiley_images,g=e.smiley_columns||8,k,m=function(l){var c=l.data.getTarget(),b=c.getName();if("a"==b)c=c.getChild(0);else if("img"!=b)return;var b=c.getAttribute("cke_src"),a=c.getAttribute("title"),c=f.document.createElement("img",{attributes:{src:b,"data-cke-saved-src":b,title:a,alt:a,width:c.$.width,height:c.$.height}});f.insertElement(c);k.hide();l.data.preventDefault()},q=CKEDITOR.tools.addFunction(function(a,c){a=
new CKEDITOR.dom.event(a);c=new CKEDITOR.dom.element(c);var b;b=a.getKeystroke();var d="rtl"==f.lang.dir;switch(b){case 38:if(b=c.getParent().getParent().getPrevious())b=b.getChild([c.getParent().getIndex(),0]),b.focus();a.preventDefault();break;case 40:(b=c.getParent().getParent().getNext())&&(b=b.getChild([c.getParent().getIndex(),0]))&&b.focus();a.preventDefault();break;case 32:m({data:a});a.preventDefault();break;case d?37:39:if(b=c.getParent().getNext())b=b.getChild(0),b.focus(),a.preventDefault(!0);
else if(b=c.getParent().getParent().getNext())(b=b.getChild([0,0]))&&b.focus(),a.preventDefault(!0);break;case d?39:37:if(b=c.getParent().getPrevious())b=b.getChild(0),b.focus(),a.preventDefault(!0);else if(b=c.getParent().getParent().getPrevious())b=b.getLast().getChild(0),b.focus(),a.preventDefault(!0)}}),d=CKEDITOR.tools.getNextId()+"_smiley_emtions_label",d=['\x3cdiv\x3e\x3cspan id\x3d"'+d+'" class\x3d"cke_voice_label"\x3e'+a.options+"\x3c/span\x3e",'\x3ctable role\x3d"listbox" aria-labelledby\x3d"'+
d+'" style\x3d"width:100%;height:100%;border-collapse:separate;" cellspacing\x3d"2" cellpadding\x3d"2"',CKEDITOR.env.ie&&CKEDITOR.env.quirks?' style\x3d"position:absolute;"':"","\x3e\x3ctbody\x3e"],n=h.length,a=0;a<n;a++){0===a%g&&d.push('\x3ctr role\x3d"presentation"\x3e');var p="cke_smile_label_"+a+"_"+CKEDITOR.tools.getNextNumber();d.push('\x3ctd class\x3d"cke_dark_background cke_centered" style\x3d"vertical-align: middle;" role\x3d"presentation"\x3e\x3ca href\x3d"javascript:void(0)" role\x3d"option"',
' aria-posinset\x3d"'+(a+1)+'"',' aria-setsize\x3d"'+n+'"',' aria-labelledby\x3d"'+p+'"',' class\x3d"cke_smile cke_hand" tabindex\x3d"-1" onkeydown\x3d"CKEDITOR.tools.callFunction( ',q,', event, this );"\x3e','\x3cimg class\x3d"cke_hand" title\x3d"',e.smiley_descriptions[a],'" cke_src\x3d"',CKEDITOR.tools.htmlEncode(e.smiley_path+h[a]),'" alt\x3d"',e.smiley_descriptions[a],'"',' src\x3d"',CKEDITOR.tools.htmlEncode(e.smiley_path+h[a]),'"',CKEDITOR.env.ie?" onload\x3d\"this.setAttribute('width', 2); this.removeAttribute('width');\" ":
"",'\x3e\x3cspan id\x3d"'+p+'" class\x3d"cke_voice_label"\x3e'+e.smiley_descriptions[a]+"\x3c/span\x3e\x3c/a\x3e","\x3c/td\x3e");a%g==g-1&&d.push("\x3c/tr\x3e")}if(a<g-1){for(;a<g-1;a++)d.push("\x3ctd\x3e\x3c/td\x3e");d.push("\x3c/tr\x3e")}d.push("\x3c/tbody\x3e\x3c/table\x3e\x3c/div\x3e");e={type:"html",id:"smileySelector",html:d.join(""),onLoad:function(a){k=a.sender},focus:function(){var a=this;setTimeout(function(){a.getElement().getElementsByTag("a").getItem(0).focus()},0)},onClick:m,style:"width: 100%; border-collapse: separate;"};
return{title:f.lang.smiley.title,minWidth:270,minHeight:120,contents:[{id:"tab1",label:"",title:"",expand:!0,padding:0,elements:[e]}],buttons:[CKEDITOR.dialog.cancelButton]}});
=======
/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.dialog.add( 'smiley', function( editor ) {
	var config = editor.config,
		lang = editor.lang.smiley,
		images = config.smiley_images,
		columns = config.smiley_columns || 8,
		i;

	// Simulate "this" of a dialog for non-dialog events.
	// @type {CKEDITOR.dialog}
	var dialog;
	var onClick = function( evt ) {
			var target = evt.data.getTarget(),
				targetName = target.getName();

			if ( targetName == 'a' )
				target = target.getChild( 0 );
			else if ( targetName != 'img' )
				return;

			var src = target.getAttribute( 'cke_src' ),
				title = target.getAttribute( 'title' );

			var img = editor.document.createElement( 'img', {
				attributes: {
					src: src,
					'data-cke-saved-src': src,
					title: title,
					alt: title,
					width: target.$.width,
					height: target.$.height
				}
			} );

			editor.insertElement( img );

			dialog.hide();
			evt.data.preventDefault();
		};

	var onKeydown = CKEDITOR.tools.addFunction( function( ev, element ) {
		ev = new CKEDITOR.dom.event( ev );
		element = new CKEDITOR.dom.element( element );
		var relative, nodeToMove;

		var keystroke = ev.getKeystroke(),
			rtl = editor.lang.dir == 'rtl';
		switch ( keystroke ) {
			// UP-ARROW
			case 38:
				// relative is TR
				if ( ( relative = element.getParent().getParent().getPrevious() ) ) {
					nodeToMove = relative.getChild( [ element.getParent().getIndex(), 0 ] );
					nodeToMove.focus();
				}
				ev.preventDefault();
				break;
				// DOWN-ARROW
			case 40:
				// relative is TR
				if ( ( relative = element.getParent().getParent().getNext() ) ) {
					nodeToMove = relative.getChild( [ element.getParent().getIndex(), 0 ] );
					if ( nodeToMove )
						nodeToMove.focus();
				}
				ev.preventDefault();
				break;
				// ENTER
				// SPACE
			case 32:
				onClick( { data: ev } );
				ev.preventDefault();
				break;

				// RIGHT-ARROW
			case rtl ? 37 : 39:
				// relative is TD
				if ( ( relative = element.getParent().getNext() ) ) {
					nodeToMove = relative.getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault( true );
				}
				// relative is TR
				else if ( ( relative = element.getParent().getParent().getNext() ) ) {
					nodeToMove = relative.getChild( [ 0, 0 ] );
					if ( nodeToMove )
						nodeToMove.focus();
					ev.preventDefault( true );
				}
				break;

				// LEFT-ARROW
			case rtl ? 39 : 37:
				// relative is TD
				if ( ( relative = element.getParent().getPrevious() ) ) {
					nodeToMove = relative.getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault( true );
				}
				// relative is TR
				else if ( ( relative = element.getParent().getParent().getPrevious() ) ) {
					nodeToMove = relative.getLast().getChild( 0 );
					nodeToMove.focus();
					ev.preventDefault( true );
				}
				break;
			default:
				// Do not stop not handled events.
				return;
		}
	} );

	// Build the HTML for the smiley images table.
	var labelId = CKEDITOR.tools.getNextId() + '_smiley_emtions_label';
	var html = [
		'<div>' +
		'<span id="' + labelId + '" class="cke_voice_label">' + lang.options + '</span>',
		'<table role="listbox" aria-labelledby="' + labelId + '" style="width:100%;height:100%;border-collapse:separate;" cellspacing="2" cellpadding="2"',
		CKEDITOR.env.ie && CKEDITOR.env.quirks ? ' style="position:absolute;"' : '',
		'><tbody>'
	];

	var size = images.length;
	for ( i = 0; i < size; i++ ) {
		if ( i % columns === 0 )
			html.push( '<tr role="presentation">' );

		var smileyLabelId = 'cke_smile_label_' + i + '_' + CKEDITOR.tools.getNextNumber();
		html.push(
			'<td class="cke_dark_background cke_centered" style="vertical-align: middle;" role="presentation">' +
			'<a href="javascript:void(0)" role="option"', ' aria-posinset="' + ( i + 1 ) + '"', ' aria-setsize="' + size + '"', ' aria-labelledby="' + smileyLabelId + '"',
			' class="cke_smile cke_hand" tabindex="-1" onkeydown="CKEDITOR.tools.callFunction( ', onKeydown, ', event, this );">',
			'<img class="cke_hand" title="', config.smiley_descriptions[ i ], '"' +
			' cke_src="', CKEDITOR.tools.htmlEncode( config.smiley_path + images[ i ] ), '" alt="', config.smiley_descriptions[ i ], '"',
			' src="', CKEDITOR.tools.htmlEncode( config.smiley_path + images[ i ] ), '"',
			// IE BUG: Below is a workaround to an IE image loading bug to ensure the image sizes are correct.
			( CKEDITOR.env.ie ? ' onload="this.setAttribute(\'width\', 2); this.removeAttribute(\'width\');" ' : '' ), '>' +
			'<span id="' + smileyLabelId + '" class="cke_voice_label">' + config.smiley_descriptions[ i ] + '</span>' +
			'</a>', '</td>'
		);

		if ( i % columns == columns - 1 )
			html.push( '</tr>' );
	}

	if ( i < columns - 1 ) {
		for ( ; i < columns - 1; i++ )
			html.push( '<td></td>' );
		html.push( '</tr>' );
	}

	html.push( '</tbody></table></div>' );

	var smileySelector = {
		type: 'html',
		id: 'smileySelector',
		html: html.join( '' ),
		onLoad: function( event ) {
			dialog = event.sender;
		},
		focus: function() {
			var self = this;
			// IE need a while to move the focus (https://dev.ckeditor.com/ticket/6539).
			setTimeout( function() {
				var firstSmile = self.getElement().getElementsByTag( 'a' ).getItem( 0 );
				firstSmile.focus();
			}, 0 );
		},
		onClick: onClick,
		style: 'width: 100%; border-collapse: separate;'
	};

	return {
		title: editor.lang.smiley.title,
		minWidth: 270,
		minHeight: 120,
		contents: [ {
			id: 'tab1',
			label: '',
			title: '',
			expand: true,
			padding: 0,
			elements: [
				smileySelector
			]
		} ],
		buttons: [ CKEDITOR.dialog.cancelButton ]
	};
} );
>>>>>>> 286455b48a1e3bb0439598f54c3db0e9fb1841cb
