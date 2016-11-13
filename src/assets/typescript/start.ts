define(['require', 'buzz'], function (require, buzz) {
    class Start {
        private activities: Array;

        constructor() {
            this.activities = [];
        }

        public run() {
            this.loadActivities();
            this.extraActivities();
        }

        public loadActivities() {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/activities', true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var activities = data.content;

                    for (var i = 0; i < activities.length; i++) {
                        (function(i) {
                            start.addActivity(new Activity(activities[i].id, activities[i].name, activities[i].title, activities[i].color, activities[i].readonly));
                        })(i)
                    }
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public extraActivities() {
            var start = this;

            setInterval(function() {
                var request = new XMLHttpRequest();
                request.open('GET', '/extra', true);

                request.onload = function() {
                    if (request.status >= 200 && request.status < 400) {
                        var data = JSON.parse(request.responseText);

                        if (data.hasOwnProperty('content') && data.content !== null) {
                            var activity = data.content;

                            if (typeof activity === 'object' && Object.keys(activity).length !== 0) {
                                start.addActivity(new Activity(activity.id, activity.name, activity.title, activity.color, activity.readonly));

                                var sound = new buzz.sound("http://static.start.dev/start/sound/activity.mp3");
                                sound.play();
                            }
                        }
                    } else {
                    }
                };

                request.onerror = function() {
                };

                request.send();
            }, 10000);
        }

        public closeActivity(id: number) {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('POST', '/activity/' + id, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));

                    for (var i = 0;  i < start.activities.length; i++) {
                        (function(i) {
                            if(start.activities[i].id === id) {
                                start.activities.splice(i, 1);
                            }
                        })(i)
                    }

                    if (start.activities.length > 0) {
                        start.openWorkspace(start.activities[0]);
                    }
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public addActivity(activity: Activity) {
            this.activities.push(activity);
            this.addSticker(activity);

            if (this.activities.length === 1) {
                this.openWorkspace(activity);
            }
        }

        public addSticker(activity: Activity) {
            var start = this;

            var sticker = document.createElement("div");

            if (activity.color != null) {
                sticker.style['border-left'] = '20px solid ' + activity.color;
            }

            sticker.id = 'sticker' + activity.id;
            sticker.setAttribute('class', 'sticker');
            sticker.innerHTML = `
                <div style="color: #cccccc; font-size: smaller">` + activity.name + `</div>
                <div style="margin-top: 5px">` + activity.title + `</div>
            `;

            sticker.addEventListener('click', function () {
                start.openWorkspace(activity);
            }, false);

            document.getElementById("stickers").appendChild(sticker);
        }

        public setWorkspaceContent(id: number, html: string) {
            document.getElementById('workspace-content' + id).innerHTML = html;
        }

        public openWorkspace(activity: Activity) {
            var start = this;
            var workspace = document.getElementById("workspace" + activity.id);

            if (workspace == null) {
                var _workspace = document.createElement("div");
                _workspace.id = 'workspace' + activity.id;
                _workspace.setAttribute('class', 'workspace');

                var _workspace_content = document.createElement("div");
                _workspace_content.id = 'workspace-content' + activity.id;

                _workspace.appendChild(_workspace_content);

                if (activity.readonly) {
                    var _close_button = document.createElement("button");
                    _close_button.id = 'close-button' + activity.id;
                    _close_button.innerText = 'Закрыть';

                    _workspace.appendChild(_close_button);
                }

                _close_button.addEventListener('click', function () {
                    if (confirm('Close activity?')) {
                        start.closeActivity(activity.id);
                    }
                }, false);

                document.getElementById("workspaces").appendChild(_workspace);
            }

            var workspaces = document.getElementsByClassName('workspace');

            for (var i = 0; i < workspaces.length; i++) {
                (function(i) {
                    workspaces[i].style.display = "none";
                })(i)
            }

            document.getElementById("workspace" + activity.id).style.display = "block";

            require(['/activity/' + activity.id], function() {});
        }
    }

    class Activity {
        id: number;
        name: string;
        title: string;
        color: string;
        readonly: boolean;

        constructor(id: number, name: string, title: string, color: string, readonly: boolean) {
            this.id = id;
            this.name = name;
            this.title = title;
            this.color = color;
            this.readonly = readonly;
        }
    }

    return new Start();
});

