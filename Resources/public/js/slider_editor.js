/*
 * This file is part of the BootstrapSliderBlockBundle and it is distributed
 * under the MIT LICENSE. To use this application you must leave intact this copyright 
 * notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    MIT LICENSE
 * 
 */
 
 $(document).ready(function() {
    $(document).on("popoverShow", function(event, element){         
        if (element.attr('data-type') != 'BootstrapSliderBlock') {
            return;
        }
        
        Holder.run();  
        $('#al_add_item').imagesList('addItem');      
        $('.al_img').imagesList('editItem');
        $('#al_delete_item').imagesList('deleteItem');
        $('.al_form_item').imagesList('saveAttributes');
        $('#al_save_item').imagesList('save');
        
        $('#al_json_block_src').ShowExternalFilesManager('images', function(){
            $('<div/>').dialogelfinder({
                    url : frontController + 'backend/' + $('#al_available_languages option:selected').val() + '/al_elFinderMediaConnect',
                    lang : 'en',
                    width : 840,
                    destroyOnClose : true,
                    commandsOptions : {
                        getfile : {
                            onlyURL  : false
                        }
                    },
                    getFileCallback : function(file, fm) {
                        var image = '/' + $('#al_assets_path').val() + '/' + file.path;
                        $('#al_json_block_src').val(image);
                        $('.al_img_selected').find('img').attr('src', image);
                        
                        $('body').showAlert('Image has been selected')
                    }
            }).dialogelfinder('instance');
        });
    });
});
