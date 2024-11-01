(function($) {
"use strict";


jQuery(document).ready(function ($) {
    
    $("#ycrun").on('click', function (event) {
        event.preventDefault();
        $("#loader").show();
        var video_id_input = $("#video_id").val();
        var lang = $('#lang').val();
        console.log(lang);

        if (video_id_input.length) {

            var video_id = video_id_input.trim();

            $.getJSON(`https://nodejs-youtube-captions.herokuapp.com/?videoId=${video_id}&language=${lang}`, function(data) {

                function countWords(str) {
                    str = str.replace(/(^\s*)|(\s*$)/gi,"");
                    str = str.replace(/[ ]{2,}/gi," ");
                    str = str.replace(/\n /,"\n");
                    return str.split(' ').length;
                }

                var words_count = countWords(data);

                $("#content").val(function () {
                    
                    var certainWords = data.split(" ").splice(0,200).join(" ");
                    return certainWords

                });
                $("#words_count").val(function () {
                    return "Words Count - " + words_count
                });
                
                $("#loader").hide();
            }).fail(function(jqXHR, textStatus, errorThrown) { alert('getJSON request failed! ' + textStatus); })

        }
        else {
            alert("Please insert video id")
        }
        

    });
});

})(jQuery); 