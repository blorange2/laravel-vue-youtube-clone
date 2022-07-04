<template>
    <div>
        <p>{{ comments.length }} comments</p>

        <div class="video-comment clearfix">
            <textarea class="form-control video-comment__input mb-2" placeholder="Say something." name="" id="" cols="30" rows="3" v-model="body"></textarea>
        
            <div class="float-right">
                <button type="submit" class="btn btn-primary" @click="createComment">Post</button>
            </div>
        </div>

        <ul class="media-list">
            <li class="media" v-for="comment in comments">
                <div class="media-left">
                    <a href="">
                        <img v-bind:src="comment.channel.image" alt="" class="media-object">
                    </a>
                </div>

                <div class="media-body">
                    <a href="">{{ comment.channel.name }}</a> {{ comment.created_at_human }}

                    <p>{{ comment.body }}</p>

                    <ul class="list-inline">
                        <li>
                            <a href="#" @click.prevent="toggleReplyForm(comment.id)">{{ replyFormVisible === comment.id ? 'Cancel' : 'Reply' }}</a>
                        </li>
                        <li>
                            <a href="#" @click.prevent="deleteComment(comment.id)">Delete comment</a>
                        </li>
                    </ul>

                    <div class="video-comment" v-if="replyFormVisible === comment.id">
                        <textarea name="" id="" cols="30" rows="3" class="form-control mb-2" v-model="replyBody"></textarea>

                        <div class="float-right">
                            <button type="submit" class="btn btn-primary" @click.prevent="createReply(comment.id)">Reply</button>
                        </div>
                    </div>

                    <div class="media ml-3" v-for="reply in comment.replies">
                        <div class="media-left">
                            <a href="">
                                <img v-bind:src="reply.channel.image" alt="" class="media-object">
                            </a>
                        </div>

                        <div class="media-body">
                            <a href="">{{ reply.channel.name }}</a> {{ reply.created_at_human }}

                            <p>{{ reply.body }}</p>

                            <ul class="list-inline">
                                <li>
                                    <a href="#" @click.prevent="deleteComment(comment.id)">Delete comment</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        videoUid: null,
    },
    data(){
        return{
            comments: [],
            body: null,
            replyBody: null,
            replyFormVisible: null,
        }
    },
    mounted(){
        this.getComments();
    },
    methods:{
        getComments(){
            axios.get('/videos/' + this.videoUid + '/comments')
                .then((response) => {
                    console.log(response);
                    this.comments = response.data.data;
                }).catch((err) => {
                    console.log(err);
                });
        },
        createComment(){
            axios.post('/videos/' + this.videoUid + '/comments', {
                'body': this.body
            })
            .then((response) => {
                this.comments.unshift(response.data.data);
                this.body = null;
            }).catch((err) => {
                console.log(err);
            });
        },
        createReply(commentId){
            axios.post('/videos/' + this.videoUid + '/comments', {
                'body': this.replyBody,
                'reply_id': commentId
            })
            .then((response) => {
                this.comments.map((comment, index) => {
                    if(comment.id === commentId){
                        this.comments[index].replies.push(response.data.data);
                    }
                });

                this.replyBody = null;
                this.replyFormVisible = null;
            }).catch((err) => {
                console.log(err);
            });
        },
        deleteComment(commentId){
            if(!confirm("Are you sure?")){
                return null;
            }

            axios.delete('/videos/' + this.videoUid + '/comments/' + commentId)
            .then((response) => {
                this.deleteById(commentId);
            }).catch((err) => {
                console.log(err);
            });
        },
        deleteById(commentId){
            this.comments.map((comment, index) => {
                if(comment.id === commentId){
                    this.comments.splice(index, 1);

                    return;
                }

                comments.replies.map((reply, replyIndex) => {
                    if(reply.id === commentId){
                        this.comments[index].replies.splice(replyIndex, 1);

                        return;
                    }
                })
            })
        },
        toggleReplyForm(commentId){
            this.replyBody = null;

            if(this.replyFormVisible === commentId){
                this.replyFormVisible = null;
                return;
            }

            this.replyFormVisible = commentId;
        }
    }
}
</script>

<style>

</style>