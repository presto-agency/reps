/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.extraPlugins = 'timestamp';
    config.extraPlugins = 'hkemoji';
    config.removeButtons = 'Save,Preview,Print,Templates,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,Link,Unlink,Anchor,Flash,Table,HorizontalRule,PageBreak,Iframe,BGColor,ShowBlocks,BidiRtl,BidiLtr,Styles,Format,Font,FontSize,Language';
    // CKEDITOR.plugins.add( 'imageuploader', {
    //     init: function( editor ) {
    //         editor.config.filebrowserBrowseUrl = 'http://reps.loc/storage/chat/pictures/3bcd2d0ebe4d5e07506f5c25d0b13e05.jpg';
    //     }
    // });

};
// const cq = JSON.parse('{!! $smiles !!}');
CKEDITOR.plugins.add( 'timestamp', {
    icons: 'timestamp',
    init: function( editor ) {
        editor.addCommand("mySimpleCommand", {

            exec: function(edt) {
                t= '555';

                     editor.insertHtml(t);
            }

        });
        editor.ui.addButton('SuperButton', {
            label: "Click me",
            command: 'mySimpleCommand',
            toolbar: 'insert',
            icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
        });
    }
});
