(function() {
    'use strict';

    const baseUrl = 'http://docker.localhost/api';

    $('.input-file').each(function() {
        var $input = $(this);
        // console.log($input);
        var $label = $input.next('.js-labelFile');
        var labelVal = $label.html();
      
        $input.on('change', function(element) {
            var file = element.target.files.length ? element.target.files[0] : null;
            var fileName = '';

            if (file) {
                fileName = file.name.split('\\').pop();

                var data = new FormData();
                data.append('file', file);

                $.ajax({
                    url: baseUrl + '/?page=csv',
                    contentType: false,
                    processData: false,
                    data,
                    method: 'POST',
                    success: function (data) {
                        console.log('OK');
                        // console.log(data);
                    }
                });
            }
            
            if (fileName) {
                $label.addClass('has-file').find('.js-fileName').html(fileName);
            } else {
                $label.removeClass('has-file').html(labelVal);
            }
        });
    });
})();
