/*
 * This file is part of the RedKiteCmsBunde Application and it is distributed
 * under the GPL LICENSE Version 2.0. To use this application you must leave
 * intact this copyright notice.
 *
 * Copyright (c) RedKite Labs <webmaster@redkite-labs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.redkite-labs.com
 *
 * @license    GPL LICENSE Version 2.0
 *
 */

;var isEditorOpened = false;

(function($){
    $.fn.ToggleBodyContents =function()
    {
        this.each(function()
        {
            $(this).click(function()
            {
                $('#slot_' + $(this).attr('ref')).animate({
                  height: 'toggle'
                }, 200);

                return false;
            });
        });

        return this;
    };

    $.fn.AddBlock =function(type, options, successCallback)
    {
        try {
            this.each(function()
            {
                var contentType = (type == null) ? $(this).attr('data-type') : type;
                var included = $(this).attr('data-included') == "1" ? true : false;
                $.ajax({
                    type: 'POST',
                    url: frontController + 'backend/' + $('#al_available_languages option:selected').val() + '/addBlock',
                    data: {'page' :  $('#al_pages_navigator').html(),
                           'language' : $('#al_languages_navigator').html(),
                           'pageId' :  $('#al_pages_navigator').attr('rel'),
                           'languageId' : $('#al_languages_navigator').attr('rel'),
                           'idBlock' : $(this).attr('data-block-id'),
                           'slotName' : $(this).attr('data-slot-name'),
                           'contentType': contentType,
                           'included': included,
                           'options': options,
                           'insertDirection': $('body').data('insertDirection')
                    },
                    beforeSend: function()
                    {
                        $('body').AddAjaxLoader();
                    },
                    success: function(response)
                    {
                        updateContentsJSon(response);
                        if (successCallback != null) {
                            successCallback();
                        }

                        $(document).trigger("blockAdded", []);
                    },
                    error: function(err)
                    {
                        $('body').showAlert(err.responseText, 0, 'alert-error alert-danger');
                    },
                    complete: function()
                    {
                        $('body').RemoveAjaxLoader();
                    }
                });

                return false;
            });        
        }
        catch(e){
            $('body').showAlert('An unespected error occoured in al-blocks file, method AddBlock. Here is the error from the server:<br/><br/>' + e + '<br/><br/>Please open an issue at <a href="https://github.com/redkite-labs/RedKiteCmsBundle/issues">Github</a> reporting this entire message.', 0, 'alert-error alert-danger');
        }
    };

    $.fn.EditBlock =function(key, value, options, successCallback)
    {
        try {
            var activeBlock = $('body').data('activeBlock');
            var item = (activeBlock != null) ? activeBlock.attr('data-item') : null;
            var parent = (activeBlock != null) ? activeBlock.attr('data-parent') : null;
            this.each(function()
            {
                value = (value == null) ? encodeURIComponent($(this).val()) : value;
                $.ajax({
                    type: 'POST',
                    url: frontController + 'backend/' + $('#al_available_languages option:selected').val() + '/editBlock',
                    data: {'page' :  $('#al_pages_navigator').html(),
                           'language' : $('#al_languages_navigator').html(),
                           'pageId' :  $('#al_pages_navigator').attr('rel'),
                           'languageId' : $('#al_languages_navigator').attr('rel'),
                           'idBlock'    : $('body').data('idBlock'),
                           'slotName'   : $('body').data("slotName"),
                           'key'        : key,
                           'value'      : value,
                           'included'   : $('body').data('included'),
                           'parent'     : parent,
                           'item'       : item,
                           'options'    : options
                    },
                    beforeSend: function()
                    {
                        $('body').AddAjaxLoader();
                    },
                    success: function(response)
                    {
                        updateContentsJSon(response);
                        Holder.run();
                        
                        var editedBlock = $('body').data('editedBlock');
                        if (successCallback != null) {
                            successCallback(editedBlock);
                        }
                        
                        if (editedBlock != null) {
                            if (parent != null) {
                                editedBlock.attr('data-parent', parent);
                            }
                            
                            $(document).trigger("blockEdited", [ editedBlock ]);                      
                        }
                    },
                    error: function(err)
                    {
                        $('body').showAlert(err.responseText, 0, 'alert-error alert-danger');
                    },
                    complete: function()
                    {
                        $(document).blocksEditor('stopCursorOverEditor');
                        $('body').RemoveAjaxLoader();
                    }
                });

                return false;
            });
        }
        catch(e){
            $('body').showAlert('An unespected error occoured in al-blocks file, method EditBlock. Here is the error from the server:<br/><br/>' + e + '<br/><br/>Please open an issue at <a href="https://github.com/redkite-labs/RedKiteCmsBundle/issues">Github</a> reporting this entire message.', 0, 'alert-error alert-danger');
        }
    };

    $.fn.Delete =function()
    {
        this.each(function()
        {
            $(this).click(function()
            {
                $(this).DeleteContent();

                return false;
            });
        });
    };

    $.fn.DeleteBlock =function()
    {
        if (confirm(translate('Are you sure to remove the active block'))) {
            try {
                var included = $(this).attr('data-included') == "1" ? true : false;
                $.ajax({
                    type: 'POST',
                    url: frontController + 'backend/' + $('#al_available_languages option:selected').val() + '/deleteBlock',
                    data: {'page' :  $('#al_pages_navigator').html(),
                           'language' : $('#al_languages_navigator').html(),
                           'pageId' :  $('#al_pages_navigator').attr('rel'),
                           'languageId' : $('#al_languages_navigator').attr('rel'),                       
                           'idBlock' : $(this).attr('data-block-id'),
                           'slotName' : $(this).attr('data-slot-name'),
                           'included': included
                    },
                    beforeSend: function()
                    {
                        $('body').AddAjaxLoader();
                    },
                    success: function(response)
                    {
                        $(document).trigger("blockDeleted", [ $('body').data('activeBlock') ]);
                        
                        updateContentsJSon(response);
                    },
                    error: function(err)
                    {
                        $('body').showAlert(err.responseText, 0, 'alert-error alert-danger');
                    },
                    complete: function()
                    {
                        $('body').RemoveAjaxLoader();
                    }
                });
            }
            catch(e){
                $('body').showAlert('An unespected error occoured in al-blocks file, method DeleteBlock. Here is the error from the server:<br/><br/>' + e + '<br/><br/>Please open an issue at <a href="https://github.com/redkite-labs/RedKiteCmsBundle/issues">Github</a> reporting this entire message.', 0, 'alert-error alert-danger');
            }
        }        
    };
})($);

