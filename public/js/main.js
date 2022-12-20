

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
      loadData(2019)
      var earningChart = null
      function loadData(year) {
        $.ajax({
          type: 'GET',
          url: "/api/admin/chart?year=" + year,
          dataType: "JSON",
          success: function (tahun) {
            drawChart(tahun, true);
          }
        });
      }
      $("#target-line-chart").change(function () {
        let year = $("#target-line-chart").val();
        loadData(year)
      });
    }

    function drawChart(data, ifExist) {
      let totalIn = data.in.reduce((val, nilaiSekarang) => {
        return val + nilaiSekarang
      }, 0)

      let totalOut = data.out.reduce((val, nilaiSekarang) => {
        return val + nilaiSekarang
      }, 0)

      $('#in').attr('data-num', totalIn).html(new Intl.NumberFormat('id-ID').format(totalIn));
      $('#out').attr('data-num', totalOut).html(new Intl.NumberFormat('id-ID').format(totalOut));

      for (let i = 1; i <= 12; i++) {
        if (data.in[i] == null) {
          data.in[i] = 0;
        }
        if (data.out[i] == null) {
          data.out[i] = 0;
        }
      }
      // console.log(earningChart == undefined)
      if (earningChart != null) {
        // console.log(earningChart);
        earningChart.destroy();
      }
      var lineChartData = {
        labels: ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"],
        datasets: [{
          data: [0, ...data.in],
          // backgroundColor: '#ff0000',
          borderColor: '#417dfc',
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: '#ffffff',
          pointBorderColor: '#417dfc',
          pointHoverRadius: 6,
          pointHoverBorderWidth: 3,
          fill: 'origin',
          label: "Dana Masuk"
        },
        {
          data: [0, ...data.out],
          // backgroundColor: '#417dfc',
          borderColor: '#ff0000',
          borderWidth: 2,
          pointRadius: 3,
          pointBackgroundColor: '#ffffff',
          pointBorderColor: '#ff0000',
          pointHoverRadius: 6,
          pointHoverBorderWidth: 3,
          fill: 'origin',
          label: "Dana Keluar"
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
              stepSize: 1000000,
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
      earningChart = new Chart(earningCanvas, {
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
            console.log(total)
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

    $.ajax({
      type: "GET",
      url: "/getNotice",
      dataType: "JSON",
      success: function (response) {
        // console.log(response)
        var dataEventCalendar = response;
        var event = [];
        // console.log(dataEventCalendar)
        for (var i = 0; i < dataEventCalendar.length; i++) {
          var time_temp = new Date(dataEventCalendar[i].date_event);
          var time = time_temp.getTime();
          var colorCategory;
          switch (response[i].category) {
            case 'Exam': {
              colorCategory = '#ffc107'
            }
              break;
            case 'Pembayaran_Gaji': case 'Pembayaran_SPP': {
              colorCategory = '#28a745'
            }
              break;
            case 'Event': {
              colorCategory = '#dc3545'
            }
              break;
            case 'Pengumuman_Sekolah': {
              colorCategory = '#007bff'
            }
              break;
            default: {

            }
              break;
          }
          event.push({
            title: dataEventCalendar[i].title,
            start: time,
            color: colorCategory,
          })
        }
        console.log(dataEventCalendar)
        if ($.fn.fullCalendar !== undefined) {
          calendarEvent(event);
        }
      }
    });

  });

})(jQuery);
function calendarEvent(event) {
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
    events: event,
    // defaultView: 'ay'
  });
}
/*-------------------------------------
    DataTable Library
-------------------------------------*/
$(document).ready(function () {
  libary = function () {
    Libtable = $("#data_book").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 1, className: "text-start", "orderable": false },
        { "width": "15%", "targets": 2, className: "text-start", "orderable": false },
        { "width": "15%", "targets": 3, className: "text-start", "orderable": false },
        { "width": "15%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 5, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 6, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 7, className: "text-center", "orderable": false },
        { "width": "5%", "targets": 8, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/library/getBook",
        'dataType:': 'json',
        'type': 'get',
      },
      'columns': [
        { 'data': 'No' },
        { 'data': 'code_book' },
        { 'data': 'name_book' },
        { 'data': 'subject' },
        { 'data': 'writer' },
        { 'data': 'class' },
        { 'data': 'published' },
        { 'data': 'creating_date' },
        { 'data': 'aksi' }

      ]


    });

  }
  libary();


  libary = function () {
    Libtable1 = $("#data_bookS").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "targets": 0, className: "text-center", "orderable": false },
        { "targets": 1, className: "text-start", "orderable": false },
        { "targets": 2, className: "text-start", "orderable": false },
        { "targets": 3, className: "text-start", "orderable": false },
        { "targets": 4, className: "text-start", "orderable": false },
        { "targets": 5, className: "text-center", "orderable": false },
        { "targets": 6, className: "text-center", "orderable": false },
        { "targets": 7, className: "text-center", "orderable": false },

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/library/getBookS",
        'dataType:': 'json',
        'type': 'get',
      },
      'columns': [
        { 'data': 'No' },
        { 'data': 'code_book' },
        { 'data': 'name_book' },
        { 'data': 'subject' },
        { 'data': 'writer' },
        { 'data': 'class' },
        { 'data': 'creating_date' },
        { 'data': 'aksi' }

      ]


    });

  }
  libary();

  //GET HAPUS
  $('#show_book').on('click', '.book_remove', function () {
    var id = $(this).attr('data');
    $('#confirmation-book-modal').modal('show');
    $('[name="kode"]').val(id);
  });

  //Hapus Data
  $('#btn_remove_book').on('click', function () {
    var kode = $('#textkode').val();
    $.ajax({
      type: "POST",
      url: "/api/library/delete-book",
      dataType: "JSON",
      data: { kode: kode },
      success: function (data) {
        if (data) {
          $('#confirmation-book-modal').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah dihapus.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })
          Libtable.draw(false)

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }



        //tampil_data_barang();
      }
    });
    return false;
  });

  //Update Buku
  $('#btn_update_book').click(function (e) {
    var id_book = $('#id_book').val();
    var name_book = $('#ebook_name').val();
    var code_book = $('#ecode_book').val();
    var subject = $('#esubject').val();
    var writer_book = $('#ewriter_book').val();
    var class_book = $('#eclass_book').val();
    var publish_date = $('#epublish_date').val();
    var upload_date = $('#eupload_date').val();
    console.log($('#eclass_book').html());
    $.ajax({
      type: "POST",
      url: "/api/library/update-book-detail",
      dataType: "JSON",
      data: { id_book: id_book, name_book: name_book, subject: subject, writer_book: writer_book, class_book: class_book, publish_date: publish_date, upload_date: upload_date, code_book: code_book },
      success: function (data) {
        if (data) {
          $('#detail-book').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah diubah.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })
          Libtable.draw(false)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      }
    });
    return false;
  });

});

