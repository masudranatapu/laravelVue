<template>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Login to your account
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <div class="col-md-12">
                                <label>Email Address </label>
                                <input v-model="query.email" type="email" class="form-control" name="email" placeholder="Email Address">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-md-12">
                                <label>Password</label>
                                <input v-model="query.password" type="password" class="form-control " name="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        components: {},
        props: [],
        data: function () {
            return {
                query : {
                    email: "",
                    password: "",
                },
            }
        },
        beforeMount() {

        },
        mounted() {

        },
        created() {

        }, 
        beforeDestroy() {

        },
        watch : {

        },
        methods : {
            
        }
    }
</script>