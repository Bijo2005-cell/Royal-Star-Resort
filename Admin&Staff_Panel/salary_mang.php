<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Management - Royal Star Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
    <style>
        /* FIX: Modal Layering (z-index) Issue */
        .modal-backdrop {
            z-index: 1050 !important;
        }

        .modal {
            z-index: 1051 !important;
            background-color:white;
        }

        /* ADDED: Print Stylesheet */
        @media print {
            body {
                background-color: #fff;
                font-size: 10pt;
            }
            /* Hide non-essential elements */
            nav.navbar,
            header .btn-toolbar,
            .row.mb-3, /* Hides the search bar */
            .modal,
            .modal-backdrop,
            .bonus-calculator,
            table th:last-child, /* Hides "Actions" header */
            table td:last-child  /* Hides "Actions" buttons in each row */
            {
                display: none !important;
            }

            main.container-fluid {
                padding: 0; margin: 0; max-width: 100%;
            }
            
            header.border-bottom {
                border: none !important;
                text-align: center;
            }
            h1.page-title {
                font-size: 18pt;
                margin-bottom: 20px !important;
            }

            .table-responsive { overflow: visible !important; }
            .table {
                width: 100% !important;
                border-collapse: collapse !important;
                font-size: 9pt;
            }
            .table th, .table td {
                border: 1px solid #666 !important;
                padding: 5px !important;
            }
            
            section.mt-5 {
                margin-top: 30px !important;
                page-break-before: auto;
            }
            h2.page-title.h3 {
                font-size: 14pt;
                text-align: center;
            }
            .card {
                box-shadow: none !important;
                border: 1px solid #ccc !important;
                page-break-inside: avoid !important;
            }
            
            @page {
                margin: 0.75in;
                size: A4 portrait;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light"><div class="container"><a class="navbar-brand">Royal <span>Star</span> Resort</a></div></nav>

<main class="container-fluid my-4">
    <header class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 page-title">Employee Salary Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#salaryModal" id="addRecordBtn"><i class="bi bi-plus-circle me-1"></i> Add Salary Record</button>
            <button type="button" class="btn btn-outline-secondary ms-2" id="printReportBtn"><i class="bi bi-printer me-1"></i> Print Report</button>
        </div>
    </header>

    <div class="row mb-3"><div class="col-md-4"><input type="text" id="searchInput" class="form-control" placeholder="Search by name or position..."></div></div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="text-uppercase">
                <tr><th>Emp. ID</th><th>Name</th><th>Position</th><th>Basic Salary</th><th>Allowances</th><th>Deductions</th><th>Net Salary</th><th>Last Payment</th><th>Actions</th></tr>
            </thead>
            <tbody id="salaryTableBody"></tbody>
        </table>
    </div>

    <section class="mt-5">
        <h2 class="page-title h3 mb-3">Recent Salary History (Last 6 Months)</h2>
        <div id="monthlyHistoryContainer"></div>
    </section>
</main>

<div class="modal fade" id="salaryModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <form id="salaryForm" class="needs-validation" novalidate>
                <div class="modal-header"><h5 class="modal-title" id="modalTitle">Add Salary Record</h5><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <div class="modal-body">
                    <input type="hidden" id="employeeIdField">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Employee & Salary Details</h5><hr>
                            <div class="row">
                                <div class="col-md-6 mb-3"><label for="employeeIdInput" class="form-label">Employee ID</label><input type="text" class="form-control" id="employeeIdInput" required></div>
                                <div class="col-md-6 mb-3"><label for="employeeName" class="form-label">Employee Name</label><input type="text" class="form-control" id="employeeName" required></div>
                                <div class="col-md-6 mb-3"><label for="employeePosition" class="form-label">Position</label><input type="text" class="form-control" id="employeePosition" required></div>
                                <div class="col-md-6 mb-3"><label for="paymentDate" class="form-label">Payment Date</label><input type="date" class="form-control" id="paymentDate" required></div>
                                <div class="col-md-4 mb-3"><label for="basicSalary" class="form-label">Basic Salary (₹)</label><input type="number" class="form-control" id="basicSalary" required min="0"></div>
                                <div class="col-md-4 mb-3"><label for="allowances" class="form-label">Allowances (₹)</label><input type="number" class="form-control" id="allowances" required min="0"></div>
                                <div class="col-md-4 mb-3"><label for="deductions" class="form-label">Deductions (₹)</label><input type="number" class="form-control" id="deductions" required min="0"></div>
                                <div class="col-12" id="calculationBreakdown"></div>
                                <div class="col-12 mb-3 mt-3"><label for="netSalary" class="form-label">Net Salary (₹)</label><input type="text" class="form-control" id="netSalary" readonly disabled></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bonus-calculator h-100">
                                <h6><i class="bi bi-calculator-fill me-2"></i>Manual Bonus</h6><hr>
                                <div class="mb-3"><label for="bonusAmount" class="form-label">Bonus Amount (₹)</label><input type="number" class="form-control form-control-sm" id="bonusAmount" min="0"></div>
                                <button type="button" class="btn btn-sm btn-outline-success w-100" id="addBonusBtn">Add Bonus to Allowances</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary" id="saveBtn">Save Record</button></div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="historyModalTitle">Salary History</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><p>Showing salary history for the last 6 months.</p><div class="table-responsive"><table class="table table-sm"><thead><tr><th>Payment Date</th><th>Basic Salary</th><th>Allowances</th><th>Deductions</th><th>Net Salary</th></tr></thead><tbody id="historyTableBody"></tbody></table></div></div></div></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('salaryTableBody');
    const monthlyHistoryContainer = document.getElementById('monthlyHistoryContainer');
    const salaryModal = new bootstrap.Modal(document.getElementById('salaryModal'));
    const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
    const modalForm = document.getElementById('salaryForm');
    const searchInput = document.getElementById('searchInput');
    const basicInput = document.getElementById('basicSalary');
    const allowancesInput = document.getElementById('allowances');
    const deductionsInput = document.getElementById('deductions');
    const netSalaryInput = document.getElementById('netSalary');
    
    // ADDED: Print Button Functionality
    const printBtn = document.getElementById('printReportBtn');
    if (printBtn) {
        printBtn.addEventListener('click', () => {
            window.print();
        });
    }

    const formatCurrency = (num) => `₹${parseFloat(num).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    const fetchAllData = () => { fetchEmployees(); fetchMonthlySummary(); };
    const fetchEmployees = () => { fetch(`../Admin&Staff_APIs/api_salary.php?action=fetch_employees&search=${searchInput.value}`).then(res => res.json()).then(data => renderTable(data)); };
    const fetchMonthlySummary = () => { fetch(`../Admin&Staff_APIs/api_salary.php?action=fetch_monthly_summary`).then(res => res.json()).then(data => renderHistorySection(data)); };

    const renderHistorySection = (summaryData) => {
        monthlyHistoryContainer.innerHTML = '';
        if (summaryData.length === 0) { monthlyHistoryContainer.innerHTML = `<p class="text-center text-muted">No salary payments in the last 6 months.</p>`; return; }
        summaryData.forEach(monthData => {
            const date = new Date(monthData.month + '-02');
            const monthYear = date.toLocaleString('default', { month: 'long', year: 'numeric' });
            const cardHtml = `<div class="card mb-3 shadow-sm"><div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap"><h5 class="mb-0 me-3">${monthYear}</h5><strong class="text-success fs-5">Total Paid: ${formatCurrency(monthData.total_paid)}</strong></div><div class="card-body"><div class="row text-center"><div class="col-md-4 mb-2 mb-md-0"><h6 class="text-muted">Employees Paid</h6><p class="fs-4 mb-0">${monthData.employees_paid}</p></div><div class="col-md-4 mb-2 mb-md-0"><h6 class="text-muted">Total Allowances</h6><p class="fs-4 mb-0 text-primary">${formatCurrency(monthData.total_allowances)}</p></div><div class="col-md-4 mb-2 mb-md-0"><h6 class="text-muted">Total Deductions</h6><p class="fs-4 mb-0 text-danger">${formatCurrency(monthData.total_deductions)}</p></div></div></div></div>`;
            monthlyHistoryContainer.insertAdjacentHTML('beforeend', cardHtml);
        });
    };

    const renderTable = (employeeData) => {
        tableBody.innerHTML = '';
        if (employeeData.length === 0) { tableBody.innerHTML = `<tr><td colspan="9" class="text-center">No staff records found.</td></tr>`; return; }
        employeeData.forEach(emp => {
            const hasSalary = emp.basic_salary !== null;
            const netSalary = hasSalary ? parseFloat(emp.basic_salary) + parseFloat(emp.allowances) - parseFloat(emp.deductions) : 0;
            const row = `<tr><td>${emp.emp_id}</td><td>${emp.name}</td><td>${emp.position || '<span class="text-muted">Not Set</span>'}</td><td>${hasSalary ? formatCurrency(emp.basic_salary) : '<span class="text-muted">N/A</span>'}</td><td>${hasSalary ? formatCurrency(emp.allowances) : '<span class="text-muted">N/A</span>'}</td><td>${hasSalary ? formatCurrency(emp.deductions) : '<span class="text-muted">N/A</span>'}</td><td><strong>${hasSalary ? formatCurrency(netSalary) : '<span class="text-muted">N/A</span>'}</strong></td><td>${emp.payment_date || '<span class="text-muted">N/A</span>'}</td><td><button class="btn btn-sm btn-outline-info" title="View History" onclick="viewHistory(${emp.id}, '${emp.name}')"><i class="bi bi-clock-history"></i></button><button class="btn btn-sm btn-outline-secondary" title="Add New Salary" onclick="prepareNewSalary(${emp.id}, '${emp.name}', '${emp.emp_id}', '${emp.position || ''}')"><i class="bi bi-pencil-square"></i></button><button class="btn btn-sm btn-outline-danger" title="Delete Employee" onclick="deleteEmployee(${emp.id}, '${emp.name}')"><i class="bi bi-trash"></i></button></td></tr>`;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    };
    
    const calculateNetSalary = () => {
        const basic = parseFloat(basicInput.value) || 0;
        const allowances = parseFloat(allowancesInput.value) || 0;
        const deductions = parseFloat(deductionsInput.value) || 0;
        netSalaryInput.value = formatCurrency(basic + allowances - deductions);
    };

    modalForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!modalForm.checkValidity()) { e.stopPropagation(); modalForm.classList.add('was-validated'); return; }
        const formData = new FormData();
        formData.append('action', 'save_record');
        formData.append('employee_id', document.getElementById('employeeIdField').value);
        formData.append('emp_id', document.getElementById('employeeIdInput').value); // Pass emp_id text for new users
        formData.append('name', document.getElementById('employeeName').value);
        formData.append('position', document.getElementById('employeePosition').value);
        formData.append('payment_date', document.getElementById('paymentDate').value);
        formData.append('basic_salary', document.getElementById('basicSalary').value);
        formData.append('allowances', document.getElementById('allowances').value);
        formData.append('deductions', document.getElementById('deductions').value);
        fetch('api_salary.php', { method: 'POST', body: formData }).then(res => res.json()).then(data => {
            if (data.status === 'success') { salaryModal.hide(); fetchAllData(); } 
            else { alert('Error: ' + data.message); }
        });
    });

    window.prepareNewSalary = (id, name, empId, position) => {
        modalForm.reset();
        modalForm.classList.remove('was-validated');
        document.getElementById('modalTitle').textContent = `Add New Salary for ${name}`;
        document.getElementById('employeeIdField').value = id;
        document.getElementById('employeeIdInput').value = empId;
        document.getElementById('employeeName').value = name;
        document.getElementById('employeePosition').value = position;
        document.getElementById('paymentDate').valueAsDate = new Date();
        ['employeeIdInput', 'employeeName'].forEach(elId => document.getElementById(elId).readOnly = true);
        basicInput.value = ''; allowancesInput.value = ''; deductionsInput.value = ''; netSalaryInput.value = '';
        document.getElementById('calculationBreakdown').innerHTML = '<p class="text-center text-muted">Calculating...</p>';
        salaryModal.show();
        fetch(`../Admin&Staff_APIs/api_salary.php?action=get_salary_details&id=${id}`).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                basicInput.value = data.basic_salary.toFixed(2);
                allowancesInput.value = data.total_allowances.toFixed(2);
                deductionsInput.value = data.total_deductions.toFixed(2);
                let breakdownHtml = '<hr><p class="fw-bold small text-muted">AUTOMATIC CALCULATIONS</p><div class="row small"><div class="col-6">';
                breakdownHtml += '<strong>Allowances:</strong><ul class="list-unstyled mb-0">';
                for (const [key, value] of Object.entries(data.allowance_breakdown)) { breakdownHtml += `<li>${key}: ${formatCurrency(value)}</li>`; }
                breakdownHtml += '</ul></div><div class="col-6">';
                breakdownHtml += '<strong>Deductions:</strong><ul class="list-unstyled mb-0">';
                for (const [key, value] of Object.entries(data.deduction_breakdown)) { breakdownHtml += `<li>${key}: ${formatCurrency(value)}</li>`; }
                breakdownHtml += '</ul></div></div>';
                document.getElementById('calculationBreakdown').innerHTML = breakdownHtml;
            } else {
                alert(data.message);
                document.getElementById('calculationBreakdown').innerHTML = `<p class="text-center text-danger small">${data.message}</p>`;
            }
            calculateNetSalary();
        });
    };
    
    // MODIFIED: This button now opens a blank form for a NEW employee
    document.getElementById('addRecordBtn').addEventListener('click', () => {
        modalForm.reset();
        modalForm.classList.remove('was-validated');
        document.getElementById('modalTitle').textContent = 'Add New Employee Salary';
        document.getElementById('employeeIdField').value = ''; // Important: clear the ID
        document.getElementById('calculationBreakdown').innerHTML = ''; // Clear breakdown
        ['employeeIdInput', 'employeeName'].forEach(elId => {
            const el = document.getElementById(elId);
            el.readOnly = false;
            el.value = '';
        });
        document.getElementById('employeePosition').value = '';
        document.getElementById('paymentDate').valueAsDate = new Date();
    });

    window.deleteEmployee = (id, name) => {
        if (confirm(`Are you sure you want to permanently delete ${name}? This will remove their user login.`)) {
            const formData = new FormData();
            formData.append('action', 'delete_employee'); formData.append('id', id);
            fetch('../Admin&Staff_APIs/api_salary.php', { method: 'POST', body: formData }).then(res => res.json()).then(data => {
                if (data.status === 'success') fetchAllData(); else alert('Error: ' + data.message);
            });
        }
    };

    window.viewHistory = (id, name) => {
        const historyTableBody = document.getElementById('historyTableBody');
        document.getElementById('historyModalTitle').textContent = `Salary History for ${name}`;
        historyTableBody.innerHTML = `<tr><td colspan="5" class="text-center">Loading...</td></tr>`;
        fetch(`../Admin&Staff_APIs/api_salary.php?action=fetch_history&id=${id}`).then(res => res.json()).then(historyData => {
            historyTableBody.innerHTML = '';
            if (historyData.length === 0) { historyTableBody.innerHTML = `<tr><td colspan="5" class="text-center">No records in the last 6 months.</td></tr>`; } 
            else {
                historyData.forEach(record => {
                    const net = parseFloat(record.basic_salary) + parseFloat(record.allowances) - parseFloat(record.deductions);
                    historyTableBody.innerHTML += `<tr><td>${record.payment_date}</td><td>${formatCurrency(record.basic_salary)}</td><td>${formatCurrency(record.allowances)}</td><td>${formatCurrency(record.deductions)}</td><td><strong>${formatCurrency(net)}</strong></td></tr>`;
                });
            }
            historyModal.show();
        });
    };

    [basicInput, allowancesInput, deductionsInput].forEach(input => input.addEventListener('input', calculateNetSalary));
    
    document.getElementById('addBonusBtn').addEventListener('click', () => {
        const bonusInput = document.getElementById('bonusAmount');
        const bonus = parseFloat(bonusInput.value) || 0;
        if (bonus > 0) {
            allowancesInput.value = ((parseFloat(allowancesInput.value) || 0) + bonus).toFixed(2);
            calculateNetSalary();
            bonusInput.value = '';
        }
    });

    searchInput.addEventListener('input', fetchEmployees);
    fetchAllData();
});
</script>
</body>
</html>