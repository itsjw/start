define(['require'], function (require) {
    class Start {
        constructor() {
            var start = this;
            var tasks = document.getElementsByClassName('task');

            for (var i = 0; i < tasks.length; i++) {
                (function(i) {
                    tasks[i].addEventListener('click', function () {
                        start.setFragment(tasks[i].dataset.id);
                    }, false);
                })(i)
            }

            setTimeout(function() {
                start.closeFragment(4);
            }, 10000);
        }

        public run() {
            this.setFeed();
        }

        public setFeed() {

        }

        public closeFragment(id: number) {
            var request = new XMLHttpRequest();
            request.open('POST', '/fragment/' + id, true);

            request.onload = function() {
                if (request.status >= 200 && request.status < 400) {
                    document.getElementById("wrapper").removeChild(document.getElementById("fragment" + id));
                    document.getElementById("tasks").removeChild(document.getElementById("task" + id));
                } else {
                }
            };

            request.onerror = function() {
            };

            request.send();
        }

        public setFragment(id: number) {
            var fragment = document.getElementById("fragment" + id);

            if (fragment == null) {
                document.getElementById("wrapper").innerHTML += '<div id="fragment' + id + '" class="fragment"></div>';
            }

            var fragments = document.getElementsByClassName('fragment');

            for (var i = 0; i < fragments.length; i++) {
                (function(i) {
                    fragments[i].style.display = "none";
                })(i)
            }

            document.getElementById("fragment" + id).style.display = "block";

            require(['/fragment/' + id], function() {});
        }
    }

    class Fragment {
        public getUri() {
            return '';
        }
    }

    return new Start();
});

