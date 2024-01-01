@include('layouts.header')

    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('layouts.topNavBar')

        @include('layouts.sideBar')

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    
                    @yield('content')

                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script>© Voter Id Registration (VIR).
                        </div>
                    </div>
                </div>
            </footer>

        </div>

    </div>
    <!-- END layout-wrapper -->

@include('layouts.footer')