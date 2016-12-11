define(['require', 'buzz'], function (require, buzz) {
    var Start = (function () {
        function Start() {
            this.duties = [];
        }
        Start.prototype.run = function () {
            var start = this;
            this.loadDuties();
            document.addEventListener('Start.closeDuty', function (event) {
                start.closeDuty(event.detail);
            });
        };
        Start.prototype.loadDuties = function () {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/duties', true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var duties = data.content;
                    for (var i = 0; i < duties.length; i++) {
                        (function (i) {
                            start.addDuty(new Duty(duties[i]));
                        })(i);
                    }
                    setInterval(function () {
                        start.loadExtraDuties();
                    }, 10000);
                }
                else {
                }
            };
            request.onerror = function () {
            };
            request.send();
        };
        Start.prototype.loadExtraDuties = function () {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/extra', true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    if (data.hasOwnProperty('content') && data.content !== null) {
                        var duty = data.content;
                        if (typeof duty === 'object' && Object.keys(duty).length !== 0) {
                            start.addDuty(new Duty(duty));
                            var sound = new buzz.sound(DATA.static + "/sound/extra.mp3");
                            sound.play();
                        }
                    }
                }
                else {
                }
            };
            request.onerror = function () {
            };
            request.send();
        };
        Start.prototype.closeDuty = function (id) {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('POST', '/duty/' + id, true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));
                    for (var i = 0; i < start.duties.length; i++) {
                        (function (i) {
                            if (start.duties[i].id === id) {
                                start.duties.splice(i, 1);
                            }
                        })(i);
                    }
                    if (start.duties.length > 0) {
                        start.openWorkspace(start.duties[0]);
                    }
                    else {
                        start.loadExtraDuties();
                    }
                }
                else {
                }
            };
            request.onerror = function () {
            };
            request.send();
        };
        Start.prototype.addDuty = function (duty) {
            this.duties.push(duty);
            this.addSticker(duty);
            if (this.duties.length === 1) {
                this.openWorkspace(duty);
            }
        };
        Start.prototype.addSticker = function (duty) {
            var start = this;
            var sticker = document.createElement("div");
            if (duty.color != null) {
                sticker.style['border-left'] = '20px solid ' + duty.color;
            }
            sticker.id = 'sticker' + duty.id;
            sticker.setAttribute('class', 'sticker');
            sticker.innerHTML = "\n                <div style=\"color: #cccccc; font-size: smaller\">" + duty.name + "</div>\n                <div style=\"margin-top: 5px\">" + duty.title + "</div>\n            ";
            sticker.addEventListener('click', function () {
                start.openWorkspace(duty);
            }, false);
            document.getElementById("stickers").appendChild(sticker);
        };
        Start.prototype.setWorkspaceContent = function (id, html) {
            document.getElementById('workspace-content' + id).innerHTML = html;
        };
        Start.prototype.openWorkspace = function (duty) {
            var start = this;
            var workspace = document.getElementById("workspace" + duty.id);
            if (workspace == null) {
                var _workspace = document.createElement("div");
                _workspace.id = 'workspace' + duty.id;
                _workspace.setAttribute('class', 'workspace');
                var _workspace_content = document.createElement("div");
                _workspace_content.id = 'workspace-content' + duty.id;
                if (duty.iframe !== null) {
                    var _iframe = document.createElement('iframe');
                    _iframe.src = duty.iframe;
                    _iframe.style.width = '100%';
                    _iframe.style.border = 0;
                    _iframe.style.height = ((window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight) - 80) + "px";
                    _workspace_content.appendChild(_iframe);
                }
                _workspace.appendChild(_workspace_content);
                if (duty.readonly) {
                    var _close_button = document.createElement("button");
                    _close_button.id = 'close-button' + duty.id;
                    _close_button.innerText = 'Закрыть';
                    _close_button.addEventListener('click', function () {
                        if (confirm('Close duty?')) {
                            start.closeDuty(duty.id);
                        }
                    }, false);
                    _workspace.appendChild(_close_button);
                }
                document.getElementById("workspaces").appendChild(_workspace);
                if (duty.iframe === null) {
                    require(['/duty/' + duty.id], function () { });
                }
            }
            var workspaces = document.getElementsByClassName('workspace');
            for (var i = 0; i < workspaces.length; i++) {
                (function (i) {
                    workspaces[i].style.display = "none";
                })(i);
            }
            document.getElementById("workspace" + duty.id).style.display = "block";
        };
        return Start;
    }());
    var Duty = (function () {
        function Duty(object) {
            this.id = null;
            this.name = null;
            this.title = null;
            this.color = null;
            this.iframe = null;
            this.readonly = null;
            if (object.id) {
                this.id = object.id;
            }
            if (object.name) {
                this.name = object.name;
            }
            if (object.title) {
                this.title = object.title;
            }
            if (object.color) {
                this.color = object.color;
            }
            if (object.iframe) {
                this.iframe = object.iframe;
            }
            if (object.id) {
                this.readonly = object.readonly;
            }
        }
        return Duty;
    }());
    return new Start();
});
