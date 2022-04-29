<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload video</div>

                    <div class="card-body">
                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div class="video-form" v-if="uploading && !failed">

                            <div class="progress mb-2" v-if="!uploadingComplete">
                                <div class="progress-bar" v-bind:style="{width: fileProgress + '%'}"></div>
                            </div>

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" v-model="title">
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" v-model="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="visibility">Visibility</label>
                                <select name="visibility" id="visibility" class="form-control" v-model="visibility">
                                    <option value="private">Private</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="public">Public</option>
                                </select>
                            </div>

                            <span class="help-block float-right">{{ saveStatus }}</span>

                            <button class="btn btn-primary" type="submit" @click.prevent="update">Save changes</button>
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
                visibility: 'private',
                saveStatus: null,
                fileProgress: 0,
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            fileInputChange(){
                this.uploading = true;
                this.failed = false;

                this.file = document.getElementById('video').files[0];

                this.store().then(() => {
                    let form = new FormData();

                    form.append('video', this.file);
                    form.append('uid', this.uid);

                    axios.post('/upload', form, {
                        onUploadProgress: progressEvent => {
                            console.log(progressEvent.loaded / progressEvent.total);
                        }
                    })
                    .then(() => {
                        this.uploadingComplete = true;
                    })
                    .catch(error => {
                        console.log(error);
                    });
                });
            },
            store(){
                let postData = {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split('.').pop()
                };

                axios.post('/videos', postData)
                    .then(response => {
                        console.log(response);
                        this.uid = response.data.data.uid;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            update(){
                this.saveStatus = 'Saving changes.';
                let postData = {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                };

                axios.put('/videos/' + this.uid, postData)
                    .then(response => {
                        this.saveStatus = 'Saved changes.';

                        setTimeout(() => {
                            this.saveStatus = null;
                        }, 3000);
                    })
                    .catch(error => {
                        console.log(error);
                        this.saveStatus = 'Failed to save changes.';
                    });

            },
            updateProgress(progressEvent){
                progressEvent.percent = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));

                this.fileProgress = progressEvent.percent;
            }
        }
    }
</script>