<template>
    <div class="video__voting">
        <a href="" class="video__voting-button" v-bind:class="{'video__voting-button--voted' : userVote == 'up'}">
            <i class="fa-solid fa-thumbs-up"></i>
        </a> {{ up }} &nbsp;

        <a href="" class="video__voting-button" v-bind:class="{'video__voting-button--voted' : userVote == 'down'}">
            <i class="fa-solid fa-thumbs-down"></i>
        </a> {{ down }} &nbsp;
    </div>
</template>

<script>
export default {
    props:{
        videoUid: null
    },
    data(){
        return{
            up: null,
            down: null,
            userVote: null,
            canVote: false,
        }
    },
    mounted() {
        this.getVotes();
    },

    methods:{
        getVotes(){
            axios.get('/videos/' + this.videoUid + '/votes')
                .then((response) => {
                    this.up = response.data.data.up;
                    this.down = response.data.data.down;
                    this.userVote = response.data.data.userVote;
                    this.canVote = response.data.data.canVote;
                }).catch((err) => {
                    console.log(err);
                });
        }
    }
}
</script>

<style>

</style>