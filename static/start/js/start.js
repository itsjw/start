define(['require'], function (require) {
    var Start = (function () {
        function Start() {
        }
        Start.prototype.run = function () {
            this.loadFeed();
        };
        Start.prototype.loadFeed = function () {
            var start = this;
            var request = new XMLHttpRequest();
            request.open('GET', '/fragments', true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    var data = JSON.parse(request.responseText);
                    var fragments = data.content;
                    for (var i = 0; i < fragments.length; i++) {
                        (function (i) {
                            var fragment = fragments[i];
                            var html = "<div id=\"task" + fragment.id + "\" class=\"task\" data-id=\"" + fragment.id + "\">\n                                <div><span style=\"color: #cccccc\">\u0414\u043B\u044F \u043A\u043E\u0433\u043E:</span> " + fragment.name + "</div>\n                                <div><span style=\"color: #cccccc\">\u041E\u043F\u0438\u0441\u0430\u043D\u0438\u0435:</span> " + fragment.title + "</div>\n                            </div>";
                            document.getElementById("tasks").innerHTML += html;
                        })(i);
                    }
                    var tasks = document.getElementsByClassName('task');
                    for (var i = 0; i < tasks.length; i++) {
                        (function (i) {
                            tasks[i].addEventListener('click', function () {
                                start.setFragment(tasks[i].dataset.id);
                            }, false);
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
        Start.prototype.closeFragment = function (id) {
            var request = new XMLHttpRequest();
            request.open('POST', '/fragment/' + id, true);
            request.onload = function () {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("wrapper").removeChild(document.getElementById("fragment" + id));
                    document.getElementById("tasks").removeChild(document.getElementById("task" + id));
                }
                else {
                }
            };
            request.onerror = function () {
            };
            request.send();
        };
        Start.prototype.addFragment = function (id, html) {
            document.getElementById('fragment' + id).innerHTML = html;
        };
        Start.prototype.setFragment = function (id) {
            var fragment = document.getElementById("fragment" + id);
            if (fragment == null) {
                document.getElementById("wrapper").innerHTML += '<div id="fragment' + id + '" class="fragment"></div>';
            }
            var fragments = document.getElementsByClassName('fragment');
            for (var i = 0; i < fragments.length; i++) {
                (function (i) {
                    fragments[i].style.display = "none";
                })(i);
            }
            document.getElementById("fragment" + id).style.display = "block";
            require(['/fragment/' + id], function () { });
        };
        return Start;
    }());
    var Fragment = (function () {
        function Fragment() {
        }
        Fragment.prototype.getUri = function () {
            return '';
        };
        return Fragment;
    }());
    return new Start();
});
