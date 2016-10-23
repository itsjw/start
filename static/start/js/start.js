define(['require'], function (require) {
    var Start = (function () {
        function Start() {
            this.activities = [];
        }
        Start.prototype.run = function () {
            this.loadActivities();
            this.extraActivities();
        };
        Start.prototype.loadActivities = function () {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/activities', true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var activities = data.content;
                    for (var i = 0; i < activities.length; i++) {
                        (function (i) {
                            start.addActivity(new Activity(activities[i].id, activities[i].name, activities[i].title));
                        })(i);
                    }
                }
                else {
                }
            };
            request.onerror = function () {
            };
            request.send();
        };
        Start.prototype.extraActivities = function () {
            var start = this;
            setInterval(function () {
                var request = new XMLHttpRequest();
                request.open('GET', '/extra', true);
                request.onload = function () {
                    if (request.status >= 200 && request.status < 400) {
                        var data = JSON.parse(request.responseText);
                        if (data.hasOwnProperty('content') && data.content !== null) {
                            var activity = data.content;
                            if (typeof activity === 'object' && Object.keys(activity).length !== 0) {
                                start.addActivity(new Activity(activity.id, activity.name, activity.title));
                            }
                        }
                    }
                    else {
                    }
                };
                request.onerror = function () {
                };
                request.send();
            }, 10000);
        };
        Start.prototype.closeActivity = function (id) {
            var request = new XMLHttpRequest();
            request.open('POST', '/activity/' + id, true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("workspaces").removeChild(document.getElementById("workspace" + id));
                    document.getElementById("stickers").removeChild(document.getElementById("sticker" + id));
                }
                else {
                }
            };
            request.onerror = function () {
            };
            request.send();
        };
        Start.prototype.addActivity = function (activity) {
            this.activities.push(activity);
            this.addSticker(activity);
            if (this.activities.length === 1) {
                this.openWorkspace(activity);
            }
        };
        Start.prototype.addSticker = function (activity) {
            var start = this;
            var sticker = document.createElement("div");
            sticker.id = 'sticker' + activity.id;
            sticker.setAttribute('class', 'sticker');
            sticker.innerHTML = "\n                <div><span style=\"color: #cccccc\">\u0414\u043B\u044F \u043A\u043E\u0433\u043E:</span> " + activity.name + "</div>\n                <div><span style=\"color: #cccccc\">\u041E\u043F\u0438\u0441\u0430\u043D\u0438\u0435:</span> " + activity.title + "</div>\n            ";
            sticker.addEventListener('click', function () {
                start.openWorkspace(activity);
            }, false);
            document.getElementById("stickers").appendChild(sticker);
        };
        Start.prototype.setWorkspaceContent = function (id, html) {
            document.getElementById('workspace' + id).innerHTML = html;
        };
        Start.prototype.openWorkspace = function (activity) {
            var workspace = document.getElementById("workspace" + activity.id);
            if (workspace == null) {
                document.getElementById("workspaces").innerHTML += '<div id="workspace' + activity.id + '" class="workspace"></div>';
            }
            var workspaces = document.getElementsByClassName('workspace');
            for (var i = 0; i < workspaces.length; i++) {
                (function (i) {
                    workspaces[i].style.display = "none";
                })(i);
            }
            document.getElementById("workspace" + activity.id).style.display = "block";
            require(['/activity/' + activity.id], function () { });
        };
        return Start;
    }());
    var Activity = (function () {
        function Activity(id, name, title) {
            this.id = id;
            this.name = name;
            this.title = title;
        }
        return Activity;
    }());
    return new Start();
});
