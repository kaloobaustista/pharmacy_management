<?php

require_once "includes/auth.php";
require_once "config/database.php";

$pageTitle = "PharmaCare - Medicines";

include "includes/header.php";
include "includes/sidebar.php";


$medicines =
    $conn->query(
        "SELECT *
         FROM medicines
         ORDER BY id DESC"
    );

?>


<main class="main-content">


    <header class="topbar">

        <div>

            <h1>
                Medicine Inventory
            </h1>

            <p>
                Manage medicines and stock.
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


    <div class="page-actions">

        <input
            type="text"
            id="medicineSearch"
            placeholder="Search medicine..."
        >

        <button
            class="primary-button"
            onclick="alert('Add Medicine feature can be added here.')"
        >
            + Add Medicine
        </button>

    </div>


    <div class="dashboard-card">


        <table id="medicineTable">

            <thead>

                <tr>

                    <th>
                        ID
                    </th>

                    <th>
                        Medicine
                    </th>

                    <th>
                        Category
                    </th>

                    <th>
                        Price
                    </th>

                    <th>
                        Stock
                    </th>

                    <th>
                        Expiration
                    </th>

                    <th>
                        Status
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php while (
                    $medicine =
                    $medicines->fetch_assoc()
                ): ?>

                <tr>

                    <td>
                        MED-<?php
                        echo str_pad(
                            $medicine["id"],
                            3,
                            "0",
                            STR_PAD_LEFT
                        );
                        ?>
                    </td>


                    <td>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $medicine[
                                    "medicine_name"
                                ]
                            );
                            ?>
                        </strong>

                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $medicine["category"]
                        );
                        ?>
                    </td>


                    <td>
                        ₱<?php
                        echo number_format(
                            $medicine["price"],
                            2
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo $medicine["stock"];
                        ?>
                    </td>


                    <td>
                        <?php
                        echo $medicine[
                            "expiration_date"
                        ];
                        ?>
                    </td>


                    <td>

                        <?php if (
                            $medicine["stock"] <= 10
                        ): ?>

                            <span class="status low">
                                Low Stock
                            </span>

                        <?php else: ?>

                            <span class="status completed">
                                Available
                            </span>

                        <?php endif; ?>

                    </td>

                </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>


</main>


<script>

const search =
    document.getElementById(
        "medicineSearch"
    );

search.addEventListener(
    "keyup",
    function() {

        const value =
            search.value.toLowerCase();

        const rows =
            document.querySelectorAll(
                "#medicineTable tbody tr"
            );

        rows.forEach(function(row) {

            row.style.display =
                row.textContent
                .toLowerCase()
                .includes(value)
                ? ""
                : "none";

        });

    }
);

</script>


</body>
</html>