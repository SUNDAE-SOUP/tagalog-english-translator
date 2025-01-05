$("form").submit(function (event) {
    console.log("access CustomJS");
    const profileImageUrl = $("#chat-container").data("profile-image-url");

    const userMessage = "Trasnlate the Tagalog word(s) or sentence(s) to English. Respond only with the exact English translation: " + $("form #message").val();
    event.preventDefault();

    //Stop empty messages
    if ($("form #message").val().trim() === "") {
        return;
    }

    //Disable form
    $("form #message").prop("disabled", true);
    $("form button").prop("disabled", true);

    Promise.all([
        $.ajax({
            url: "/chat",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                model: "gpt-3.5-turbo",
                content: userMessage,
            },
        }),
        $.ajax({
            url: "/gemini", 
            method: "POST",
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Authorization: "Bearer AIzaSyAnnZpF66HxifV8W56eo-jHmT-1_eRNfPk", // Replace with your actual Gemini API key
            },
            data: {
                prompt: userMessage,
            },
        }),
    ])
        .then(([chatGPTResponse, geminiResponse]) => {
            // sending message
            $(".messages > .message")
                .last()
                .after(
                    '<div class="right message">' +
                        "<p>" +
                        $("form #message").val() +
                        "</p>" +
                        '<img src="' +
                        profileImageUrl +
                        '" alt="Avatar">' +
                        "</div>"
                );

            // ChatGPT response
            $(".messages > .message")
                .last()
                .after(
                    '<div class="left message">' +
                        '<img src="' +
                        profileImageUrl +
                        '" alt="Avatar">' +
                        "<p>**This is the output of ChatGPT:** " +
                        chatGPTResponse +
                        "</p>" +
                        "</div>"
                );

            // Gemini response
            $(".messages > .message")
                .last()
                .after(
                    '<div class="left message">' +
                        '<img src="' +
                        profileImageUrl +
                        '" alt="Avatar">' +
                        "<p>**This is the output of Gemini:** " +
                        geminiResponse.response +
                        "</p>" + // Assuming the response structure is { response: "your response" }
                        "</div>"
                );

            // Cleanup
            $("form #message").val("");
            $(document).scrollTop($(document).height());

            // Enable form
            $("form #message").prop("disabled", false);
            $("form button").prop("disabled", false);
        })
        .catch((error) => {
            console.error("Error:", error);
            // Handle errors appropriately (e.g., display error messages to the user)
            // Enable form
            $("form #message").prop("disabled", false);
            $("form button").prop("disabled", false);
        });
});
