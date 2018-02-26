/*
 *	Upload files to the server using HTML 5 Drag and drop the folders on your local computer
 *
 *	Tested on:
 *	Mozilla Firefox 3.6.12
 *	Google Chrome 7.0.517.41
 *	Safari 5.0.2
 *	Safari na iPad
 *	WebKit r70732
 *
 *	The current version does not work on:
 *	Opera 10.63
 *	Opera 11 alpha
 *	IE 6+
 */
var json_parse=function(){var h,a,k={'"':'"',"\\":"\\","/":"/",b:"\u0008",f:"\u000c",n:"\n",r:"\r",t:"\t"},j,g=function(a){throw{name:"SyntaxError",message:a,at:h,text:j};},b=function(b){b&&b!==a&&g("Expected '"+b+"' instead of '"+a+"'");a=j.charAt(h);h+=1;return a},l=function(){var c;c="";a==="-"&&(c="-",b("-"));for(;a>="0"&&a<="9";)c+=a,b();if(a===".")for(c+=".";b()&&a>="0"&&a<="9";)c+=a;if(a==="e"||a==="E"){c+=a;b();if(a==="-"||a==="+")c+=a,b();for(;a>="0"&&a<="9";)c+=a,b()}c=+c;if(isFinite(c))return c;
else g("Bad number")},m=function(){var c,f,d="",e;if(a==='"')for(;b();)if(a==='"')return b(),d;else if(a==="\\")if(b(),a==="u"){for(f=e=0;f<4;f+=1){c=parseInt(b(),16);if(!isFinite(c))break;e=e*16+c}d+=String.fromCharCode(e)}else if(typeof k[a]==="string")d+=k[a];else break;else d+=a;g("Bad string")},e=function(){for(;a&&a<=" ";)b()},n=function(){switch(a){case "t":return b("t"),b("r"),b("u"),b("e"),true;case "f":return b("f"),b("a"),b("l"),b("s"),b("e"),false;case "n":return b("n"),b("u"),b("l"),
b("l"),null}g("Unexpected '"+a+"'")},i;i=function(){e();switch(a){case "{":var c;a:{var f,d={};if(a==="{"){b("{");e();if(a==="}"){b("}");c=d;break a}for(;a;){f=m();e();b(":");Object.hasOwnProperty.call(d,f)&&g('Duplicate key "'+f+'"');d[f]=i();e();if(a==="}"){b("}");c=d;break a}b(",");e()}}g("Bad object")}return c;case "[":a:{c=[];if(a==="["){b("[");e();if(a==="]"){b("]");f=c;break a}for(;a;){c.push(i());e();if(a==="]"){b("]");f=c;break a}b(",");e()}}g("Bad array")}return f;case '"':return m();case "-":return l();
default:return a>="0"&&a<="9"?l():n()}};return function(b,f){var d;j=b;h=0;a=" ";d=i();e();a&&g("Syntax error");return typeof f==="function"?function o(a,b){var c,e,d=a[b];if(d&&typeof d==="object")for(c in d)Object.prototype.hasOwnProperty.call(d,c)&&(e=o(d,c),e!==void 0?d[c]=e:delete d[c]);return f.call(a,b,d)}({"":d},""):d}}();

