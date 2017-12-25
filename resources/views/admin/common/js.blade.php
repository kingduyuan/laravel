<!-- jQuery 2.1.4 -->
<script src="{{ asset('admin-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('admin-assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/nprogress/nprogress.js') }}"></script>
<script>
    (function () {
        document.onreadystatechange = function () {
            NProgress.start();
            if (document.readyState === "Uninitialized") {
                NProgress.set(1);
            }
            if (document.readyState === "Interactive") {
                NProgress.set(0.5);
            }
            if (document.readyState === "complete") {
                NProgress.done();
            }
        }
    })();
</script>