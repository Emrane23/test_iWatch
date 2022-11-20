<template>
  <div>
<div class="card">
    <div class="card-header">
        <h3>Notifications : {{ notifications.length }}</h3>
    </div>
    <div class="card-body">
        <div class="media p-2" v-for="(n,i) in notifications" :key="i">
        <img
          class="mr-2"
          style="height: 60px; width: 60px"
          :src="'/profile/' + n.data.comment_owner.profile_image"
          alt="commenter image"
        />
        <div class="media-body">
          <div class="mt-0">
            <strong>{{ n.data.comment_owner.name }}</strong> added a comment on your post
          </div>
          <router-link class="p-0" :to="`/post/${n.data.post.id}`" target="_blank">{{ n.data.post.title }}</router-link>
          <p class="m-0"><i class="fa fa-clock-o mr-1"></i> {{formaTime(n.data.commented_at)  }} </p>
        </div>
      </div>
    </div>
</div>

  </div>
</template>

<script>
export default {
data(){
    return {
        notifications: [],
    }
},
mounted(){
this.getAllNotifications();
},
methods:{
    getAllNotifications(){
        axios.get('/api/get-all-notifications').then(res => {
            this.notifications = res.data
        })
    },
    formaTime(date) {
            let d = new Date(date);
            return `${d.getFullYear()}/${d.getMonth()}/${d.getDate()}`;
        },
}

}
</script>

<style>

</style>