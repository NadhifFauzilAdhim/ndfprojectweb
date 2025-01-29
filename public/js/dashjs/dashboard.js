$(function () {
  var visitData = visitDataGlobal;
  var chart = {
      series: [
          {
              name: "Visits",
              data: visitData,
          }
      ],
      chart: {
          toolbar: {
              show: false,
          },
          type: "area",
          fontFamily: "inherit",
          foreColor: "#adb0bb",
          height: 320,
          animations: {
              enabled: true,
              easing: "easeinout",
              speed: 800,
          },
      },
      colors: ["#007bff"], 
      stroke: {
          width: 3,
          curve: "smooth",
      },
      markers: {
          size: 5,
          colors: ["#ffffff"], // Warna putih untuk isi marker
          strokeColors: "#007bff", // Warna biru untuk pinggiran marker
          strokeWidth: 2,
          hover: {
              size: 7,
          },
      },
      dataLabels: {
          enabled: false,
      },
      legend: {
          show: true,
          position: "top",
          horizontalAlign: "right",
          markers: {
              radius: 12,
          },
      },
      grid: {
          borderColor: "rgba(0,0,0,0.1)",
          strokeDashArray: 3,
          xaxis: {
              lines: {
                  show: true,
              },
          },
          yaxis: {
              lines: {
                  show: true,
              },
          },
      },
      xaxis: {
          axisBorder: {
              show: false,
          },
          axisTicks: {
              show: false,
          },
          categories: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
      },
      yaxis: {
          tickAmount: 5,
          labels: {
              formatter: function(val) {
                  return val + "k"; 
              },
          },
      },
      tooltip: {
          theme: "dark",
          x: {
              show: true,
          },
          y: {
              formatter: function(val) {
                  return val + " Visits";
              },
          },
      },
      fill: {
          type: "gradient",
          gradient: {
              shade: "light",
              type: "vertical",
              shadeIntensity: 0.25,
              gradientToColors: ["#80d0ff"], 
              inverseColors: true,
              opacityFrom: 1,
              opacityTo: 0.3,
          },
      },
  };
  
  var chart = new ApexCharts(
      document.querySelector("#traffic-overview"),
      chart
  );
  chart.render();
});

document.addEventListener("DOMContentLoaded", function() {
  const toastElList = [].slice.call(document.querySelectorAll('.toast'));
  const toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl);
  });
  toastList.forEach(toast => toast.show());
});