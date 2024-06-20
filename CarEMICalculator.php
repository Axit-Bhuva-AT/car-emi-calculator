<html>

<head>
    <title>Car EMI Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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
    </style>
</head>

<body>
    <div class="container">
        <center>
            <table class="table">
                <tr>
                    <td>
                        <?php

                            // Retrieve form inputs
                            $downPayment = floatval($_POST['down_payment']);
                            $salary = floatval($_POST['salary']);
                            $maxMonthlyPayment = floatval($_POST['max_monthly_payment']);
                            $loanTerm = intval($_POST['loan_term']);
                            $interestRate = floatval($_POST['interest_rate']);

                            // Calculate maximum allowable EMI as 10% of salary
                            $maxAllowableEMI = $salary * 0.10;

                            if ($maxMonthlyPayment > $maxAllowableEMI) {
                                $maxMonthlyPayment = $maxAllowableEMI;
                            }

                            // Convert annual interest rate to monthly and percentage to decimal
                            $monthlyInterestRate = ($interestRate / 100) / 12;

                            // Calculate maximum loan achievable
                            if ($monthlyInterestRate > 0) {
                                $maxLoan = ($maxMonthlyPayment * (pow(1 + $monthlyInterestRate, $loanTerm) - 1)) / ($monthlyInterestRate * pow(1 + $monthlyInterestRate, $loanTerm));
                            } else {
                                // If interest rate is 0%, the formula simplifies to:
                                $maxLoan = $maxMonthlyPayment * $loanTerm;
                            }

                            // Add down payment to maximum loan achievable
                            $totalLoan = $maxLoan + $downPayment;

                            // Display the result
                            echo "<div class='container'>";
                            echo "<h2>Car Loan Affordability Result</h2>";
                            echo "<p>Based on your inputs, the maximum loan achievable is: <strong>₹" . number_format($totalLoan, 2) . "</strong></p>";
                            echo "<a href='index.php' class='btn btn-primary'>Go Back</a>";
                            echo "</div>";

                        ?>


                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="/carEMI/" class="btn btn-warning">Return Home</a>
                    </td>
                </tr>
            </table>
        </center>
    </div>

</body>

</html>