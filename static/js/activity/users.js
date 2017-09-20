var users = new Vue({
    el: '#users',
    data: {
        users: [],
        form_activities: [],
        form_navs: [],
        form_roles: [],
        creating: false,
        index: null,
        form: {}
    },
    methods: {
        init: function () {
            this.resetForm();

            this.$http.get('/api/users').then(function(response) {
                if (response.body.content) {
                    this.users = response.body.content;
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

            this.$http.get('/api/navs').then(function(response) {
                if (response.body.content) {
                    this.form_navs = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });

            this.$http.get('/api/roles').then(function(response) {
                if (response.body.content) {
                    this.form_roles = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });
        },
        editUser: function (user) {
            this.form = JSON.parse(JSON.stringify(user));
            this.creating = true;
            this.index = this.users.indexOf(user);
        },
        saveForm: function () {
            var $this = this;
            var request = null;

            if (this.form.id) {
                request = this.$http.put('/api/user/' + this.form.id, this.form);
            } else {
                request = this.$http.post('/api/user', this.form);
            }

            request.then(function(response) {
                if ([200, 201].indexOf(response.status) > -1) {
                    if ($this.index !== null) {
                        $this.users[$this.index] = response.body.content;
                    } else {
                        $this.users.push(response.body.content);
                    }

                    $this.cancelForm();
                }
            }, function(response) {
                console.log(response);
            });
        },
        deleteUser: function (user) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            this.$http.delete('/api/user/' + user.id).then(function(response) {
                if (response.status === 200) {
                    $this.users.splice($this.users.indexOf(user), 1);
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
                username: '',
                password: '',
                firs_name: '',
                last_name: '',
                activities: [],
                navs: [],
                roles: []
            };
        }
    }
});

users.init();
