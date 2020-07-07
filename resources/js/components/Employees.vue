<template>
    <div class="container">
        <div class="row" v-if="$gateAuth.isSuperAdminOrAdmin()">
          <div class="col-md-12 mt-3">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Employee Lists</h3>

                <div class="card-tools">
                  <!-- <button class="btn btn-success" data-toggle="modal" data-target="#employeeModal"><i class="fas fa-employee-plus"></i> Add New</button> -->
                  <button class="btn btn-success" @click="addModalEmployee"><i class="fas fa-employee-plus"></i> Add New</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="table-responsive">
                <table class="table table-hover" id="employees_table_id">
                  <thead class="thead-dark">
                    <tr>
                      <th>MODIFY</th>
                      <th class="th-200">FULL NAME</th>
                      <th class="th-50">AGE</th>
                      <th class="th-150">CONTACT NO.</th>
                      <th class="th-80">STATUS</th>
                      <th class="th-80">SALARY</th>
                      <th class="th-150">POSITION</th>
                      <th class="th-200">EMAIL</th>
                      <th class="th-300">ADDRESS</th>
                      <th class="th-150">ADDED BY</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="employee in employees.data" :key="employee.id">
                      <td>
                          <a href="" @click.prevent="editModal(employee)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="" @click.prevent="deleteEmployee(employee.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                      </td>
                      <td>{{employee.full_name | firtCharCapitalize }}</td>
                      <td>{{employee.age}}</td>
                      <td>{{employee.contact_no}}</td>
                      <td>{{employee.status}}</td>
                      <td>{{employee.salary}}</td>
                      <td>{{employee.position | firtCharCapitalize}}</td>
                      <td>{{employee.email}}</td>
                      <td>{{employee.address | firtCharCapitalize}}</td>
                      <td>{{employee.user_name}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-6">
                    <pagination :data="employees" @pagination-change-page="getResults"></pagination>
                  </div>
                  <div class="col-md-6">
                     <button @click="generatePDF" class="btn btn-primary float-right">
                     Print</button>
                  </div>
                </div>
                
               
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div v-if="!$gateAuth.isSuperAdminOrAdmin()">
          <not-found></not-found>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 v-show="!editModeEmployee" class="modal-title" id="employeeModalLabel">Add New</h5>
                <h5 v-show="editModeEmployee" class="modal-title" id="employeeModalLabel">Update employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editModeEmployee ? update_employee() : create_employee()">
              <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <input v-model="form.full_name" type="text" name="full_name" placeholder="Full Name" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('full_name') }">
                          <has-error :form="form" field="full_name"></has-error>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                          <input v-model="form.age" type="number" name="age" placeholder="Age" 
                            class="form-control" :class="{ 'is-invalid': form.errors.has('age') }">
                          <has-error :form="form" field="age"></has-error>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                      <input v-model="form.contact_no" type="number" name="contact_no" placeholder="Contact Number" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('contact_no') }">
                      <has-error :form="form" field="contact_no"></has-error>
                    </div>
                </div>

                    <div class="col-md-6">
                    <div class="form-group">
                      <input v-model="form.address" type="text" name="address" placeholder="Address" 
                        class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                      <has-error :form="form" field="address"></has-error>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                  <select name="status" v-model="form.status" class="form-control" :class="{ 'is-invalid': form.errors.has('status')}">
                      <option selected="selected" value="">Select Status</option>
                      <option value="Single">Single</option>
                      <option value="Married">Married</option>
                      <option value="Widow">Widow</option>
                  </select>
                  <has-error :form="form" field="status"></has-error>
                </div>
            </div>

                <div class="col-md-6">
                <div class="form-group">
                  <input v-model="form.salary" type="number" name="salary" placeholder="Salary" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('salary') }">
                  <has-error :form="form" field="salary"></has-error>
                </div>
            </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                  <input v-model="form.position" type="text" name="position" placeholder="Position" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('position') }">
                  <has-error :form="form" field="position"></has-error>
                </div>
            </div>

                <div class="col-md-6">
                <div class="form-group">
                  <input v-model="form.email" type="text" name="email" placeholder="Email" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>
            </div>
        </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-show="!editModeEmployee" type="submit" class="btn btn-primary">Create</button>
                <button v-show="editModeEmployee" type="submit" class="btn btn-primary">Update</button>
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
                editModeEmployee: false,
                employees: {},
                form: new formGlobal({
                id: '',
                full_name: '',
                age: '',
                contact_no: '',
                address: '',
                status: '',
                salary: '',
                position: '',
                email: '',
                user_name: ''
            })
            }
        },
        methods: {

           generatePDF() {
             const doc = new jsPDF()
              var finalY = doc.lastAutoTable.finalY || 10
              doc.text('From javascript arrays', 14, finalY + 15)
              // doc.autoTable({ html: '#employees_table_id' })
              axios.get('api/print-employee')
              .then(response => {
                  doc.autoTable({
                  startY: finalY + 20,
                  head: [['Full Name', 'Age', 'Status', 'Address', 'Email']],
                  body: [
                    [this.employees = response.data.full_name, this.form.age, this.form.status,
                     this.form.address, this.form.email]
                  ]
                })

              })
              
              doc.save('table.pdf')
           },
            getResults(page = 1) {
              axios.get('api/employee?page=' + page)
                .then(response => {
                  this.employees = response.data;
                });
            },
            addModalEmployee() {
              this.editModeEmployee = false
              this.form.reset()
              $('#employeeModal').modal('show')
            },
            displayemployees() {
                 if(this.$gateAuth.isSuperAdminOrAdmin()) {
                    axios.get('api/employee')
                    .then(response => {
                      this.employees = response.data;
                    })
                 }
            },

            create_employee() {
                this.$Progress.start()
                this.form.post('api/employee')
                .then(() => {
                    Fire.$emit('employeeEvent')
                    $('#employeeModal').modal('hide')
                    toast.fire({
                      icon: 'success',
                      title: 'Successfully created employee!'
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

            editModal(employeeData) {
              this.editModeEmployee = true
              this.form.reset()
              $('#employeeModal').modal('show')
              this.form.fill(employeeData)
            },

            update_employee() {
              this.$Progress.start()
              this.form.put('api/employee/'+this.form.id)
              .then(() => {
                Fire.$emit('employeeEvent')
                $('#employeeModal').modal('hide')
                toast.fire({
                  icon: 'success',
                  title: 'Successfully updated employee!'
                })
                this.$Progress.finish()
              })
              .catch(() =>{
                  this.$Progress.fail()
                  toast.fire({
                  icon: "error",
                  title: "Check the fill up form!"
                  })
              })
            },

            deleteEmployee(id) {
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
                  this.form.delete('api/employee/'+id)
                  .then(()=> {
                      swal.fire(
                        'Deleted!',
                        'Employee has been deleted.',
                        'success'
                      )
                    Fire.$emit('employeeEvent')
                    this.$Progress.finish()
                  })
                  .catch(() => {
                    this.$Progress.fail()
                    swal.fire("Failed!", "Check the fill up form!", "Warning");
                  })
                }
              })
             }
        },
        created() {
          Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/find-employee?q=' + query)
                .then((data) => {
                    this.employees = data.data
                })
                .catch(() => {
                })
            })
          
            this.displayemployees()
            Fire.$on('employeeEvent', () => {
              this.displayemployees()
            })
        }
    }
</script>