function showMediaLibrary(html)
{
    if($('body').find("al_media_lib").length == 0)
    {
        $('<div id="al_media_lib"></div>')
                .css("display", "none")
                .appendTo('body');
    }
    $('#al_media_lib').html(html);
}

function updateContentsJSon(response, editorWidth)
{
    var slot;
    $(response).each(function(key, item)
    {
        switch(item.key)
        {
            case "message":
                $('body').showAlert(item.value);
                
                break;
            case "redraw-slot":
                slot = $('.al_' + item.slotName);
                if (slot.length > 0) {
                    slot
                        .html(item.value)
                        .find('[data-editor="enabled"]')
                        .blocksEditor('start')
                    ;
                } else {
                    var element = $('[data-name="' + item.blockId + '"]');
                    var parent = element.parent();
                    element.replaceWith(item.value);
                    $(parent)
                        .find('[data-editor="enabled"]')
                        .blocksEditor('start')
                    ;
                }
                
                break;
            case "add-block":                
                if(item.insertAfter == 'block_0')
                {
                    var slot = $('.al_' + item.slotName);
                    if (slot.length > 0) {
                        slot
                            .empty()
                            .append(item.value)
                        ;
                    } else {
                        $('[data-slot-name="' + item.slotName + '"]')
                            .replaceWith(item.value);
                    }
                }
                else
                {
                    if ($('body').data('insertDirection') == 'top') {                        
                        $('[data-name="' + item.insertAfter + '"]').parent().before(item.value);
                    } else {                        
                        $('[data-name="' + item.insertAfter + '"]').parent().after(item.value);
                    }
                }
                
                $('[data-name="' + item.blockId + '"]').blocksEditor('start');
                
                break;
            case "edit-block": 
                var blockName = '[data-name="' + item.blockName + '"]';
                $(blockName)
                    .blocksEditor('stopEditElement')
                    .replaceWith(item.value);
                
                // Here we need to retrieve the block again because it has just been replaced
                $(blockName)
                    .blocksEditor('startEditElement')
                    .blocksEditor('hideElementContent')
                ;     
                
                $('body').data('editedBlock', $(blockName));
                
                break;
            case "remove-block":
                $('[data-name="' + item.blockName + '"]')
                    .unbind()
                    .remove()
                ;
                
                break;
            case "images-list":
                $('.al_images_list').html(item.value);
                
                break;
            case "externalAssets":
                $('.al_' + item.section  + '_list').html(item.value);
                $('[data-name="' + item.blockName + '"]').replaceWith(item.blockContent);
                
                break;
            case "editorContents":
                $('.editor_contents').html(item.value);
                
                break;
        }
    });
}
