<template>
    <div class="container">
        <div class="row justify-content-center">
                
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Contact Developer</h3>
                    </div>

                    <div class="card-body">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                    <input name="name" v-model="form.name" type="text" class="form-control" id="inputName" placeholder="Name">
                                    <has-error :form="form" field="name"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                    <input name="email" v-model="form.email" type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    <has-error :form="form" field="email"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="issue" class="col-sm-2 col-form-label">Issue Topic</label>
                                    <div class="col-sm-10">
                                    <input name="issue" v-model="form.issue" type="text" class="form-control" id="inputName" placeholder="Issue Topic">
                                    <has-error :form="form" field="issue"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="message" class="col-sm-2 col-form-label">Message</label>
                                    <div class="col-sm-10">
                                    <textarea name="message" v-model="form.message" type="text" class="form-control" id="inputName" placeholder="Message" cols="40" rows="10"></textarea>
                                    <has-error :form="form" field="message"></has-error>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                    <button @click.prevent="sendIssue" type="submit" class="btn btn-danger">Submit</button>
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
                name: '',
                email: '',
                issue: '',
                message: '',
             })
            }
        },
        methods: {
            sendIssue() {
                this.$Progress.start()
                this.form.post('contact-us')
                .then(() => {
                    toast.fire({
                      icon: 'success',
                      title: 'Successfully sent user!'
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
              }
        }
    }
</script>
