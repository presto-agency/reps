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
export const strParse = (str) => {

    str = str.replace(/\[url\]([\s\S]*)\[\/url\]/gim, '<a href="$1" target="_blank">Ссылка</a>');
    str = str.replace(/%([\s\S]*)%/gim, '<img src="$1"  alt="picture"/>');
    str = str.replace(/;([\s\S]*);/gim, '<img src="storage/chat/smiles/$1" style="display: inline;" alt="smile"/>');
    str = str.replace(/\[img\]([\s\S]*)\[\/img\]/gim, '<img src="$1" style="max-width: 100%;" alt="Incorrect image link"/>');
    for (let i = 1; i <= 6; i++) {
        if (str.search(`c${i}`) > -1) {
            if (i === 1)
                str = str.replace(/\[c1\]([\s\S]*)\[\/c1\]/gim, '<span style="color: #FFFF77;">$1</span>');
            else if (i === 2)
                str = str.replace(/\[c2\]([\s\S]*)\[\/c2\]/gim, '<span style="color: #FF77FF;">$1</span>');
            else if (i === 3)
                str = str.replace(/\[c3\]([\s\S]*)\[\/c3\]/gim, '<span style="color: #77FFFF;">$1</span>');
            else if (i === 4)
                str = str.replace(/\[c4\]([\s\S]*)\[\/c4\]/gim, '<span style="color: #FFAAAA;">$1</span>');
            else if (i === 5)
                str = str.replace(/\[c5\]([\s\S]*)\[\/c5\]/gim, '<span style="color: #AAFFAA;">$1</span>');
            else
                str = str.replace(/\[c6\]([\s\S]*)\[\/c6\]/gim, '<span style="color: #AAAAFF;">$1</span>');
        }
    }
    return str
};
export const parsePath = (mes, smiles, images) => {
    if (mes.search(';') > -1) {
        smiles.forEach((item) => {
            if (mes.search(item.charactor) > -1)
                mes = mes.replace(/;([\s\S]*);/gim, `;${item.src};`);
        })
    }
    if (mes.search('%') > -1)
        mes = mes.replace(/%([\s\S]*)%/gim, `%${images.filepath}%`);
    return mes;
};
export const getFilterUser = (text) => {
    var string_array = text.split(' ');
    var focus_word = '';
    string_array.forEach(word => {
        if (word.substring(0, 1)) {
            focus_word = word.substring(1)
        }
    });
    return focus_word;
};
export const bold = (text) => {
    textareaObj().value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        textareaObj().value = textareaObj().value.replace(sel, '<b>' + sel + '</b>');
    } else {
        insertText('<b></b>')
    }
    textareaObj().focus();
    return textareaObj().value
};
export const color = (text) => {
    textareaObj().value = text;
    let sel = document.getSelection().toString();
    return sel;
};
export const italic = (text) => {
    textareaObj().value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '<i>' + sel + '</i>');
        textareaObj().value = newValue;
    } else {
        insertText('<i></i>')
    }
    textareaObj().focus();
    return textareaObj().value
};

export function pickColor(color) {
    let textareaObj = document.getElementById('pop_editor');
    // let textareaObj = document.getElementById('pop_editor');
    console.log(textareaObj);
    let sel = getSelection();
    //if (sel.length > 0) {
    let newValue = textareaObj.value.replace(sel, '[' + color.key + ']' + sel + '[/' + color.key + ']');
    //textareaObj.value = newValue;
    //} else {
    //insertText('[' + color.key + '][/' + color.key + ']')
    //}
    textareaObj.value = "s";
    textareaObj.focus();
    console.log(textareaObj.value)

}

export const underline = (text) => {
    textareaObj().value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '<u>' + sel + '</u>');
        textareaObj().value = newValue;
    } else {
        insertText('<u></u>')
    }
    textareaObj().focus();
    return textareaObj().value
};
export const link = (text) => {
    textareaObj().value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '[url]' + sel + '[/url]');
        textareaObj().value = newValue;

    } else {
        insertText('[url][/url]')
    }
    textareaObj().focus();
    return textareaObj().value
};
export const img = (text) => {
    textareaObj().value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '[img]' + sel + '[/img]');
        textareaObj().value = newValue;

    } else {
        insertText('[img][/img]')
    }
    textareaObj().focus();
    return textareaObj().value
};
export const meme = () => {
    let sel = getSelection();
    if (sel.length > 0) {
        let newValue = textareaObj().value.replace(sel, '[d]' + sel + '[/d]');
        textareaObj().value = newValue;
    } else {
        insertText('[d][/d]')
    }
    textareaObj().focus();
    return textareaObj().value
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
