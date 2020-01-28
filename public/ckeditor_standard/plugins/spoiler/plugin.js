CKEDITOR.editorConfig = function (config) {
    config.extraPlugins = 'spoiler';
    config.removeButtons = 'Save,Preview,Print,Templates,Find,Replace,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,Unlink,Anchor,Flash,Table,HorizontalRule,PageBreak,Iframe,BGColor,ShowBlocks,BidiRtl,BidiLtr,Styles,Format,Font,FontSize,Language,Image,Smiley';
    config.allowedContent = true;
};
CKEDITOR.plugins.add('spoiler', {
    init: function (editor) {
        var cmd = editor.addCommand('spoiler', {
            exec: function (editor) {
                editor.insertHtml('[spoiler-shell]' + editor.getSelection().getSelectedText() + '[/spoiler-shell]');
                // editor.insertHtml('<div class="bbSpoiler">999<div class="bbSpoilerTitle">' + '<a href="#" onclick="return xbbSpoiler(this)">' +
                //     '<strong>показать</strong>' +
                //     '<strong style="display:none">скрыть</strong>' +
                //     '</a>' +
                //     '</div>' +
                //     '<div class="spoiler" style="display:none">' + editor.getSelection().getSelectedText() + '</div>' +
                //     '</div>');
            }
        });
        cmd.modes = {wysiwyg: 1, source: 1};// плагин будет работать и в режиме wysiwyg и в режиме исходного текста
        editor.ui.addButton('spoiler', {
            label: 'Добавить текущую дату и время',
            command: 'spoiler',
            toolbar: 'about'
        });
    },
    icons: 'spoiler', // иконка

});

// <div class="bbSpoiler">
//     <div class="bbSpoilerTitle">
//     <a href="#" onclick="return xbbSpoiler(this)">
//     <strong>показать</strong>
//     <strong style="display:none">скрыть</strong>
//     </a>
//     </div>
//     <div class="spoiler" style="display:none">tt5</div>
//     </div>
