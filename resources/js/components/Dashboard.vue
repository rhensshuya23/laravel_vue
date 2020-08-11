<template>
    <div class="container">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h5 class="m-0 text-dark">Don't stop to push yourself, everyday is a new beggining!</h5>
              </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ numberOfEmployees }}</h3>

                <p>Number of employees</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>0</h3>

                <p>Number of Students</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ numberOfUsers }}</h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>


        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-gradient-success">
              <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">

                <h3 class="card-title">
                  <i class="fa fa-calendar"></i>
                  Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                 
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                    <div>
                      <b-calendar block @context="onContext"></b-calendar>
                    </div>
              </div>
              <!-- /.card-body -->
            </div>
            </div>
            <div class="col-md-8">
                <div class="card">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="fa fa-clipboard-list"></i>
                  To Do List
                  <button class="btn btn-primary fas fa-plus" @click="addTodoModal">Add todo</button>
                </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <ul v-for="todo in todos.data" :key="todo.id" class="todo-list ui-sortable" data-widget="todo-list">
                  <li>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                      <!-- <i class="fas fa-edit"></i> -->
                      <a href="" @click.prevent="deleteTodo(todo.id)">
                        <i class="fa fa-trash red"></i>
                      </a>
                    </div>
                    <!-- drag handle -->
                   <!--  <span class="handle ui-sortable-handle">
                      <i class="fas fa-ellipsis-v"></i>
                      <i class="fas fa-ellipsis-v"></i>
                    </span> -->
                    <!-- todo text -->
                    <span class="text">{{ todo.title }}</span>
                    <!-- Emphasis label -->
                    
                  </li>
                </ul>
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-md-6">
                    <pagination :data="todos" @pagination-change-page="getResults"></pagination>
                  </div>
                </div>
              </div>
            </div>
            </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="todo_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="">Add New</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="createTodo()">
                <div class="modal-body">
                  <div class="form-group">
                    <input v-model="form.title" type="text" name="title" placeholder="Enter Task" 
                      class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                    <has-error :form="form" field="title"></has-error>
                  </div>
                </div>

                  <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
            </div>
          </div>
  </div>
</template>

<script>
    export default {
        data: function() {
          return {
            numberOfEmployees: null,
            numberOfUsers: null,
            context: null,
            todos: {},
            form: new formGlobal({
              title: ''
            }),
          }
        },
        methods: {
          count() {
            let employeesCount = axios.get('api/count-employees')
            let usersCount = axios.get('api/count-users')
            axios.all([employeesCount, usersCount])
            .then(axios.spread((...response) => { //(res1, res2)
                // this.numberOfEmployees = res1.data
                // this.numberOfUsers = res2.data
                this.numberOfEmployees = response[0].data
                this.numberOfUsers = response[1].data
            }))
          },
          onContext(ctx) {
            this.context = ctx
          },
          displayTodos() {
            axios.get('api/todo')
            .then(res => {
              this.todos = res.data
            })
          },
          getResults(page = 1) {
              axios.get('api/todo?page=' + page)
                .then(response => {
                  this.todos = response.data;
                });
            },
          addTodoModal() {
            this.form.reset()
            $('#todo_modal').modal('show')
          },
          createTodo() {
            this.$Progress.start()
            this.form.post('api/todo')
            .then(() => {
                Fire.$emit('todoEvent')
                $('#todo_modal').modal('hide')
                toast.fire({
                  icon: 'success',
                  title: 'Successfully created task!'
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
          deleteTodo(id) {
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
                  this.form.delete('api/todo/'+id)
                  .then(()=> {
                      swal.fire(
                        'Deleted!',
                        'Todo has been deleted.',
                        'success'
                      )
                    Fire.$emit('todoEvent')
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
          this.count()
          this.displayTodos();
          Fire.$on('todoEvent', () => {
              this.displayTodos()
            })
        }
    }
</script>
