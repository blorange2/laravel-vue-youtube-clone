<template>
    <video 
        src="" 
        id="video" 
        class="video-js vjs-default-skin vjs-big-play-centered"
        controls
        preload="auto"
        data-setup='{"fluid": true}'
        v-bind:poster="thumbnailUrl">
        <source type="video/mp4" v-bind:src="videoUrl"></video>
    </video>
</template>

<script>
import videojs from 'video.js';

export default {
    props: {
        videoUid: null,
        videoUrl: null,
        thumbnailUrl: null,
    },
    data(){
        return{
            player: null,
            duration: 0,
        }
    },
    mounted() {
        this.player = videojs('video');

        this.player.on('loadedmetadata', () => {
            this.duration = Math.round(this.player.duration());
        })

        setInterval(() => {
            if(this.hasHitViewQuota()){
                console.log("A view happened...");
                this.createView();
            }
        }, 1000);
    },
    beforeDestroy() {
        if (this.player) {
            this.player.dispose();
        }
    },
    methods: {
        hasHitViewQuota(){
            if(!this.duration){
                return false;
            }

            return Math.round(this.player.currentTime()) === Math.round((10 * this.duration) / 100);
        },
        createView(){
            axios.post('/videos/' + this.videoUid + '/views')
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    }

};
</script>
