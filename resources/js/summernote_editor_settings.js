$(document).ready(function () {
console.log(444);
    $(document).ready(function () {

        var editor = $('#editor-body');

        var configFull = {
            lang: 'ru-RU', // default: 'en-US'
            shortcuts: false,
            airMode: false,
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false, // set focus to editable area after initializing summernote
            disableDragAndDrop: false,
            callbacks: {
                onImageUpload: function (files) {
                    uploadFile(files);
                },

                onMediaDelete: function ($target, editor, $editable) {

                    var fileURL = $target[0].src;
                    deleteFile(fileURL);

// remove element in editor
                    $target.remove();
                }
            }
        };

// Featured editor
        editor.summernote(configFull);

// Upload file on the server.
        function uploadFile(filesForm) {
            data = new FormData();

// Add all files from form to array.
            for (var i = 0; i < filesForm.length; i++) {
                data.append("files[]", filesForm[i]);
            }

            $.ajax({
                data: data,
                type: "POST",
                url: "/ajax/uploader/upload",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: false,
                processData: false,
                success: function (images) {
//console.log(images);

// If not errors.
                    if (typeof images['error'] == 'undefined') {

// Get all images and insert to editor.
                        for (var i = 0; i < images['url'].length; i++) {

                            editor.summernote('insertImage', images['url'][i], function ($image) {
//$image.css('width', $image.width() / 3);
//$image.attr('data-filename', 'retriever')
                            });
                        }
                    }
                    else {
// Get user's browser language.
                        var userLang = navigator.language || navigator.userLanguage;

                        if (userLang == 'ru-RU') {
                            var error = 'Ошибка, не могу загрузить файл! Пожалуйста, проверьте файл или ссылку. ' +
                                'Изображение должно быть не менее 500px!';
                        }
                        else {
                            var error = 'Error, can\'t upload file! Please check file or URL. Image should be more then 500px!';
                        }

                        alert(error);
                    }
                }
            });
        }

// Delete file from the server.
        function deleteFile(file) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "/ajax/uploader/delete",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: false,
                processData: false,
                success: function (image) {
//console.log(image);
                }
            });
        }

    });

});
