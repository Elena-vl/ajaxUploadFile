<!-- Modernizer -->
<script src="/components/formstone/demo/js/modernizr.js?v=1.4.13"></script>
<!-- Compiled CSS -->
<link rel="stylesheet" href="/components/formstone/demo/css/site.css?v=1.4.13">
<!-- Compiled JS -->
<script src="/components/formstone/demo/js/site.js?v=1.4.13"></script>
<script src="/components/formstone/dist/js/core.js"></script>


<div class="wrap" style="background-color:#ffffff;padding:30px;">
    <h1>Пример Upload</h1>
    <div class="upload"></div>
    <div id="res"></div>
</div>

<script>
    jQuery('document').ready(function($) {
        $('.upload').upload({
            action:'/obr.php',
            label:'Перетащите файл в блок загрузки',
            postKey:'newfile',
            maxQueue:1,
            maxSize:10485760
        })
            .on("start.upload", Start)
            .on("filestart.upload", fileStart)
            .on("fileprogress.upload", fileProgress)
            .on("filecomplete.upload", filePComplelele)
            .on("fileerror.upload", fileError)
            .on("complete.upload", Complete);
    });
    //начало загрузки файлов
    function Start (e, files) {
        console.log('Start');
        var html = '';
        for(var i=0; i < files.length; i++) {
            if(files[i].size > 10485760) {
                alert('Size');
            }
            html +='<li data-index="' + files[i].index + '"><span class="file">' + files[i].name + '</span><progress value="0" max="100"></progress><span class="progress"></span></li>'
        }
        $("#res").append(html);
    }
    //начинается непосредственная загрузка файла на сервер
    function fileStart(e, file) {
        console.log('FIle Start');
        $("#res").find('li[data-index='+file.index+']').find('.progress').text('0%');
    }
    //Отображение прогресса загрузки файлов
    function fileProgress(e, file, percent) {
        console.log('FIle Progress');
        $("#res")
            .find('li[data-index='+file.index+']')
            .find('progress').attr('value',percent)
            .next().text(percent + '%');

    }
    //Окончание загрузки файла
    function filePComplelele (e, file, response) {
        console.log('FIle Complete');
        if(response == '' || response.toLowerCase() == 'error') {

            $("#res").find('li[data-index='+file.index+']')
                .addClass('upload_error')
                .find('.progress')
                .text('Ошибка загрузки');
        }
        else {
            $("#res").find('li[data-index='+file.index+']')
                .addClass('upload_ok')
                .find('.progress')
                .text('Загружено');
        }
    }
    //Проверка ошибок и окончание загрузки файла
    function fileError (e, file) {
        console.log('Error');
        $("#res").find('li[data-index='+file.index+']')
            .addClass('upload_error')
            .find('.progress')
            .text('Файл не поддерживается');
    }

    function Complete(e) {console.log('Complete');}
</script>
<style>
    .fs-upload-target {

        height:200px;
    }
    .fs-upload.fs-upload-dropping .fs-upload-target {
        border-color:green;
    }
    progress {
        border:0;
        width: 50%;
        height: 20px;
        border-radius: 5px;
        background: #f1f1f1;
    }
    progress::-webkit-progress-bar {
        width: 300px;
        height: 20px;
        border-radius: 5px;
        background: #f1f1f1;
    }

    progress::-moz-progress-bar {
        border-radius: 5px;
        background: #35b545;
    }
    li.upload_error progress::-moz-progress-bar{
        background: #ff0000 !important;
    }
    li.upload_error {
        color:#ff0000
    }

    li {
        list-style-image: none;
        list-style-position: outside;
        list-style-type: none;
        margin-bottom: 10px;
        margin-left: 0;
        margin-right: 0;
        margin-top: 10px;
        text-align: left;
        width: 100%;
    }
    .file {
        display: block;
        float: left;
        width: 20%;
    }
    .progress {
        display: block;
        float: right;
        text-align: right;
        width: 30%;
    }
    .upload_ok {
        color:green;
    }
</style>
