  $(document).ready(function(){
      $('#menu_icon').click(function(){
        $('#sub_menu').slideToggle();
        document.getElementById('menu_icon').classList.toggle("change")
      })


      $.ajax({
          url: '/get_wallet_data',
          type: 'get',
          data: {a:1},
          beforeSend: function () { $('.loader_container').removeClass('display_none'); },
          success: function(data){
            //   console.log(data.btc_in);

              var options = {
                chart: {
                  type: 'line',
                  height: 500,
                  toolbar: {
                      show: false,
                  },
                },
                stroke: {
                    curve: ['straight'],
                    colors: ['#FDB702'],
                    width: [5]
                    // curve: ['straight', 'straight'],
                    // colors: ['#FDB702','#ffdb7e'],
                    // width: [5,5]
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Segoe UI',
                        colors: ['#3F1268'],
                    },
                },
                markers: {
                    size: 8,
                    strokeColors: '#FDB702',
                    strokeWidth: 2,
                    colors: '#fff',
                },
                series: [
                    {
                        name: 'In',
                        data: data.btc_in
                    },
                    // {
                    //     name: 'Out',
                    //     data: data.btc_out
                    // }
                ],
                xaxis: {
                    type: 'category',
                    categories: data.key_display,
                    labels: {
                        show: true,
                    },
                    axisTicks: {
                        show: true,
                    },
                    tooltip: {
                        enabled: false,
                    },
                    tickPlacement: 'between'
                },
                yaxis: {
                    labels: {
                        show: true,
                        formatter: (value) => { return value.toFixed(8); },
                    },
                },
                tooltip: {
                    enabled: false,
                },
                colors: ['#FDB702'],
                // colors: ['#FDB702','#ffdb7e'],
                responsive: [{
                    breakpoint: 880,
                    options: {
                        chart: {
                            type: 'line',
                            height: 300,
                            toolbar: {
                                show: false,
                            },
                        },
                        
                    },
                }]
              }  
              var chart = new ApexCharts(document.querySelector("#chart"), options);  
              chart.render();
              $('.loader_container').addClass('display_none');

          },
        error:function(xhr, status, error){
            var err = eval("(" + xhr.responseText + ")");
            console.log(err.errors)
            $('.loader_container').addClass('display_none');
        }
      }).done(function () {
        $('.loader_container').addClass('display_none');
    })
  })