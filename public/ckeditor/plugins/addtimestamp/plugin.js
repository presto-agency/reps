CKEDITOR.plugins.add('addtimestamp',{
    init: function(editor){
        var cmd = editor.addCommand('addtimestamp', {
            exec:function(editor){
                editor.insertHtml('[spoiler]444[spoiler]'); // собственно сама работа плагина
            }
        });
        cmd.modes = { wysiwyg : 1, source: 1 };// плагин будет работать и в режиме wysiwyg и в режиме исходного текста
        editor.ui.addButton('addtimestamp',{
            label: 'Добавить текущую дату и время',
            icon:this.path+'/spoiler.png', // иконка
            command: 'addtimestamp'
        });
    }
});