$('#show_book').on('click', '.book_detail', function () {
  var id = $(this).attr('data');
  $('#detail-book').modal('show');
  $.ajax({
    type: "GET",
    url: "/" + "api" + "/" + "library" + "/" + id + "/book-detail",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      // $.each(data, function (key, val) {
      // console.log(data);
      $('#detail-book').on('shown.bs.modal', function () {
        $('#ebook_name').focus();
      });
      $('#detail-book').modal('show');
      $('[name="id_book"]').val(data[0].id_book);
      $('[name="ebook_name"]').val(data[0].name_book);
      $('[name="esubject"]').val(data[0].id_subject).change();
      $('[name="ewriter_book"]').val(data[0].writer_book);
      $('[name="eclass_book"]').val(data[0].id_class).change();
      $('[name="epublish_date"]').val(data[0].publish_date);
      $('[name="eupload_date"]').val(data[0].upload_date);
      $('[name="ecode_book"]').val(data[0].code_book);
      // });
    }
  });
  return false;
});

/*-------------------------------------
    DataTable Transport
-------------------------------------*/
$(document).ready(function () {
  transport = function () {
    transTable = $("#data_transport").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "5%", "targets": 1, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 2, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "15%", "targets": 5, className: "text-end", "orderable": false },
        { "width": "15%", "targets": 6, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/transport/getTransport",
        'dataType:': 'json',
        'type': 'get',
      },
      'columns': [
        { 'data': 'No' },
        { 'data': 'id_driver' },
        { 'data': 'route_name' },
        { 'data': 'vehicle_number' },
        { 'data': 'driver_name' },
        { 'data': 'phone_number' },
        { 'data': 'aksi' }

      ]


    });

  }
  transport();

  transportS = function () {
    transTable1 = $("#data_transportS").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "5%", "targets": 1, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 2, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 5, className: "text-center", "orderable": false },
        { "width": "15%", "targets": 6, className: "text-center", "orderable": false },
        // { "width": "15%", "targets": 7, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/transport/getTransportS",
        'dataType:': 'json',
        'type': 'get',
      },
      'columns': [
        { 'data': 'No' },
        { 'data': 'id_driver' },
        { 'data': 'route_name' },
        { 'data': 'vehicle_number' },
        { 'data': 'driver_name' },
        { 'data': 'license_number' },
        { 'data': 'phone_number' },
        // { 'data': 'aksi' }

      ]


    });

  }
  transportS();

  // RESET BUTTON
  $('#reset_transport').click(function (e) {
    e.preventDefault();
    $('#eroute_name').val('');
    $('#eid_driver').val('');
    $('#evehicle_number').val('');
    $('#edriver_name').val('');
    $('#elicense_number').val('');
    $('#ephone_number').val('');
  });

  //GET HAPUS
  $('#show_transport').on('click', '.transport_remove', function () {
    var id = $(this).attr('data');
    $('#confirmation-transport-modal').modal('show');
    $('[name="kode"]').val(id);
  });

  //Hapus Data
  $('#btn_remove_transport').on('click', function () {
    var kode = $('#textkode').val();
    $.ajax({
      type: "POST",
      url: "/api/transport/delete-transport",
      dataType: "JSON",
      data: { kode: kode },
      success: function (data) {
        if (data) {
          $('#confirmation-transport-modal').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah dihapus.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })
          transTable.draw(false)

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }

      }
    });
    return false;
  });

  //Update Transport
  $('#btn_update_transport').click(function (e) {
    var id_transport = $('#id_transport').val();
    var route_name = $('#eroute_name_edit').val();
    var vehicle_number = $('#evehicle_number_edit').val();
    var driver_name = $('#edriver_name_edit').val();
    var license_number = $('#elicense_number_edit').val();
    var phone_number = $('#ephone_number_edit').val();
    var id_driver = $('#eid_driver_edit').val();
    console.log(id_transport)
    // console.log(driver_name)
    // console.log(license_number)
    // console.log(phone_number)
    // console.log(route_name)
    // console.log(id_driver)
    $.ajax({
      type: "POST",
      url: "/api/transport/update-transport-detail",
      dataType: "JSON",
      data: { id_transport: id_transport, route_name: route_name, vehicle_number: vehicle_number, driver_name: driver_name, license_number: license_number, phone_number: phone_number, id_driver: id_driver },
      success: function (data) {
        if (data) {
          $('#detail-transport').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            $('#eroute_name').val('');
            $('#eid_driver').val('');
            $('#evehicle_number').val('');
            $('#edriver_name').val('');
            $('#elicense_number').val('');
            $('#ephone_number').val('');
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah diubah.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })

          transTable.draw(false)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      }
    });
    return false;
  });

  //tambah Data
  $('#btn_add_transport').on('click', function () {
    // var id_transport = $('#id_transport').val();
    var route_name = $('#eroute_name').val();
    var vehicle_number = $('#evehicle_number').val();
    var driver_name = $('#edriver_name').val();
    var license_number = $('#elicense_number').val();
    var phone_number = $('#ephone_number').val();
    var id_driver = $('#eid_driver').val();
    // console.log($('#eroute_name').val())
    $.ajax({
      type: "POST",
      url: "/api/transport/add-transport",
      dataType: "JSON",
      data: { route_name: route_name, vehicle_number: vehicle_number, driver_name: driver_name, license_number: license_number, phone_number: phone_number, id_driver: id_driver },
      success: function (data) {
        if (data) {
          console.log(data)
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            transTable.draw(false)
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah ditambahkan.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )

          })

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }

      }
    });
    return false;
  });

});

