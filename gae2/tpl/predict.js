$('form').submit(function() {
    try {
        var price = parseFloat($('#price').val());

        if(isNaN(price) || price < 0) {
            throw 'oops';
        }
    } catch(e) {
        $('#price').focus().parent().parent().parent().addClass('error');
        return false;
    }

    $('#price').removeClass('error');
    $('#result').show();

    googleapis.auth.checkLoginComplete();

    function login() {
        var config = {
            'client_id': '609185851266.apps.googleusercontent.com',
            'scope': 'https://www.googleapis.com/auth/prediction',
        };
        googleapis.auth.login(config, checkStatus);
    }

    function checkStatus() {
        var token = googleapis.auth.getToken();
        if(token) {
            var tech = parseInt($('#tech').val(), 10),
                culture = parseInt($('#culture').val(), 10),
                games = parseInt($('#games').val(), 10),
                sports = parseInt($('#sports').val(), 10),
                clothing = parseInt($('#clothing').val(), 10);

            prediction.predict({
                'id': 'giftideas',
                'input': {'csvInstance': [price, tech, culture, games, sports, clothing]}
            }).execute(function(reply) {
                console.log(reply);
            });
        } else {
            alert('You need to be logged...');
        }
    }

    checkStatus();
    return false;
});

