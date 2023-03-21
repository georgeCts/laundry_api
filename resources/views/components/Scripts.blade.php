@section('components.Scripts')
    <script type="text/javascript">
        window.CSRF_TOKEN = '{{ csrf_token() }}';
    </script>
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/vendor.bundle.addons.js') }}"></script>
    <script src="{{ asset('js/notie.min.js') }}"></script>
    <!-- End plugin js for this page-->

    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <!-- endinject -->

    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        let permission = Notification.permission;

        Echo.channel('events')
            .listen('RealTimeMessage', (e) => {
                if(permission === "granted"){
                    showNotification();
                } else if(permission === "default"){
                    requestAndShowPermission();
                } else {
                    alert("Use normal alert");
                }
            });

        function requestAndShowPermission() {
            Notification.requestPermission(function (permission) {
                if (permission === "granted") {
                    showNotification();
                }
            });
        }
        function showNotification() {
            let title = "Nuevo servicio";
            let body = "Se ha solicitado un servicio de lavandería";

            let notification = new Notification(title, { body });

            notification.onclick = () => {
                    notification.close();
                    window.parent.focus();
            }
        }
    </script>

    @yield('scripts')
    <!-- End custom js for this page-->
@endsection