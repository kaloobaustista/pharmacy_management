<?php

require_once "includes/auth.php";
require_once "config/database.php";

$pageTitle = "PharmaCare - Customers";

include "includes/header.php";
include "includes/sidebar.php";


$customers =
    $conn->query(
        "SELECT *
         FROM customers
         ORDER BY id DESC"
    );

?>


<main class="main-content">


    <header class="topbar">

        <div>

            <h1>
                Customers
            </h1>

            <p>
                Manage customer records.
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
            id="customerSearch"
            placeholder="Search customer..."
        >

        <button
            class="primary-button"
            onclick="alert('Add Customer feature can be added here.')"
        >
            + Add Customer
        </button>

    </div>


    <div class="dashboard-card">

        <table id="customerTable">

            <thead>

                <tr>

                    <th>
                        ID
                    </th>

                    <th>
                        Name
                    </th>

                    <th>
                        Contact
                    </th>

                    <th>
                        Email
                    </th>

                    <th>
                        Address
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php while (
                    $customer =
                    $customers->fetch_assoc()
                ): ?>

                <tr>

                    <td>
                        CUS-<?php
                        echo str_pad(
                            $customer["id"],
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
                                $customer[
                                    "customer_name"
                                ]
                            );
                            ?>
                        </strong>

                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $customer["contact"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $customer["email"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $customer["address"]
                        );
                        ?>
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
        "customerSearch"
    );

search.addEventListener(
    "keyup",
    function() {

        const value =
            search.value.toLowerCase();

        const rows =
            document.querySelectorAll(
                "#customerTable tbody tr"
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