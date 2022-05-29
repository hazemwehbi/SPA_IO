<template>
    <div>
        <h4 class="text-center">Add Task</h4>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addTask">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="task.name">
                    </div><br>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="task.description">
                    </div><br>
                    <button type="submit" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            task: {}
        }
    },
    methods: {
        addTask() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/tasks/add', this.task)
                    .then(response => {
                        this.$router.push({name: 'tasks'})
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>
