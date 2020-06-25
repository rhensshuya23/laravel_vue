<template>
    <div class="container">
        <div class="row" v-if="$gateAuth.isAdmin()">
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Lists</h3>

                <div class="card-tools">
                  <!-- <button class="btn btn-success" data-toggle="modal" data-target="#userModal"><i class="fas fa-user-plus"></i> Add New</button> -->
                  <button class="btn btn-success" @click="addModal"><i class="fas fa-user-plus"></i> Add New</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>NAME</th>
                      <th>POSITION</th>
                      <th>EMAIL</th>
                      <th>TYPE</th>
                      <th>REGISTERED AT</th>
                      <th>MODIFY</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users.data" :key="user.id">
                      <td>{{user.id}}</td>
                      <td>{{user.name | firtCharCapitalize }}</td>
                      <td>{{user.position | firtCharCapitalize}}</td>
                      <td>{{user.email}}</td>
                      <td>{{user.type | firtCharCapitalize}}</td>
                      <td>{{user.created_at | myDate}}</td>
                      <td>
                          <a href="" @click.prevent="editModal(user)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="" @click.prevent="deleteUser(user.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="users" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div v-if="!$gateAuth.isAdmin()">
          <not-found></not-found>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-show="!editMode" class="modal-title" id="userModalLabel">Add New</h5>
                <h5 v-show="editMode" class="modal-title" id="userModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editMode ? updateUser() : createUser()">
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.name" type="text" name="name" placeholder="Name" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.position" type="text" name="position" placeholder="Position" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('position') }">
                  <has-error :form="form" field="position"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.email" type="text" name="email" placeholder="Email" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.bio" type="text" name="bio" placeholder="Short Bio for User (Optional)" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }">
                  <has-error :form="form" field="bio"></has-error>
                </div>

                <div class="form-group">
                  <select name="type" v-model="form.type" id="type" class="form-control" 
                  :class="{ 'is-invalid': form.errors.has('type')}">
                      <option value="">Select User Role</option>
                      <option value="admin">Admin</option>
                      <option value="user">User</option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.password" type="text" name="password" placeholder="Password" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
              </div>

              </form>

            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        // every component needs to return data
        data() {
            return {
                editMode: false,
                users: {},
                form: new formGlobal({
                id: '',
                name: '',
                position: '',
                email: '',
                password: '',
                type: '',
                bio: '',
                photo: ''
            })
            }
        },
        methods: {
            getResults(page = 1) {
              axios.get('api/user?page=' + page)
                .then(response => {
                  this.users = response.data;
                });
            },
            addModal() {
              this.editMode = false
              this.form.reset()
              $('#userModal').modal('show')
            },
            displayUsers() {
                // axios.get('api/user').then(({data}) => (this.users = data.data));
                // axios({
                //     method: 'get',
                //     url: 'api/user'
                // })
                // .then(({data}) => (this.users = data.data))
                 // or like this
                 if(this.$gateAuth.isAdmin()) {
                    axios.get('api/user')
                    .then(response => {
                      this.users = response.data;
                    })
                 }
            },

            createUser() {
                this.$Progress.start()
                this.form.post('api/user')
                .then(() => {
                    Fire.$emit('userEvent')
                    $('#userModal').modal('hide')
                    toast.fire({
                      icon: 'success',
                      title: 'Successfully created user!'
                    })
                    this.$Progress.finish()
                  })
                  .catch(() => {
                    this.$Progress.fail()
                    toast.fire({
                      icon: "error",
                      title: "The given data was invalid!"
                    })
                  })
            },

            editModal(userData) {
              this.editMode = true
              this.form.reset()
              $('#userModal').modal('show')
              this.form.fill(userData)
            },

            updateUser() {
              // console.log("Edit Mode")
              this.$Progress.start()
              this.form.put('api/user/'+this.form.id)
              .then(() => {
                Fire.$emit('userEvent')
                $('#userModal').modal('hide')
                toast.fire({
                  icon: 'success',
                  title: 'Successfully updated user!'
                })
                this.$Progress.finish()
              })
              .catch(() =>{
                  this.$Progress.fail()
                  toast.fire({
                  icon: "error",
                  title: "The given data was invalid!"
                  })
              })
            },

            deleteUser(id) {
              swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                if(result.value) { //if result is true then
                  this.$Progress.start()
                  this.form.delete('api/user/'+id)
                  .then(()=> {
                      swal.fire(
                        'Deleted!',
                        'User has been deleted.',
                        'success'
                      )
                    Fire.$emit('userEvent')
                    this.$Progress.finish()
                  })
                  .catch(() => {
                    this.$Progress.fail()
                    swal.fire("Failed!", "There was something wrong!", "Warning");
                  })
                }
              })
             }
        },
        created() {
          Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findUser?q=' + query)
                .then((data) => {
                    this.users = data.data
                })
                .catch(() => {
                })
            })
          
            this.displayUsers()
            // setInterval(() => this.displayUsers(), 3000)
            Fire.$on('userEvent', () => {
              this.displayUsers()
            })
        }
    }
</script>
