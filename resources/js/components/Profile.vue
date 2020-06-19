<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img src="/././././public/img/default.png" class="img-circle elevation-2" alt="User Image">
                    </div>

                    <h3 class="profile-username text-center">{{ this.form.name }}</h3>

                    <p class="text-muted text-center">Software Engineer</p>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- About Me Box -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">

                    <p class="text-muted">
                      {{ this.form.bio }}
                    </p>

                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profile Component</h3>
                    </div>

                    <div class="card-body">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                    <input v-model="form.name" type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                    <input v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                    <input type="text" name="password" class="form-control" id="password" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                                    <div class="col-sm-10">
                                    <input type="file" class="form-input" name="photo">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new formGlobal({
                id: '',
                name: '',
                email: '',
                password: '',
                type: '',
                bio: '',
                photo: ''
             })
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            axios.get("api/profile")
            .then(({data}) => (this.form.fill(data)));
        }
    }
</script>
