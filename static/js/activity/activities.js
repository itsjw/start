var activities = new Vue({
    el: '#activities',
    data: {
        activities: [],
        creating: false,
        index: null,
        form: {}
    },
    methods: {
        init: function () {
            this.resetForm();

            this.$http.get('/api/activities').then(function(response) {
                if (response.body.content) {
                    this.activities = response.body.content;
                }
            }, function(response) {
                console.log(response);
            });
        },
        editActivity: function (activity) {
            this.form = JSON.parse(JSON.stringify(activity));
            this.creating = true;
            this.index = this.activities.indexOf(activity);
        },
        saveForm: function () {
            var $this = this;
            var request = null;

            if (this.form.id) {
                request = this.$http.put('/api/activity/' + this.form.id, this.form);
            } else {
                request = this.$http.post('/api/activity', this.form);
            }

            request.then(function(response) {
                if ([200, 201].indexOf(response.status) > -1) {
                    if ($this.index !== null) {
                        $this.activities[$this.index] = response.body.content;
                    } else {
                        $this.activities.push(response.body.content);
                    }

                    $this.cancelForm();
                }
            }, function(response) {
                console.log(response);
            });
        },
        deleteActivity: function (activity) {
            if (!confirm('Вы уверены?')) {
                return;
            }

            var $this = this;

            this.$http.delete('/api/activity/' + activity.id).then(function(response) {
                if (response.status === 200) {
                    $this.activities.splice($this.activities.indexOf(activity), 1);
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
                iframe: '',
                priority: '',
                color: '',
                commenting: false,
                postponing: false,
                closing: true
            };
        }
    }
});

activities.init();
