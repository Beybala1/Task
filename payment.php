<?php
$title = "Ödəniş";
require_once('config/db.php');
require_once('config/functions.php');
include 'include/meta.php';
?>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <?php include 'include/sidebar.php'; ?>
        <!-- Layout container -->
        <div class="layout-page">
            <?php include 'include/header.php'; ?>
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="col-md">
                        <div class="card">
                            <h5 class="card-header">Ödəniş əlavə et</h5>
                            <div class="card-body">
                                <form method="post">
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-amount">Məbləğ</label>
                                        <input type="text" name="amount" class="form-control" id="amount"
                                               placeholder="1000.00" required/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-payment_type_id">Ödəniş üsulu</label>
                                        <select name="payment_type_id" class="form-control" id="payment_type_id">
                                            <option value="">Ödəniş üsulu seçin</option>
                                            <?php
                                                $payment_types = get('payment_type'); // Pass the $con variable here
                                                foreach ($payment_types as $payment_type):
//                                          ?>
                                                <option value="<?= $payment_type['id'] ?>"><?= $payment_type['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-currency_id">Valyuta</label>
                                        <select name="currency_id" class="form-control" id="currency_id">
                                            <option value="">Valyuta seçin</option>
                                            <?php
                                            $currencies = get('currency'); // Pass the $con variable here
                                            foreach ($currencies as $currency):
                                                ?>
                                                <option value="<?= $currency['id'] ?>"><?= $currency['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-income">Mədaxil</label>
                                        <input type="text" name="income" class="form-control" id="income"
                                               placeholder="1000.00" required/>
                                        <div class="valid-feedback"> </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-expense">Məxaric</label>
                                        <input type="text" name="expense" class="form-control" id="expense"
                                               placeholder="1000.00" required/>
                                        <div class="valid-feedback"> </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-amount">Rəy</label>
                                        <textarea name="comment" class="form-control" id="comment" rows="3"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" name="submit" id="submit" class="btn btn-success">
                                                Daxil et</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
        $("#amount").keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault(); // Prevent form submission
                $("#submit").click();   // Trigger the click event of the submit button
            }
        });

        $("#submit").click(function() {
            var amount = $("#amount").val();
            var payment_type_id = $("#payment_type_id").val();
            var currency_id = $("#currency_id").val();
            var income = $("#income").val();
            var expense = $("#expense").val();
            var comment = $("#comment").val();

            if (amount === ''|| payment_type_id === '' || currency_id === '' || income === '' || expense === '') {
                alert("Xanaları boş buraxmaq olmaz");
                return false;
            }

            $.ajax({
                type: "POST",
                url: "payment-ajax.php",
                data: {
                    amount: amount,
                    payment_type_id: payment_type_id,
                    currency_id: currency_id,
                    income: income,
                    expense: expense,
                    comment: comment
                },
                cache: false,
                success: function(data) {
                    // Display a success message
                    alert("Ödəniş uğurla əlavə edildi");
                },
                error: function(xhr, status, error) {
                    console.error(xhr);
                }
            });
        });
    });

</script>

<!-- Display Result -->
<div id="result"></div>
</body>

</html>
