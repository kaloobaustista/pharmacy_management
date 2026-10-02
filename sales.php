<?php

require_once "includes/auth.php";
require_once "config/database.php";

$pageTitle = "PharmaCare - Sales";

include "includes/header.php";
include "includes/sidebar.php";


$sales =
    $conn->query(
        "SELECT *
         FROM sales
         ORDER BY sale_date DESC"
    );


$totalSalesResult =
    $conn->query(
        "SELECT COALESCE(
            SUM(total_amount), 0
        ) AS total
        FROM sales"
    );


$totalSales =
    $totalSalesResult
    ->fetch_assoc()["total"];

?>


<main class="main-content">


    <header class="topbar">

        <div>

            <h1>
                Sales & Transactions
            </h1>

            <p>
                Monitor pharmacy transactions.
            </p>

        </div>


        <div class="admin-profile">

            <div class="profile-icon">
                A
            </div>

            <div>

                <strong>
                    Administrator
                </strong>

                <small>
                    Admin
                </small>

            </div>

        </div>

    </header>


    <section class="statistics">


        <div class="stat-card">

            <div class="stat-icon green">
                💰
            </div>

            <div>

                <p>
                    Total Sales
                </p>

                <h2>
                    ₱<?php
                    echo number_format(
                        $totalSales,
                        2
                    );
                    ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon blue">
                🧾
            </div>

            <div>

                <p>
                    Transactions
                </p>

                <h2>
                    <?php
                    echo $sales->num_rows;
                    ?>
                </h2>

            </div>

        </div>


    </section>


    <div class="dashboard-card">


        <div class="card-header">

            <h2>
                Transaction History
            </h2>

            <button
                class="primary-button"
                onclick="alert('New Sale feature can be added here.')"
            >
                + New Sale
            </button>

        </div>


        <table>

            <thead>

                <tr>

                    <th>
                        Transaction ID
                    </th>

                    <th>
                        Customer
                    </th>

                    <th>
                        Total
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Date
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php while (
                    $sale =
                    $sales->fetch_assoc()
                ): ?>

                <tr>

                    <td>
                        #TXN-<?php
                        echo str_pad(
                            $sale["id"],
                            3,
                            "0",
                            STR_PAD_LEFT
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $sale["customer_name"]
                        );
                        ?>
                    </td>


                    <td>
                        ₱<?php
                        echo number_format(
                            $sale["total_amount"],
                            2
                        );
                        ?>
                    </td>


                    <td>

                        <span class="status completed">

                            <?php
                            echo htmlspecialchars(
                                $sale["status"]
                            );
                            ?>

                        </span>

                    </td>


                    <td>
                        <?php
                        echo date(
                            "M d, Y h:i A",
                            strtotime(
                                $sale["sale_date"]
                            )
                        );
                        ?>
                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>


    </div>


</main>


</body>
</html>