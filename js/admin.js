var player;

$( document ).ready(function() {

    $('.play').click(function (){
        var videoId =  $(this).data("video-id");
        var start = $(this).data("start");
        var end = $(this).data("end");

        if(!player) {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                videoId: videoId,
                playerVars: {
                    start: start,
                    end: end
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                }
            });
        } else {
            player.loadVideoById({'videoId': videoId,
                'startSeconds': start,
                'endSeconds': end});
        }
    })
});

function onPlayerReady(event) {
    event.target.playVideo();
}

function onPlayerStateChange(){
    console.log('on-player-state');
}