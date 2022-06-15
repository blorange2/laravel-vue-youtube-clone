<template>
    <div>
        <p>{{ comments.length }} comments</p>

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

                    <div class="media ml-3" v-for="reply in comment.replies">
                        <div class="media-left">
                            <a href="">
                                <img v-bind:src="reply.channel.image" alt="" class="media-object">
                            </a>
                        </div>

                        <div class="media-body">
                            <a href="">{{ reply.channel.name }}</a> {{ reply.created_at_human }}

                            <p>{{ reply.body }}</p>
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
        }
    }
}
</script>

<style>

</style>