$('#show_transport').on('click', '.transport_detail', function () {
  var id = $(this).attr('data');
  $('#detail-transport').modal('show');
  $.ajax({
    type: "GET",
    url: "/" + "api" + "/" + "transport" + "/" + id + "/transport-detail",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      // console.log(data.id_transport);
      $('#detail-transport').on('shown.bs.modal', function () {
        $('#eroute_name_edit').focus();
      });
      $('#detail-transport').modal('show');
      $('[name="id_transport"]').val(data.id_transport);
      $('[name="eroute_name"]').val(data.route_name);
      $('[name="edriver_name"]').val(data.driver_name);
      $('[name="evehicle_number"]').val(data.vehicle_number);
      $('[name="elicense_number"]').val(data.license_number);
      $('[name="ephone_number"]').val(data.phone_number);
      $('[name="eid_driver"]').val(data.id_driver);

    }
  });
  return false;

});

/*-------------------------------------
    DataTable Hostel
-------------------------------------*/
$(document).ready(function () {
  hostel = function () {
    hostelTable = $("#data_hostell").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 1, className: "text-start", "orderable": false },
        { "width": "1%", "targets": 2, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-center", "orderable": false },
        { "width": "1%", "targets": 4, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 5, className: "text-right", "orderable": false },
        { "width": "15%", "targets": 6, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/hostel/getHostel",
        'dataType:': 'json',
        'type': 'get',
      },
      'columns': [
        { 'data': 'No' },
        { 'data': 'hostel_name' },
        { 'data': 'room_number' },
        { 'data': 'room_type' },
        { 'data': 'number_of_bed' },
        { 'data': 'cost_per_bed' },
        { 'data': 'aksi' }

      ]


    });

  }
  hostel();

  hostelS = function () {
    hostelTable1 = $("#data_hostellS").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "targets": 0, className: "text-center", "orderable": false },
        { "targets": 1, className: "text-start", "orderable": false },
        { "targets": 2, className: "text-center", "orderable": false },
        { "targets": 3, className: "text-center", "orderable": false },
        { "targets": 4, className: "text-center", "orderable": false },
        { "targets": 5, className: "text-right", "orderable": false },
        // { "width": "15%", "targets": 6, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/hostel/getHostelS",
        'dataType:': 'json',
        'type': 'get',
      },
      'columns': [
        { 'data': 'No' },
        { 'data': 'hostel_name' },
        { 'data': 'room_number' },
        { 'data': 'room_type' },
        { 'data': 'number_of_bed' },
        { 'data': 'cost_per_bed' },
        // { 'data': 'aksi' }

      ]


    });

  }
  hostelS();

  // RESET BUTTON
  $('#reset_hostel').click(function (e) {
    e.preventDefault();
    $('#ehostel_name').val('');
    $('#eroom_number').val('');
    $('#eroom_type').val('').change();
    $('#enumber_of_bed').val('');
    $('#ecost_per_bed').val('');
  });

  //GET HAPUS
  $('#show_hostel').on('click', '.hostel_remove', function () {
    var id = $(this).attr('data');
    $('#confirmation-hostel-modal').modal('show');
    $('[name="kode"]').val(id);
  });

  //Hapus Data
  $('#btn_remove_hostel').on('click', function () {
    var kode = $('#textkode').val();
    $.ajax({
      type: "POST",
      url: "/api/hostel/delete-hostel",
      dataType: "JSON",
      data: { kode: kode },
      success: function (data) {
        if (data) {
          $('#confirmation-hostel-modal').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah dihapus.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })
          hostelTable.draw(false)

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }

      }
    });
    return false;
  });

  //Update hostel
  $('#btn_update_hostel').click(function (e) {
    var id_hostel = $('#id_hostel').val();
    var hostel_name = $('#ehostel_name_edit').val();
    var room_number = $('#eroom_number_edit').val();
    var room_type = $('#eroom_type_edit').val();
    var number_of_bed = $('#enumber_of_bed_edit').val();
    var cost_per_bed = $('#ecost_per_bed_edit').val();
    // console.log(id_hostel)
    $.ajax({
      type: "POST",
      url: "/api/hostel/update-hostel-detail",
      dataType: "JSON",
      data: { id_hostel: id_hostel, hostel_name: hostel_name, room_number: room_number, room_type: room_type, number_of_bed: number_of_bed, cost_per_bed: cost_per_bed },
      success: function (data) {
        if (data) {
          $('#detail-hostel').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah diubah.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })

          hostelTable.draw(false)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      }
    });
    return false;
  });

  //tambah Data
  $('#btn_add_hostel').on('click', function () {
    // var id_hostel = $('#id_hostel').val();
    var hostel_name = $('#ehostel_name').val();
    var room_number = $('#eroom_number').val();
    var room_type = $('#eroom_type').val();
    var number_of_bed = $('#enumber_of_bed').val();
    var cost_per_bed = $('#ecost_per_bed').val();
    console.log(hostel_name)
    if (hostel_name == ""
      || room_number == ""
      || room_type == ""
      || number_of_bed == ""
      || cost_per_bed == ""
    ) {
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data harus diisi semua!'
      })
    } else {
      $.ajax({
        type: "POST",
        url: "/api/hostel/add-hostel",
        dataType: "JSON",
        data: { hostel_name: hostel_name, room_number: room_number, room_type: room_type, number_of_bed: number_of_bed, cost_per_bed: cost_per_bed },
        success: function (data) {
          if (data) {
            console.log(data)
            let timerInterval
            Swal.fire({
              title: 'Memuat Data...',
              html: 'Tunggu  <b></b>  Detik.',
              timer: 300,
              timerProgressBar: true,
              didOpen: () => {
                Swal.showLoading()
                const b = Swal.getHtmlContainer().querySelector('b')
                timerInterval = setInterval(() => {
                  b.textContent = Swal.getTimerLeft()
                }, 100)
              },
              willClose: () => {
                clearInterval(timerInterval)
              }
            }).then((result) => {
              $('#ehostel_name').val('');
              $('#eroom_number').val('');
              $('#eroom_type').val('').change();
              $('#enumber_of_bed').val('');
              $('#ecost_per_bed').val('');
              hostelTable.draw(false)
              Swal.fire(
                {
                  icon: 'success',
                  title: 'Berhasil',
                  text: 'Data telah ditambahkan.',
                  //footer: '<a href="">Why do I have this issue?</a>'
                }

              )

            })

          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Ada yang eror!',
              //footer: '<a href="">Why do I have this issue?</a>'
            })
          }

        }
      });
    }
    return false;
  });

});

