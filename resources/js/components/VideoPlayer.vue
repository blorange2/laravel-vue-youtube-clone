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
        }
    },
    mounted() {
        this.player = videojs('video');
    },
    beforeDestroy() {
        if (this.player) {
            this.player.dispose();
        }
  }
};
</script>
