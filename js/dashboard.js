$(document).ready(function(){
    setTimeout(function(){
        $('.operation-info').alert('close');
    }, 3000);

    $('.client-pass').on('click', function(){
       $.redirect('../templates/chooseDocuments.php', {workerid: 'client'}, 'post');
    });
});