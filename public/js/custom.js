var options = {
    chart: {
      type: 'area',
      height: 500,
      toolbar: {
          show: false,
      },
    },
    fill: {
        colors: '#FDB702',
        opacity: 1,
        type: 'solid',
    },
    stroke: {
        curve: 'straight',
        colors: '#FDB702',
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
    series: [{
      name: 'sales',
      data: [30,40,35,50,49,60,70,91,120]
    }],
    xaxis: {
      categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999],
      labels: {
          show: false,
      },
      axisTicks: {
          show: false,
      },
      tooltip: {
          enabled: false,
      }
    },
    yaxis: {
        labels: {
            show: false,
        },
    },
    tooltip: {
        enabled: false,
    },
    responsive: [{
        breakpoint: 880,
        options: {
            chart: {
                type: 'area',
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

  $(document).ready(function(){
      $('#menu_icon').click(function(){
        $('#sub_menu').slideToggle();
        document.getElementById('menu_icon').classList.toggle("change")
      })
  })