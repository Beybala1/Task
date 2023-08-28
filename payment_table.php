<?php
$title = "Ödəniş cədvəli";
include 'include/meta.php';
require_once 'config/functions.php';
require_once 'config/db.php';
?>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
        <?php include('include/sidebar.php')  ?>
        <!-- Layout container -->
        <div class="layout-page">
            <?php include('include/header.php')  ?>
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <h5 class="card-header">Ödəniş cədvəli</h5>
                        <div class="container">
                            <div class="table-responsive text-nowrap">
                                <table id="table" class="table table-striped">
                                    <thead>
                                    <tr class="text-nowrap">
                                        <th>#</th>
                                        <th>Məbləğ</th>
                                        <th>Ödəniş üsulu</th>
                                        <th>Valyuta</th>
                                        <th>Rəy</th>
                                        <th>Mədaxil</th>
                                        <th>Məxaric</th>
                                        <th>Qalıq</th>
                                        <th>Tarix</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "
                                        SELECT
                                            p.id,
                                            p.amount,
                                            pt.name AS payment_type_name,
                                            c.name AS currency_name,
                                            p.comment,
                                            p.income,
                                            p.expense,
                                            p.created_at
                                        FROM
                                            payment p
                                        INNER JOIN
                                            payment_type pt ON p.payment_type_id = pt.id
                                        INNER JOIN
                                            currency c ON p.currency_id = c.id;
                                    ";
                                    $stmt = $con->prepare($sql);
                                    $stmt->execute();
                                    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    ?>
                                    <?php foreach ($payments as $payment): ?>
                                        <tr>
                                            <th scope="row"><?php echo $payment['id']; ?></th>
                                            <td><?php echo $payment['amount']; ?></td>
                                            <td><?php echo $payment['payment_type_name']; ?></td>
                                            <td><?php echo $payment['currency_name']; ?></td>
                                            <td><?php echo $payment['comment']; ?></td>
                                            <td><?php echo $payment['income']; ?></td>
                                            <td><?php echo $payment['expense']; ?></td>
                                            <td><?php echo $payment['income'] - $payment['expense']; ?></td>
                                            <td><?php echo $payment['created_at']; ?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                    $con = null;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Content -->
                <?php include('include/footer.php') ?>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->
<?php include('include/script.php') ?>
</body>
</html>