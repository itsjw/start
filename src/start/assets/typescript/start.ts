define(['require'], function (require) {
    class Start {
        constructor() {
            var start = this;
            var fragments = document.getElementsByClassName('fragment');

            for (var i = 0; i < fragments.length; i++) {
                var fragment = fragments[i];
                var uri = fragment.dataset.uri;

                fragment.addEventListener('click', function() {
                    start.setFragment(uri);
                }, false);
            }
        }

        public run() {
            this.setFeed();
        }

        public setFeed() {

        }

        public setFragment(uri: string) {
            require([uri + '?'], function() {});
        }
    }

    class Fragment {
        public getUri() {
            return '';
        }
    }

    return new Start();
});

