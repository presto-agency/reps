/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.extraPlugins = 'hkemoji , addtimestamp';
    config.allowedContent = true;
    config.removeButtons = 'Save,Preview,Print,Templates,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,Unlink,Anchor,Flash,Table,HorizontalRule,PageBreak,Iframe,BGColor,ShowBlocks,BidiRtl,BidiLtr,Styles,Format,Font,FontSize,Language,Image,Smiley';
    // CKEDITOR.plugins.add( 'imageuploader', {
    //     init: function( editor ) {
    //         editor.config.filebrowserBrowseUrl = 'http://reps.loc/storage/chat/pictures/3bcd2d0ebe4d5e07506f5c25d0b13e05.jpg';
    //     }
    // });

};

// const cq = JSON.parse('{!! $smiles !!}');

CKEDITOR.plugins.add('addtimestamp',{
    init: function(editor){
        var cmd = editor.addCommand('addtimestamp', {
            exec:function(editor){
                editor.insertHtml('[bbSpoiler]' +
                    '[bbSpoilerTitle]' +
                    '[spoiler_block]'+
                    '[b]'+'Показать'+'[/b]'+
                    '[b]'+'Скрыть'+'[/b]'+
                    '[/spoiler_block]'+
                    '[spoiler]'+ editor.getSelection().getSelectedText()+'[/spoiler]'+
                    '[bbSpoilerTitle]' +
                    // '[spoiler]'+editor.getSelection().getSelectedText()+'[/spoiler][/item_spoiler]' +
                    '[/bbSpoiler]' );
                // editor.insertHtml(' [spoiler class="spoiler"]444[spoiler]'); // собственно сама работа плагина
            }
        });
        cmd.modes = { wysiwyg : 1, source: 1 };// плагин будет работать и в режиме wysiwyg и в режиме исходного текста
        editor.ui.addButton('addtimestamp',{
            label: 'Добавить текущую дату и время',
            command: 'addtimestamp',
            toolbar: 'about'
        });
    },
    icons:'addtimestamp', // иконка

});






//fff


















