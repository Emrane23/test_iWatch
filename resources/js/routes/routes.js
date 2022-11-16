import Vue from 'vue' 
import VueRouter from 'vue-router' 

Vue.use(VueRouter)

import Posts from '../components/PostsComponent.vue' ; 
import PostDetails from '../components/PostDetailsComponent.vue' ; 
import CategoryPosts from '../components/CategoryPostsComponent.vue' ; 

const routes = [
    {path:'/' , component: Posts, name: 'Posts'},
    {path:'/post/:id' , component: PostDetails, name: 'PostDetails'},
    {path:'/category/:slug/posts' , component: CategoryPosts, name: 'CategoryPosts'}
];

const router = new VueRouter({
    routes,hashbang:false,mode:'history'
})


export default router ;