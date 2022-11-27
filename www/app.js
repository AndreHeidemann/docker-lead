//Default Toastr Notification Settings
const baseUrl = 'http://docker.localhost/api';

(function() {
})();

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
                        var res = JSON.parse(data);
                        console.log(res);
                        if (res.status == 1) {
                            toastr.success(res.msg);
                            $('#file').val('');
                            $label.removeClass('has-file').find('.js-fileName').html('Selecione CSV');                            
                            refreshDataTable();
                        }else if(res.status == 0){
                            toastr.error(res.msg);
                            $('#file').val('');
                            $label.removeClass('has-file').find('.js-fileName').html('Selecione CSV');                            
                        }else{
                            toastr.error("Erro desconhecido: "+res);
                            $('#file').val('');
                            $label.removeClass('has-file').find('.js-fileName').html('Selecione CSV');                            
                        }
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

    toastr.options = {
        'closeButton': true,
        'debug': false,
        'newestOnTop': true,
        'progressBar': false,
        'positionClass': 'toast-top-right',
        'preventDuplicates': false,
        'showDuration': '1000',
        'hideDuration': '1000',
        'timeOut': '5000',
        'extendedTimeOut': '1000',
        'showEasing': 'swing',
        'hideEasing': 'linear',
        'showMethod': 'fadeIn',
        'hideMethod': 'fadeOut',
    }

    function chartEmptyGenderCounter(data){
        if ( document.getElementById("chartEmptyGenderCounter").hasChildNodes() ) {
            document.getElementById("chartEmptyGenderCounter").innerHTML = '';
        }
        var options = {
            title: {
                text: "Quantidade de clientes com ou sem sobrenome",
                align: 'left',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                    fontSize:  '14px',
                    fontWeight:  'bold',
                    fontFamily:  undefined,
                    color:  '#ECF0F5'
                },
            },            
            colors : ['#0DB8DE','#27EF9F'],
            series: [data.rowsCounter-data.emptyGenderCounter,data.emptyGenderCounter],
            chart: {
                width: 380,
                type: 'pie',
            },
            legend: {
                show: true,
                labels: {
                    colors: "#ECF0F5",
                    useSeriesColors: false
                },
            },
            labels: ['Possue Sobrenome', 'Sobrenome não informado'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };  
        var chart = new ApexCharts(document.getElementById("chartEmptyGenderCounter"), options);
        chart.render();
    }

    function chartInvalidEmailCounter(data){
        if ( document.getElementById("chartInvalidEmailCounter").hasChildNodes() ) {
            document.getElementById("chartInvalidEmailCounter").innerHTML = '';
        }
        var options = {
            title: {
                text: "Quantidade de clientes com email válido ou inválido",
                align: 'left',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                  fontSize:  '14px',
                  fontWeight:  'bold',
                  fontFamily:  undefined,
                  color:  '#ECF0F5'
                },
            },   
            colors : ['#0DB8DE','#27EF9F'],
            series: [data.rowsCounter-data.invalidEmailCounter,data.invalidEmailCounter],
            chart: {
                width: 380,
                type: 'pie',
            },
            legend: {
                show: true,
                labels: {
                    colors: "#ECF0F5",  // TEXT COLOR CAN BE CHANGED HERE
                    useSeriesColors: false
                },
            },
            labels: ['Email Válido', 'Email Inválido'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };  
        var chart = new ApexCharts(document.getElementById("chartInvalidEmailCounter"), options);
        chart.render();
    }

    function chartEmptyLastNameCounter(data){
        if ( document.getElementById("chartEmptyLastNameCounter").hasChildNodes() ) {
            document.getElementById("chartEmptyLastNameCounter").innerHTML = '';
        }
        var options = {
            title: {
                text: "Quantidade de clientes com ou sem gênero",
                align: 'left',
                margin: 10,
                offsetX: 0,
                offsetY: 0,
                floating: false,
                style: {
                  fontSize:  '14px',
                  fontWeight:  'bold',
                  fontFamily:  undefined,
                  color:  '#ECF0F5'
                },
            }, 
            colors : ['#0DB8DE','#27EF9F'],
            series: [data.rowsCounter-data.emptyLastNameCounter,data.emptyLastNameCounter],
            chart: {
            width: 380,
            type: 'pie',
            },
            legend: {
                show: true,
                labels: {
                  colors: "#ECF0F5",  // TEXT COLOR CAN BE CHANGED HERE
                  useSeriesColors: false
              },
            },
            labels: ['Possue Gênero', 'Gênero não informado'],            
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };  
        var chart = new ApexCharts(document.getElementById("chartEmptyLastNameCounter"), options);
        chart.render();
    }

    function refreshDataTable() {
        $.ajax({
            url: baseUrl + '/?page=table',
            method: 'GET',
            success: function (response) {                        
                var res = JSON.parse(response);
                
                if (res && res.status && res.data && res.data.length) {                    
                    chartEmptyGenderCounter(res);
                    chartInvalidEmailCounter(res);
                    chartEmptyLastNameCounter(res);
                    $('#table-lead').removeClass('d-none');
                    $('#table-lead').DataTable({
                        "destroy": true,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/pt-BR.json"
                        },
                        "data": res.data,
                        "columns": [
                            {"data": "ID"},
                            {"data": "FIRST_NAME"},
                            {"data": "LAST_NAME"},
                            {"data": "EMAIL"},
                            {"data": "GENDER"},
                            {"data": "IP_ADDRESS"},
                            {"data": "COMPANY"},
                            {"data": "CITY"},
                            {"data": "TITLE"},
                            {"data": "WEBSITE"}
                        ],
                        "columnDefs": [                            
                            { "width": "10px", "className": "no-wrap", "targets": "_all" }
                                                                                  
                        ],
                        "order": [[1, 'asc']]
                    });
                }else{
                    $('#table-lead').addClass('d-none');
                }
            }
        });
    }
  
    refreshDataTable();    
})();





/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.extn+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}