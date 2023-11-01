<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        /* CSS for the notification container */
        #notificationContainer {
            background-color: rgba(229, 229, 229, 1);
            width: 400px;
            padding: 10px;
            margin: 10px;
            border-radius: 0px;
            display: none;
            position: relative;
            left: 45%;
            text-align: center;
        }

        #notificationTriangle {
            width: 0;
            height: 0;
            border-left: 10px solid transparent;
            border-right: 10px solid transparent;
            border-bottom: 10px solid rgba(231, 231, 231, 1);
            position: absolute;
            top: -10px;


            transform: translateX(-50%);
        }

        body {
            font-family: Roboto, sans-serif;
        }

        .rounded-button {
            margin-top: 5px;
            
            margin-left: 88%;
            display: flex;
            align-items: center;
            background-color: transparent;
            color: white;
            border: none;
            outline: none;
            padding: 0;
            width: 26px;
            height: 26px;
            background-image: url('icon.png');
            background-size: cover;
            border-radius: 50%;
            transition: background-color 0.2s, box-shadow 0.2s;
            box-shadow: none;
            user-select: none;
        }

        .rounded-button:hover,
        .rounded-button:active {
            background-color: transparent;
            box-shadow: none;
        }

        .rounded-button {
            border: none;
            user-select: none;
        }

        .material-icons {
            user-select: none;
        }

        /* CSS for the notification container */
        #notificationContainer {
    background-color: rgba(229, 229, 229, 1);
    width: 400px;
    padding: 10px;
    margin: 10px;
    border-radius: 0px;
    display: none;
    position: relative;
    left: 72%;
    text-align: center;
    position: relative;
    transform: translateX(-50%);
    right: 100.953125px;
    top: 109px;
    box-shadow: 0 2px 1px #aaa;
    border-bottom-color: #bbb;
    color: #404040;
    font: 13px Roboto,arial,sans-serif;
}

/* Add triangle to the container */
#notificationTriangle {
    width: 20px;
    height: 22px;
    border-bottom: 10px solid rgba(231, 231, 231, 1);
    position: absolute;
    top: 19px;
    left: 88.76%;
    transform: translateX(-50%);
    }



    </style>
</head>
<body>
    <button id="showNotification" class="btn rounded-button" style="background-color: transparent;">
        <i class="material-icons left" style="  margin: 0 auto; font-size: 1.5rem; margin-bottom: 0px; font-size: 1.14rem;">notifications</i>
    </button>

  
    
    <div id="notificationContainer" style="color: #aaa; max-height: 500px; overflow-y: auto;">
    <div id="notificationTriangle" style="display: none;"></div>
    <span class="title" style="color: #6f6f6f; text-align: center; font-size: 15px;">Loogle notification</span>
    <br> <br>
    <div id="mentionsContainer"></div>
</div>    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationContainer = document.getElementById('notificationContainer');
        const notificationTriangle = document.getElementById('notificationTriangle');

        // Show the notification and triangle
        document.getElementById('showNotification').addEventListener('click', function() {
            if (notificationContainer.style.display === 'block') {
                notificationContainer.style.display = 'none';
                notificationTriangle.style.display = 'none';
            } else {
                notificationContainer.style.display = 'block';
                notificationTriangle.style.display = 'block';
            }
        });

        // Show the notification when clicking the triangle
        notificationTriangle.addEventListener('click', function() {
            if (notificationContainer.style.display === 'block') {
                notificationContainer.style.display = 'none';
                notificationTriangle.style.display = 'none';
            } else {
                notificationContainer.style.display = 'block';
                notificationTriangle.style.display = 'block';
            }
        });
    });
</script>

