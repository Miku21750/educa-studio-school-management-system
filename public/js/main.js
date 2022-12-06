(function ($) {
  "use strict";

  /*-------------------------------------
      Sidebar Toggle Menu
    -------------------------------------*/
  $('.sidebar-toggle-view').on('click', '.sidebar-nav-item .nav-link', function (e) {
    if (!$(this).parents('#wrapper').hasClass('sidebar-collapsed')) {
      var animationSpeed = 300,
        subMenuSelector = '.sub-group-menu',
        $this = $(this),
        checkElement = $this.next();
      if (checkElement.is(subMenuSelector) && checkElement.is(':visible')) {
        checkElement.slideUp(animationSpeed, function () {
          checkElement.removeClass('menu-open');
        });
        checkElement.parent(".sidebar-nav-item").removeClass("active");
      } else if ((checkElement.is(subMenuSelector)) && (!checkElement.is(':visible'))) {
        var parent = $this.parents('ul').first();
        var ul = parent.find('ul:visible').slideUp(animationSpeed);
        ul.removeClass('menu-open');
        var parent_li = $this.parent("li");
        checkElement.slideDown(animationSpeed, function () {
          checkElement.addClass('menu-open');
          parent.find('.sidebar-nav-item.active').removeClass('active');
          parent_li.addClass('active');
        });
      }
      if (checkElement.is(subMenuSelector)) {
        e.preventDefault();
      }
    } else {
      if ($(this).attr('href') === "#") {
        e.preventDefault();
      }
    }
  });

  /*-------------------------------------
      Sidebar Menu Control
    -------------------------------------*/
  $(".sidebar-toggle").on("click", function () {
    window.setTimeout(function () {
      $("#wrapper").toggleClass("sidebar-collapsed");
    }, 500);
  });

  /*-------------------------------------
      Sidebar Menu Control Mobile
    -------------------------------------*/
  $(".sidebar-toggle-mobile").on("click", function () {
    $("#wrapper").toggleClass("sidebar-collapsed-mobile");
    if ($("#wrapper").hasClass("sidebar-collapsed")) {
      $("#wrapper").removeClass("sidebar-collapsed");
    }
  });

  /*-------------------------------------
      jquery Scollup activation code
   -------------------------------------*/
  $.scrollUp({
    scrollText: '<i class="fa fa-angle-up"></i>',
    easingType: "linear",
    scrollSpeed: 900,
    animation: "fade"
  });

  /*-------------------------------------
      jquery Scollup activation code
    -------------------------------------*/
  $("#preloader").fadeOut("slow", function () {
    $(this).remove();
  });

  $(function () {
    /*-------------------------------------
          Data Table init
      -------------------------------------*/
    if ($.fn.DataTable !== undefined) {
      $('.data-table').DataTable({
        paging: true,
        searching: false,
        info: false,
        lengthChange: false,
        lengthMenu: [20, 50, 75, 100],
        columnDefs: [{
          targets: [0, -1], // column or columns numbers
          orderable: false // set orderable for selected columns
        }],
      });
    }

    /*-------------------------------------
          All Checkbox Checked
      -------------------------------------*/
    $(".checkAll").on("click", function () {
      $(this).parents('.table').find('input:checkbox').prop('checked', this.checked);
    });

    /*-------------------------------------
          Tooltip init
      -------------------------------------*/
    $('[data-toggle="tooltip"]').tooltip();

    /*-------------------------------------
          Select 2 Init
      -------------------------------------*/
    if ($.fn.select2 !== undefined) {
      $('.select2').select2({
        width: '100%'
      });
    }

    /*-------------------------------------
          Date Picker
      -------------------------------------*/
    if ($.fn.datepicker !== undefined) {
      $('.air-datepicker').datepicker({
        language: {
          days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
          daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
          daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
          months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
          monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          today: 'Today',
          clear: 'Clear',
          dateFormat: 'dd/mm/yyyy',
          firstDay: 0
        }
      });
    }

    /*-------------------------------------
          Counter
      -------------------------------------*/
    var counterContainer = $(".counter");
    if (counterContainer.length) {
      counterContainer.counterUp({
        delay: 50,
        time: 1000
      });
    }

    /*-------------------------------------
          Vector Map 
      -------------------------------------*/
    if ($.fn.vectorMap !== undefined) {
      $('#world-map').vectorMap({
        map: 'world_mill',
        zoomButtons: false,
        backgroundColor: 'transparent',

        regionStyle: {
          initial: {
            fill: '#0070ba'
          }
        },
        focusOn: {
          x: 0,
          y: 0,
          scale: 1
        },
        series: {
          regions: [{
            values: {
              CA: '#41dfce',
              RU: '#f50056',
              US: '#f50056',
              IT: '#f50056',
              AU: '#fbd348'
            }
          }]
        }
      });
    }

    /*-------------------------------------
          Line Chart 
      -------------------------------------*/
    if ($("#earning-line-chart").length) {
      $(document).ready(function () {
        $.ajax({
          type: "GET",
          url: "/api/admin/apidata",
          dataType: "JSON",
          success: function (dana) {
            console.log(dana.sppSiswa)
            // $.each(dana.sppSiswa, function (i, data) {
            //   console
            // });
          }
        });
      })

      var lineChartData = {
        labels: ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
          data: [0, 50000,20000, 30000, 70000,80000,40000,60000,30000,60000,70000,40000,30000],
          backgroundColor: '#ff0000',
          borderColor: '#ff0000',
          borderWidth: 1,
          pointRadius: 0,
          pointBackgroundColor: '#ff0000',
          pointBorderColor: '#ffffff',
          pointHoverRadius: 6,
          pointHoverBorderWidth: 3,
          fill: 'origin',
          label: "Total Collection"
        },
        {
          data: [0,  50000,20000, 30000, 70000,100000,40000,60000,30000,60000,70000,40000,30000],
          backgroundColor: '#417dfc',
          borderColor: '#417dfc',
          borderWidth: 1,
          pointRadius: 0,
          pointBackgroundColor: '#304ffe',
          pointBorderColor: '#ffffff',
          pointHoverRadius: 6,
          pointHoverBorderWidth: 3,
          fill: 'origin',
          label: "Fees Collection"
        }
        ]
      };
      var lineChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 2000
        },
        scales: {

          xAxes: [{
            display: true,
            ticks: {
              display: true,
              fontColor: "#222222",
              fontSize: 14,
              padding: 20
            },
            gridLines: {
              display: true,
              drawBorder: true,
              color: '#cccccc',
              borderDash: [5, 5]
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              display: true,
              autoSkip: true,
              maxRotation: 0,
              fontColor: "#646464",
              fontSize: 12,
              stepSize: 10000,
              padding: 20,
              callback: function (value) {
                var ranges = [{
                  divider: 1,
                  suffix: 'Rp '
                },
                {
                  divider: 1,
                  suffix: 'Rp '
                }
                ];

                function formatNumber(n) {
                  for (var i = 0; i < ranges.length; i++) {
                    if (n >= ranges[i].divider) {
                      return ranges[i].suffix + (n / ranges[i].divider).toString();
                    }
                  }
                  return n;
                }
                return formatNumber(value);
              }
            },
            gridLines: {
              display: true,
              drawBorder: false,
              color: '#cccccc',
              borderDash: [5, 5],
              zeroLineBorderDash: [5, 5],
            }
          }]
        },
        legend: {
          display: false
        },
        tooltips: {
          mode: 'index',
          intersect: false,
          enabled: true
        },
        elements: {
          line: {
            tension: 0.15
          },
          point: {
            pointStyle: 'circle'
          }
        }
      };
      var earningCanvas = $("#earning-line-chart").get(0).getContext("2d");
      var earningChart = new Chart(earningCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
      });
    }

    /*-------------------------------------
          Bar Chart 
      -------------------------------------*/
    if ($("#expense-bar-chart").length) {

      var barChartData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
          backgroundColor: ["#40dfcd", "#417dfc", "#ffaa01"],
          data: [125000, 100000, 75000, 50000, 150000],
          label: "Expenses (millions)"
        },]
      };
      var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 2000
        },
        scales: {

          xAxes: [{
            display: false,
            maxBarThickness: 100,
            ticks: {
              display: false,
              padding: 0,
              fontColor: "#646464",
              fontSize: 14,
            },
            gridLines: {
              display: true,
              color: '#e1e1e1',
            }
          }],
          yAxes: [{
            display: true,
            ticks: {
              display: true,
              autoSkip: false,
              fontColor: "#646464",
              fontSize: 14,
              stepSize: 25000,
              padding: 20,
              beginAtZero: true,
              callback: function (value) {
                var ranges = [{
                  divider: 1e6,
                  suffix: 'M'
                },
                {
                  divider: 1e3,
                  suffix: 'k'
                }
                ];

                function formatNumber(n) {
                  for (var i = 0; i < ranges.length; i++) {
                    if (n >= ranges[i].divider) {
                      return (n / ranges[i].divider).toString() + ranges[i].suffix;
                    }
                  }
                  return n;
                }
                return formatNumber(value);
              }
            },
            gridLines: {
              display: true,
              drawBorder: true,
              color: '#e1e1e1',
              zeroLineColor: '#e1e1e1'

            }
          }]
        },
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        elements: {}
      };
      var expenseCanvas = $("#expense-bar-chart").get(0).getContext("2d");
      var expenseChart = new Chart(expenseCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      });
    }

    /*-------------------------------------
          Doughnut Chart 
      -------------------------------------*/

    if ($("#student-doughnut-chart").length) {
      var siswaPerempuan;
      var siswaLaki;
      $(document).ready(function () {
        $.ajax({
          type: "GET",
          url: "/api/admin/apidata",
          dataType: "JSON",
          success: function (total) {
            let a = total;
            // console.log(a['totalSiswaFemale'])
            siswaPerempuan = a['totalSiswaFemale']
            siswaLaki = a['totalSiswaMale']

            // console.log(siswaPerempuan)
            var doughnutChartData = {
              labels: ["Siswa Perempuan", "Siswa Laki-laki"],
              datasets: [{
                backgroundColor: ["#304ffe", "#ffa601"],
                data: [siswaPerempuan, siswaLaki],
                label: "Total Siswa"
              },]
            };
            var doughnutChartOptions = {
              responsive: true,
              maintainAspectRatio: false,
              cutoutPercentage: 65,
              rotation: -9.4,
              animation: {
                duration: 2000
              },
              legend: {
                display: false
              },
              tooltips: {
                enabled: true
              },
            };
            var studentCanvas = $("#student-doughnut-chart").get(0).getContext("2d");
            var studentChart = new Chart(studentCanvas, {
              type: 'doughnut',
              data: doughnutChartData,
              options: doughnutChartOptions
            });
          }
        });
      })
    }
    
    /*-------------------------------------
          Calender initiate 
      -------------------------------------*/
    if ($.fn.fullCalendar !== undefined) {
      $('#fc-calender').fullCalendar({
        header: {
          center: 'basicDay,basicWeek,month',
          left: 'title',
          right: 'prev,next',
        },
        fixedWeekCount: false,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        aspectRatio: 1.8,
        events: [{
          title: 'All Day Event',
          start: '2019-04-01'
        },

        {
          title: 'Meeting',
          start: '2019-04-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2019-04-15T17:30:00'
        },
        {
          title: 'Birthday Party',
          start: '2019-04-20T07:00:00'
        }
        ]
      });
    }
  });

})(jQuery);

