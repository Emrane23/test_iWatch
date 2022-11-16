<template>
  <div>
    <div class="col-lg-8">

<!-- Title -->
<h1 class="mt-4">{{ post.title }}</h1>

<!-- Author -->
<p class=" alert alert-info" style="width: fit-content ;
padding: 5px ;
color: #142d31 ;"  v-if="post.category">{{ post.category.name }}
</p>

<hr>

<!-- Date/Time -->
<p>Posted on <strong class="badge badge-primary p-1">{{ post.added_at_date }}</strong> at <strong class="badge badge-danger p-1"> {{ post.added_at_hour }}</strong>
    <span class="float-right"><strong class="badge badge-info p-1">{{ post.comments_count }}</strong> comments</span></p>

<hr>

<!-- Preview Image -->
<img class="img-fluid rounded" :src="'/img/'+post.image" style="width:900px;max-height:300px" alt="">

<hr>

<!-- Post Content -->
{{ post.body }}
<hr>

<!-- Comments Form -->
<div class="card my-4">
  <h5 class="card-header">Leave a Comment:</h5>
  <div class="card-body">
    <form>
      <div class="form-group">
        <textarea class="form-control" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<!-- Single Comment -->
<div class="media mb-4" v-for="(comment,index) in post.comments" :key="index">
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
export default {
  data(){
    return {
      post:''
    }
  },
  created(){
    this.getPost();
  },
  methods:{
    getPost(){
                axios.get('/api/posts/'+this.$route.params.id)
                .then(res => {
                this.post = res.data; 
                // console.log(res)
            }
                ). catch(err => console.log(err))
            }
  }
}
</script>

<style>

</style>