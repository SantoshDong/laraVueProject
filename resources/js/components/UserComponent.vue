<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 mb-5">
               <div>
                    <span type="button" class="btn btn-primary" @click="newModal"><i class="fas fa-user-plus fa-fw"></i> Add New</span>
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
                                <a href="#"><i class="fas fa-edit blue" @click="editModal(user)"></i></a>
                                <span>/</span>
                                <a href="#" @click="deleteUser(user.id)"><i class="fas fa-trash red"></i></a>
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
                <h5 class="modal-title" v-show="!editmode" id="exampleModalCenterTitle">Create User</h5>
                 <h5 class="modal-title" v-show="editmode" id="exampleModalCenterTitle">Update User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editmode ? updateUser() : createUser()">
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
                            <option value="" selected="true" disabled="disabled">select User Role</option>
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
                    <button v-show = "editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show = "!editmode" type="submit" class="btn btn-primary">Save changes</button>
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
                editmode:false,
                users : {},
                form: new Form ({
                    id:'',
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
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#AddNewModal').modal('show');
            },
            updateUser(){
                // console.log('editing');
                this.$Progress.start()
                this.form.put('api/users/'+this.form.id)
                .then(()=>{
                    $('#AddNewModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'information has been updated.',
                        'success'
                        )
                        Fire.$emit('AfterCreate')
                        this.$progress.finish();
                })
                .catch(() => {
                    this.$progress.fail();
                });
            },
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#AddNewModal').modal('show');
                this.form.fill(user);
            },
            deleteUser(id){
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            //send request to the server
                                if (result.isConfirmed) {
                                    this.form.delete('api/users/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        )
                                     Fire.$emit('AfterCreate')
                                    }).catch(()=>{
                                        Swal.Fire(
                                            'Failed!',
                                            'There was something wrong',
                                            'warning'
                                        )
                                    })
                                }
                        })
            },
            loadUsers(){
                // By using Axios es63
                //axios get going to the user then gave us a data {{ data }} this is data function after store them in user
                axios.get("api/users").then(({ data }) => (this.users = data));
            },
            createUser(){
                this.form.post('api/users')
                .then(()=>{
                this.$Progress.start()
                Fire.$emit('AfterCreate')
                $('#AddNewModal').modal('hide');
                Toast.fire({
                icon: 'success',
                title: 'User created successfully'
                })
                  this.$Progress.finish()
                })
                .catch()
            }
        },
        created() {
            this.loadUsers();
            // setInterval(() => this.loadUsers(), 3000);
            //custom event
            Fire.$on('AfterCreate',()=> {
                this.loadUsers();
            });
        }
    }
</script>
