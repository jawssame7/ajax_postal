$(function () {
    $('#get_address_btn').click(function () {
        $resultsErr = $('#results_error');
        $text = $('input[name=zip_code]');
        console.log($text)
        $.ajax('api.php', {
            type: 'get',
            data: {
                zip_code: $text.val()
            }
        }).then(function (data) {
            console.log(data);
            if (data.success === true) {
                var $zip = $('#zip_code');
                var $add1 = $('#address1');
                var $add2 = $('#address2');
                var $add3 = $('#address3');
                var $kan1 = $('#kana1');
                var $kan2 = $('#kana2');
                var $kan3 = $('#kana3');
                if (data.results.length > 0) {
                    var ret = data.results[0];
                    $zip.text(ret.zip_code);
                    $add1.text(ret.address1);
                    $add2.text(ret.address2);
                    $add3.text(ret.address3);
                    $kan1.text(ret.kana1);
                    $kan2.text(ret.kana2);
                    $kan3.text(ret.kana3);

                }
            } else {
                $resultsErr.text(data.message);
                $resultsErr.show();
            }
            

        });
    });
    
});