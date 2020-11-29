<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mb-5">
               <div>
                    <span type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddNewModal"><i class="fas fa-user-plus fa-fw"></i> Add New</span>
               </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                            <th scope="col">ID</th>
                            <th scope="col">NAME</th>
                            <th scope="col">EMAIL</th>
                            <th scope="col">TYPE</th>
                            <th scope="col">REGISTER AT</th>
                            <th scope="col">EDIT/DELET</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                            <th scope="row">{{ user.id }}</th>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email}}</td>
                            <td>{{ user.type | capitalize }}</td>
                            <td>{{ user.created_at | myDate}}</td>
                            <td>
                                <a href="#"><i class="fas fa-edit blue"></i></a>
                                <span>/</span>
                                <a href="#"><i class="fas fa-trash red"></i></a>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Add New Modal -->
        <div class="modal fade" id="AddNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="createUser">
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name" placeholder="Enter Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.email" type="email" name="email" placeholder="Enter Email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <textarea v-model="form.bio" type="text" name="bio" placeholder="Enter Bio (Optional)" class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>
                    <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">select User Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">Stander User</option>
                            <option value="author">Author</option>
                            <has-error :form="form" field="name"></has-error>
                        </select>
                    </div>
                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password" placeholder="Enter password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users : {},
                form: new Form ({
                    name:'',
                    email:'',
                    password:'',
                    type:'',
                    bio:'',
                    photo: ''
                })
            }
        },
        methods: {
            loadUsers(){
                // By using Axios es63
                //axios get going to the user then gave us a data {{ data }} this is data function after store them in user
                axios.get("api/users").then(({ data }) => (this.users = data));
            },
            createUser(){
                 this.$Progress.start()
                this.form.post('api/users')
                  this.$Progress.finish()
            }
        },
        created() {
            this.loadUsers();
        }
    }
</script>