$('#show_hostel').on('click', '.hostel_detail', function () {
  var id = $(this).attr('data');
  $('#detail-hostel').modal('show');
  $.ajax({
    type: "GET",
    url: "/" + "api" + "/" + "hostel" + "/" + id + "/hostel-detail",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      // console.log(data.id_hostel);
      $('#detail-hostel').on('shown.bs.modal', function () {
        $('#ehostel_name_edit').focus();
      });
      $('#detail-hostel').modal('show');
      $('[name="id_hostel"]').val(data.id_hostel);
      $('[name="ehostel_name"]').val(data.hostel_name);
      $('[name="eroom_number"]').val(data.room_number);
      $('[name="eroom_type"]').val(data.room_type).change();
      $('[name="enumber_of_bed"]').val(data.number_of_bed);
      $('[name="ecost_per_bed"]').val(data.cost_per_bed);

    }
  });
  return false;
});

/*-------------------------------------
    DataTable Exam
-------------------------------------*/
$(document).ready(function () {
  exam = function () {
    examTable = $("#data_exam").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 1, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 2, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 5, className: "text-center", "orderable": false },
        { "width": "15%", "targets": 6, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/exam/getExam",
        'dataType:': 'json',
        'type': 'get',
      },

      'columns': [
        { 'data': 'No' },
        { 'data': 'exam_name' },
        { 'data': 'subject_name' },
        { 'data': 'class' },
        { 'data': 'exam_date' },
        { 'data': 'exam_time' },
        { 'data': 'aksi' }
      ]


    });

  }
  exam();

  examS = function () {
    examTable1 = $("#data_examS").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 1, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 2, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 5, className: "text-center", "orderable": false },
        // { "width": "15%", "targets": 6, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/exam/getExamS",
        'dataType:': 'json',
        'type': 'get',
      },

      'columns': [
        { 'data': 'No' },
        { 'data': 'exam_name' },
        { 'data': 'subject_name' },
        { 'data': 'class' },
        { 'data': 'exam_date' },
        { 'data': 'exam_time' },
        // { 'data': 'aksi' }
      ]


    });

  }
  examS();

  // RESET BUTTON
  $('#reset_exam').click(function (e) {
    e.preventDefault();
    $('#eexam_name').val('');
    $('#eclass').val('');
    $('#esubject').val('').change();
    $('#eexam_date').val('');
    $('#eexam_start').val('');
    $('#eexam_end').val('');
  });

  //GET HAPUS
  $('#show_exam').on('click', '.exam_remove', function () {
    var id = $(this).attr('data');
    $('#confirmation-exam-modal').modal('show');
    $('[name="kode"]').val(id);
  });

  //Hapus Data
  $('#btn_remove_exam').on('click', function () {
    var kode = $('#textkode').val();
    $.ajax({
      type: "POST",
      url: "/api/exam/delete-exam",
      dataType: "JSON",
      data: { kode: kode },
      success: function (data) {
        if (data) {
          $('#confirmation-exam-modal').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah dihapus.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })
          examTable.draw(false)

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }

      }
    });
    return false;
  });

  //Update exam
  $('#btn_update_exam').click(function (e) {
    var id_exam = $('#id_exam').val();
    var exam_name = $('#eexam_name_edit').val();
    var id_subject = $('#esubject_edit').val();
    var id_class = $('#eclass_edit').val();
    var exam_date = $('#eexam_date_send').val();
    var exam_start = $('#eexam_start_send').val();
    var exam_end = $('#eexam_end_send').val();
    $.ajax({
      type: "POST",
      url: "/api/exam/update-exam-detail",
      dataType: "JSON",
      data: { id_exam: id_exam, exam_name: exam_name, id_subject: id_subject, id_class: id_class, exam_date: exam_date, exam_start: exam_start, exam_end: exam_end },
      success: function (data) {
        if (data) {
          $('#detail-exam').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah diubah.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
          })

          examTable.draw(false)
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      }
    });
    return false;
  });

  //tambah Data
  $('#btn_add_exam').on('click', function () {
    // var id_exam = $('#id_exam').val();
    var exam_name = $('#eexam_name').val();
    var id_class = $('#eclass').val();
    var id_subject = $('#esubject').val();
    var exam_date = $('#eexam_date').val();
    var exam_start = $('#eexam_start').val();
    var exam_end = $('#eexam_end').val();
    console.log(id_class);
    console.log(id_subject);
    $.ajax({
      type: "POST",
      url: "/api/exam/add-exam",
      dataType: "JSON",
      data: { exam_name: exam_name, id_class: id_class, id_subject: id_subject, exam_date: exam_date, exam_start: exam_start, exam_end: exam_end },
      success: function (data) {
        if (data) {
          console.log(data)
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            $('#eexam_name').val('');
            $('#eclass').val('');
            $('#esubject').val('').change();
            $('#eexam_date').val('');
            $('#eexam_start').val('');
            $('#eexam_end').val('');
            examTable.draw(false)
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah ditambahkan.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )

          })

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }

      }
    });
    z
    return false;
  });

});

