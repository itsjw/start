define(['require'], function (require) {
    class Start {
        private activities: Array;

        constructor() {
            this.activities = [];
        }

        public run() {
            this.loadStickers();
        }

        public loadStickers() {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/activities', true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var activities = data.content;

                    for (var i = 0; i < activities.length; i++) {
                        (function(i) {
                            var activity = new Activity(activities[i].id, activities[i].name, activities[i].title);
                            start.activities.push(activity);
                            start.addSticker(activity);
                        })(i)
                    }

                    var stickers = document.getElementsByClassName('sticker');

                    for (var i = 0; i < stickers.length; i++) {
                        (function(i) {
                            stickers[i].addEventListener('click', function () {
                                start.addWorkspace(stickers[i].dataset.id);
                            }, false);
                        })(i)
                    }

                    if (activities.length > 0) {
                        start.addWorkspace(activities[0].id);
                    }
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public closeActivity(id: number) {
            var request = new XMLHttpRequest();
            request.open('POST', '/activity/' + id, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public addSticker(activity: Activity) {
            document.getElementById("stickers").innerHTML += `<div id="sticker` + activity.id + `" class="sticker" data-id="` + activity.id + `">
                <div><span style="color: #cccccc">Для кого:</span> ` + activity.name + `</div>
                <div><span style="color: #cccccc">Описание:</span> ` + activity.title + `</div>
            </div>`;
        }

        public addActivity(id: number, html: string) {
            document.getElementById('workspace' + id).innerHTML = html;
        }

        public addWorkspace(id: number) {
            var fragment = document.getElementById("workspace" + id);

            if (fragment == null) {
                document.getElementById("workspaces").innerHTML += '<div id="workspace' + id + '" class="workspace"></div>';
            }

            var workspaces = document.getElementsByClassName('workspace');

            for (var i = 0; i < workspaces.length; i++) {
                (function(i) {
                    workspaces[i].style.display = "none";
                })(i)
            }

            document.getElementById("workspace" + id).style.display = "block";

            require(['/activity/' + id], function() {});
        }
    }

    class Activity {
        id: number;
        name: string;
        title: string;

        constructor(id: number, name: string, title: string) {
            this.id = id;
            this.name = name;
            this.title = title;
        }
    }

    return new Start();
});

