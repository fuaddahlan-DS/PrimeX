function formSubmit(e, r) {
    $.ajax({
        url: e,
        type: "POST",
        data: r,
        success: function(e) {
            var r = JSON.parse(e);
            "success" == r.status.trim() ? alert("sss") : alert("There is internal system error, please contact our customer service.")
        },
        error: function(e, r) {
            ajax_error_handling(e, r)
        }
    })
}

function goStep2() {
    $("#step1").fadeOut("fast"), $("#step2").fadeIn("slow"), $("#entryform").scrollTop(0)
}

function goStep3() {
    $("#step2").fadeOut("fast"), $("#step3").fadeIn("slow"), $("#entryform").scrollTop(0)
}

function prevstep1() {
    $("#step2").fadeOut("slow"), $("#step1").fadeIn("fast"), $("#entryform").scrollTop(0)
}

function prevstep2() {
    $("#step3").fadeOut("slow"), $("#step2").fadeIn("fast"), $("#entryform").scrollTop(0)
}

function changeVideo(e) {
    var r = document.getElementById("iframeYoutube");
    r.src = "https://www.youtube.com/embed/" + e, $("#showcasevideos").modal("show")
}
for (var amount = 800, sky = $(".sky"), i = 0; amount > i; i++) {
    var s = $('<div class="star-blink"><div></div></div>');
    s.css({
        top: 100 * Math.random() + "%",
        left: 100 * Math.random() + "%",
        animation: "blinkAfter 15s infinite " + 100 * Math.random() + "s ease-out",
        width: 2 * Math.random() + 7 + "px",
        height: 2 * Math.random() + 7 + "px",
        opacity: 5 * Math.random() / 10 + .5
    }), i % 8 === 0 ? s.addClass("red") : i % 10 === 6 && s.addClass("blue"), sky.append(s)
}
$("#step1-next").click(function() {
    $(".error-message").hide();
    var e = $("#name").val().trim(),
        r = $("#ic-number").val().trim(),
        s = $("#contact-person").val().trim(),
        o = $("#house-no").val().trim(),
        t = $("#mobile-no").val().trim(),
        i = $("#email").val().trim(),
        a = $("#address").val().trim(),
        m = 0;
    "" == e && ($("#error-message-name").html("This field is required"), $("#error-message-name").show(), m++), "" == r ? ($("#error-message-ic").html("This field is required"), $("#error-message-ic").show(), m++) : r.match(/^[0-9]{12}$/) || ($("#error-message-ic").html("Please input numbers only and ensure that there are 12 numbers"), $("#error-message-ic").show(), m++), "" == s && ($("#error-message-cp").html("This field is required"), $("#error-message-cp").show(), m++), "" == o ? ($("#error-message-house-no").html("This field is required"), $("#error-message-house-no").show(), m++) : o.match(/^[0-9]{9,12}$/) || ($("#error-message-house-no").html("Please input numbers only and ensure that there are between 9 - 12 numbers"), $("#error-message-house-no").show(), m++), "" == t ? ($("#error-message-mobile-no").html("This field is required"), $("#error-message-mobile-no").show(), m++) : t.match(/^[0-9]{9,12}$/) || ($("#error-message-mobile-no").html("Please input numbers only and ensure that there are between 9 - 12 numbers"), $("#error-message-mobile-no").show(), m++), "" == i ? ($("#error-message-email").html("This field is required"), $("#error-message-email").show(), m++) : i.match(/^[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/) || ($("#error-message-email").html("Invalid email address"), $("#error-message-email").show(), m++), "" == a && ($("#error-message-address").html("This field is required"), $("#error-message-address").show(), m++), 0 == m ? goStep2() : $("#entryform").scrollTop(0)
});
var posterSize = 0,
    posterType = "",
    posterData = "";
$("#poster").bind("change", function() {
    posterData = this.files[0], posterSize = this.files[0].size / 1024 / 1024, posterType = this.files[0].type, $("#poster-name").html(this.files[0].name), console.log(poster.files[0])
}), $("#step2-next").click(function() {
    $(".error-message").hide();
    var e = $("#title").val().trim(),
        r = $("#format").val().trim().toUpperCase(),
        s = $("#youtube").val().trim(),
        o = $("#language").val().trim(),
        t = $("#synopsis").val().trim(),
        i = $("#duration-min").val().trim(),
        a = $("#duration-sec").val().trim(),
        m = $("#fun-fact-1").val().trim(),
        n = $("#fun-fact-2").val().trim(),
        l = $("#fun-fact-3").val().trim(),
        h = $("#fun-fact-4").val().trim(),
        d = $("#fun-fact-5").val().trim(),
        u = $("#poster").val().trim(),
        c = 0;
    "" == t && ($("#error-message-synopsis").show(), c++), "" == o && ($("#error-message-language").show(), c++), "" == e && ($("#error-message-title").show(), c++), "" == r ? ($("#error-message-format").html("This field is required"), $("#error-message-format").show(), c++) : "AVI" != r & "MP4" != r & "H.264" != r && ($("#error-message-format").html("Invalid input"), $("#error-message-format").show(), c++), "" == o && ($("#error-message-cp").html("This field is required"), $("#error-message-cp").show(), c++), "" == s ? ($("#error-message-youtube").html("This field is required"), $("#error-message-youtube").show(), c++) : s.match(/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/) || ($("#error-message-youtube").html("Invalid input"), $("#error-message-youtube").show()), "" == i ? ($("#error-message-duration-min").html("This field is required"), $("#error-message-duration-min").show(), c++) : i.match(/^[0-9]{1,3}$/) || ($("#error-message-duration-min").html("Invalid input"), $("#error-message-duration-min").show(), c++), "" == a ? ($("#error-message-duration-sec").html("This field is required"), $("#error-message-duration-sec").show(), c++) : a.match(/^[0-9]{1,2}$/) || ($("#error-message-duration-sec").html("Invalid input"), $("#error-message-duration-sec").show(), c++), "" == m | "" == n | "" == l | "" == h | "" == d && ($("#error-message-fun-fact").show(), c++), "" == u ? ($("#error-message-poster").html("This field is required"), $("#error-message-poster").show(), c++) : "image/jpeg" != posterType & "image/jpg" != posterType ? ($("#error-message-poster").html("Short film poster must be in JPG or JPEG format"), $("#error-message-poster").show(), c++) : 1 > posterSize ? ($("#error-message-poster").html("Photo chosen is too small"), $("#error-message-poster").show(), c++) : posterSize > 3 && ($("#error-message-poster").html("Photo chosen is too big"), $("#error-message-poster").show(), c++), 0 == c ? goStep3() : $("#entryform").scrollTop(0)
}), $("#submitButton").click(function() {
    $(this).prop("disabled", !0), $(this).html("Submitting your Video"), $("#overlay").removeClass("hide"), $(".error-message").hide();
    var e = $("#director").val().trim(),
        r = $("#producer").val().trim(),
        s = $("#screenplay-writter").val().trim(),
        o = $("#script-writter").val().trim(),
        t = $("#cinematographer").val().trim(),
        i = $("#production-designer").val().trim(),
        a = $("#sound-designer").val().trim(),
        m = $("#main-casts").val().trim(),
        n = $("#editor").val().trim(),
        l = $("#casts").val().trim(),
        h = $("#others").val().trim(),
        d = 0;
    "" == e && ($("#error-message-director").html("This field is required"), $("#error-message-director").show(), d++), "" == r && ($("#error-message-producer").html("This field is required"), $("#error-message-producer").show(), d++), "" == s && ($("#error-message-screenplay-writter").html("This field is required"), $("#error-message-screenplay-writter").show(), d++), "" == o && ($("#error-message-script-writter").html("This field is required"), $("#error-message-script-writter").show(), d++), "" == t && ($("#error-message-cinematographer").html("This field is required"), $("#error-message-cinematographer").show(), d++), "" == i && ($("#error-message-production-designer").html("This field is required"), $("#error-message-production-designer").show(), d++), "" == a && ($("#error-message-sound-designer").html("This field is required"), $("#error-message-sound-designer").show(), d++), "" == n && ($("#error-message-editor").html("This field is required"), $("#error-message-editor").show(), d++), "" == m && ($("#error-message-main-casts").html("This field is required"), $("#error-message-main-casts").show(), d++), "" == l && ($("#error-message-casts").html("This field is required"), $("#error-message-casts").show(), d++), "" == h && ($("#error-message-others").html("This field is required"), $("#error-message-others").show(), d++), 0 == d ? $("#submit").click() : ($("#entryform").scrollTop(0), $(this).prop("disabled", !1), $(this).html("Submit Entry"), $("#overlay").addClass("hide"))
}), $("#step1-prev").click(function() {
    prevstep1()
}), $("#step2-prev").click(function() {
    prevstep2()
}), $(document).ready(function() {
    $(".error-message").hide(), $("#step2, #step3").hide(), $("#myModal").on("hidden.bs.modal", function() {
        $("#iframeYoutube").attr("src", "#")
    })
});
var $window, $document, $body;
$window = $(window), $document = $(document), $body = $("body"), $window.bind("resizeEnd", function() {
    $(".banner-animation, #fullscreen-banner").height($window.height())
}), $window.resize(function() {
    this.resizeTO && clearTimeout(this.resizeTO), this.resizeTO = setTimeout(function() {
        $(this).trigger("resizeEnd")
    }, 300)
}).trigger("resize"), $(".float, .float1, .float2, .float3, .float4").click(function() {
    var e = 10;
    $("html, body").animate({
        scrollTop: $("#showcase").offset().top + e
    }, 2e3)
});
var $liftOff = $(".mobile-floating ");
$window.on("scroll", function() {
    $window.scrollTop() > 2600 ? $liftOff.addClass("show").removeClass("hide") : $liftOff.addClass("hide").removeClass("show")
});