define(['require'], function (require) {
    var Start = (function () {
        function Start() {
            var start = this;
            var tasks = document.getElementsByClassName('task');
            for (var i = 0; i < tasks.length; i++) {
                (function (i) {
                    tasks[i].addEventListener('click', function () {
                        start.setFragment(tasks[i].dataset.id);
                    }, false);
                })(i);
            }
            setTimeout(function () {
                start.closeFragment(4);
            }, 10000);
        }
        Start.prototype.run = function () {
            this.setFeed();
        };
        Start.prototype.setFeed = function () {
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
