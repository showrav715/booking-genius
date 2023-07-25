(function($) {

            var elementArray = document.getElementsByClassName("nic-edit");
            for (var i = 0; i < elementArray.length; ++i) {
              nicEditors.editors.push(
                new nicEditor({fullPanel : true}).panelInstance(
                  elementArray[i]
                )
              );
          }

// image reader-----------------------------------------------------//
          
          $('.image').on('change',function(){
            console.log('Hi');
            var file = event.target.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
               console.log(e.target.result)
              $('.image-view img').removeClass('d-none');
              $('.image-view img').attr('src',e.target.result);
            };
      
        reader.readAsDataURL(file);
          })
 // image reader-----------------------------------------------------//

})(jQuery);


  