/*-------------------------------------
    Others Query for Code
-------------------------------------*/



/*-------------------------------------
      Google Translate 
  -------------------------------------*/
// function googleTranslateElementInit(){
//   new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element')
// }
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    // includedLanguages: 'en,es,pl,pt,zh-CN,zh-TW,ar,so,ru,hy,ko,vi',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
// JQUERY
$('document').ready(function () {
  $('#google_translate_element').on("click", function () {

    // Change font family and color
    $("iframe").contents().find(".goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div") //, .goog-te-menu2 *
      .css({
        'color': '#544F4B',
        'background-color': '#e3e3ff',
        'font-family': '"Open Sans",Helvetica,Arial,sans-serif'
      });

    // Change hover effects  #e3e3ff = white
    $("iframe").contents().find(".goog-te-menu2-item div").hover(function () {
      $(this).css('background-color', '#17548d').find('span.text').css('color', '#e3e3ff');
    }, function () {
      $(this).css('background-color', '#e3e3ff').find('span.text').css('color', '#544F4B');
    });

    // Change Google's default blue border
    $("iframe").contents().find('.goog-te-menu2').css('border', '1px solid #17548d');

    $("iframe").contents().find('.goog-te-menu2').css('background-color', '#e3e3ff');

    // Change the iframe's box shadow
    $(".goog-te-menu-frame").css({
      '-moz-box-shadow': '0 3px 8px 2px #666666',
      '-webkit-box-shadow': '0 3px 8px 2px #666',
      'box-shadow': '0 3px 8px 2px #666'
    });
  });
});