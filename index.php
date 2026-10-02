<?php
session_start();

/* =========================
   ADMIN LOGIN INFORMATION
   ========================= */

$adminUsername = "Bethzaries";
$adminPassword = "beth0908";
$loginCode = "BETHZARIES";


/* =========================
   SAMPLE MEDICINES
   ========================= */

if (!isset($_SESSION["medicines"])) {

    $_SESSION["medicines"] = [
        [
            "name" => "Paracetamol 500mg",
            "category" => "Pain Reliever",
            "price" => 5.00,
            "stock" => 50
        ],
        [
            "name" => "Amoxicillin 500mg",
            "category" => "Antibiotic",
            "price" => 12.00,
            "stock" => 25
        ],
        [
            "name" => "Ibuprofen 200mg",
            "category" => "Pain Reliever",
            "price" => 8.00,
            "stock" => 40
        ],
        [
            "name" => "Vitamin C 500mg",
            "category" => "Vitamin",
            "price" => 10.00,
            "stock" => 75
        ]
    ];
}


/* =========================
   LOGIN PROCESS
   ========================= */

$error = "";

if (isset($_POST["login"])) {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $code = trim($_POST["login_code"]);

    if (
        $username === $adminUsername &&
        $password === $adminPassword &&
        $code === $loginCode
    ) {

        $_SESSION["logged_in"] = true;
        $_SESSION["admin_name"] = "System Administrator";

    } else {

        $error = "Invalid username, password, or login code.";

    }
}


/* =========================
   LOGOUT
   ========================= */

if (isset($_GET["logout"])) {

    session_destroy();

    header("Location: index.php");
    exit();

}


/* =========================
   ADD MEDICINE
   ========================= */

if (
    isset($_POST["add_medicine"]) &&
    isset($_SESSION["logged_in"])
) {

    $medicineName = trim($_POST["medicine_name"]);
    $category = trim($_POST["category"]);
    $price = floatval($_POST["price"]);
    $stock = intval($_POST["stock"]);

    if (
        $medicineName !== "" &&
        $category !== "" &&
        $price >= 0 &&
        $stock >= 0
    ) {

        $_SESSION["medicines"][] = [
            "name" => $medicineName,
            "category" => $category,
            "price" => $price,
            "stock" => $stock
        ];
    }

}


/* =========================
   CHECK LOGIN
   ========================= */

