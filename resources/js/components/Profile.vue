<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 mt-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <div class="text-center">
                      <img :src="getProfilePhoto" @error="onImgError()" width="100px" height="100px" class="img-circle elevation-2" alt="User Image">
                    </div>

                    <h3 class="profile-username text-center">{{ this.form.name }}</h3>

                    <p class="text-muted text-center">{{ this.form.position }}</p>
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

            <div class="col-md-9 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Profile</h3>
                    </div>

                    <div class="card-body">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                    <input v-model="form.name" type="text" class="form-control" id="inputName" placeholder="Name">
                                    <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                    <input v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                    <input disabled="" v-model="form.password" type="text" name="password" class="form-control" id="password" placeholder="The password is temporary disabled">
                                    <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                                    <div class="col-sm-10">
                                    <input type="file" @change="updatePhoto" class="form-input" name="photo">
                                    <has-error :form="form" field="photo"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-danger">Submit</button>
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
                imgError: false,
                form: new formGlobal({
                id: '',
                name: '',
                position: '',
                email: '',
                // password: '',
                type: '',
                bio: '',
                photo: ''
             })
            }
        },
        methods: {
            displayInfo() {
                 axios.get("api/profile")
                 .then(({data}) => (this.form.fill(data)));
            },
            // getProfilePhoto(event) {
            //     // if
            //     // console.log(this.form.photo)
            //     // let photo = (this.form.photo.length > 100) ? this.form.photo : "/img/profile/"+this.form.photo;
            //     // if(this.form.photo == "profile.png") {
            //     //     photo = "img/default.png"
            //     // }
            //     // return photo;
            // },
            onImgError() {
                this.imgError = true;
            },
            updatePhoto(fileEvent) {
                // console.log("uploading file")
                let file = fileEvent.target.files[0] // 0 because array starts in 0
                // console.log(file)
                let reader = new FileReader();

                if(file['size'] < 2111775) {
                    reader.onloadend = (file) => {
                    this.form.photo = reader.result
                  }
                  reader.readAsDataURL(file);
                }
                else {
                    swal.fire({
                      title: 'Oops...',
                      text: "Please upload less than 2mb file!",
                      icon: 'warning',
                      type: 'error'
                       })
                }
                  
            },

            updateInfo() {
                this.$Progress.start()
                this.form.put('api/profile')
                .then(() => {
                    Fire.$emit('userEvent')
                    toast.fire({
                      icon: 'success',
                      title: 'Successfully updated profile!'
                    })
                    this.$Progress.finish()
                })
                .catch(() => {
                    this.$Progress.fail()
                })
                window.location.reload();
            }
        },
        created() {
            this.displayInfo()
            Fire.$on('userEvent', () => {
              this.displayInfo()
            })
           
        },
        computed: {
            getProfilePhoto() {
                let photo = (this.imgError) ? 
                "/img/default.png" : 
                "/img/profile/"+this.form.photo
                if (this.form.photo.length > 100) {
                    photo = this.form.photo
                }
                return photo
            }
        }
    }
</script>
