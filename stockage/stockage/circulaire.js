// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

console.log("nombreMetal1");
var nombreMetal1 = document.getElementById("nombreMetal1").value;
var nombreNiambour = document.getElementById("nombreNiambour").value;
var nombreCranteuse = document.getElementById("nombreCranteuse").value;
var nombreTrefilage = document.getElementById("nombreTrefilage").value;
var nombreMbao = document.getElementById("nombreMbao").value;
console.log(nombreMetal1);

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["METAL 1", "METAL MBAO", "NIAMBOUR", "MACHINE CRANTEUSE", "MACHINE TREFILAGE"],
    datasets: [{
      data: [nombreMetal1, nombreMbao, nombreNiambour, nombreCranteuse, nombreTrefilage],
      backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#1cc99a', '#11b9cc'],
      hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#17a689', '#2c9aaf'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});


var chart = new CanvasJS.Chart("myPieChart", {
	animationEnabled: true,
	title:{
		text: "Email Categories",
		horizontalAlign: "left"
	},
	data: [{
		type: "doughnut",
		startAngle: 60,
		//innerRadius: 60,
		indexLabelFontSize: 17,
		indexLabel: "{label} - #percent%",
		toolTipContent: "<b>{label}:</b> {y} (#percent%)",
		dataPoints: [
			{ y: 67, label: "Inbox" },
			{ y: 28, label: "Archives" },
			{ y: 10, label: "Labels" },
			{ y: 7, label: "Drafts"},
			{ y: 15, label: "Trash"},
			{ y: 6, label: "Spam"}
		]
	}]
});
chart.render();
