define(['require', 'buzz'], function (require, buzz) {
    class Start {
        private duties: Array;

        constructor() {
            this.duties = [];
        }

        public run() {
            var start = this;

            this.loadDuties();

            document.addEventListener('Start.closeDuty', function(event) {
                start.closeDuty(event.detail);
            });
        }

        public loadDuties() {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/duties', true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var duties = data.content;

                    if (duties.length == 0) {
                        document.getElementById("no-duties").style.display = 'block';
                    }

                    for (var i = 0; i < duties.length; i++) {
                        (function(i) {
                            start.addDuty(new Duty(duties[i]));
                        })(i)
                    }

                    setInterval(function() {
                        start.loadExtraDuties();
                    }, 10000);
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public loadExtraDuties() {
            var start = this;

            var request = new XMLHttpRequest();
            request.open('GET', '/extra', true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);

                    if (data.hasOwnProperty('content') && data.content !== null) {
                        var duty = data.content;

                        if (typeof duty === 'object' && Object.keys(duty).length !== 0) {
                            document.getElementById("no-duties").style.display = 'none';

                            start.addDuty(new Duty(duty));

                            var sound = new buzz.sound(DATA.static + "/sound/extra.mp3");
                            sound.play();
                        }
                    }

                    if (start.duties.length == 0) {
                        document.getElementById("no-duties").style.display = 'block';
                    }
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public postponeDuty(id: number, period: string) {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('POST', '/duty/postpone/' + id, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));

                    for (var i = 0;  i < start.duties.length; i++) {
                        (function(i) {
                            if(start.duties[i].id === id) {
                                start.duties.splice(i, 1);
                            }
                        })(i)
                    }

                    if (start.duties.length > 0) {
                        start.openWorkspace(start.duties[0]);
                    } else {
                        start.loadExtraDuties();
                    }
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send(JSON.stringify({"period": period}));
        }

        public closeDuty(id: number) {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('POST', '/duty/close/' + id, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));

                    for (var i = 0;  i < start.duties.length; i++) {
                        (function(i) {
                            if(start.duties[i].id === id) {
                                start.duties.splice(i, 1);
                            }
                        })(i)
                    }

                    if (start.duties.length > 0) {
                        start.openWorkspace(start.duties[0]);
                    } else {
                        start.loadExtraDuties();
                    }
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public addDuty(duty: Duty) {
            this.duties.push(duty);
            this.addSticker(duty);

            if (this.duties.length === 1) {
                this.openWorkspace(duty);
            }
        }

        public addSticker(duty: Duty) {
            var start = this;

            var sticker = document.createElement("div");

            if (duty.color != null) {
                sticker.style['border-left'] = '20px solid ' + duty.color;
            }

            sticker.id = 'sticker' + duty.id;
            sticker.setAttribute('class', 'sticker');
            sticker.innerHTML = `
                <div style="color: #cccccc; font-size: smaller">` + duty.name + `</div>
                <div style="margin-top: 5px">` + duty.title + `</div>
            `;

            sticker.addEventListener('click', function () {
                start.openWorkspace(duty);
            }, false);

            document.getElementById("stickers").appendChild(sticker);
        }

        public setWorkspaceContent(id: number, html: string) {
            document.getElementById('duty-area' + id).innerHTML = html;
        }

        public openWorkspace(duty: Duty) {
            var start = this;
            var workspace = document.getElementById("workspace" + duty.id);

            if (workspace == null) {
                var _workspace = document.createElement("div");
                _workspace.id = 'workspace' + duty.id;
                _workspace.setAttribute('class', 'workspace');

                var _buttons_area = document.createElement("div");
                _buttons_area.setAttribute('class', 'buttons-area');

                _workspace.appendChild(_buttons_area);

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
                    (function(i) {
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
                    })(i)
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

                    _buttons_area.appendChild(_close_button);
                }

                var _postpone_button = document.createElement("button");
                _postpone_button.id = 'postpone-button' + duty.id;
                _postpone_button.innerText = 'Отложить';

                _postpone_button.addEventListener('click', function (event) {
                    var duty_area = document.getElementById("duty-area" + duty.id);

                    if (duty_area.style.display == 'none') {
                        document.getElementById("duty-area" + duty.id).style.display = "block";
                        document.getElementById("postpone-area" + duty.id).style.display = "none";
                        _postpone_button.innerText = 'Отложить';
                    } else {
                        document.getElementById("duty-area" + duty.id).style.display = "none";
                        document.getElementById("postpone-area" + duty.id).style.display = "block";
                        _postpone_button.innerText = 'Назад';
                    }
                }, false);

                _buttons_area.appendChild(_postpone_button);

                document.getElementById("workspaces").appendChild(_workspace);

                if (duty.iframe === null) {
                    require(['/duty/' + duty.id], function() {});
                }
            }

            var workspaces = document.getElementsByClassName('workspace');
            var stickers = document.getElementsByClassName('sticker');

            for (var i = 0; i < workspaces.length; i++) {
                (function(i) {
                    workspaces[i].style.display = "none";
                    stickers[i].style.background = "white";
                })(i)
            }

            document.getElementById("sticker" + duty.id).style.background = "cornsilk";
            document.getElementById("workspace" + duty.id).style.display = "block";
        }
    }

    class Duty {
        id: number = null;
        name: string = null;
        title: string = null;
        color: string = null;
        iframe: string = null;
        readonly: boolean = null;

        constructor(object: any) {
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
    }

    return new Start();
});