$('#show_exam').on('click', '.exam_detail', function () {
  var id = $(this).attr('data');
  $('#detail-exam').modal('show');
  $.ajax({
    type: "GET",
    url: "/" + "api" + "/" + "exam" + "/" + id + "/exam-detail",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      // console.log(data);
      $('#detail-exam').on('shown.bs.modal', function () {
        $('#eexam_name').focus();
      });
      $('#detail-exam').modal('show');
      $('[name="id_exam"]').val(data.id_exam);
      $('[name="eexam_name_edit"]').val(data.exam_name);
      $('[name="esubject"]').val(data.id_subject).change();
      $('[name="eclass"]').val(data.id_class).change();
      $('[name="eexam_date"]').val(data.exam_date);
      $('[name="eexam_start"]').val(data.exam_start);
      $('[name="eexam_end"]').val(data.exam_end);

    }
  });
  return false;
});

/*-------------------------------------
    DataTable Exam Grades
-------------------------------------*/
$(document).ready(function () {
  grade = function () {
    gradeTable = $("#data_grade").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 1, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 2, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 4, className: "text-center", "orderable": false },
        { "width": "5%", "targets": 5, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/exam/getExamGrade",
        'dataType:': 'json',
        'type': 'get',
      },

      'columns': [
        { 'data': 'No' },
        { 'data': 'grade_name' },
        { 'data': 'percent_from' },
        { 'data': 'grade_desc' },
        { 'data': 'grade_point' },
        { 'data': 'aksi' }
      ]


    });

  }
  grade();

  // UNTUK MURID DAN OTU
  grade = function () {
    gradeTable = $("#data_gradeS").on('preXhr.dt', function (e, settings, data) {

      console.log('loading ....');

    }).on('draw.dt', function () {
      console.log('dapat data ....');

    }).DataTable({
      responsive: {
        details: {
          type: 'column'
        }
      },
      "columnDefs": [
        { "width": "1%", "targets": 0, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 1, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 2, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-start", "orderable": false },
        { "width": "5%", "targets": 4, className: "text-center", "orderable": false },
        // { "width": "5%", "targets": 5, className: "text-center", "orderable": false }

      ],
      'pageLength': 10,
      'responsive': true,
      'processing': true,
      'serverSide': true,
      'ajax': {
        'url': "/api/exam/getExamGradeS",
        'dataType:': 'json',
        'type': 'get',
      },

      'columns': [
        { 'data': 'No' },
        { 'data': 'grade_name' },
        { 'data': 'percent_from' },
        { 'data': 'grade_desc' },
        { 'data': 'grade_point' },
        // { 'data': 'aksi' }
      ]


    });

  }
  grade();

  //Update exam
  $('#btn_update_grade').click(function (e) {
    var id_exam_grade = $('#id_exam_grade').val();
    var grade_name = $('#egrade_name').val();
    var grade_point = $('#egrade_point').val();
    var percent_from = $('#egrade_from').val();
    var percent_upto = $('#egrade_upto').val();
    var grade_desc = $('#egrade_desc').val();

    $.ajax({
      type: "POST",
      url: "/api/exam/update-grade-detail",
      dataType: "JSON",
      data: { id_exam_grade: id_exam_grade, grade_name: grade_name, grade_point: grade_point, percent_from: percent_from, percent_upto: percent_upto, grade_desc: grade_desc },
      success: function (data) {
        if (data) {
          $('#detail-grade').modal('hide');
          let timerInterval
          Swal.fire({
            title: 'Memuat Data...',
            html: 'Tunggu  <b></b>  Detik.',
            timer: 300,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              const b = Swal.getHtmlContainer().querySelector('b')
              timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
              }, 100)
            },
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            Swal.fire(
              {
                icon: 'success',
                title: 'Berhasil',
                text: 'Data telah diubah.',
                //footer: '<a href="">Why do I have this issue?</a>'
              }

            )
            gradeTable.draw(false)
          })

        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Ada yang eror!',
            //footer: '<a href="">Why do I have this issue?</a>'
          })
        }
      }
    });
    return false;
  });
});
$('#show_grade').on('click', '.grade_detail', function () {
  var id = $(this).attr('data');
  $('#detail-grade').modal('show');
  $.ajax({
    type: "GET",
    url: "/" + "api" + "/" + "exam" + "/" + id + "/grade-detail",
    dataType: "JSON",
    data: { id: id },
    success: function (data) {
      console.log(data);
      $('#detail-grade').on('shown.bs.modal', function () {
        $('#egrade_name').focus();
      });
      $('#detail-grade').modal('show');
      $('[name="id_exam_grade"]').val(data.id_exam_grade);
      $('[name="grade_name"]').val(data.grade_name);
      $('[name="grade_point"]').val(data.grade_point);
      $('[name="form"]').val(data.percent_from);
      $('[name="upto"]').val(data.percent_upto);
      // $('[name="precentage_from"]').val(data.percent_from);
      // $('[name="precentage_upto"]').val(data.percent_upto);
      $('[name="grade_desc"]').val(data.grade_desc);

    }
  });
  return false;
});



