$(document).ready(function(){
    var selectedDocuments = new Array();
    var toArchiveDoc = -1;

    var insertWarningDoc;
    var addWarning = $('#addWarning').DataTable({
        pageLength: 3,
        lengthChange: false,
        bInfo: false
    });

    $('#addWarning tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            addWarning.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            insertWarningDoc = $(this).attr('data-document-id');
        }
    });

    $('#button').click( function () {
        addWarning.row('.selected').remove().draw( false );
    });

    $('.btn-add-warning').on('click', function(){
        $.redirect("../server/insertWarning.php", {docid: insertWarningDoc, warntext: $('.warn-text').val(), typeid: $('.warning-select option:selected').attr('data-warning-id')}, "post");
    });

    $('#documents').DataTable({
        'columnDefs': [
            {
                'targets': 0,
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<input type="checkbox" class="dt-checkboxes choose-doc-chbox" />';
                    }

                    return data;
                },
                'checkboxes': {
                    'selectRow': true,
                    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                }
            }
        ],
        'select': 'multi',
        'order': [[1, 'asc']]
    });

    $('.choose-doc-chbox').on('click', function(){
        var indeks = selectedDocuments.indexOf($(this).parent().parent().attr('data-document-id'));
        if(indeks == -1){
            selectedDocuments.push($(this).parent().parent().attr('data-document-id'));
        }else {
            selectedDocuments.splice(indeks, 1);
        }
        console.log(selectedDocuments);
    });


    $('.btn-add-exp').on('click', function(){
        $.redirect("../server/insertExplanation.php", {docid: insertWarningDoc, warntext: $('.warn-text').val()},"post");
    });

    $('#track-docs').DataTable();

    $('#workers').DataTable({
        select: true
    });

    $('#workers tbody').on('click', 'tr', function() {
        $.redirect('../templates/chooseDocuments.php', {workerid: $(this).attr("data-worker-id")}, "post");
    });


    var toArchive = $('#toArchive').DataTable({
    });

    $('#toArchive tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            toArchiveDoc = -1;
            console.log(toArchiveDoc);
        }
        else {
            toArchive.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            toArchiveDoc = $(this).attr('data-archive-id');
            console.log(toArchiveDoc);
        }
    });

    $('.pass-docs').on('click', function(){
        if(selectedDocuments.length == 0){
            $('#myModal').modal();
        }else {
            $.redirect('../server/passToWorker.php', {documentid: selectedDocuments}, "post");
        }
    });

    $('.btn-insert-doc').on('click', function(){
        var insert = new Array();
        insert.push($('.type-blocked').val());
        insert.push($('.clients-blocked').val());
        insert.push($('.deliveries-blocked').val());
        insert.push($('.document-amount').val());
        insert.push($('.payment-type').val());
        insert.push($('#create-date').val());
        insert.push($('#payment-date').val());
        insert.push($('.document-number').val());
        console.log(insert);
        $.redirect("../server/insertDocument.php", {insert: insert}, "post");
    });

    $('.btn-to-archive').on('click', function(){
        if(toArchiveDoc == -1){
            alert("Nie wybrano żadnej faktury");
        }else {
            $.redirect("../server/passToArchive.php", {docid: toArchiveDoc},"post");
        }
    });

    var clients = $('#clients').DataTable({
        pageLength: 3,
        lengthChange: false,
        bInfo: false
    });

    $('#clients tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $('.clients-blocked').val("");
        }
        else {
            clients.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('.clients-blocked').val($(this).attr('data-client-id'));
        }
    });

    var types = $('#types').DataTable({
        pageLength: 3,
        lengthChange: false,
        bInfo: false
    });

    $('#types tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $('.type-blocked').val("");
            $('.document-number').val("");
        }
        else {
            types.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('.type-blocked').val($(this).attr('data-type-id'));
            $('.document-number').val($(this).attr('data-type-id'));
        }
    });

    var deliveries = $('#delivery').DataTable({
        pageLength: 3,
        lengthChange: false,
        bInfo: false
    });

    $('#delivery tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            $('.deliveries-blocked').val("");
        }
        else {
            deliveries.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $('.deliveries-blocked').val($(this).attr('data-delivery-id'));
        }
    });

    $('.warning-select').on('change', function(){
        var warnid;
        $('.warning-select option:selected').each(function(){
            warnid = $(this).attr('data-warning-id');
        });
        $.ajax({
            url: '../server/getWarningText.php',
            method: 'post',
            data: {
                warn: warnid
            }
        }).done(response => {
            $('.warn-text').text(response);
        });
    });

    $('#create-date').datetimepicker({
        format: 'DD/MM/YYYY, HH:mm:ss'
    });
    $('#payment-date').datetimepicker({
        format: 'DD/MM/YYYY, HH:mm:ss'
    });
});