<script>
    function fetchMentions() {
        const mentionsContainer = document.getElementById('mentionsContainer');

        // Clear existing mentions
        mentionsContainer.innerHTML = '';

        // Make an AJAX request to fetch mentions
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'notifications-handler.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const mentions = JSON.parse(xhr.responseText);

                if (mentions.length > 0) {
                    mentions.forEach(function (mention, index) {
                        // Create a div element to display sender name, content, and timestamp
                        const mentionDiv = document.createElement('div');

                        // Set background color to white
                        mentionDiv.style.backgroundColor = 'white';
                        mentionDiv.style.display = 'flex';
                        mentionDiv.style.alignItems = 'left';
    
                        mentionDiv.style.borderRadius = '0px';


                        mentionDiv.addEventListener('click', function () {
                        const postId = mention.post_id;


                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', 'onclick.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                        // Handle the response or errors if needed
                        }
                       };
                        xhr.send('post_id=' + postId);

                         //  After marking the mention as read, redirect to the post
                         window.location.href = window.location.origin + '/view_post.php?post_id=' + postId;
                       });

                        // Create an image (PFP) element
                        const pfpImage = document.createElement('img');
                        pfpImage.src = 'https://yt3.ggpht.com/ytc/APkrFKaEi25zAXv7eUtMEtWm99TSnR49Qn29zBQVYr16FA=s96-c-k-c0x00000000-no-cc-rj-rp';
                        pfpImage.alt = 'PFP';
                        pfpImage.style.width = '80px';
                        pfpImage.style.borderRadius = '5%';
                        pfpImage.style.height = '80px';
     
                        mentionDiv.appendChild(pfpImage);

                        // Create a div to contain sender name, content, and timestamp
                        const textContainer = document.createElement('div');
                        textContainer.style.marginLeft = '10px';
                        textContainer.style.marginTop = '9px';
                        // Create a span for sender name (Title)
                        const senderSpan = document.createElement('span');
                        senderSpan.textContent = mention.sender;
                        senderSpan.style.color = '#262626';
                        senderSpan.style.fontWeight = 'bold';
                        senderSpan.style.lineHeight = '18px';
                        senderSpan.style.marginTop = '16px';
                        senderSpan.style.marginRight = '80%';
                        textContainer.appendChild(senderSpan);

                        // Create a line break
                        textContainer.appendChild(document.createElement('br'));

                        // Create a span for mention content
                        const contentSpan = document.createElement('span');
                        contentSpan.textContent = mention.content;
                        
                        contentSpan.style.overflow = 'hidden';
                        contentSpan.style.textOverflow = 'ellipsis';
                        contentSpan.style.width = '240px';
                        contentSpan.style.marginLeft = '11px';    
                        contentSpan.style.whiteSpace = 'nowrap';
                        contentSpan.style.color = '#262626'
                        textContainer.appendChild(contentSpan);

                        // Create a span for the timestamp
                        const timestampSpan = document.createElement('span');
                        const timestamp = calculateTimestamp(mention.created_at);
                        timestampSpan.textContent = timestamp;
                        timestampSpan.style.fontSize = '11px';
                        timestampSpan.style.marginRight = '55px';
                        timestampSpan.style.color = '#737373';
                        timestampSpan.style.position = 'relative';
                        timestampSpan.style.top = '17px';
                        textContainer.appendChild(document.createElement('br'));
                        textContainer.appendChild(timestampSpan);
                  

                        mentionDiv.appendChild(textContainer);

                        // Create an anchor element to make the div clickable
                        const anchor = document.createElement('a');
                        anchor.href = 'view_post.php?id=' + mention.post_id;
                        anchor.style.display = 'none'; // Hide the anchor
                        mentionDiv.appendChild(anchor);

                        mentionsContainer.appendChild(mentionDiv);

                        

                        // Add a line break after each mention except the last one
                        if (index < mentions.length - 1) {
                            mentionsContainer.appendChild(document.createElement('br'));
                        }
                    });
                } else {
                    // If there are no new mentions, you can display a message or leave it empty.
                    mentionsContainer.innerHTML = 'No new mentions.';
                }
            }
        };

        xhr.send();
    }

    // Calculate and format the timestamp
    function calculateTimestamp(createdAt) {
        const currentDate = new Date();
        const mentionDate = new Date(createdAt);
        const timeDifference = currentDate - mentionDate;
        const seconds = Math.floor(timeDifference / 1000);
        const minutes = Math.floor(seconds / 60);
        const hours = Math.floor(minutes / 60);
        const days = Math.floor(hours / 24);
        const years = Math.floor(days / 365);

        if (seconds < 60) {
            return `${seconds} seconds ago`;
        } else if (minutes < 60) {
            return `${minutes} minutes ago`;
        } else if (hours < 24) {
            return `${hours} hours ago`;
        } else if (days < 365) {
            return `${days} days ago`;
        } else {
            return `${years} years ago`;
        }
    }

    // Fetch mentions initially and every 25 seconds
    fetchMentions();
    setInterval(fetchMentions, 2500000); // 25 seconds in milliseconds
</script>



</body>
</html>
