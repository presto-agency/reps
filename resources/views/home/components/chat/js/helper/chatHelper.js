import * as utilsHelper from './utilsHelper';

export const textareaObj = (id) => {
    //var popupStatus = document.getElementById("popupStatus").value;

    var textareaObject = id;
    return document.getElementById(textareaObject);
};

export const getSelection = () => {
    var start = textareaObj().selectionStart;
    var finish = textareaObj().selectionEnd;
    var sel = textareaObj().value.substring(start, finish);
    return sel;
};
export const strParse= (str) => {
    str= str.replace(/\[b\]/g, `<b>`);
    str= str.replace(/\[\/b\]/g, `</b>`);
    str= str.replace(/\[i\]/g, `<i>`);
    str= str.replace(/\[\/i\]/g, `</i>`);
    str= str.replace(/\[u\]/g, `<u>`);
    str= str.replace(/\[\/u\]/g, `</u>`);
    str= str.replace(/\[url\]([\s\S]*)\[\/url\]/g, '<a href="$1" target="_blank">Ссылка</a>');
    str= str.replace(/%([^%]*)%/g, '<img src="$1"  alt="picture"/>');
    str= str.replace(/;([^;]*);/g, '<img src="storage/chat/smiles/$1"style="display: inline;" alt="smile"/>');
    str = str.replace(/\[img\]([\s\S]*)\[\/img\]/g, '<img src="$1" style="max-width: 100%;" alt="Incorrect image_1 link"/>');
    for(let i=1; i<=6; i++) {
        if(str.search(`c${i}`)>-1) {
            if(i===1) {
                str = str.replace(/\[c1\]([\s\S]*)\[\/c1\]/gim, '<span style="color: #FFFF77;">$1</span>');
            }
            else if(i===2) {
                str = str.replace(/\[c2\]([\s\S]*)\[\/c2\]/gim, '<span style="color: #FF77FF;">$1</span>');
            }
            else if(i===3) {
                str = str.replace(/\[c3\]([\s\S]*)\[\/c3\]/gim, '<span style="color: #77FFFF;">$1</span>');
            }
            else if(i===4) {
                str = str.replace(/\[c4\]([\s\S]*)\[\/c4\]/gim, '<span style="color: #FFAAAA;">$1</span>');
            }
            else if(i===5) {
                str = str.replace(/\[c5\]([\s\S]*)\[\/c5\]/gim, '<span style="color: #AAFFAA;">$1</span>');
            }
            else {
                str = str.replace(/\[c6\]([\s\S]*)\[\/c6\]/gim, '<span style="color: #AAAAFF;">$1</span>');
            }
        }
    }

    return str
};
export const parseUser = (str,id,usernick,messagearray) => {
    if(usernick!='') {
        let val = '<span><font color="#0567cc" size="2">'+'@'+usernick+', '+'</font></span>';
        str = str.replace(/@([\s\S]*),/gim, val)
    }
    else {
       if(str.search('@')>-1) {

           messagearray.forEach((item)=>{
               if(str.search('@'+item.user_id+',')>-1){
                   let val = '<span><font color="#0567cc" size="2">'+'@'+item.usernick+', '+'</font></span>';
                   str = str.replace(/@([\s\S]*),/gim, val)
               }

           })
       }
    }
    return str;
};
export const parsePath = (mes,smiles,images) => {
    if(mes.search(';')>-1){
        smiles.forEach((item)=>{
            if(mes.search(item.charactor)>-1) {
                let regex = new RegExp(';'+item.charactor+ ';','g');
                mes = mes.replace(regex, `;${item.src};`);

            }
        })
    }
    if(mes.search('%')>-1) {
        images.forEach((item)=>{
            if(mes.search(item.charactor)>-1) {
                let regex = new RegExp('%'+item.charactor+ '%','g');
                mes = mes.replace(regex, `%${item.filepath}%`);
            }
        });

    }
    return mes;
};
export const CheckAvatar = (img) => {
    if(img===null) {
        img = '/images/default/avatar/avatar.png'
    }
    return img
};
export const bold = (text,id) => {
    textareaObj(id).value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        textareaObj(id).value = textareaObj().value.replace(sel, '[b]'+sel+'[/b]');
    } else {
        insertText('[b][/b]', id)
    }
    textareaObj(id).focus();
    return textareaObj(id).value
};
export const color = (text,id) => {
    textareaObj(id).value = text;
    let sel = document.getSelection().toString();
    return sel;
};
export const italic = (text,id) => {
    textareaObj(id).value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj(id).value.replace(sel, '[i]'+sel+'[/i]');
        textareaObj().value = newValue;
    }  else {
        insertText('[i][/i]',id)
    }
    textareaObj(id).focus();
    return textareaObj(id).value
};

export const underline = (text,id) => {
    textareaObj(id).value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj(id).value.replace(sel, '[u]'+sel+'[/u]');
        textareaObj(id).value = newValue;
    } else {
        insertText('[u][/u]',id)
    }
    textareaObj(id).focus();
    return textareaObj(id).value
};
export const link = (text,id) => {
    textareaObj(id).value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj(id).value.replace(sel, '[url]'+sel+'[/url]');
        textareaObj(id).value = newValue;

    } else {
        insertText('[url][/url]', id)
    }
    textareaObj(id).focus();
    return textareaObj(id).value
};
export const img = (text,id) => {
    textareaObj(id).value = text;
    let sel = document.getSelection().toString();
    if (sel.length > 0) {
        let newValue = textareaObj(id).value.replace(sel, '[img]'+sel+'[/img]');
        textareaObj(id).value = newValue;

    } else {
        insertText('[img][/img]', id)
    }
    textareaObj(id).focus();
    return textareaObj(id).value
};

export const insertText = (text,id) => {
    var txtarea = textareaObj(id);
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
