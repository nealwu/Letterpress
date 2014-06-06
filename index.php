<html>
    <head>
        <title>Letterpress Solver!</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#submit').click(function() {
                    $('#words').empty();
                    $.ajax({
                        url: 'solver.php',
                        cache: false,
                        data: {
                            group1: $('#group1').val().toLowerCase(),
                            group2: $('#group2').val().toLowerCase(),
                            group3: $('#group3').val().toLowerCase()
                        },
                        success: function(result) {
                            var mapping = JSON.parse(result);

                            if (mapping.length == 0) {
                                $('#words').append($('<h3>').text('Invalid!'));
                            } else {
                                $('#words').append($('<table>').attr('id', 'wordlist'));
                                $('#wordlist').append('<tr><th>Suggestion</th><th>Score (2 * Group1 + Group2)</th></tr>');

                                for (var word in mapping) {
                                    var score = mapping[word];
                                    $('#wordlist').append('<tr><td><pre>' + word.toUpperCase() + '</pre></td><td>' + score + '</td></tr>');
                                }
                            }
                        }
                    });
                });
            });
        </script>
        <style type="text/css">
            *:not(pre) {
                font-family: "museo-sans-rounded","museo_sans_500regular",Arial,Helvetica,sans-serif;
            }
        </style>
    </head>

    <body>
        <img height="25%" src="letterpress.png"></img>
        <div>
            <h3>Group 1 is the light red letters.<br>Group 2 is the white letters.<br>Group 3 is everything else (the blue and dark red letters).</h3>
        </div>
        <div>
            Group 1 <input id="group1" placeholder="LVIP">
            <br>
            Group 2 <input id="group2" placeholder="OHAKKJ">
            <br>
            Group 3 <input id="group3" placeholder="SOEONYDRTFRPYAR">
            <br>
            <input id="submit" type="submit" value="Submit">
        </div>
        <div id="words"></div>
    </body>
</html>