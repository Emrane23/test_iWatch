import Vue from 'vue' 
import VueRouter from 'vue-router' 

Vue.use(VueRouter)

import Posts from '../components/PostsComponent.vue' ; 
import PostDetails from '../components/PostDetailsComponent.vue' ; 
import CategoryPosts from '../components/CategoryPostsComponent.vue' ; 
import AdminIndex from '../components/Admin/AdminComponent.vue' ; 
import Error404 from '../components/404PageComponent.vue' ; 
import ListNotifications from '../components/AllNotificationsComponent.vue' ; 
import Contact from '../components/ContactComponent.vue' ; 


const routes = [
    {path:'/' , component: Posts, name: 'Posts'},
    {path:'/post/:id' , component: PostDetails, name: 'PostDetails'},
    {path:'/category/:slug/posts' , component: CategoryPosts, name: 'CategoryPosts'},
    {path:'/admin' , component: AdminIndex, name: 'AdminIndex'},
    {path:'*' , component: Error404, name: 'Error404'},
    {path:'/list-notifications' , component: ListNotifications, name: 'ListNotifications'},
    {path:'/contact' , component: Contact, name: 'Contact'},
];

const router = new VueRouter({
    routes,hashbang:false,mode:'history'
})


export default router ;