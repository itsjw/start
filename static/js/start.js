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
        Start.prototype.postponeDuty = function (id, period) {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('POST', '/duty/postpone/' + id, true);
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
            request.send(JSON.stringify({ "period": period }));
        };
        Start.prototype.closeDuty = function (id) {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('POST', '/duty/close/' + id, true);
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
            document.getElementById('duty-area' + id).innerHTML = html;
        };
        Start.prototype.openWorkspace = function (duty) {
            var start = this;
            var workspace = document.getElementById("workspace" + duty.id);
            if (workspace == null) {
                var _workspace = document.createElement("div");
                _workspace.id = 'workspace' + duty.id;
                _workspace.setAttribute('class', 'workspace');
                var _duty_area = document.createElement("div");
                _duty_area.id = 'duty-area' + duty.id;
                if (duty.iframe !== null) {
                    var _iframe = document.createElement('iframe');
                    _iframe.src = duty.iframe;
                    _iframe.style.width = '100%';
                    _iframe.style.border = 0;
                    _iframe.style.height = ((window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight) - 80) + "px";
                    _duty_area.appendChild(_iframe);
                }
                _workspace.appendChild(_duty_area);
                var _postpone_area = document.createElement("div");
                _postpone_area.id = 'postpone-area' + duty.id;
                _postpone_area.setAttribute('class', 'postpone-area');
                var _postpone_area_list = document.createElement("ul");
                var postpone_options = ['+15 min', '+30 min', '+1 hour', '+2 hour', '+1 day'];
                for (i = 0; i < postpone_options.length; i++) {
                    (function (i) {
                        var _li = document.createElement("li");
                        var _span = document.createElement("span");
                        _span.innerText = postpone_options[i];
                        _span.addEventListener('click', function () {
                            if (confirm('Postpone duty?')) {
                                start.postponeDuty(duty.id, postpone_options[i]);
                            }
                        }, false);
                        _li.appendChild(_span);
                        _postpone_area_list.appendChild(_li);
                    })(i);
                }
                _postpone_area.appendChild(_postpone_area_list);
                _workspace.appendChild(_postpone_area);
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
                var _postpone_button = document.createElement("button");
                _postpone_button.id = 'postpone-button' + duty.id;
                _postpone_button.innerText = 'Отложить';
                _postpone_button.addEventListener('click', function (event) {
                    var duty_area = document.getElementById("duty-area" + duty.id);
                    if (duty_area.style.display == 'none') {
                        document.getElementById("duty-area" + duty.id).style.display = "block";
                        document.getElementById("postpone-area" + duty.id).style.display = "none";
                    }
                    else {
                        document.getElementById("duty-area" + duty.id).style.display = "none";
                        document.getElementById("postpone-area" + duty.id).style.display = "block";
                    }
                }, false);
                _workspace.appendChild(_postpone_button);
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
