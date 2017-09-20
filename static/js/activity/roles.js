var roles = new Vue({
    el: '#roles',
    data: {
        roles: [],
        form_activities: [],
        form_navs: [],
        creating: false,
        index: null,
        form: {}
    },
    methods: {
        init: function () {
            this.resetForm();

            this.$http.get('/api/roles').then(function(response) {
                if (response.body.content) {
                    this.roles = response.body.content;
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
        },
        editRole: function (role) {
            this.form = JSON.parse(JSON.stringify(role));
            this.creating = true;
            this.index = this.roles.indexOf(role);
        },
        saveForm: function () {
            var $this = this;
            var request = null;

            if (this.form.id) {
                request = this.$http.put('/api/role/' + this.form.id, this.form);
            } else {
                request = this.$http.post('/api/role', this.form);
            }

            request.then(function(response) {
                if ([200, 201].indexOf(response.status) > -1) {
                    if ($this.index !== null) {
                        $this.roles[$this.index] = response.body.content;
                    } else {
                        $this.roles.push(response.body.content);
                    }

                    $this.cancelForm();
                }
            }, function(response) {
                console.log(response);
            });
        },
        deleteRole: function (role) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            this.$http.delete('/api/role/' + role.id).then(function(response) {
                if (response.status === 200) {
                    $this.roles.splice($this.roles.indexOf(role), 1);
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
                activities: [],
                navs: []
            };
        }
    }
});

roles.init();
