$(function () {
    var INDEX = 0;
    $("#chat-submit").click(function (e) {
        e.preventDefault();
        var msg = $("#chat-input").val();
        if (msg.trim() == '') {
            return false;
        }
        generate_message(msg, 'self');
        var buttons = [
            {
                name: 'Existing User',
                value: 'existing'
            },
            {
                name: 'New User',
                value: 'new'
            }
        ];
       
        setTimeout(function () {
            response_msg(msg, 'user');
        }, 1000)

    })
    function compare(promptsArray, repliesArray, string) {
        let reply;
        let replyFound = false;
        for (let x = 0; x < promptsArray.length; x++) {
            for (let y = 0; y < promptsArray[x].length; y++) {
                if (promptsArray[x][y] === string) {
                    let replies = repliesArray[x];
                    reply = replies[Math.floor(Math.random() * replies.length)];
                    replyFound = true;
                    // Stop inner loop when input value matches prompts
                    break;
                }
            }
            if (replyFound) {
                // Stop outer loop when reply is found instead of interating through the entire array
                break;
            }
        }
        return reply;
    }
    function dictionary(request) {
        let product;

        if (request.match("Standard") && request.match("Quote")) {
            product = "Of course may I have your name please"
        } else if (request.match("Excelium") && request.match("Quote")) {
            product = "Of course may I have your name please"
        } else if (request.match("Premium") && request.match("Quote")) {
            product = "Of course may I have your name please"
        } else {
            let text = request.toLowerCase().replace(/[^\w\s]/gi, "").replace(/[\d]/gi, "").trim();
            text = text
                .replace(/ a /g, " ")   // 'tell me a story' -> 'tell me story'
                .replace(/i feel /g, "")
                .replace(/whats/g, "what is")
                .replace(/please /g, "")
                .replace(/ please/g, "")
                .replace(/r u/g, "are you");
            if (compare(prompts, replies, text)) {
                // Search for exact match in `prompts`
                product = compare(prompts, replies, text);
            } else if (text.match(/thank/gi)) {
                product = "You're welcome!"
            } else if (text.match(/(corona|covid|virus)/gi)) {
                // If no match, check if message contains `coronavirus`
                product = coronavirus[Math.floor(Math.random() * coronavirus.length)];
            } else {
                // If all else fails: random alternative
                product = alternative[Math.floor(Math.random() * alternative.length)];
            }
        }
      

        return product;
    }
    function response_msg(request, type) {

        var msg = dictionary(request);
        INDEX++;
        var str = "";
       
        str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + type + "\">";
      
        str += "          <div class=\"cm-msg-text\">";

        str += "        <i class=\"fas fa-comment-alt\"></i>  &nbsp;";
        str += msg;
        str += "          <\/div>";
        str += "        <\/div>";
        $(".chat-logs").append(str);
        $("#cm-msg-" + INDEX).hide().fadeIn(300);
        if (type == 'self') {
            $("#chat-input").val('');
        }
        $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight }, 1000);
    }
    function generate_message(msg, type) {
        INDEX++;
        var str = "";
        str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + type + "\">";

        str += "          <div class=\"cm-msg-text\">";
        str += msg;

        str += "   &nbsp;       <i class=\"fas fa-comment-alt\"></i>";
        str += "          <\/div>";
        str += "        <\/div>";
        $(".chat-logs").append(str);
        $("#cm-msg-" + INDEX).hide().fadeIn(300);
        if (type == 'self') {
            $("#chat-input").val('');
        }
        $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight }, 1000);
    }

    function generate_button_message(msg, buttons) {
        /* Buttons should be object array 
          [
            {
              name: 'Existing User',
              value: 'existing'
            },
            {
              name: 'New User',
              value: 'new'
            }
          ]
        */
        INDEX++;
        var btn_obj = buttons.map(function (button) {
            return "              <li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\"" + button.value + "\">" + button.name + "<\/a><\/li>";
        }).join('');
        var str = "";
        str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg user\">";
   
        str += "          <div class=\"cm-msg-text\">";
        str += "aiejgeg";
        str += "          <\/div>";
        str += "          <div class=\"cm-msg-button\">";
        str += "            <ul>";
        str += btn_obj;
        str += "            <\/ul>";
        str += "          <\/div>";
        str += "        <\/div>";
        $(".chat-logs").append(str);
        $("#cm-msg-" + INDEX).hide().fadeIn(300);
        $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight }, 1000);
        $("#chat-input").attr("disabled", true);
    }

    $(document).delegate(".chat-btn", "click", function () {
        var value = $(this).attr("chat-value");
        var name = $(this).html();
        $("#chat-input").attr("disabled", false);
        generate_message(name, 'self');
    })

    $("#chat-circle").click(function () {
        $("#chat-circle").toggle('scale');
        $(".chat-box").toggle('scale');
    })

    $(".chat-box-toggle").click(function () {
        $("#chat-circle").toggle('scale');
        $(".chat-box").toggle('scale');
    })

})

