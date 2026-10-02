<?php

require_once "includes/auth.php";
require_once "config/database.php";

$pageTitle = "PharmaCare - Dashboard";

include "includes/header.php";
include "includes/sidebar.php";


/* TOTAL MEDICINES */

$medicineResult =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM medicines"
    );

$medicineCount =
    $medicineResult->fetch_assoc()["total"];


/* LOW STOCK */

$lowStockResult =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM medicines
         WHERE stock <= 10"
    );

$lowStock =
    $lowStockResult->fetch_assoc()["total"];


/* TOTAL CUSTOMERS */

$customerResult =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM customers"
    );

$customerCount =
    $customerResult->fetch_assoc()["total"];


/* TODAY'S SALES */

$salesResult =
    $conn->query(
        "SELECT COALESCE(
            SUM(total_amount), 0
        ) AS total
        FROM sales
        WHERE DATE(sale_date) = CURDATE()"
    );

$todaySales =
    $salesResult->fetch_assoc()["total"];


/* RECENT SALES */

$recentSales =
    $conn->query(
        "SELECT *
         FROM sales
         ORDER BY sale_date DESC
         LIMIT 5"
    );

?>


<main class="main-content">


    <header class="topbar">

        <div>

            <h1>
                Dashboard
            </h1>

            <p>
                Welcome back,
                <?php
                echo htmlspecialchars(
                    $_SESSION["admin_name"]
                );
                ?>!
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


    <!-- STATISTICS -->

    <section class="statistics">


        <div class="stat-card">

            <div class="stat-icon blue">
                💊
            </div>

            <div>

                <p>
                    Total Medicines
                </p>

                <h2>
                    <?php echo $medicineCount; ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon green">
                💰
            </div>

            <div>

                <p>
                    Today's Sales
                </p>

                <h2>
                    ₱<?php
                    echo number_format(
                        $todaySales,
                        2
                    );
                    ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon orange">
                ⚠️
            </div>

            <div>

                <p>
                    Low Stock
                </p>

                <h2>
                    <?php echo $lowStock; ?>
                </h2>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon purple">
                👥
            </div>

            <div>

                <p>
                    Customers
                </p>

                <h2>
                    <?php echo $customerCount; ?>
                </h2>

            </div>

        </div>


    </section>


    <!-- RECENT SALES -->

    <section class="dashboard-card">

        <div class="card-header">

            <h2>
                Recent Sales
            </h2>

            <a href="sales.php">
                View All
            </a>

        </div>


        <table>

            <thead>

                <tr>

                    <th>
                        Transaction
                    </th>

                    <th>
                        Customer
                    </th>

                    <th>
                        Amount
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
                    $recentSales->fetch_assoc()
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
                            "M d, Y",
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

    </section>


</main>


</body>
</html>