$loggedIn = isset($_SESSION["logged_in"]) &&
            $_SESSION["logged_in"] === true;

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Bethzaries - Pharmacy Management System</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }


        body {
            background: #f3f7f6;
            color: #263238;
        }


        /* =========================
           LOGIN PAGE
           ========================= */

        .login-page {

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            background:
                linear-gradient(
                    135deg,
                    #dff7ef,
                    #e7f2ff
                );

            padding: 20px;

        }


        .login-box {

            width: 420px;

            background: white;

            padding: 40px;

            border-radius: 20px;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.12);

        }


        .logo {

            width: 75px;

            height: 75px;

            margin: 0 auto 15px;

            border-radius: 20px;

            display: flex;

            justify-content: center;

            align-items: center;

            background: #0ca678;

            color: white;

            font-size: 40px;

        }


        .login-box h1 {

            text-align: center;

            color: #073b32;

            margin-bottom: 8px;

        }


        .subtitle {

            text-align: center;

            color: #78909c;

            margin-bottom: 30px;

        }


        .form-group {

            margin-bottom: 18px;

        }


        .form-group label {

            display: block;

            margin-bottom: 7px;

            font-weight: bold;

            color: #37474f;

        }


        .form-group input {

            width: 100%;

            padding: 13px;

            border: 1px solid #cfd8dc;

            border-radius: 9px;

            outline: none;

            font-size: 15px;

        }


        .form-group input:focus {

            border-color: #0ca678;

            box-shadow:
                0 0 0 3px
                rgba(12, 166, 120, 0.12);

        }


        .login-button {

            width: 100%;

            border: none;

            padding: 14px;

            background: #0ca678;

            color: white;

            font-size: 16px;

            font-weight: bold;

            border-radius: 9px;

            cursor: pointer;

        }


        .login-button:hover {

            background: #087f5b;

        }


        .error {

            background: #ffe3e3;

            color: #c92a2a;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            text-align: center;

        }


        .demo-login {

            margin-top: 25px;

            padding: 15px;

            background: #f1f8f6;

            border-radius: 10px;

            font-size: 14px;

            line-height: 1.8;

        }


        .demo-login strong {

            color: #087f5b;

        }


        /* =========================
           DASHBOARD
           ========================= */

        .layout {

            min-height: 100vh;

            display: flex;

        }


        .sidebar {

            width: 250px;

            background: #073b32;

            color: white;

            padding: 25px 18px;

            position: fixed;

            left: 0;

            top: 0;

            bottom: 0;

        }


        .brand {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 10px;

            margin-bottom: 35px;

        }


        .brand-icon {

            width: 45px;

            height: 45px;

            background: #0ca678;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 25px;

        }


        .brand h2 {

            font-size: 18px;

        }


        .brand span {

            font-size: 11px;

            color: #a8c7c0;

        }


        .menu {

            display: flex;

            flex-direction: column;

            gap: 8px;

        }


        .menu a {

            text-decoration: none;

            color: #d7e9e5;

            padding: 13px;

            border-radius: 9px;

            display: block;

        }


        .menu a:hover {

            background: #0b6655;

            color: white;

        }


        .logout {

            position: absolute;

            bottom: 25px;

            left: 18px;

            right: 18px;

            text-decoration: none;

            color: white;

            background: #c92a2a;

            padding: 12px;

            border-radius: 9px;

            text-align: center;

        }


        .logout:hover {

            background: #a61e1e;

        }


        .main {

            margin-left: 250px;

            width: calc(100% - 250px);

            padding: 30px;

        }


        .topbar {

            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 30px;

        }


        .topbar h1 {

            color: #073b32;

        }


        .admin {

            background: white;

            padding: 12px 18px;

            border-radius: 10px;

            box-shadow:
                0 3px 12px
                rgba(0,0,0,0.06);

        }


        /* =========================
           STATISTICS
           ========================= */

        .stats {

            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 20px;

            margin-bottom: 30px;

        }


        .stat-card {

            background: white;

            padding: 22px;

            border-radius: 15px;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,0.06);

        }


        .stat-card h3 {

            font-size: 14px;

            color: #78909c;

            margin-bottom: 10px;

        }


        .stat-card .number {

            font-size: 30px;

            font-weight: bold;

            color: #073b32;

        }


        .green {

            border-left: 5px solid #0ca678;

        }


        .blue {

            border-left: 5px solid #339af0;

        }


        .orange {

            border-left: 5px solid #f08c00;

        }


        .purple {

            border-left: 5px solid #7950f2;

        }


        /* =========================
           CONTENT
           ========================= */

        .content-grid {

            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 25px;

        }


        .card {

            background: white;

            padding: 25px;

            border-radius: 15px;

            box-shadow:
                0 4px 15px
                rgba(0,0,0,0.06);

        }


        .card h2 {

            color: #073b32;

            margin-bottom: 20px;

        }


        table {

            width: 100%;

            border-collapse: collapse;

        }


        th {

            text-align: left;

            background: #f1f8f6;

            padding: 12px;

            color: #37474f;

        }


        td {

            padding: 12px;

            border-bottom: 1px solid #eceff1;

        }


        .stock-good {

            color: #2b8a3e;

            font-weight: bold;

        }


        .stock-low {

            color: #c92a2a;

            font-weight: bold;

        }


        /* =========================
           ADD MEDICINE FORM
           ========================= */

        .add-form {

            display: grid;

            gap: 15px;

        }


        .add-form input {

            width: 100%;

            padding: 12px;

            border: 1px solid #cfd8dc;

            border-radius: 8px;

        }


        .add-form button {

            background: #0ca678;

            color: white;

            border: none;

            padding: 13px;

            border-radius: 8px;

            cursor: pointer;

            font-weight: bold;

        }


        .add-form button:hover {

            background: #087f5b;

        }


        /* =========================
           RESPONSIVE
           ========================= */

        @media (max-width: 900px) {

            .stats {

                grid-template-columns:
                    repeat(2, 1fr);

            }

            .content-grid {

                grid-template-columns: 1fr;

            }

        }


        @media (max-width: 650px) {

            .sidebar {

                width: 100%;

                height: auto;

                position: relative;

            }

            .layout {

                display: block;

            }

            .main {

                margin-left: 0;

                width: 100%;

            }

            .logout {

                position: relative;

                left: 0;

                right: 0;

                bottom: 0;

                display: block;

                margin-top: 20px;

            }

            .stats {

                grid-template-columns: 1fr;

            }

            .topbar {

                display: block;

            }

            .admin {

                margin-top: 15px;

            }

        }

    </style>

</head>


<body>


<?php if (!$loggedIn): ?>

    <!-- =========================
         LOGIN INTERFACE
         ========================= -->

    <div class="login-page">

        <div class="login-box">

            <div class="logo">
                ⚕
            </div>

            <h1>
                Bethzaries
            </h1>

            <p class="subtitle">
                Bethzaries - Pharmacy Management System
            </p>


            <?php if ($error !== ""): ?>

                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label>
                        Admin Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        placeholder="Enter admin username"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Login Code
                    </label>

                    <input
                        type="password"
                        name="login_code"
                        placeholder="Enter login code"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="login"
                    class="login-button"
                >
                    🔐 Login to System
                </button>

            </form>


            <div class="demo-login">

                <strong>Demo Admin Account</strong>

                <br>

                Username:
                <b>Bethzaries</b>

                <br>

                Password:
                <b>beth0908</b>

                <br>

                Login Code:
                <b>BETHZARIES</b>

            </div>

        </div>

    </div>


