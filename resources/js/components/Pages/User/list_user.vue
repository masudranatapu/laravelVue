<script setup>
    import axios from "axios";
    import { ref, onMounted, onUpdated } from "vue";
    import $ from "jquery";
    import { Form, Field } from "vee-validate";
    import * as yup from "yup";

    const users = ref([]);
    const editing = ref(false);
    const formValues = ref({
        id:'',
        name :'',
        phone :'',
        email :'',
        address :'',
    });
    const from = ref(null);
    

    const geUsers = () => {
        axios.get("/user/list").then((response) => {
            users.value = response.data.data;
        });
    };

    const addUser = () => {
        editing.value = false;
        from.value.resetForm();
        $("#userModal").modal('show');
    }

    const schema = yup.object({
        name: yup.string().required(),
        email: yup.string().required().email(),
        address: yup.string().required().min(4),
        phone: yup.number().required().min(6),
        password: yup.string().required().min(4),
    });

    const editSchema = yup.object({
        name: yup.string().required(),
        email: yup.string().required().email(),
        address: yup.string().required().min(4),
        phone: yup.number().required().min(6),
        password: yup.string().when((password, schema) => {
            return password ? yup.string().min(4) : schema;
        }),
    });
    
    const createNewUser = (values, { resetForm }) => {
        axios.post("/user/store", values).then((response) => {
            console.log(response.data.type);
            if (response.data.type == "Success") {
                users.value.unshift(response.data.data);
                $("#userModal").modal("hide");
                resetForm();
            } else {
                console.log(response.massage);
            }
        });
    };

    const handleSubmit = (values) => {
        if(editing.value == true) {
            updateUser();
        }else {
            createNewUser();
        }
    }

    const updateUser = () => {
        console.log('sdfsd');
    }

    const editUser = (user) => {
        editing.value = true;
        from.value.resetForm();
        $("#userModal").modal('show');
        formValues.value =user; 
        console.log(formValues);
    }
    
    onMounted(() => {
        geUsers();
    });
</script>

<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/admin/dashboard">
                                Home
                            </router-link>
                        </li>
                        <li class="breadcrumb-item active">
                            User
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-info" @click="addUser">
                                Create New User
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th>SL No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in users" :key="user.id">
                                    <th>{{ index + 1 }}</th>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.phone }}</td>
                                    <td>{{ user.address }}</td>
                                    <td>{{ user.created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:;" class="btn btn-primary btn-sm" @click.prevent="editUser(user)">
                                                Edit
                                            </a>
                                            <a href="javascript:;" class="btn btn-secondary btn-sm">
                                                Delete
                                            </a>
                                        </div>
                                    </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span v-if="editing">Edit User</span>
                        <span v-else>Create New User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="from" @submit="handleSubmit" :validation-schema="editing ? editSchema : schema" v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Name</label>
                            <Field type="text" name="name" v-model="formValues.name" class="form-control" :class="{ 'is-invalid': errors.name }" placeholder="Name" />
                            <span class="invalid-feedback">{{ errors.name }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <Field type="email" name="email" v-model="formValues.email" class="form-control" :class="{ 'is-invalid': errors.email }" placeholder="Email"/>
                            <span class="invalid-feedback">{{ errors.email }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Phone</label>
                            <Field type="number" name="phone" v-model="formValues.phone" class="form-control" :class="{ 'is-invalid': errors.phone }" placeholder="Phone number" />
                            <span class="invalid-feedback">{{ errors.phone }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <Field type="text" name="address" v-model="formValues.address" class="form-control" :class="{ 'is-invalid' : errors.address }" placeholder="Address" />
                            <span class="invalid-feedback">{{ errors.address }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <Field type="password" name="password" class="form-control" :class="{ 'is-invalid': errors.password }" placeholder="Password" />
                            <span class="invalid-feedback">{{ errors.password }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>