/*-------------------------------------
      Notice Board
  -------------------------------------*/
$(document).ready(function () {
  var data = [];

  function difference2Parts(milliseconds) {
    const secs = Math.floor(Math.abs(milliseconds) / 1000);
    const mins = Math.floor(secs / 60);
    const hours = Math.floor(mins / 60);
    const days = Math.floor(hours / 24);
    const millisecs = Math.floor(Math.abs(milliseconds)) % 1000;
    const multiple = (term, n) => n !== 1 ? `${n} ${term}s` : `1 ${term}`;

    return {
      days: days,
      hours: hours % 24,
      hoursTotal: hours,
      minutesTotal: mins,
      minutes: mins % 60,
      seconds: secs % 60,
      secondsTotal: secs,
      milliSeconds: millisecs,
      get diffStr() {
        return `${multiple(`day`, this.days)}, ${multiple(`hour`, this.hours)}, ${multiple(`minute`, this.minutes)} and ${multiple(`second`, this.seconds)}`;
      },
      get diffStrMs() {
        return `${this.diffStr.replace(` and`, `, `)} and ${multiple(`millisecond`, this.milliSeconds)}`;
      },
    };
  }

  function untilXMas(date) {
    const nextChristmas = new Date(date);
    const report = document.querySelector(`#nextXMas`);

    const diff = () => {
      const diffs = difference2Parts(nextChristmas - new Date());
      report.innerHTML = `Awaiting next XMas 🙂 (${diffs.diffStrMs.replace(/(\d+)/g, a => `<b>${a}</b>`)})<br>
            <br>In other words, until next XMas lasts&hellip;<br>
            In minutes: <b>${diffs.minutesTotal}</b><br>In hours: <b>${diffs.hoursTotal}</b><br>In seconds: <b>${diffs.secondsTotal}</b>`;
      setTimeout(diff, 200);
    };
    return difference2Parts(nextChristmas - new Date());
  }

  function drawNotice(s) {
    //console.log(s);
    const months = ["Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
      "September", "Oktober", "November", "Desember"
    ];
    // drawNotice();
    $.ajax({
      type: "GET",
      url: "/getNotice",
      dataType: "JSON",
      success: function (response) {
        //console.log(response[0])
        $('#notice-list').empty();
        $.each(response, function (i, data) {
          data += data[i]
          var dAwal = new Date(response[i].date_notice)
          var bulan = months[dAwal.getMonth()];
          var tanggal = dAwal.getDate();
          var tahun = dAwal.getFullYear();
          var minus = untilXMas(dAwal);
          //console.log(minus)
          //console.log(minus.minutesTotal);
          var difference;
          if (minus.minutesTotal <= 60) {
            difference = minus.minutesTotal + ' menit lalu';
          } else if (minus.hoursTotal <= 24) {
            difference = minus.hoursTotal + ' jam lalu';
          } else {
            difference = minus.days + ' hari lalu';
          }

          console.log('response[i].category')
          var classCategory;
          switch (response[i].category) {
            case 'Exam': {
              classCategory = 'bg-warning'
            }
              break;
            case 'Pembayaran_Gaji': case 'Pembayaran_SPP': {
              classCategory = 'bg-success'
            }
              break;
            case 'Event': {
              classCategory = 'bg-danger'
            }
              break;
            case 'Pengumuman_Sekolah': {
              classCategory = 'bg-primary'
            }
              break;
            default: {

            }
              break;
          }
          $('#notice-list').append(
            '<div class="notice-list noticeBoardToModal" data-id="' +
            response[i].id_notification +
            '" data-toggle="modal" data-target="#noticeModal"><div class="post-date ' +
            classCategory + '">' +
            tanggal + ' ' + bulan + ', ' + tahun +
            '</div><h6 class="notice-title"><a href="#">' + response[i]
              .title +
            '</a></h6> <div class="entry-meta">  ' + response[i]
              .posted_by +
            ' / <span>' + difference + '</span></div></div>')
        });
      },
      complete: function () { }
    });
  };
  drawNotice();

  $('#noticeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('id') // Extract info from data-* attributes
    const months = ["Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
      "September", "Oktober", "November", "Desember"
    ];
    // console.log(recipient);
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    $.ajax({
      type: "GET",
      url: "/getNoticeDetails",
      data: {
        id: recipient
      },
      dataType: "JSON",
      success: function (response) {
        //console.log(response)
        var dAwal = new Date(response[0].date_notice)
        var bulan = months[dAwal.getMonth()];
        var tanggal = dAwal.getDate();
        var tahun = dAwal.getFullYear();
        var minus = untilXMas(dAwal);
        //console.log(minus)
        //console.log(minus.minutesTotal);
        var difference;
        if (minus.minutesTotal <= 60) {
          difference = minus.minutesTotal + ' menit lalu';
        } else if (minus.hoursTotal <= 24) {
          difference = minus.hoursTotal + ' jam lalu';
        } else {
          difference = minus.days + ' hari lalu';
        }

        //console.log(response[i].category)
        var classCategory;
        switch (response[0].category) {
          case 'Exam': {
            classCategory = 'bg-warning'
          }
            break;
          case 'Pembayaran_Gaji': case 'Pembayaran_SPP': {
            classCategory = 'bg-success'
          }
            break;
          case 'Event': {
            classCategory = 'bg-danger'
          }
            break;
          case 'Pengumuman_Sekolah': {
            classCategory = 'bg-primary'
          }
            break;
          default: {

          }
            break;
        }
        var modal = $(this)
        $('#noticeDetailModal').empty()
        console.log($('#noticeDetailModal').html())
        $('#noticeDetailModal').append('<div class="notice-list noticeBoardToModal" data-id="' +
          response[0].id_notification +
          '" data-toggle="modal" data-target="#noticeModal"><div class="post-date ' +
          classCategory + '">' +
          tanggal + ' ' + bulan + ', ' + tahun +
          '</div><h6 class="notice-title"><a href="#">' + response[0]
            .title +
          '</a></h6> <p>' + response[0].details + '</p> <div class="entry-meta">  ' + response[0]
            .posted_by +
          ' / <span>' + difference + '</span></div></div>');
      }
    });
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

  })
  $('#resetFormNoticeBoard').click(function (e) {
    e.preventDefault();
    $('#categoryNoticeBoard').val('').change();
    $('#titleNoticeBoard').val('');
    $('#detailsNoticeBoard').val('');

  });
})

