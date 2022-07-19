var player;
var donePlaying = false;
const playerStateIcons = {
    play: "bi bi-play-circle",
    pause: "bi bi-pause-circle",
    next: "bi bi-skip-forward-circle",
    stop: "bi bi-stop-circle",
    replay: "bi bi-arrow-clockwise",
    hidden: "hidden"
}
var results = [];
var playerIconState = null;
var level = 0;
var currentSong = null;
var currentSongNumber = null;
var answerHtml = `
<div class="py-2 rounded-circle">
    <p data-answer-id="{{id}}" class="answear">{{answer}}</p>
</div>
`
var progressHtml = `
<i data-step="{{step}}" class="mx-2 bi bi-circle"></i>
`

$(document).ready(function () {

    $('#play').click(function () {
        currentSongNumber = level;
        currentSong = songs[currentSongNumber];
        level++;
        $(this).hide()
        drawAnswers()
        drawProgress()
        initPlayer()
    })

    $("body").on("click tap", ".answear", function () {
        var currentAnswer = $(this)
        var answerId = currentAnswer.data("answer-id");
        $.ajax({
            type: "POST",
            url: "../check_answer.php",
            data: {
                'answer_id': answerId,
                'song_id': currentSong.id
            },
            success: function (response) {
                if(results[currentSongNumber] === undefined) {
                    var currentProgress = $("#progress-wrapper").find(`[data-step='${currentSong.id}']`)
                    currentProgress.removeClass("bi-circle").addClass("bi-circle-fill")
                    results[currentSongNumber] = response
                    $(".answear").removeClass("error").removeClass("success")
                    if(response) {
                        currentAnswer.removeClass("error").addClass("success")
                        currentProgress.addClass('success')
                    } else {
                        currentAnswer.removeClass("success").addClass("error")
                        currentProgress.addClass('error')

                    }
                    if(songs[currentSongNumber + 1] !== undefined) {
                        updatePlayerIcon(playerStateIcons.next)
                    } else {
                        updatePlayerIcon(playerStateIcons.stop)
                    }
                } else {
                    if(songs[currentSongNumber + 1] !== undefined) {
                        updatePlayerIcon(playerStateIcons.next)
                    } else {
                        updatePlayerIcon(playerStateIcons.stop)
                    }
                }

            },
            error: function () {
                alert('error');
            },
            dataType: 'JSON'
        });

    })

    $("#player-icon").click(function() {
        console.log('here');
        console.log(playerIconState);
        switch (playerIconState) {
            case playerStateIcons.play:
                play();
                break;
            case playerStateIcons.pause:
                pause();
                break;
            case playerStateIcons.next:
                next();
                break;
            case playerStateIcons.replay:
                replay();
                break;
            case playerStateIcons.stop:
                stop();
                break;
            default:
                initPlayer()
                break;
        }
    })

});

function play() {
    player.playVideo();
    updatePlayerIcon(playerStateIcons.pause)
}

function pause() {
    player.pauseVideo();
    updatePlayerIcon(playerStateIcons.play)
}

function stop() {
    player.stopVideo();
    $("#player-icon").hide();
    $('#answers-wrapper').hide();
}

function next() {
    if(songs[currentSongNumber + 1] !== undefined) {
        level++;
        currentSongNumber = currentSongNumber + 1;
        currentSong = songs[currentSongNumber];
        player.loadVideoById({'videoId':  currentSong.video_id,
            'startSeconds':  currentSong.start,
            'endSeconds': currentSong.end});
        drawAnswers();
        updatePlayerIcon(playerStateIcons.pause)
    }
}

function replay() {
    player.loadVideoById({'videoId':  currentSong.video_id,
        'startSeconds':  currentSong.start,
        'endSeconds': currentSong.end});
    updatePlayerIcon(playerStateIcons.pause)
}

// keep
function drawAnswers() {
    var answersWrapper = $('#answers-wrapper');
    answersWrapper.html("");
    var answerItemHtml;
    currentSong.answers.forEach(answerItem => {
        answerItemHtml = $(answerHtml
            .replace("{{answer}}", answerItem.answer)
            .replace("{{id}}", answerItem.id)
        )
        answersWrapper.append(answerItemHtml)
    })
}

function drawProgress() {
    var progressWrapper = $('#progress-wrapper');
    progressWrapper.html("");
    var progressItemHtml;
    songs.forEach(song => {
        progressItemHtml = $(progressHtml
            .replace("{{step}}", song.id)
        )
        progressWrapper.append(progressItemHtml)
    })
}


// keep
function initPlayer() {

    if (player) {
        return
    }
    player = new YT.Player('player', {
        height: '0',
        width: '0',
        videoId: currentSong.video_id,
        playerVars: {
            start: currentSong.start,
            end: currentSong.end
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });

}

// keep
function onPlayerReady(event) {
    event.target.playVideo();
    updatePlayerIcon(playerStateIcons.pause)
}

// keep
function onPlayerStateChange(event) {
    if (event.data === 0 && !donePlaying) {
        donePlaying = true;
        updatePlayerIcon(playerStateIcons.replay)
    } else if (event.data === 1) {
        donePlaying = false;
    }
}

function updatePlayerIcon(icon) {
    playerIconState = icon;
    $("#player-icon").removeClass().addClass(icon);
}