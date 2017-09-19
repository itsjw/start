var navs = new Vue({
    el: '#navs',
    data: {
        navs: [],
        form_activities: [],
        creating: false,
        index: null,
        form: {}
    },
    methods: {
        init: function () {
            this.resetForm();

            this.$http.get('/api/navs').then(function(response) {
                if (response.body.content) {
                    this.navs = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });

            this.$http.get('/api/activities').then(function(response) {
                if (response.body.content) {
                    this.form_activities = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });
        },
        editNav: function (nav) {
            this.form = JSON.parse(JSON.stringify(nav));
            this.creating = true;
            this.index = this.navs.indexOf(nav);
        },
        saveForm: function () {
            var $this = this;
            var request = null;

            if (this.form.id) {
                request = this.$http.put('/api/nav/' + this.form.id, this.form);
            } else {
                request = this.$http.post('/api/nav', this.form);
            }

            request.then(function(response) {
                if ([200, 201].indexOf(response.status) > -1) {
                    if ($this.index !== null) {
                        $this.navs[$this.index] = response.body.content;
                    } else {
                        $this.navs.push(response.body.content);
                    }

                    $this.cancelForm();
                }
            }, function(response) {
                console.log(response);
            });
        },
        deleteNav: function (nav) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            this.$http.delete('/api/nav/' + nav.id).then(function(response) {
                if (response.status === 200) {
                    $this.navs.splice($this.navs.indexOf(nav), 1);
                }
            }, function(response) {
                console.log(response);
            });
        },
        cancelForm: function () {
            this.resetForm();
            this.creating = false;
            this.index = null;
        },
        resetForm: function () {
            this.form = {
                name: '',
                link: '',
                priority: ''
            };
        }
    }
});

navs.init();
