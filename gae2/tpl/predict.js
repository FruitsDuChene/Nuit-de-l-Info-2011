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

    var tech = parseInt($('#tech').val(), 10),
        culture = parseInt($('#culture').val(), 10),
        games = parseInt($('#games').val(), 10),
        sports = parseInt($('#sports').val(), 10),
        clothing = parseInt($('#clothing').val(), 10);

    prediction.predict({
        'id': 'giftideas',
        'input': {'csvInstance': [price, tech, culture, games, sports, clothing]}
    }).execute(function(reply) {
        var html = '',
            out = reply['outputMulti'];

        for(var i = 0, l = out.length; i < l; ++i) {
            html += '<tr>';
            html += '<td>' + out[i]['label'] + '</td>';
            html += '<td>' + Math.round(100 * out[i]['score']) + '</td>';
            html += '</tr>';
        }

        $('#result tbody').html(html);
    });

    return false;
});