<?php else: ?>


    <!-- =========================
         MAIN SYSTEM
         ========================= -->

    <div class="layout">


        <!-- SIDEBAR -->

        <aside class="sidebar">

            <div class="brand">

                <div class="brand-icon">
                    ⚕
                </div>

                <div>

                    <h2>
                        Bethzaries
                    </h2>

                    <span>
                        Admin Panel
                    </span>

                </div>

            </div>


            <div class="menu">

                <a href="#">
                    🏠 Dashboard
                </a>

                <a href="#medicines">
                    💊 Medicines
                </a>

                <a href="#add">
                    ➕ Add Medicine
                </a>

                <a href="#">
                    👥 Customers
                </a>

                <a href="#">
                    🧾 Sales
                </a>

                <a href="#">
                    📊 Reports
                </a>

            </div>


            <a
                href="?logout=true"
                class="logout"
            >
                🚪 Logout
            </a>

        </aside>


        <!-- MAIN CONTENT -->

        <main class="main">


            <div class="topbar">

                <div>

                    <h1>
                        Pharmacy Dashboard
                    </h1>

                    <p>
                        Welcome to your pharmacy management system.
                    </p>

                </div>


                <div class="admin">

                    👤
                    <?php
                    echo htmlspecialchars(
                        $_SESSION["admin_name"]
                    );
                    ?>

                </div>

            </div>


            <!-- STATISTICS -->

            <div class="stats">


                <div class="stat-card green">

                    <h3>
                        Total Medicines
                    </h3>

                    <div class="number">

                        <?php
                        echo count(
                            $_SESSION["medicines"]
                        );
                        ?>

                    </div>

                </div>


                <div class="stat-card blue">

                    <h3>
                        Total Stock
                    </h3>

                    <div class="number">

                        <?php

                        $totalStock = 0;

                        foreach (
                            $_SESSION["medicines"]
                            as $medicine
                        ) {

                            $totalStock +=
                                $medicine["stock"];

                        }

                        echo $totalStock;

                        ?>

                    </div>

                </div>


                <div class="stat-card orange">

                    <h3>
                        Low Stock Items
                    </h3>

                    <div class="number">

                        <?php

                        $lowStock = 0;

                        foreach (
                            $_SESSION["medicines"]
                            as $medicine
                        ) {

                            if (
                                $medicine["stock"] <= 10
                            ) {

                                $lowStock++;

                            }

                        }

                        echo $lowStock;

                        ?>

                    </div>

                </div>


                <div class="stat-card purple">

                    <h3>
                        System Status
                    </h3>

                    <div
                        class="number"
                        style="font-size:20px;"
                    >
                        Online
                    </div>

                </div>


            </div>


            <div class="content-grid">


                <!-- MEDICINES -->

                <div
                    class="card"
                    id="medicines"
                >

                    <h2>
                        💊 Medicine Inventory
                    </h2>


                    <table>

                        <thead>

                            <tr>

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

                            </tr>

                        </thead>


                        <tbody>

                            <?php

                            foreach (
                                $_SESSION["medicines"]
                                as $medicine
                            ):

                            ?>

                                <tr>

                                    <td>
                                        <?php
                                        echo htmlspecialchars(
                                            $medicine["name"]
                                        );
                                        ?>
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
                                        if (
                                            $medicine["stock"]
                                            <= 10
                                        ):
                                        ?>

                                            <span
                                                class="stock-low"
                                            >
                                                <?php
                                                echo $medicine["stock"];
                                                ?>
                                                Low
                                            </span>

                                        <?php else: ?>

                                            <span
                                                class="stock-good"
                                            >
                                                <?php
                                                echo $medicine["stock"];
                                                ?>
                                                Available
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


                <!-- ADD MEDICINE -->

                <div
                    class="card"
                    id="add"
                >

                    <h2>
                        ➕ Add New Medicine
                    </h2>


                    <form
                        method="POST"
                        class="add-form"
                    >

                        <input
                            type="text"
                            name="medicine_name"
                            placeholder="Medicine name"
                            required
                        >


                        <input
                            type="text"
                            name="category"
                            placeholder="Category"
                            required
                        >


                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            placeholder="Price"
                            required
                        >


                        <input
                            type="number"
                            name="stock"
                            placeholder="Stock quantity"
                            required
                        >


                        <button
                            type="submit"
                            name="add_medicine"
                        >
                            + Add Medicine
                        </button>

                    </form>

                </div>


            </div>


        </main>

    </div>


<?php endif; ?>


</body>

</html>