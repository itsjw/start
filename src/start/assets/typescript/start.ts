define(['require'], function (require) {
    class Start {
        constructor() {
            var start = this;
            var fragments = document.getElementsByClassName('fragment');

            for (var i = 0; i < fragments.length; i++) {
                (function(i) {
                    fragments[i].addEventListener('click', function () {
                        start.setFragment(fragments[i].dataset.id);
                    }, false);
                })(i)
            }
        }

        public run() {
            this.setFeed();
        }

        public setFeed() {

        }

        public setFragment(id: number) {
            var wrapper = document.getElementById(id.toString());

            if (wrapper == null) {
                document.getElementById("wrapper").innerHTML += '<div id="' + id + '" class="wrapper"></div>';
            }

            var wrappers = document.getElementsByClassName('wrapper');

            for (var i = 0; i < wrappers.length; i++) {
                (function(i) {
                    wrappers[i].style.display = "none";
                })(i)
            }

            document.getElementById(id.toString()).style.display = "block";

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