/*-------------------------------------
    Date Format
-------------------------------------*/
//GET Details
function dateFormat(inputDate, format) {
  //parse the input date
  const date = new Date(inputDate);

  //extract the parts of the date
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();

  //replace the month
  format = format.replace("MM", month.toString().padStart(2, "0"));

  //replace the year
  if (format.indexOf("yyyy") > -1) {
    format = format.replace("yyyy", year.toString());
  } else if (format.indexOf("yy") > -1) {
    format = format.replace("yy", year.toString().substr(2, 2));
  }

  //replace the day
  format = format.replace("dd", day.toString().padStart(2, "0"));

  return format;
}


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
  $("#guru").select2({
    ajax: {
        url: "/api/get-guru",
        method: "get",
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
          params.page = params.page || 1;
          // console.log(data)
          var results = [];
          $.each(data, function(k, v) {
            // console.log(v.id_user);
              results.push({
                  id: v.id_user,
                  text: v.first_name+ ' '+ v.last_name,
                 
              });
          });

          return {
              results: results,
              // pagination:
              // {
              //     more: true
              // }
          };
            // return {
            //     results: data
            // };
        },
        cache: true
    },
    placeholder: "Pilih Guru",
}).ready(function () {
    // $(".select2-selection__placeholder").text("Enter a User ID or Name")
})

