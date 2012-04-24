var uploader = new plupload.Uploader({
   runtimes : 'html5,flash',
   container : 'import',
   browse_button : 'MediaFile',
   url : 'upload.php',
   flash_swf_url: '/js/plupload/plupload.flash.swf',
   multipart : true,
   urlstream_upload:true,
   multipart_params:{directory:'test'}
});

uploader.init();

uploader.bind('FilesAdded', function(up,files){
   var filelist = $('#filelist');
   for(var i in files){
       var file = files[i];
       filelist.prepend('<div id="'+file.id+' class="file">'+file.name+' ('+plupload.formatSize(file.size)+')'+'</div>');
   } 
});

jQuery(function($){
   
   //$('form').onSubmit
   
});
