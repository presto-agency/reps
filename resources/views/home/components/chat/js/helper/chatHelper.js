import * as utilsHelper from './utilsHelper';

export const textareaObj = () => {
    //var popupStatus = document.getElementById("popupStatus").value;
    var textareaObject = 'pop_editor';
    return document.getElementById(textareaObject);
};

export const getSelection = () => {
    var start = textareaObj().selectionStart;
    var finish = textareaObj().selectionEnd;
    var sel = textareaObj().value.substring(start, finish);
    return sel;
};
export const strParse= (str) => {

    str = str.replace(/\[img\]([\s\S]*)\[\/img\]/gim, '<img src="$1" style="max-width: 100%;" alt="Uncorrect link"/>');
    str= str.replace(/\[url\]([\s\S]*)\[\/url\]/gim, '<a href="$1">$1</a>');
    return str
};
export const getFilterUser = (text) => {
    var string_array = text.split(' ');
    var focus_word = '';
    string_array.forEach(word => {
        if(word.substring(0, 1)) {
            focus_word = word.substring(1)
        }
    });
    return focus_word;
};
export const bold = () => {

    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '<b>'+sel+'</b>');
        textareaObj().value = newValue;
    } else {
        insertText('<b></b>')
    }
    textareaObj().focus();
};
export const italic = () => {
    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '<i>'+sel+'</i>');
        textareaObj().value = newValue;

    }  else {
        insertText('<i></i>')
    }
    textareaObj().focus();
};
export function pickColor(color) {
    let textareaObj = document.getElementById('pop_editor');
    // let textareaObj = document.getElementById('pop_editor');
    console.log(textareaObj);
    let sel = getSelection();
    //if (sel.length > 0) {
       let newValue = textareaObj.value.replace(sel, '[' + color.key + ']' + sel +'[/' + color.key + ']');
        //textareaObj.value = newValue;
    //} else {
        //insertText('[' + color.key + '][/' + color.key + ']')
    //}
    textareaObj.value= "s";
    textareaObj.focus();
   console.log(textareaObj.value)

}
export const underline = () => {
    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '<u>'+sel+'</u>');
        textareaObj().value = newValue;
    } else {
        insertText('<u></u>')
    }
    textareaObj().focus();
};
export const link = () => {
    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '[url]'+sel+'[/url]');
        textareaObj().value = newValue;

    } else {
        insertText('[url][/url]')
    }
    textareaObj().focus();
};
export const img = () => {
    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '[img]'+sel+'[/img]');
        textareaObj().value = newValue;

    } else {
        insertText('[img][/img]')
    }
    textareaObj().focus();
};
export const meme = () => {
    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '[d]'+sel+'[/d]');
        textareaObj().value = newValue;
    } else {
        insertText('[d][/d]')
    }
    textareaObj().focus();
};

export const insertText = (text) => {
    var txtarea = textareaObj();
    if (!txtarea) {
        return;
    }

    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (document.selection ? "ie" : false));
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart('character', -txtarea.value.length);
        strPos = range.text.length;
    } else if (br == "ff") {
        strPos = txtarea.selectionStart;
    }

    var front = (txtarea.value).substring(0, strPos);
    var back = (txtarea.value).substring(strPos, txtarea.value.length);
    txtarea.value = front + text + back;
    strPos = (utilsHelper.regex_test(text)) ? strPos + (Math.floor(text.length / 2)) : text.length;
    if (br == "ie") {
        txtarea.focus();
        var ieRange = document.selection.createRange();
        ieRange.moveStart('character', -txtarea.value.length);
        ieRange.moveStart('character', strPos);
        ieRange.moveEnd('character', 0);
        ieRange.select();
    } else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.focus();
    txtarea.scrollTop = scrollPos;
};
