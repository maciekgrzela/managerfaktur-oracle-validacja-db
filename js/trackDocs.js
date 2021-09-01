$(document).ready(function(){
    $('#track-docs').DataTable({
        paging: false,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        columnDefs: [{
            'targets': [5],
            'orderable': false
        }]
    });

    $('.show-history').on('click', function(){
        var docid = $(this).attr('data-document-id');
        $.ajax({
            url: '../server/getDocumentHistory.php',
            method: 'post',
            data: {
                doc: docid
            }
        }).done(response => {
            $('.history-title').text("Droga dokumentu: "+$(this).attr('data-document-id'));
            $('.history-body').html(response);
            $('#history').modal();
        });
    });
});