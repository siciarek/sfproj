var contextClass = (window.AudioContext ||
        window.webkitAudioContext ||
        window.mozAudioContext ||
        window.oAudioContext ||
        window.msAudioContext);

var messageDisplayed = false;

if (contextClass) {
    // Web Audio API is available.
    var context = new contextClass();
    var gainValue = 0.1;
    var gainNode = context.createGain ? context.createGain() : context.createGainNode();
    var oscillator;
} else {

    $(".beginTuning").click(function (e) {
        e.stopImmediatePropagation();

        if (!messageDisplayed) {

            $("#generator")
                    .css("padding-top", '0')
                    .prepend("<p style='padding:20px;font-size:0.8em;'>Sorry, it looks like your browser is not compatible with this particular feature. If possible, please try again with the latest version of Chrome, Safari or Firefox.</p>");
            $(this)
                    .parents(".tuningTable")
                    .before("<p style='padding:20px;font-size:0.8em;'>Sorry, it looks like your browser is not compatible with the tone generator. If possible, please try again with the latest version of Chrome, Safari or Firefox.</p>");

            messageDisplayed = true;
        }
    });
}

var oscs = {sine: 0, square: 1, sawtooth: 2, triangle: 3};

var oscOn = function (freq) {

    oscillator = context.createOscillator();

    // oscillator.type = 0;
    oscillator.frequency.value = freq;

    oscillator.connect(gainNode);
    gainNode.connect(context.destination);
    gainNode.gain.value = $(".volume-slider").length ? volume($(".volume-slider").val()) / 2 : gainValue;


    if ($("input[name='waveform']:checked").length) {

        if (oscillator.type === parseInt(oscillator.type)) {
            oscillator.type = oscs[$("input[name='waveform']:checked").val()];
        } else {
            oscillator.type = $("input[name='waveform']:checked").val();
        }
    } else {
        if (oscillator.type === parseInt(oscillator.type)) {
            oscillator.type = 0;
        } else {
            oscillator.type = "sine";
        }
    }
    oscillator.start ? oscillator.start(0) : oscillator.noteOn(0)
    // oscillator.start(0);
};

function start(freq) {
    if (typeof oscillator != 'undefined')
        oscillator.disconnect();
    oscOn(freq);
    $(".beginTuning").addClass("active");
}

function startTuning(freq) {
    if (typeof oscillator != 'undefined')
        oscillator.disconnect();

    oscOn(freq);

    $("#generator .beginTuning").addClass("active");
}

function stop() {
    oscillator.disconnect();
    $("#generator .beginTuning").removeClass("active");
}

function validate(n) {
    return (isNumber(n) && n > 0 && n < 20001);
}

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function onSlide() {
    gainNode.gain.value = volume($(".volume-slider").val()) / 2;
}
;

function logSlider(position) {
    var minP = 0;
    var maxP = 100;

    var minV = Math.log(0.0001);
    var maxV = Math.log(0.5);

    var scale = (maxV - minV) / (maxP - minP);

    return Math.pow(1.032, minV + scale * (position - minP));


}

function volume(position) {
    return Math.pow(position, 2) / 10000;
}

$("document").ready(function () {

    $(".volume-slider").noUiSlider({
        start: 50,
        range: {
            'min': 0,
            'max': 100
        },
    });

    $('.volume-slider').on('slide', function () {
        onSlide();
    });

    $("input[name='waveform']").click(function (e) {
        e.stopPropagation();
        if (typeof oscillator != 'undefined') {
            if (oscillator.type === parseInt(oscillator.type)) {
                oscillator.type = oscs[$(this).val()];
            } else {
                oscillator.type = $(this).val();
            }
        }
    });

    $("#generator .beginTuning").click(function (e) {
        if (validate($("#freq").val())) {
            start(parseFloat(document.getElementById("freq").value));
            var freq = $("#freq").val();
            var dataString = 'freq=' + freq + '&mode=javascript';

        } else {
            alert("Sorry, you entered an invalid number. Please enter a number between 1 and 20000 and try again.");
        }
    });
});
