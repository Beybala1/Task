<?php
$title = "Ödəniş üsulu";
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
                            <h5 class="card-header">Ödəniş üsulu əlavə et</h5>
                            <div class="card-body">
                                <?php

                                ?>
                                <form>
                                    <div class="mb-3">
                                        <label class="form-label" for="bs-validation-name">Ödəniş üsulu</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="(nəğd,kredit və.s)" required/>
                                        <div class="valid-feedback"> </div>
                                        <div class="invalid-feedback"> Başlıq daxil et. </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="button" name="submit" id="submit" class="btn btn-success">Daxil et</button>
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

<!-- Include jQuery library -->
<script>
    $(document).ready(function() {
        $("#name").keypress(function(event) {
            if (event.which === 13) {
                event.preventDefault(); // Prevent form submission
                $("#submit").click();   // Trigger the click event of the submit button
            }
        });

        $("#submit").click(function() {
            var name = $("#name").val();

            if (name === '') {
                alert("Xanaları boş buraxmaq olmaz");
                return false;
            }

            $.ajax({
                type: "POST",
                url: "index-ajax.php",
                data: {
                    name: name,
                },
                cache: false,
                success: function(data) {
                    // Display a success message
                    alert("Ödəniş üsülü uğurla əlavə edildi");

                    // Clear the input value
                    $("#name").val('');
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
