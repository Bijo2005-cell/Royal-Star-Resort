<?php
// No session check is needed for this standalone version.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Salary Details - Royal Star Resort</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Fauna+One&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
   <link rel="stylesheet" href="../Styling&Scripts/style.css">
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container">
                <a class="navbar-brand" >Royal <span>Star</span> Resort</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                           <h1>Salary Details</h1>
                        </li>
                    </ul>
                </div>
                </div>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-5">
                <div class="card1 profile-card">
                    <div class="card-body1 text-center">
                        <img id="employeePhoto" src="https://placehold.co/120x120/8B4513/FFFFFF?text=JS" alt="Employee Photo" class="profile-img mb-3">
                        <h2 id="employeeName" class="profile-name"></h2>
                        <p id="employeePosition" class="text-muted fs-5"></p>
                        <div class="profile-details text-start mt-4">
                            <p><strong>Employee ID:</strong> <span id="employeeId"></span></p>
                            <p><strong>Department:</strong> <span id="employeeDepartment"></span></p>
                        </div>
                    </div>
                </div>

                <div class="card-body1">
                    <div class="card-header1" id="currentSalaryHeader">
                        Salary Details - July 2025
                    </div>
                    <div class="card-body1 p-4">
                        <div id="currentSalaryBreakdown">
                            </div>
                        <div class="text-center mt-4">
                            <button id="downloadSlipBtn" class="btn btn-gold w-100">
                                <i class="bi bi-download me-2"></i>Download Salary Slip
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="card-body1">
                    <div class="card-header">
                        Salary History (Last 6 Months)
                    </div>
                    <div class="card-body1">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Basic Salary</th>
                                        <th>Net Salary</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody id="salaryHistoryTable">
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body1">
                    <div class="card-header1">
                        Net Salary Trend
                    </div>
                    <div class="card-body1">
                        <canvas id="salaryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- DATA (Hardcoded for demonstration) ---
            const employeeData = {
                id: 'RSR-001',
                name: 'Noyal Jaison',
                position: 'General Manager',
                department: 'Management',
                photoUrl: 'https://placehold.co/120x120/8B4513/FFFFFF?text=NJ',
                salaryHistory: [
                    { month: 'February 2025', basic: 120000, allowances: 18000, deductions: 5000, date: '2025-02-28', method: 'Bank Transfer' },
                    { month: 'March 2025', basic: 120000, allowances: 18000, deductions: 5000, date: '2025-03-31', method: 'Bank Transfer' },
                    { month: 'April 2025', basic: 120000, allowances: 18000, deductions: 5000, date: '2025-04-30', method: 'Bank Transfer' },
                    { month: 'May 2025', basic: 120000, allowances: 20000, deductions: 5000, date: '2025-05-31', method: 'Bank Transfer' },
                    { month: 'June 2025', basic: 120000, allowances: 20000, deductions: 5000, date: '2025-06-30', method: 'Bank Transfer' },
                    { month: 'July 2025', basic: 120000, allowances: 20000, deductions: 5000, date: '2025-07-31', method: 'Bank Transfer' },
                ]
            };
            const currentSalary = employeeData.salaryHistory[employeeData.salaryHistory.length - 1];

            // --- UTILITY FUNCTIONS ---
            const formatCurrency = (amount) => `₹${amount.toLocaleString('en-IN')}`;
            const calculateNetSalary = (basic, allowances, deductions) => basic + allowances - deductions;

            // --- POPULATE UI FUNCTIONS ---

            // Populate Profile Card
            function populateProfile() {
                document.getElementById('employeePhoto').src = employeeData.photoUrl;
                document.getElementById('employeeName').textContent = employeeData.name;
                document.getElementById('employeePosition').textContent = employeeData.position;
                document.getElementById('employeeId').textContent = employeeData.id;
                document.getElementById('employeeDepartment').textContent = employeeData.department;
            }

            // Populate Current Salary Card
            function populateCurrentSalary() {
                const netSalary = calculateNetSalary(currentSalary.basic, currentSalary.allowances, currentSalary.deductions);
                document.getElementById('currentSalaryHeader').textContent = `Salary Details - ${currentSalary.month}`;
                const breakdownDiv = document.getElementById('currentSalaryBreakdown');
                breakdownDiv.innerHTML = `
                    <div class="salary-item">
                        <span class="label">Basic Salary</span>
                        <span class="value">${formatCurrency(currentSalary.basic)}</span>
                    </div>
                    <div class="salary-item">
                        <span class="label">Allowances</span>
                        <span class="value">${formatCurrency(currentSalary.allowances)}</span>
                    </div>
                    <div class="salary-item">
                        <span class="label">Deductions</span>
                        <span class="value text-danger">-${formatCurrency(currentSalary.deductions)}</span>
                    </div>
                     <div class="salary-item mt-3 p-2 net-salary">
                        <span class="label">Net Salary</span>
                        <span class="value">${formatCurrency(netSalary)}</span>
                    </div>
                    <div class="salary-item">
                        <span class="label">Payment Date</span>
                        <span class="value">${currentSalary.date}</span>
                    </div>
                    <div class="salary-item">
                        <span class="label">Payment Method</span>
                        <span class="value">${currentSalary.method}</span>
                    </div>
                `;
            }

            // Populate Salary History Table
            function populateSalaryHistory() {
                const tableBody = document.getElementById('salaryHistoryTable');
                tableBody.innerHTML = '';
                // Show in reverse chronological order
                [...employeeData.salaryHistory].reverse().forEach(record => {
                    const net = calculateNetSalary(record.basic, record.allowances, record.deductions);
                    const row = `
                        <tr>
                            <td>${record.month}</td>
                            <td>${formatCurrency(record.basic)}</td>
                            <td><strong>${formatCurrency(net)}</strong></td>
                            <td>${record.date}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }

            // Render Salary Trend Chart
            function renderChart() {
                const ctx = document.getElementById('salaryChart').getContext('2d');
                const labels = employeeData.salaryHistory.map(s => s.month.split(' ')[0]);
                const data = employeeData.salaryHistory.map(s => calculateNetSalary(s.basic, s.allowances, s.deductions));

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Net Salary (₹)',
                            data: data,
                            borderColor: '#8B4513',
                            backgroundColor: 'rgba(139, 69, 19, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: false,
                                ticks: {
                                    callback: function(value, index, values) {
                                        return '₹' + (value / 1000) + 'k';
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // --- PDF DOWNLOAD FUNCTIONALITY ---
            function downloadSalarySlip() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                const netSalary = calculateNetSalary(currentSalary.basic, currentSalary.allowances, currentSalary.deductions);

                // Header
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(22);
                doc.setTextColor('#8B4513');
                doc.text('Royal Star Resort', 105, 20, null, null, 'center');
                
                doc.setFontSize(16);
                doc.setTextColor('#333');
                doc.text(`Salary Slip - ${currentSalary.month}`, 105, 30, null, null, 'center');
                
                doc.setLineWidth(0.5);
                doc.setDrawColor('#D4AF37');
                doc.line(20, 35, 190, 35);

                // Employee Details
                doc.setFontSize(12);
                doc.setFont('helvetica', 'bold');
                doc.text('Employee Details', 20, 45);
                doc.setFont('helvetica', 'normal');
                doc.text(`Name: ${employeeData.name}`, 20, 55);
                doc.text(`Employee ID: ${employeeData.id}`, 20, 62);
                doc.text(`Position: ${employeeData.position}`, 20, 69);
                doc.text(`Payment Date: ${currentSalary.date}`, 130, 55);
                
                doc.line(20, 80, 190, 80);

                // Earnings and Deductions
                doc.setFont('helvetica', 'bold');
                doc.text('Earnings', 40, 90);
                doc.text('Amount (₹)', 100, 90);
                doc.text('Deductions', 140, 90);
                doc.text('Amount (₹)', 180, 90, null, null, 'right');
                
                doc.setFont('helvetica', 'normal');
                doc.text('Basic Salary', 40, 100);
                doc.text(currentSalary.basic.toLocaleString('en-IN'), 100, 100);
                doc.text('Allowances', 40, 107);
                doc.text(currentSalary.allowances.toLocaleString('en-IN'), 100, 107);

                doc.text('Standard Deductions', 140, 100);
                doc.text(currentSalary.deductions.toLocaleString('en-IN'), 180, 100, null, null, 'right');

                doc.line(20, 125, 190, 125);
                
                // Totals
                const totalEarnings = currentSalary.basic + currentSalary.allowances;
                doc.setFont('helvetica', 'bold');
                doc.text('Total Earnings', 40, 135);
                doc.text(totalEarnings.toLocaleString('en-IN'), 100, 135);
                doc.text('Total Deductions', 140, 135);
                doc.text(currentSalary.deductions.toLocaleString('en-IN'), 180, 135, null, null, 'right');

                // Net Salary
                doc.setFontSize(14);
                doc.setFillColor('#f1eadd');
                doc.rect(20, 145, 170, 10, 'F');
                doc.setTextColor('#8B4513');
                doc.text('Net Salary Payable', 25, 152);
                doc.text(formatCurrency(netSalary), 185, 152, null, null, 'right');

                // Footer
                doc.setFontSize(10);
                doc.setTextColor('#999');
                doc.text('This is a computer-generated salary slip and does not require a signature.', 105, 280, null, null, 'center');

                doc.save(`Salary_Slip_${employeeData.name.replace(' ', '_')}_${currentSalary.month}.pdf`);
            }

            document.getElementById('downloadSlipBtn').addEventListener('click', downloadSalarySlip);

            // --- INITIALIZE PAGE ---
            populateProfile();
            populateCurrentSalary();
            populateSalaryHistory();
            renderChart();
        });
    </script>
</body>
</html>