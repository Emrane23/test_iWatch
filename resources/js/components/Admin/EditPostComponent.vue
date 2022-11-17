<template>
  <div id="editPostModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form enctype="multipart/form-data" novalidate>
                        <div class="modal-header">
                            <h4 class="modal-title">Edit</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>title</label>
                                <input type="text" class="form-control" v-model="PostToEdit.title">
                            </div>
                            <div class="form-group">
                                <label>body</label>
                                <textarea name="" cols="30" class="form-control" rows="10" v-model="PostToEdit.body"></textarea>
                            </div>
                            <div class="form-group">
                                <label>category</label>
                                <select name="" class="form-control" v-if="PostToEdit.category" v-model="PostToEdit.category.id">
                                    <option value="0" disabled selcted>choose category</option>

                                    <option :value="category.id" v-for="category in categories" :key="category.id">
                                      {{category.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>image</label>
                                <img :src="'img/' + PostToEdit.image" style="width:60px;height:60px;border:1px solid #999" alt="">
                                <input type="file" class="form-control" required @change="onChangeImage">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                            <input type="submit" class="btn btn-success" value="Save" @click.prevent="updatePost">
                        </div>
                    </form>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    data(){
        return{
            
            categories:[]
        }
    },
    created(){
        this.getCategories();
    },
    methods:{
        
    getCategories(){
        axios.get("/api/admin/categories")
        .then((res) => {
          this.categories = res.data;
          
        })
        .then((err) => console.log(err));
    },
    onChangeImage(event){
        this.PostToEdit.image = event.target.files[0]
    },
    updatePost(){
        let  config = {
            headers:{"content-type": 'multipart/form-data'}
        }

        let formdata = new FormData(); 
        formdata.append('title',this.PostToEdit.title)
        formdata.append('body',this.PostToEdit.body)
        formdata.append('id',this.PostToEdit.id)
        formdata.append('image',this.PostToEdit.image)
        formdata.append('category',this.PostToEdit.category.id)
        axios.post('/api/admin/updatepost',formdata,config).then(res => {
            // this.title = "" ;
            // this.body = "" ; 
            // this.category =""; 
            this.PostToEdit.image = res.data.image ;
            
            $('#editPostModal').modal('hide');
            $('modal-backdrop').css('display','none');

        })
    }
    },
    computed:{
        PostToEdit(){
            return this.$store.getters.PostToEdit ;
        }
    }

}
</script>

<style>

</style>