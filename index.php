<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car EMI Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
            font-weight: bold;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            padding: 10px;

            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .error-message {
            color: red;
            font-size: 1em;
            height: 1.5em;
            font-weight: bolder;
        }

        input[type="reset"],
        input[type="submit"] {
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        input[type="reset"]:hover,
        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .req {
            color: #f00;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Car EMI Calculator</h1>
        <form id="emiCalculatorForm" method="post" action="CarEMICalculator.php">
            <label for="down_payment">Down Payment<span class="req">*</span></label>
            <input type="text" id="down_payment" name="down_payment" placeholder="Enter down payment amount">
            <span id="down_payment_error" class="error-message"></span>

            <label for="salary">Current Salary<span class="req">*</span></label>
            <input type="text" id="salary" name="salary" placeholder="Enter your monthly salary">
            <span id="salary_error" class="error-message"></span>

            <label for="max_monthly_payment">Maximum Monthly Payment<span class="req">*</span></label>
            <input type="text" id="max_monthly_payment" name="max_monthly_payment" placeholder="Set maximum monthly payment">
            <span id="max_monthly_payment_error" class="error-message"></span>

            <label for="loan_term">Length of Loan Term (Months)<span class="req">*</span></label>
            <input type="text" id="loan_term" name="loan_term" placeholder="Enter loan term in months">
            <span id="loan_term_error" class="error-message"></span>

            <label for="interest_rate">Loan Interest Rate (%)<span class="req">*</span></label>
            <input type="text" id="interest_rate" name="interest_rate" placeholder="Enter loan interest rate">
            <span id="interest_rate_error" class="error-message"></span>

            <input type="reset" id="resetButton" value="Reset">
            <input type="submit" value="Calculate">
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Validate on blur event and remove error message on valid input
            $('#down_payment').on('input', function() {
                validateDownPayment();
            });

            $('#salary').on('input', function() {
                validateSalary();
            });

            $('#max_monthly_payment').on('input', function() {
                validateMaxMonthlyPayment();
            });

            $('#loan_term').on('input', function() {
                validateLoanTerm();
            });

            $('#interest_rate').on('input', function() {
                validateInterestRate();
            });

            // Remove error messages on click outside of inputs
            $('body').click(function(event) {
                if (!$(event.target).closest('form').length) {
                    $('.error-message').text('');
                }
            });

            // Validate form on submit
            $('#emiCalculatorForm').submit(function(e) {
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
            $('#resetButton').click(function() {
                $('.error-message').text(''); // Clear error messages
            });

            function validateDownPayment() {
                var downPayment = $('#down_payment').val();
                if (downPayment === '' || isNaN(downPayment) || downPayment < 0) {
                    $('#down_payment_error').text('Please enter a valid down payment (minimum 0).');
                    return false;
                }
                $('#down_payment_error').text('');
                return true;
            }

            function validateSalary() {
                var salary = $('#salary').val();
                if (salary === '' || isNaN(salary) || salary <= 0) {
                    $('#salary_error').text('Please enter a valid current salary (minimum 0).');
                    return false;
                }
                $('#salary_error').text('');
                return true;
            }

            function validateMaxMonthlyPayment() {
                var maxMonthlyPayment = $('#max_monthly_payment').val();
                var salary = $('#salary').val();
                if (maxMonthlyPayment === '' || isNaN(maxMonthlyPayment) || maxMonthlyPayment <= 0) {
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
                if (loanTerm === '' || isNaN(loanTerm) || loanTerm < 36 || loanTerm > 60) {
                    $('#loan_term_error').text('Please enter a valid loan term (between 36 and 60 months).');
                    return false;
                }
                $('#loan_term_error').text('');
                return true;
            }

            function validateInterestRate() {
                var interestRate = $('#interest_rate').val();
                if (interestRate === '' || isNaN(interestRate) || interestRate < 0 || interestRate > 12) {
                    $('#interest_rate_error').text('Please enter a valid interest rate (between 0 and 12%).');
                    return false;
                }
                $('#interest_rate_error').text('');
                return true;
            }
        });
    </script>
</body>

</html>