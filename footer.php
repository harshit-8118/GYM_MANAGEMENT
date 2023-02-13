
<script src="assets/js/jquery.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.dataTables.js"></script>
<script src="assets/js/datatables.bootstrap.min.js"></script>
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/dataTables.buttons.html5.min.js"></script>
<script src="assets/js/dataTables.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="assets/js/dataTables.vfs_fonts.min.js"></script>
<script src="assets/js/multi.min.js"></script>
<script src="assets/js/admin.js"></script>
<script type="text/javascript">

$(document).ready(()=>{
    $('.table-data').DataTable({
        dom: Bfrtip,
        buttons: ['excel', 'pdf', 'print']
    });

    $('.select2').select2();
    $('.image').change(()=>{
        readURL(this);
    });
    function readURL(input){
        if(input.files and input.files[0]){
            var reader = new FileReader();
            reader.onload = (e)=>{
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDaraURL(input.files[0]);
        }
    }

    $('#sidebarCollapse').on('click', ()=>{
        $('#sidebar').toggleClass('active');
    });

});
</script>
    
</body>
</html>