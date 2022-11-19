<template>
  <div>
    <div class="col-lg-8">

<!-- Title -->
<h1 class="mt-4">{{ post.title }}</h1>

<!-- Author -->
<p class=" alert alert-info" style="width : fit-content ;
padding: 5px ;
color: #142d31 ;"  v-if="post.category">{{ post.category.name }}
</p>

<hr>

<!-- Date/Time -->
<p>Posted on <strong class="badge badge-primary p-1">{{ post.added_at_date }}</strong> at <strong class="badge badge-danger p-1"> {{ post.added_at_hour }}</strong>
    <span class="float-right"><strong class="badge badge-info p-1">{{ comments.length }}</strong> comments</span></p>

<hr>

<!-- Preview Image -->
<img class="img-fluid rounded" :src="'/img/'+post.image" style="width:900px;max-height:300px" alt="">

<hr>

<!-- Post Content -->
{{ post.body }}
<hr>

<!-- Comments Form -->
<div class="card my-4" v-if="isLogged">
  <h5 class="card-header">Leave a Comment:</h5>
  <div class="card-body">
    <form>
      <input type="hidden" name="" v-model="post_id">
      <div class="form-group">
        <textarea class="form-control" rows="3" v-model="body"></textarea>
      </div>
      <button type="submit" class="btn btn-primary" @click.prevent="addComment">Submit</button> 
    </form>
  </div>
</div>

<!-- Single Comment -->
<div class="media mb-4 comment" v-for="(comment,index) in post.comments" :key="index">
  <img class="d-flex mr-3 rounded-circle" :src="'/profile/'+comment.user.profile_image" style="height:50px;width:50px" alt="">
  <div class="media-body">
    <h5 class="mt-0">{{ comment.user.name }}</h5>
    {{ comment.body }}
  </div>
</div>

<!-- Comment with nested comments -->
<!-- <div class="media mb-4">
  <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
  <div class="media-body">
    <h5 class="mt-0">Commenter Name</h5>
    Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

    <div class="media mt-4">
      <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
      <div class="media-body">
        <h5 class="mt-0">Commenter Name</h5>
        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
      </div>
    </div>

    <div class="media mt-4">
      <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
      <div class="media-body">
        <h5 class="mt-0">Commenter Name</h5>
        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
      </div>
    </div>

  </div>
</div> -->

</div>
  </div>
</template>

<script>
import { parse } from 'path';

export default {
  data(){
    return {
      post:'',
      body:'',
      post_id:'', 
      comments: []
    }
  },
  created(){
    this.getPost();
    this.updateToken();
  },
  methods:{
    getPost(){
                axios.get('/api/posts/'+this.$route.params.id)
                .then(res => {
                this.post = res.data
                this.post_id = this.post.id;
                this.comments = this.post.comments;
                this.initializeListner();
                // console.log(res)
            }
                ). catch(err => console.log(err))
            },
    addComment(){
      let {body,post_id} = this ; 
      axios.post('/api/comment/create',{body,post_id}).then((res) => {
            this.comments.unshift(res.data);
            // this.$alert("you comment Added successfully");
          })
          .catch((err) => console.log(err));
          this.body = "" ;
    }, 
    updateToken(){
      let token = JSON.parse(localStorage.getItem('userToken')) 
      this.$store.commit('setUserToken',token)
    },
    initializeListner(){
      window.Echo.private(`newComment.${this.post_id}`)
        .listen('NewComment', (e) => {
        console.log('event work');
        this.comments.unshift(e.comment);

        document.querySelectorAll('.comment').forEach(item =>{
          item.classList.remove('new')
        })
        document.querySelectorAll('.comment')[0].classList.add('new')

    });
    }
  },
  computed:{
    isLogged(){
      return this.$store.getters.isLogged
    }
     
  }
}
</script>

<style>
.comment{
  padding: 0.5rem;
  background: #fff;
}

.comment.new{
  background-color: #fff;
  animation-name: newComment ;
  -webkit-animation-name: newComment ;
  animation-duration: 6s;
  -webkit-animation-duration: 6s;
  animation-iteration-count: 1;
  -webkit-animation-iteration-count: 1;
}
@keyframes newComment {
  from {background-color: rgb(241, 245,24);}
  to {background-color: inherit;}
}
</style>