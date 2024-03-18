document.addEventListener('DOMContentLoaded', function() {
    fetch('/graficoAcoes')
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById('graficoPizza').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.datasets[0].data,
                        backgroundColor: data.datasets[0].backgroundColor,
                        borderColor: data.datasets[0].borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' 
                            }
                        }
                    }
                }
            });
        });
});

document.addEventListener('DOMContentLoaded', function() {
    fetch('/graficoFiis')
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById('graficoPizza2').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.datasets[0].data,
                        backgroundColor: data.datasets[0].backgroundColor,
                        borderColor: data.datasets[0].borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' 
                            }
                        }
                    }
                }
            });
        });
});

document.addEventListener('DOMContentLoaded', function() {
    fetch('/graficoTotal')
        .then(response => response.json())
        .then(data => {
            var ctx = document.getElementById('graficoPizza3').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.datasets[0].data,
                        backgroundColor: data.datasets[0].backgroundColor,
                        borderColor: data.datasets[0].borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' 
                            }
                        }
                    }
                }
            });
        });
});
