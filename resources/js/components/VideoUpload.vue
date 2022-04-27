<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload</div>

                    <div class="card-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div class="video-form" v-if="uploading && !failed">
                            Form
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                uid: null,
                uploading: false,
                uploadingComplete: false,
                failed: false,
                title: 'Untitled',
                description: null,
                visibility: 'private'
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            fileInputChange(){
                this.uploading = true;
                this.failed = false;

                this.file = document.getElementById('video').files[0]

                this.store().then(() => {
                    // upload the video
                });
            },
            store(){
                let postData = {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split('.').pop()
                };

                console.log(postData);

                axios.post('/videos', postData)
                    .then(response => {
                        console.log(response);
                        this.uid = response.data.data.uid;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>