$("#get-ortu").select2({
  ajax: {
      url: "/api/get-ortu",
      method: "get",
      data: function (params) {
          return {
              q: params.term,
              page: params.page
          };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        console.log(data)
        var results = [];
        $.each(data, function(k, v) {
          // console.log(v.id_user);
            results.push({
                id: v.id_user,
                text: v.first_name+ ' '+ v.last_name,
               
            });
        });

        return {
            results: results,
            // pagination:
            // {
            //     more: true
            // }
        };
          // return {
          //     results: data
          // };
      },
      cache: true
  },
  // placeholder: "Pilih Orang Tua",
}).ready(function () {
  // $(".select2-selection__placeholder").text("Enter a User ID or Name")
})
$("#get-siswa").select2({
  ajax: {
      url: "/api/get-siswa",
      method: "get",
      data: function (params) {
          return {
              q: params.term,
              page: params.page
          };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        console.log(data)
        var results = [];
        $.each(data, function(k, v) {
          // console.log(v.id_user);
            results.push({
                id: v.id_user,
                text: v.first_name+ ' '+ v.last_name,
               
            });
        });

        return {
            results: results,
            // pagination:
            // {
            //     more: true
            // }
        };
          // return {
          //     results: data
          // };
      },
      cache: true
  },
  // placeholder: "Pilih Orang Tua",
}).ready(function () {
  // $(".select2-selection__placeholder").text("Enter a User ID or Name")
})
$("#nameMessageForm").select2({
  ajax: {
      url: "/api/get-all",
      method: "get",
      data: function (params) {
          return {
              q: params.term,
              page: params.page
          };
      },
      processResults: function (data, params) {
        params.page = params.page || 1;
        console.log(data)
        var results = [];
        $.each(data, function(k, v) {
          // console.log(v.id_user);
            results.push({
                id: v.id_user,
                text: v.first_name+ ' '+ v.last_name,
               
            });
        });

        return {
            results: results,
            // pagination:
            // {
            //     more: true
            // }
        };
          // return {
          //     results: data
          // };
      },
      cache: true
  },
  // placeholder: "Pilih Orang Tua",
}).ready(function () {
  // $(".select2-selection__placeholder").text("Enter a User ID or Name")
})
  
  

  

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


