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
                            group1: $('#group1').val(),
                            group2: $('#group2').val(),
                            group3: $('#group3').val()
                        },
                        success: function(result) {
                            $('#words').append($('<h3>').text('Suggestions:'));
                            $('#words').append($('<ul>').attr('id', 'wordlist'));

                            var mapping = JSON.parse(result);

                            for (var word in mapping) {
                                var score = mapping[word];
                                $('#wordlist').append('<li>' + word + '</li>');
                            }
                        }
                    });
                });
            });
        </script>
    </head>

    <body>
        <div>
            <h3>HOWTO: Group 1 is the light red letters, Group 2 is the white letters, and Group 3 is everything else (the blue and dark red letters).</h3>
        </div>
        <div>
            Group 1: <input id="group1">
            <br>
            Group 2: <input id="group2">
            <br>
            Group 3: <input id="group3">
            <br>
            <input id="submit" type="submit" value="Submit">
        </div>
        <div id="words"></div>
    </body>
</html>