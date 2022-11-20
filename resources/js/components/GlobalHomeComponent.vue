<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Emrane Klaai</a>
      <notification/>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <router-link class="nav-link" to="/">Home
              <span class="sr-only">(current)</span>
            </router-link>
          </li>
          <li class="nav-item" >
            <router-link class="nav-link" v-if="isAdmin" to="/admin">Admin
              <span class="sr-only">(current)</span>
            </router-link>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.html">blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contact.html">Contact</a>
          </li>
          
          <li v-if="!isLogged" class="nav-item register-btn reg-login-btn" data-toggle="modal" data-target="#register-modal">
            <a class="btn btn-info nav-link" href="" data-toggle="modal" data-target="#register-modal">Register</a>
          </li>
          <li v-if="!isLogged"  class="nav-item btn-btn-success" data-toggle="modal" data-target="#login-modal">
            <a class="btn btn-primary text-weight nav-link" href="#">login</a>
          </li>
          <li v-if="!isAdmin && isLogged"  class="nav-item btn-btn-success"   data-toggle="modal" data-target="#addPostModal">
            <a class="btn btn-primary text-weight nav-link" href="#">Add Post</a>
          </li>
          <li  class="nav-item" v-if="isLogged" @click.stop="logout">
            <a class="nav-link" href="">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div id="addPostModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Post</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>title</label>
                                <input type="text" class="form-control" v-model="title">
                            </div>
                            <div class="form-group">
                                <label>body</label>
                                <textarea name="" cols="30" class="form-control" rows="10" v-model="body"></textarea>
                            </div>
                            <div class="form-group">
                                <label>category</label>
                                <select name="" class="form-control" v-model="category">
                                    <option value="0" disabled selcted>choose category</option>

                                    <option :value="category.id" v-for="category in categories" :key="category.id">
                                      {{category.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>image</label>
                                <input type="file" class="form-control" required @change="onChangeImage">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" value="Add" @click.prevent="addPost">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <router-view></router-view>
    </div>
    
</template>

<script>
import  notification from "./NotificationComponent.vue";

export default {
  data(){
    return {
      title:'',
            body:'',
            image:'',
            category:'',
            categories:[]
    }
  },
  components:{
    notification
  },
  created(){
    this.updateToken();
    this.setUser();
    this.getCategories();
  },
  methods:{
  updateToken(){
   
      let token = JSON.parse(localStorage.getItem('userToken')) 
      this.$store.commit('setUserToken',token)
    
  },
  getCategories(){
        axios.get("/api/user/categories")
        .then((res) => {
          this.categories = res.data;
          
        })
        .then((err) => console.log(err));
    },
  onChangeImage(event){
        this.image = event.target.files[0]
    },
    addPost(){

        let  config = {
            headers:{"content-type": 'multipart/form-data'}
        }

        let formdata = new FormData(); 
        formdata.append('title',this.title)
        formdata.append('body',this.body)
        formdata.append('image',this.image)
        formdata.append('category',this.category)
        axios.post('/api/user/addpost',formdata,config).then(res => {
            this.title = "" ;
            this.body = "" ; 
            this.image = "" ;
            this.category =""; 
            $('#addPostModal').modal('hide');
            $('modal-backdrop').css('display','none')

        })
    },
  setUser(){
    if (this.isLogged){
      axios.get('/api/user')
                .then( res => {
                    this.$store.commit('setUser',res.data.user)
                })
    }
    },
      logout(){
        this.$store.commit('logout') ;
      }
},
computed:{
    isLogged(){
      return this.$store.getters.isLogged
    },
    isAdmin(){
        return this.$store.getters.isAdmin
    }
}, 

}
</script>

