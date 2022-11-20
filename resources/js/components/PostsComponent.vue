<template>
  <div class="row">
    <div class="col-md-8" v-if="issearching">...searching posts</div>
    <div class="col-md-8" v-else>
      <h1 class="my-4">
        List
        <small>Posts</small>
      </h1>
      <div class="media simple-post" v-for="post in posts.data" :key="post.id">
        <img
          class="mr-3"
          :src="'img/' + post.image"
          alt="Generic placeholder image"
        />
        <div class="media-body">
          <h4 class="mt-0">
            <router-link :to="'/post/' + post.id"
              >{{ post.title }}
            </router-link>
          </h4>
          {{ post.body.substr(0, 150) }}
          <ul class="list-inline list-unstyled d-flex post-info">
            <li>
              <span
                ><i class="fa fa-user"></i> posted by :
                <strong class="text-primary">{{ post.user.name }}</strong>
              </span>
            </li>
            <li>|</li>
            <li>
              <span><i class="fa fa-calendar"></i> {{ post.added_at }} </span>
            </li>
            <li>|</li>
            <span
              ><i class="fa fa-comment"></i>
              {{ post.comments_count }} comments</span
            >
          </ul>
        </div>
        <i class="fa fa-trash"></i><a @click="deletePost(post.id)">delete</a>
      </div>
      <!-- Pagination -->
      <pagination :data="posts" @pagination-change-page="getPosts"></pagination>
    </div>
    <!-- Sidebar Widgets Column -->
    <div class="col-md-4">
      <!-- Search Widget -->
      <div class="card my-4">
        <h5 class="card-header">Search</h5>
        <div class="card-body">
          <div class="input-group">
            <input
              type="text"
              class="form-control"
              placeholder="Search for..."
              v-model="searchpost"
            />
            <span class="input-group-btn">
              <button class="btn btn-secondary" type="button">Go!</button>
            </span>
          </div>
        </div>
      </div>
      <!-- Categories Widget -->
      <categories></categories>
    </div>
  </div>
</template>

<script>
import categories from "./CategoriesComponent.vue";

export default {
  data() {
    return {
      posts: {},
      searchpost: "",
      issearching: "",
      test: false,
    };
  },
  components: {
    categories,
  },
  watch: {
    searchpost(query) {
      if (query) {
        axios
          .get("/api/searchposts/" + query + "?page=1")
          .then((res) => {
            this.posts = res.data;
            // this.issearching = 'nothing post found !' ;
          })
          .catch((err) => console.log(err));
      } else {
        let oldposts = JSON.parse(localStorage.getItem("posts"));
        this.posts = oldposts;
        this.issearching = false;
      }
    },
  },
  mounted() {
    this.getPosts();
    this.VerifUser();
  },
  methods: {
    getPosts(page = 1) {
      axios
        .get("/api/posts?page=" + page)
        .then((res) => {
          this.posts = res.data;
          localStorage.setItem("posts", JSON.stringify(this.posts));
        })
        .then((err) => console.log(err));
    },
    VerifUser() {
      if (this.isLogged) {
        axios.get("/api/user").then((res) => {});
        return res.data.id;
      }
    },
    deletePost(postId) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("/api/posts/delete/" + postId)
            .then((res) => {
              console.log(res.data.message == "you are not allowed!");
              if (res.data.message == "you are not allowed!") {
                this.$swal({
                  icon: "error",
                  title: "Oops...",
                  text: "Something went wrong!, you are not allowed!",
                  footer: '<a href="">Why do I have this issue?</a>',
                });
              } else {
                this.$swal(
                  "Deleted!",
                  "Your file has been deleted.",
                  "success"
                );
              }
            })
            .then((err) => console.log(err));
        }
      });
    },
  },
};
</script>
