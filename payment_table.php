<?php
$title = "Ödəniş cədvəli";
require_once 'config/db.php';
require_once 'config/functions.php';
include 'include/meta.php';
?>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">
        <?php include 'include/sidebar.php'; ?>
        <!-- Layout container -->
        <div class="layout-page">
            <?php include 'include/header.php'; ?>
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="card">
                        <h5 class="card-header">Ödəniş cədvəli</h5>
                        <div class="container">
                            <form method="post">
                                <div class="row">
                                    <div class="mb-3 col-3">
                                        <label class="form-label" for="bs-validation-payment_type_id">Ödəniş üsulu</label>
                                        <select name="payment_type_id" class="form-control" id="payment_type_id">
                                            <option value="reset">Ödəniş üsulu seçin</option>
                                            <?php
                                            $payment_types = get('payment_type'); // Pass the $con variable here
                                            foreach ($payment_types as $payment_type):
                                                ?>
                                                <option value="<?= $payment_type['id'] ?>"><?= $payment_type['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label class="form-label" for="bs-validation-currency_id">Valyuta</label>
                                        <select name="currency_id" class="form-control" id="currency_id">
                                            <option value="reset">Valyuta seçin</option>
                                            <?php
                                            $currencies = get('currency'); // Pass the $con variable here
                                            foreach ($currencies as $currency):
                                                ?>
                                                <option value="<?= $currency['id'] ?>"><?= $currency['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
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
                                <tbody id="table-body-placeholder">
                                <?php
                                $payment_type_id = $_POST['payment_type_id'] ?? null;

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
                                        currency c ON p.currency_id = c.id
                                ";

                                if ($payment_type_id !== null) {
                                    $sql .= "WHERE p.payment_type_id = :payment_type_id";
                                }

                                $stmt = $con->prepare($sql);

                                if ($payment_type_id !== null) {
                                    $stmt->bindParam(':payment_type_id', $payment_type_id, PDO::PARAM_INT);
                                }

                                $stmt->execute();
                                $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($payments as $payment):
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $payment['id'] ?></th>
                                            <td><?php echo $payment['amount'] ?></td>
                                            <td><?php echo $payment['payment_type_name'] ?></td>
                                            <td><?php echo $payment['currency_name'] ?></td>
                                            <td><?php echo $payment['comment'] ?></td>
                                            <td><?php echo $payment['income'] ?></td>
                                            <td><?php echo $payment['expense'] ?></td>
                                            <td><?php echo ($payment['income'] - $payment['expense']) ?></td>
                                            <td><?php echo $payment['created_at'] ?></td>
                                        </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- / Content -->
                <?php include 'include/footer.php'; ?>
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

<?php include 'include/script.php'; ?>
<script>
    $(document).ready(function() {
        function updateTable(paymentTypeId, currencyId) {
            $.ajax({
                url: "ajax_load_payments.php",
                method: "POST",
                data: {
                    payment_type_id: paymentTypeId,
                    currency_id: currencyId
                },
                success: function(response) {
                    $("#table tbody").html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Apply filters when payment type or currency is changed
        $("#payment_type_id, #currency_id").change(function() {
            var selectedPaymentType = $("#payment_type_id").val();
            var selectedCurrency = $("#currency_id").val();
            updateTable(selectedPaymentType, selectedCurrency);
        });

        // Reset both payment type and currency filters
        $("#reset_filters").click(function() {
            $("#payment_type_id").val("");
            $("#currency_id").val("");
            updateTable("", "");
        });
    });

</script>
</body>
</html>