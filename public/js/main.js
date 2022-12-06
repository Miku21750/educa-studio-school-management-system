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
          data: [0, 50000, 20000, 30000, 70000, 80000, 40000, 60000, 30000, 60000, 70000, 40000, 30000],
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
          data: [0, 50000, 20000, 30000, 70000, 100000, 40000, 60000, 30000, 60000, 70000, 40000, 30000],
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
        { "width": "5%", "targets": 1, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 2, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 5, className: "text-center", "orderable": false },
        { "width": "15%", "targets": 6, className: "text-center", "orderable": false },
        { "width": "5%", "targets": 7, className: "text-center", "orderable": false },
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
        { 'data': 'vehicle_number' },
        { 'data': 'vehicle_number' },
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
    var id_transport = $('#id_transport').val();
    var route_name = $('#eroute_name').val();
    var vehicle_number = $('#evehicle_number').val();
    var driver_name = $('#ecategory_book').val();
    var license_number = $('#ewriter_book').val();
    var phone_number = $('#eclass_book').val();
    var id_driver = $('#epublish_date').val();
    var upload_date = $('#eupload_date').val();
    // console.log(id_transport)
    // console.log(driver_name)
    // console.log(license_number)
    // console.log(phone_number)
    // console.log(route_name)
    // console.log(id_driver)
    // console.log(upload_date)
    $.ajax({
      type: "POST",
      url: "/api/library/update-book-detail",
      dataType: "JSON",
      data: { id_transport: id_transport, route_name: route_name, vehicle_number: vehicle_number, driver_name: driver_name, license_number: license_number, phone_number: phone_number, id_driver: id_driver, upload_date: upload_date },
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
      console.log(data[0]);
      $('#detail-book').modal('show');
      $('[name="id_transport"]').val(data.id_transport);
      $('[name="eroute_name"]').val(data.name_book);
      $('[name="evehicle_number"]').val(data.name_book);
      $('[name="ecategory_book"]').val(data.category_book);
      $('[name="ewriter_book"]').val(data.writer_book);
      $('[name="eclass_book"]').val(data.class_book);
      $('[name="epublish_date"]').val(data.id_driver);
      $('[name="eupload_date"]').val(data.upload_date);
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
        { "width": "5%", "targets": 1, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 2, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 3, className: "text-center", "orderable": false },
        { "width": "10%", "targets": 4, className: "text-start", "orderable": false },
        { "width": "10%", "targets": 5, className: "text-center", "orderable": false },
        { "width": "15%", "targets": 6, className: "text-center", "orderable": false },
        { "width": "15%", "targets": 7, className: "text-center", "orderable": false }

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
        { 'data': 'license_number' },
        { 'data': 'phone_number' },
        { 'data': 'aksi' }

      ]


    });

  }
  transport();

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

  //Update Buku
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
      $('#detail-book').modal('show');
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