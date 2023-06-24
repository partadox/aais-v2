<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>AAIS - Login</title>
    <meta content="Alhaqq Academic Information System" name="description" />
    <meta content="AAIS v2 by Arta Kusuma Teknologi Development" name="author" />
    <link rel="shortcut icon" href="<?= base_url('public/img/favicon.png') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" integrity="sha512-rt/SrQ4UNIaGfDyEXZtNcyWvQeOq0QLygHluFQcSjaGB04IxWhal71tKuzP6K8eYXYB6vJV4pHkXcmFGGQ1/0w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.css" integrity="sha512-Dovl+OCTZYdn+CwnU7ChS28VCZ1lDlhpZUpDIFvYtW8y20+lcZeWYnQrILYfGhcXSgzeXVhgjwQP39zfbdDPQw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= base_url() ?>public/assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>public/assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>public/assets/css/front_login_reg.css" rel="stylesheet" type="text/css">

    <script src="https://www.google.com/recaptcha/api.js?render=<?= $site_key ?>"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('<?= $site_key ?>', {action: 'submit'}).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
            });
        });
    </script>

</head>

<body>

    <!-- Begin page -->
    <div class="blockSign">
        <div id="formContent">

                <div id="signin">
                    <div class="text-center m-t-0 m-b-15">
                        <a href="" class="logo logo-admin"><img src="<?= base_url('public/img/logo-alhaqq.png') ?>" alt="" height="55"></a>
                    </div>
                    <h6>Isi form dibawah untuk masuk akun!</h6>
                    <?= form_open('auth/dologin', ['class' => 'formlogin']) ?>
                    <?= csrf_field() ?>
                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                        <div class="form-group">
                            <input type="text" placeholder="Username" name="username" id="username" class="fadeIn " />
                            <div class="invalid-feedback error_username">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Password" name="password" id="password"  class="fadeIn ">
                            <div class="invalid-feedback error_password">
                        </div>
                        <div class="form-group mt-2 mb-2">
                            <input style="margin-left:-60px;" class="form-check-input text-left" type="checkbox" value="1" id="remember">
                            <p>Ingat saya</p>
                        </div>
                        <input id="login" type="submit" value="Masuk"></input>
                        <h6 id="formFooter"><a>Ingin daftar di program Al-Haqq? Silahkan hubungi admin untuk pembuatan akun.</a></h6>
                        <p id="formFooter"><a>Lupa Username atau Password? Hubungi Admin</a></p>
                        <p id="formFooter"><a href="https://alhaqq.or.id/">Kembali ke Website Depan alhaqq.or.id</a></p>
                    <?= form_close() ?>
                </div>
        </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
<!-- jQuery  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js" integrity="sha512-o36qZrjup13zLM13tqxvZTaXMXs+5i4TL5UWaDCsmbp5qUcijtdCFuW9a/3qnHGfWzFHBAln8ODjf7AnUNebVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.js" integrity="sha512-37SbZHAnGzLuZV850k61DfQdZ5cnahfloYHizjpEwDgZGw49+D6oswdI8EX3ogzKelDLjckhvlK0QZsY/7oxYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
    // Login
    $(".formlogin").submit(function (e) {
        e.preventDefault();
        $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: $(this).serialize(),
        dataType: "json",
        beforeSend: function () {
            $("#login").attr("disabled", true);
            $("#login").html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>'
            );
        },
        complete: function () {
            $("#login").removeAttr("disabled", false);
            $("#login").html("Login");
        },
        success: function (response) {
            if (response.success == false) {
            Swal.fire({
                title: "Error!",
                text: response.message,
                icon: "error",
                showConfirmButton: false,
                timer: 1350,
            });
            }
            if (response.success == true) {
            Swal.fire({
                title: response.data.title,
                text: response.message,
                icon: response.data.icon,
                showConfirmButton: false,
                timer: 1250,
            }).then(function () {
                window.location = response.data.link;
            });
            }
        },
        });
        return false;
    });
});
</script>

</html>