function uploader(place, targetPHP, callback) {

    // Upload image files
    var upload = function (file) {

        // Firefox 3.6, Chrome 6, WebKit
        if (window.FileReader) {

            // Once the process of reading file
            this.loadEnd = function () {
                bin = reader.result;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', targetPHP + '?up=true', true);
                var boundary = 'xxxxxxxxx';
                var body = '--' + boundary + "\r\n";
                body += "Content-Disposition: form-data; name='upload'; filename='" + file.name + "'\r\n";
                body += "Content-Type: application/octet-stream\r\n\r\n";
                body += bin + "\r\n";
                body += '--' + boundary + '--';
                xhr.setRequestHeader('content-type', 'multipart/form-data; boundary=' + boundary);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState != 4) {
                        return;
                    }
                    if (callback && xhr.responseText) {
                        var result = json_parse(xhr.responseText, function (key, value) {
                            var a;
                            if (typeof value === 'string') {
                                a =
                                    /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2}(?:\.\d*)?)Z$/.exec(value);
                                if (a) {
                                    return new Date(Date.UTC(+a[1], +a[2] - 1, +a[3], +a[4],
                                        +a[5], +a[6]));
                                }
                            }
                            return value;
                        });
                        callback({data:result});
                    }
                };
                // Firefox 3.6 provides a feature sendAsBinary ()

                if (xhr.sendAsBinary != null) {
                    xhr.sendAsBinary(body);
                    // Chrome 7 sends data but you must use the base64_decode on the PHP side
                } else {
                    xhr.open('POST', targetPHP + '?up=true&base64=true', true);
                    xhr.setRequestHeader('UP-FILENAME', file.name);
                    xhr.setRequestHeader('UP-SIZE', file.size);
                    xhr.setRequestHeader('UP-TYPE', file.type);
                    xhr.send(window.btoa(bin));


                }
            }

            // Loading errors
            this.loadError = function (event) {
                switch (event.target.error.code) {
                    case event.target.error.NOT_FOUND_ERR:
                        callback({
                            error:'Файл не найден!'
                        });
                        break;
                    case event.target.error.NOT_READABLE_ERR:
                        callback({
                            error:'Файл недоступен!'
                        });
                        break;
                    case event.target.error.ABORT_ERR:
                        break;
                    default:
                        callback({
                            error:'Ошибка чтения.'
                        });
                }
            }

            // Reading Progress
            this.loadProgress = function (event) {
                if (event.lengthComputable) {
                    var percentage = Math.round((event.loaded * 100) / event.total);
                    callback({
                        progress:'Загружено : ' + percentage + '%'
                    });
                    document.getElementById(status).innerHTML = 'Загружено : ' + percentage + '%';
                }
            }

            var reader = new FileReader();
            // Firefox 3.6, WebKit
            if (reader.addEventListener) {
                reader.addEventListener('loadend', this.loadEnd, false);
                if (status != null) {
                    reader.addEventListener('error', this.loadError, false);
                 //   reader.addEventListener('progress', this.loadProgress, false);
                }

                // Chrome 7
            } else {
                reader.onloadend = this.loadEnd;
                if (callback != null) {
                    reader.onerror = this.loadError;
                    //reader.onprogress = this.loadProgress;
                }
            }

            // The function that starts reading the file as a binary string
            reader.readAsBinaryString(file);


            // Safari 5 does not support FileReader
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', targetPHP + '?up=true', true);
            xhr.setRequestHeader('UP-FILENAME', file.name);
            xhr.setRequestHeader('UP-SIZE', file.size);
            xhr.setRequestHeader('UP-TYPE', file.type);
            xhr.onreadystatechange = function () {
                if (xhr.readyState != 4) {
                    return;
                }
                if (callback && xhr.responseText) {
                    var result = json_parse(xhr.responseText, function (key, value) {
                        var a;
                        if (typeof value === 'string') {
                            a =
                                /^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2}(?:\.\d*)?)Z$/.exec(value);
                            if (a) {
                                return new Date(Date.UTC(+a[1], +a[2] - 1, +a[3], +a[4],
                                    +a[5], +a[6]));
                            }
                        }
                        return value;
                    });
                    callback({data:result});
                }
            };
            xhr.send(file);
        }
    }

    // Function drop file
    this.drop = function (event) {
        event.preventDefault();
        var dt = event.dataTransfer;
        var files = dt.files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            upload(file);
        }
    }

    // The inclusion of the event listeners (DragOver and drop)

    this.uploadPlace = document.getElementById(place);
    this.uploadPlace.addEventListener("dragover", function (event) {
        event.stopPropagation();
        event.preventDefault();
    }, true);
    this.uploadPlace.addEventListener("drop", this.drop, false);

}

	
