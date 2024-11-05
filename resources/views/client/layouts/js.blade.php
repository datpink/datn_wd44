<script src="{{ asset('theme/client/assets/js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/chosen.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/countdown.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/lightbox.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/slick.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/threesixty.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('theme/client/assets/js/mobilemenu.js') }}"></script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyC3nDHy1dARR-Pa_2jjPCjvsOR4bcILYsM'></script>
<script src="{{ asset('theme/client/assets/js/functions.js') }}"></script>
<script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<script>
    // Chặn click chuột phải
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });

    // Chặn F12 (mở console)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && e.key === 'I')) {
            e.preventDefault();
        }
    });

    // Chặn Ctrl+U (Xem nguồn trang)
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'u') {
            e.preventDefault();
        }
    });

    // Chặn F11 (Chế độ toàn màn hình)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'F11') {
            e.preventDefault();
        }
    });
</script>
