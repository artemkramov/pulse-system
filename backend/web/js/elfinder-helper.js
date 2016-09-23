/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
   
    $(".btn-image-remove").click(function() {
        var attr = $(this).attr('data-image');
        $("img[data-rel="+attr.toString()+"]").attr('src',no_image);
        $("input[data-text="+attr.toString()+"]").val("");
    });
    
    $(".form-image").change(function() {
        var attr = $(this).attr('data-text');
        $("img[data-rel="+attr.toString()+"]").attr('src',$(this).val());
    });
    
   // mihaildev.elFinder.register(" . Json::encode($this->options['id']) . ", function(files, id){ var _f = []; for (var i in files) { _f.push(files[i].url); } \$('#' + id).val(_f.join(', ')).trigger('change'); return true;}); $(document).on('click','#" . $this->buttonOptions['id'] . "', function(){mihaildev.elFinder.openManager(" . Json::encode($this->_managerOptions) . ");});
    
});

