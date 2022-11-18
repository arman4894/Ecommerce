<footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
              <b><a href="https://indrijunanda.gitlab.io/" target="_blank">indrijunanda</a></b>
            </span>
          </div>
        </div>
       
      </footer>

       <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('js/ruang-admin.min.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script> 
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

  <script type="text/javascript">
    function confirmDelete(){
      return confirm('Are you sure you want to delete?');
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
  $('#summernote').summernote();
});
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
  $('#summernote1').summernote();
});
  </script>
</body>

</html>