<!DOCTYPE html>
<html>

<head>
    <title>Car EMI Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap');

        *,
        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            -moz-osx-font-smoothing: grayscale;
        }

        html,
        body {
            height: 100%;
            background-color: whitesmoke;
            overflow: hidden;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center !important;
            align-items: center;
            text-align: center;
            min-height: 100vh;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <form id="emiCalculatorForm" method="post" action="CarEMICalculator.php">
            <table>
                <tr>
                    <td><label for="down_payment">Down Payment</label></td>
                    <td>
                        <input type="text" id="down_payment" name="down_payment" placeholder="Down Payment">
                        <span id="down_payment_error" class="error-message"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="salary">Current Salary</label></td>
                    <td>
                        <input type="text" id="salary" name="salary" placeholder="Current Salary">
                        <span id="salary_error" class="error-message"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="max_monthly_payment">Maximum Monthly Payment</label></td>
                    <td>
                        <input type="text" id="max_monthly_payment" name="max_monthly_payment" placeholder="Maximum Monthly Payment">
                        <span id="max_monthly_payment_error" class="error-message"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="loan_term">Length of Loan Term (Months)</label></td>
                    <td>
                        <input type="text" id="loan_term" name="loan_term" placeholder="Loan Term">
                        <span id="loan_term_error" class="error-message"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="interest_rate">Loan Interest Rate (%)</label></td>
                    <td>
                        <input type="text" id="interest_rate" name="interest_rate" placeholder="Interest Rate">
                        <span id="interest_rate_error" class="error-message"></span>
                    </td>
                </tr>
                <tr>
                    <td><input type="reset" id="resetButton" value="Reset"></td>
                    <td><input type="submit" value="Calculate"></td>
                </tr>
            </table>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            // Validate on blur event
            $('#down_payment').blur(function () {
                validateDownPayment();
            }).on('input', function () {
                validateDownPayment();
            });

            $('#salary').blur(function () {
                validateSalary();
            }).on('input', function () {
                validateSalary();
            });

            $('#max_monthly_payment').blur(function () {
                validateMaxMonthlyPayment();
            }).on('input', function () {
                validateMaxMonthlyPayment();
            });

            $('#loan_term').blur(function () {
                validateLoanTerm();
            }).on('input', function () {
                validateLoanTerm();
            });

            $('#interest_rate').blur(function () {
                validateInterestRate();
            }).on('input', function () {
                validateInterestRate();
            });

            // Validate form on submit
            $('#emiCalculatorForm').submit(function (e) {
                e.preventDefault(); // Prevent form submission

                // Clear previous error messages
                $('.error-message').text('');

                // Perform form validation
                var isValid = true;

                if (!validateDownPayment()) isValid = false;
                if (!validateSalary()) isValid = false;
                if (!validateMaxMonthlyPayment()) isValid = false;
                if (!validateLoanTerm()) isValid = false;
                if (!validateInterestRate()) isValid = false;

                // If all inputs are valid, submit the form
                if (isValid) {
                    this.submit();
                }
            });

            // Reset button event listener
            $('#resetButton').click(function () {
                $('.error-message').text(''); // Clear error messages
            });

            function validateDownPayment() {
                var downPayment = $('#down_payment').val();
                if (downPayment == '' || isNaN(downPayment) || downPayment < 0) {
                    $('#down_payment_error').text('Please enter a valid down payment (minimum 0).');
                    return false;
                }
                $('#down_payment_error').text('');
                return true;
            }

            function validateSalary() {
                var salary = $('#salary').val();
                if (salary == '' || isNaN(salary) || salary <= 0) {
                    $('#salary_error').text('Please enter a valid current salary (minimum 0).');
                    return false;
                }
                $('#salary_error').text('');
                return true;
            }

            function validateMaxMonthlyPayment() {
                var maxMonthlyPayment = $('#max_monthly_payment').val();
                var salary = $('#salary').val();
                if (maxMonthlyPayment == '' || isNaN(maxMonthlyPayment) || maxMonthlyPayment <= 0) {
                    $('#max_monthly_payment_error').text('Please enter a valid maximum monthly payment.');
                    return false;
                } else if (salary > 0 && maxMonthlyPayment > salary * 0.10) {
                    $('#max_monthly_payment_error').text('Maximum monthly payment cannot exceed 10% of your salary.');
                    return false;
                }
                $('#max_monthly_payment_error').text('');
                return true;
            }

            function validateLoanTerm() {
                var loanTerm = $('#loan_term').val();
                if (loanTerm == '' || isNaN(loanTerm) || loanTerm < 36 || loanTerm > 60) {
                    $('#loan_term_error').text('Please enter a valid loan term (36 to 60 months).');
                    return false;
                }
                $('#loan_term_error').text('');
                return true;
            }

            function validateInterestRate() {
                var interestRate = $('#interest_rate').val();
                if (interestRate == '' || isNaN(interestRate) || interestRate < 0 || interestRate > 12) {
                    $('#interest_rate_error').text('Please enter a valid interest rate (0 to 12%).');
                    return false;
                }
                $('#interest_rate_error').text('');
                return true;
            }
        });
    </script>
</body>

</html>
