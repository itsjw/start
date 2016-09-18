define(['require'], function (require) {
    class Start {
        constructor() {
        }

        public run() {
            this.setFeed();
        }

        public setFeed() {

        }

        public setFragment(fragment: Fragment) {
            require([fragment.getUri() + '?'], function() {});
        }
    }

    class Fragment {
        public getUri() {
            return '';
        }
    }

    return new Start();
});

