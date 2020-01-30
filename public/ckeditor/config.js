/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'hkemoji , addtimestamp';
    config.removeButtons = 'Save,Preview,Print,Templates,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,Unlink,Anchor,Flash,Table,HorizontalRule,PageBreak,Iframe,BGColor,ShowBlocks,BidiRtl,BidiLtr,Styles,Format,Font,FontSize,Language,Image,Smiley';

};

// const cq = JSON.parse('{!! $smiles !!}');

CKEDITOR.plugins.add('addtimestamp', {
    init: function (editor) {
        var cmd = editor.addCommand('addtimestamp', {
            exec: function (editor) {
                editor.insertHtml('[spoiler-shell]' + editor.getSelection().getSelectedText() + '[/spoiler-shell]');
                // editor.insertHtml(' [spoiler class="spoiler"]444[spoiler]'); // собственно сама работа плагина
            }
        });
        cmd.modes = {wysiwyg: 1, source: 1};// плагин будет работать и в режиме wysiwyg и в режиме исходного текста
        editor.ui.addButton('addtimestamp', {
            label: 'Добавить спойлер',
            command: 'addtimestamp',
            toolbar: 'about'
        });
    },
    icons: 'addtimestamp', // иконка

});
/////////////////

//fff


















