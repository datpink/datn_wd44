<script src="{{ asset('theme/admin/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/js/modernizr.js') }}"></script>
<script src="{{ asset('theme/admin/assets/js/moment.js') }}"></script>

<script src="{{ asset('theme/admin/assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script>

<script src="{{ asset('theme/admin/assets/vendor/apex/apexcharts.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/vendor/apex/custom/sales/salesGraph.js') }}"></script>
<script src="{{ asset('theme/admin/assets/vendor/apex/custom/sales/revenueGraph.js') }}"></script>
<script src="{{ asset('theme/admin/assets/vendor/apex/custom/sales/taskGraph.js') }}"></script>

<script src="{{ asset('theme/admin/assets/js/main.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

<script>
    // Chặn click chuột phải
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Chặn F12 (mở console)
    document.onkeydown = function(e) {
        if (e.key == 'F12') {
            e.preventDefault();
            return false;
        }
    };
</script>


