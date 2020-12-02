<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                  <div class="card card-widget widget-user">
                      <!-- Add the bg color to the header using any of the bg-* classes -->
                      <div class="widget-user-header bg-info">
                        <h3 class="widget-user-username">Alexander Pierce</h3>
                        <h5 class="widget-user-desc">Founder &amp; CEO</h5>
                      </div>
                      <div class="widget-user-image" style="background-image:url('./images/profile.jpg');">
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">3,200</h5>
                              <span class="description-text">SALES</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4 border-right">
                            <div class="description-block">
                              <h5 class="description-header">13,000</h5>
                              <span class="description-text">FOLLOWERS</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                          <div class="col-sm-4">
                            <div class="description-block">
                              <h5 class="description-header">35</h5>
                              <span class="description-text">PRODUCTS</span>
                            </div>
                            <!-- /.description-block -->
                          </div>
                          <!-- /.col -->
                        </div>
                        <!-- /.row -->
                      </div>
                  </div>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="tab-pane" id="activity">
                      <h5>Dispaly your activities here</h5>
                    </div>
                    <!-- /.tab-pane -->
            
                    <div class="tab-pane active" id="settings">
                      <form class="form-horizontal">
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="email" v-model="form.name" class="form-control" id="inputName" placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                          <div class="col-sm-10">
                            <textarea v-model="form.bio" class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                          </div>
                        </div>
                          <div class="form-group row">
                            <label for="exampleFormControlFile1" class="col-sm-2 col-form-label">Upload file here</label>
                            <div class="col-sm-10">
                                  <input type="file" @change="updateProfile" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                          </div>
                        <div class="form-group row">
                          <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                          </div>
                        </div>
                          <div class="form-group row">
                          <label for="inputPassport" class="col-sm-2 col-form-label">Passport(leave empty if not changing)</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputPassport" placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button @click.prevent="updateInfo" type="submit" class="btn btn-danger">Submit</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
          </div>
        </div>
    </div>
</template>
<style>
.widget-user-image{
background-size:100% 100%;
height:100px;
width:100px;
border-radius:50%;
}
</style>
<script>
    export default {
      data(){
        return{
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
        mounted() {
            console.log('Component mounted.')
        },
         methods : {
           updateInfo(){
                this.form.put('api/profile/')
                .then(()=>{

                })
                .catch();
           },
          updateProfile(e){
            // console.log("uploading");
            let file = e.target.files[0];
            console.log(file);
            let reader = new FileReader();
            if(file['size'] < 50000){
            reader.onloadend = (file) => {
              // console.log('RESULT', reader.result);
              this.form.photo = reader.result;
            } 
            reader.readAsDataURL(file);
          }else{
                Swal.fire({
                title: 'Image Alert',
                text: 'please upload the image size ',
                icon: 'error',
                confirmButtonText: 'opps'
              });
          }
          }
        },
        created(){
              axios.get("api/profile").then(({ data }) => (this.form.fill(data)));
        }
    }
</script>
