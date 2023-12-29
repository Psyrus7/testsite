function addComment() {
    var nameInput = document.getElementById('commentName');
    var textInput = document.getElementById('commentText');
    var commentList = document.getElementById('commentList');

    var name = nameInput.value.trim();
    var text = textInput.value.trim();

    // Clear the form fields
    nameInput.value = '';
    textInput.value = '';

    if (name && text) {
        var xhr = new XMLHttpRequest();

        // Configure the request
        xhr.open('POST', 'server.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');

        // Set up a callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 201) {
                    // Successfully added comment
                    var addedComment = JSON.parse(xhr.responseText);

                    // Update the UI with the newly added comment
                    var comment = document.createElement('li');
                    comment.className = 'comment';
                    comment.innerHTML = '<strong>' + addedComment.name + ':</strong> <p>' + addedComment.text + '</p>';
                    commentList.appendChild(comment);
                } else {
                    // Handle errors
                    console.error('Error adding comment:', xhr.statusText);
                }
            }
        };

        // Create a JSON object with the comment data
        var newComment = {
            name: name,
            text: text
        };

        // Convert the JSON object to a string and send the request
        xhr.send(JSON.stringify(newComment));
    }
}
