
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      
    </div>
    <strong>Copyright &copy;2020</strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

<!-- ./wrapper -->

<!-- jQuery 3 -->

<!-- FastClick -->
<script src="{{asset('public/backend/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/backend/dist/js/adminlte.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('public/backend/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../../dist/js/demo.js"></script> -->
<script src="{{asset('public/backend/dist/js/demo.js')}}"></script>
<!-- FLOT CHARTS -->

<!--toaster-->
<script src="{{asset('public/backend/toastr.min.js')}}"></script>
<script src="{{ asset ('public/backend/common/bootbox.js') }}"></script>
<script src="{{ asset ('public/backend/common/common.js') }}"></script>


<!---Datatable Js --->
<script src="{{ asset('public/backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!----end Datatable Js------>

<!-- Toogle Button -->
<script src="{{asset('public/backend/bootstrap-toggle.min.js') }}"></script>


<!-- Datatable Respponsive-->
<script src="{{ asset ('public/backend/common/responsive.min.js') }}"></script>
<script src="{{ asset ('public/backend/common/rowReorder.min.js') }}"></script>
<!-- end -->
@yield('pagescript')

{!! Toastr::message() !!}
</body>
</html>